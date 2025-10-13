<?php

namespace App\Http\Controllers;

use App\Http\Resources\FacilityResource;
use App\Models\Facility;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Cache::remember('facilities', 300, function () {
            $facilities = Facility::whereHas('status', function ($query) {
                $query->where('status', 'Active');
            })->get();

            return FacilityResource::collection($facilities)->resolve();
        });

        return response()->json($data);
    }

    public function indexAdmin()
    {
        $data = Cache::remember('facilities-admin', 300, function () {
            $facilities = Facility::all();

            return FacilityResource::collection($facilities)->resolve();
        });

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Cache::forget('facilities');
        Cache::forget('facilities-admin');
        $defaultStatusId = Status::firstOrCreate(['status' => 'Active'])->id;

        $facility = Facility::create([
            'name' => $request->name,
            'status_id' => $request->status_id ?? $defaultStatusId,
        ]);

        return response()->json($facility, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $facility = Facility::findOrFail($id);

        $validate = $request->validate([
            'name' => 'sometimes|string|max:255',
            'status_id' => 'sometimes|integer'
        ]);

        $facility->update($validate);

        return response()->json([
            'message' => 'Berhasil update Facility',
            'data' => $facility
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Cache::forget('facilities');
        Cache::forget('facilities-admin');
        $facility = Facility::findOrFail($id);
        $facility = Facility::with('images')->findOrFail($id);

        // Hapus semua gambar dari storage lokal
        foreach ($facility->images as $image) {
            if ($image->image) {
                Storage::disk('public')->delete($image->image);
            }
        }

        $facility->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
