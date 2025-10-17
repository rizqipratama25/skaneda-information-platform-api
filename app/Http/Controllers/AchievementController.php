<?php

namespace App\Http\Controllers;

use App\Http\Resources\AchievementResource;
use App\Http\Resources\AgendaResource;
use App\Models\Achievements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $achievements = Achievements::with(['category', 'createdBy', 'updatedBy', 'deletedBy'])->get();
        return response()->json(AchievementResource::collection($achievements));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'category_id' => 'required|integer'
        ]);

        $manager = new ImageManager(new Driver());

        $image = $manager->read($request->file('image'))->toWebp(quality: 85);
        $filename = Str::uuid() . '.' . 'webp';

        Storage::disk('public')->put('achievements_image/' . $filename, $image->toString());

        $achievement = Achievements::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => 'achievements_image/' . $filename,
            'category_id' => $request->category_id
        ]);


        return response()->json(new AchievementResource($achievement), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $achivement = Achievements::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
            'category_id' => 'sometimes|integer'
        ]);

        $data = [];

        if ($request->filled('title')) {
            $data['title'] = $validated['title'];
        }

        if ($request->filled('description')) {
            $data['description'] = $validated['description'];
        }

        if ($request->filled('category_id')) {
            $data['category_id'] = $validated['category_id'];
        }

        // Jika ada gambar baru (opsional)
        if ($request->hasFile('image')) {
            // Hapus gambar lama (kalau ada)
            if (!empty($achivement->image) && file_exists(public_path('achievements_image/' . $achivement->image))) {
                unlink(public_path('achievements_image/' . $achivement->image));
            }

            // Simpan gambar baru
            $manager = new ImageManager(new Driver());

            $image = $manager->read($request->file('image'))->toWebp(quality: 85);
            $filename = Str::uuid() . '.' . 'webp';

            Storage::disk('public')->put('achievements_image/' . $filename, $image->toString());

            // Simpan path relatif ke kolom image
            $data['image'] = 'achievements_image/' . $filename;
        }

        // Update data di database
        $achivement->update($data);

        // Kembalikan data terbaru
        return response()->json([
            'message' => 'Achievement updated successfully',
            'data' => new AchievementResource($achivement),
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $achievement = Achievements::findOrFail($id);
        if ($achievement->image) {
            // Jika menggunakan Storage facade (untuk file di storage/app/public)
            Storage::disk('public')->delete($achievement->image);
        }
        $achievement->delete();

        return response()->json(["message" => "Achievement deleted successfully"]);
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
