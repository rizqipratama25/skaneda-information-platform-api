<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Status;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facilities = Facility::with('images')->get();
        return response()->json($facilities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
    public function destroy(Facility $facility)
    {
        $facility->delete();

        return response()->json(["message" => "Delete successfully"], 204);
    }
}
