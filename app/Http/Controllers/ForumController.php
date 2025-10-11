<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\Status;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facilities = Forum::with(['status'])->get();
        return response()->json($facilities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $defaultStatusId = Status::firstOrCreate(['status' => 'Active'])->id;

        $request->validate([
            'forum_name' => 'required|string',
            'description' => 'required|string',
        ]);


        $data = Forum::create([
            'forum_name' => $request->forum_name,
            'description' => $request->description,
            'status_id' => $request->status_id ?? $defaultStatusId
        ]);

        return response()->json(['data' => $data]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Forum::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Forum::findOrFail($id);

        $validate = $request->validate([
            'forum_name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'status_id' => 'sometimes|integer',
        ]);

        $data->update( $validate);

        return response()->json([
            'message' => 'Berhasil update Forum',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Forum::findOrFail($id);
        $data->delete(); // soft delete, tidak benar-benar hilang dari DB

        return response()->json([
            'message' => 'Forum berhasil dihapus'
        ]);
    }
}
