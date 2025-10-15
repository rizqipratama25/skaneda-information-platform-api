<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Cache::remember('news', 300, function () {
            $news = News::with(['createdBy', 'updatedBy', 'deletedBy'])->get();
            return NewsResource::collection($news)->resolve();
        });

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Cache::forget('news');
        $request->validate([
            'title' => 'required|string|max:255',
            'contents' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $path = $request->file('image')->store('news_images', 'public');

        $news = News::create([
            'title' => $request->title,
            'slug' => $this->generateUniqueSlug($request->title),
            'contents' => $request->contents,
            'image' => $path
        ]);


        return response()->json(new NewsResource($news), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $news = News::where('slug', $slug)->firstOrFail();

        return response()->json(new NewsResource($news));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        // Hapus cache lama
        Cache::forget('news');

        // Ambil data news berdasarkan slug
        $news = News::where('slug', $slug)->firstOrFail();

        // Validasi input
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'contents' => 'sometimes|string',
            'image' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048', // optional jika nanti mau ubah gambar juga
        ]);

        $data = [];

        // Update title dan slug unik
        if ($request->filled('title')) {
            $newTitle = trim($validated['title']);

            // selalu update title, tapi slug hanya jika judul BERUBAH
            if ($newTitle !== $news->title) {
                $data['title'] = $newTitle;
                // generate slug unik sambil mengabaikan ID berita ini sendiri
                $data['slug']  = $this->generateUniqueSlug($newTitle);
            } else {
                // judul sama persis → jangan ubah slug
                $data['title'] = $newTitle;
            }
        }

        // Update konten
        if ($request->filled('contents')) {
            $data['contents'] = $validated['contents'];
        }

        // Jika ada gambar baru (opsional)
        if ($request->hasFile('image')) {
            // Hapus gambar lama (kalau ada)
            if (!empty($news->image) && file_exists(public_path('news_images/' . $news->image))) {
                unlink(public_path('news_images/' . $news->image));
            }

            // Simpan gambar baru
            $path = $request->file('image')->store('news_images', 'public');

            // Simpan path relatif ke kolom image
            $data['image'] = $path;
        }

        // Update data di database
        $news->update($data);

        // Kembalikan data terbaru
        return response()->json([
            'message' => 'News updated successfully',
            'data' => new NewsResource($news),
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        Cache::forget('news');
        $news = News::where('slug', $slug)->firstOrFail();
        if ($news->image) {
            // Jika menggunakan Storage facade (untuk file di storage/app/public)
            Storage::disk('public')->delete($news->image);
        }
        $news->delete();

        return response()->json(["message" => "News deleted successfully"]);
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
