<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobResource;
use App\Models\JobListing;
use App\Models\Status;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    public function index()
    {
        $data = JobListing::all();
        return response()->json(JobResource::collection($data));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => "required|string",
            'open_positions' => "required|integer",
            'position' => "required|string",
            'type_id' => "required|integer",
            'location' => "required|string",
            'description' => "required|string",
            'registration_link' => "required|string"
        ]);


        $data = JobListing::create([
            'name' => $request->name,
            'open_positions' => $request->open_positions,
            'position' => $request->position,
            'type_id' => $request->type_id,
            'location' => $request->location,
            'description' => $request->description,
            'registration_link' => $request->registration_link,
        ]);

        return response()->json(new JobResource($data));
    }

    public function update(Request $request, string $id)
    {
        $data = JobListing::findOrFail($id);

        $validate = $request->validate([
            'name' => "sometimes|string",
            'open_positions' => "sometimes|integer",
            'position' => "sometimes|string",
            'type_id' => "sometimes|integer",
            'location' => "sometimes|string",
            'description' => "sometimes|string",
            'registration_link' => "sometimes|string"
        ]);

        $data->update($validate);

        return response()->json([
            'message' => 'Job updated successfully',
            'data' => new JobResource($data)
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
            'message' => 'Job deleted successfully'
        ]);
    }
}
