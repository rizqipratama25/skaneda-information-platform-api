<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExtracurricularResource;
use App\Models\Extracurricular;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ExtracurricularController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Cache::remember('extracurricular', 300, function () {
            $extra = Extracurricular::whereHas('status', function ($query) {
                $query->where('status', 'Active')->with(['status', 'images']);
            })->get();

            return ExtracurricularResource::collection($extra)->resolve();
        });

        return response()->json($data);
    }

    public function indexAdmin()
    {
        $data = Cache::remember('extracurricular-admin', 300, function () {
            $extra = Extracurricular::with('status')->get();
            return ExtracurricularResource::collection($extra)->resolve();
        });

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Cache::forget('extracurricular');
        Cache::forget('extracurricular-admin');
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $manager = new ImageManager(new Driver());

        $image = $manager->read($request->file('image'))->toWebp(quality: 85);
        $filename = Str::uuid() . '.' . 'webp';

        Storage::disk('public')->put('extracurricular_images/' . $filename, $image->toString());

        $defaultStatusId = Status::firstOrCreate(['status' => 'Active'])->id;

        $data = Extracurricular::create([
            'name' => $request->name,
            'image' => 'extracurricular_images/' . $filename,
            'status_id' => $request->status_id ?? $defaultStatusId
        ]);

        return response()->json(new ExtracurricularResource($data));
    }

    /**
     * Display the specified resource.
     */
    public function show(Extracurricular $extracurricular)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Cache::forget('extracurricular');
        Cache::forget('extracurricular-admin');

        $ext = Extracurricular::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'image' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
            'status_id' => 'sometimes|integer',
        ]);

        $data = [];

        if ($request->filled('name')) {
            $data['name'] = $validated['name'];
        }

        if ($request->filled('status_id')) {
            $data['status_id'] = $validated['status_id'];
        }

        // Jika ada gambar baru (opsional)
        if ($request->hasFile('image')) {
            // Hapus gambar lama (kalau ada)
            if (!empty($ext->image) && file_exists(public_path('extracurricular_images/' . $ext->image))) {
                unlink(public_path('extracurricular_images/' . $ext->image));
            }

            // Simpan gambar baru
            $manager = new ImageManager(new Driver());

            $image = $manager->read($request->file('image'))->toWebp(quality: 85);
            $filename = Str::uuid() . '.' . 'webp';

            Storage::disk('public')->put('extracurricular_images/' . $filename, $image->toString());

            // Simpan path relatif ke kolom image
            $data['image'] = 'extracurricular_images/' . $filename;
        }

        // Update data di database
        $ext->update($data);

        // Kembalikan data terbaru
        return response()->json([
            'message' => 'Extracurricular updated successfully',
            'data' => new ExtracurricularResource($ext),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Cache::forget('extracurricular');
        Cache::forget('extracurricular-admin');
        $extracurricular = Extracurricular::findOrFail($id);
        if ($extracurricular->image) {
            // Jika menggunakan Storage facade (untuk file di storage/app/public)
            Storage::disk('public')->delete($extracurricular->image);
        }
        $extracurricular->delete();

        return response()->json([
            'message' => 'Extracurricular deleted successfully'
        ]);
    }
}
