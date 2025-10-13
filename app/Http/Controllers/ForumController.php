<?php

namespace App\Http\Controllers;

use App\Http\Resources\ForumDetailResource;
use App\Http\Resources\ForumResource;
use App\Models\Forum;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Cache::remember('forums', 300, function () {
            $forum = Forum::whereHas('status', function ($query) {
                $query->where('status', 'Active');
            })->get();

            return ForumResource::collection($forum)->resolve();
        });

        return response()->json($data);
    }

    public function indexAdmin()
    {
        $data = Cache::remember('forums-admin', 300, function () {
            $forum = Forum::all();

            return ForumResource::collection($forum)->resolve();
        });

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Cache::forget('forums');
        Cache::forget('forums-admin');
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
        return response()->json(new ForumDetailResource($data));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Cache::forget('forum');
        Cache::forget('forum-admin');
        $data = Forum::findOrFail($id);

        $validate = $request->validate([
            'forum_name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'status_id' => 'sometimes|integer',
        ]);

        $data->update($validate);

        return response()->json([
            'message' => 'Berhasil update Forum',
            'data' => new ForumResource($data)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cache::forget('forum');
        Cache::forget('forum-admin');
        $data = Forum::findOrFail($id);
        $data->delete(); // soft delete, tidak benar-benar hilang dari DB

        return response()->json([
            'message' => 'Forum berhasil dihapus'
        ]);
    }
}
