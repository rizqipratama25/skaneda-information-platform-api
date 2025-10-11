<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Status::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $userStatus = Status::create($validated);

        return response()->json($userStatus, 201);
    }

    public function show(Status $userStatus)
    {
        return response()->json($userStatus);
    }

    public function update(Request $request, $id)
    {
        $userStatus = Status::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $userStatus->update($validated);

        return response()->json($userStatus);
    }

    public function destroy($id)
    {
        $userStatus = Status::findOrFail($id);
        $userStatus->delete();

        return response()->json(["message" => "Delete successfully"], 204);
    }
}
