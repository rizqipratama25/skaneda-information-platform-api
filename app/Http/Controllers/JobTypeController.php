<?php

namespace App\Http\Controllers;

use App\Models\JobType;
use App\Models\Status;
use Illuminate\Http\Request;

class JobTypeController extends Controller
{
    public function index()
    {
        $data = JobType::all();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $defaultStatusId = Status::firstOrCreate(['status' => 'Active'])->id;

        $request->validate([
            'type' => "required|string",
        ]);


        $data = JobType::create([
            'type' => $request->type,
        ]);

        return response()->json(['data' => $data]);
    }

    public function update(Request $request, string $id)
    {
        $data = JobType::findOrFail($id);

        $validate = $request->validate([
            'type' => "required|string",
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
        $data = JobType::findOrFail($id);
        $data->delete();

        return response()->json([
            'message' => 'Loker berhasil dihapus'
        ]);
    }
}
