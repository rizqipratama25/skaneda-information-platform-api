<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Status;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $data = Chat::all();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $defaultStatusId = Status::firstOrCreate(['status' => 'Pending'])->id;

        $request->validate([
            'chat' => 'required|string',
            'forum_id' => 'required|integer',
        ]);


        $data = Chat::create([
            'chat' => $request->chat,
            'forum_id' => $request->forum_id,
            'status_id' => $request->status_id ?? $defaultStatusId
        ]);

        return response()->json(['data' => $data]);
    }

    public function update(Request $request, string $id)
    {
        $data = Chat::findOrFail($id);

        $validate = $request->validate([
            'chat' => 'sometimes|string',
            'forum_id' => 'sometimes|integer',
            'status_id' => 'sometimes|integer'
        ]);

        $data->update( $validate);

        return response()->json([
            'message' => 'Berhasil update Chat',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Chat::findOrFail($id);
        $data->delete(); 

        return response()->json([
            'message' => 'Chat berhasil dihapus'
        ]);
    }
}
