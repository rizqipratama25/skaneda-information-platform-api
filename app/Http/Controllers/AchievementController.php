<?php

namespace App\Http\Controllers;

use App\Models\Achievements;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Achievements::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'contents' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $path = $request->file('image')->store('achievements_image', 'public');

        $achievement = Achievements::create([
            'title' => $request->title,
            'slug' => $this->generateUniqueSlug($request->title),
            'contents' => $request->contents,
            'image' => $path
        ]);


        return response()->json($achievement, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $achievement = Achievements::where('slug', $slug)->firstOrFail();

        return response()->json($achievement);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $achievement = Achievements::where('slug', $slug)->firstOrFail();

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'contents' => 'sometimes|string',
        ]);

        $data = [];

        if ($request->filled('title')) {
            $data['title'] = $request->title;
            $data['slug'] = $this->generateUniqueSlug($request->title);
        }

        if ($request->filled('contents')) {
            $data['contents'] = $request->contents;
        }

        $achievement->update($data);

        return response()->json($achievement->fresh(), 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $achievement = Achievements::where('slug', $slug)->firstOrFail();
        $achievement->delete();

        return response()->json(["message" => "Delete successfully"]);
    }

    function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;

        while (Achievements::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
