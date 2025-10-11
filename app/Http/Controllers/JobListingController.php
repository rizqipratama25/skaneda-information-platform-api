<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\Status;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    public function index()
    {
        $data = JobListing::all();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $defaultStatusId = Status::firstOrCreate(['status' => 'Active'])->id;

        $request->validate([
            'name' => "required|string",
            'open_positions' => "required|integer",
            'position' => "required|string",
            'type' => "required|string",
            'location' => "required|string",
            'description' => "required|string",
            'registration_link' => "required|string"
        ]);


        $data = JobListing::create([
            'name' => $request->name,
            'open_positions' => $request->open_positions,
            'position' => $request->position,
            'type' => $request->type,
            'location' => $request->location,
            'description' => $request->description,
            'registration_link' => $request->registration_link,
            'status_id' => $request->status_id ?? $defaultStatusId
        ]);

        return response()->json(['data' => $data]);
    }

    public function update(Request $request, string $id)
    {
        $data = JobListing::findOrFail($id);

        $validate = $request->validate([
            'name' => "sometimes|string",
            'open_positions' => "sometimes|integer",
            'position' => "sometimes|string",
            'type' => "sometimes|string",
            'location' => "sometimes|string",
            'description' => "sometimes|string",
            'registration_link' => "sometimes|string"
        ]);

        $data->update($validate);

        return response()->json([
            'message' => 'Berhasil update Loker',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = JobListing::findOrFail($id);
        $data->delete();

        return response()->json([
            'message' => 'Loker berhasil dihapus'
        ]);
    }
}
