<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(News::all());
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

        $path = $request->file('image')->store('news_image', 'public');

        $news = News::create([
            'title' => $request->title,
            'slug' => $this->generateUniqueSlug($request->title),
            'contents' => $request->contents,
            'image' => $path
        ]);


        return response()->json($news, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();

        return response()->json($news);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();

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

        $news->update($data);

        return response()->json($news, 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();
        $news->delete();

        return response()->json(["message" => "Delete successfully"]);
    }

    function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;

        while (News::where('slug', $slug)->withTrashed()->exists()) {
            $slug = $original . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
