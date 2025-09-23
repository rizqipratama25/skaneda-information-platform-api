<?php

namespace App\Http\Controllers;

use App\Models\Extracurricular;
use App\Models\ExtracurricularImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExtracurricularImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ExtracurricularImage::all();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'extracurricular_id' => 'required|integer'
        ]);

        $path = $request->file('image')->store('news_image', 'public');

        $news = ExtracurricularImage::create([
            'image' => $path,
            'extracurricular_id' => $request->extracurricular_id
        ]);

        return response()->json($news, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExtracurricularImage $extracurricularImage)
    {
        // Validasi input
        $validated = $request->validate([
            'image' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
            'extracurricular_id' => 'required|integer'
        ]);

        // Kalau ada file baru
        if ($request->hasFile('image')) {
            // Hapus file lama (jika ada)
            if ($extracurricularImage->image && Storage::disk('public')->exists($extracurricularImage->image)) {
                Storage::disk('public')->delete($extracurricularImage->image);
            }

            // Simpan file baru
            $path = $request->file('image')->store('extracurricular_images', 'public');
            $validated['image'] = $path;
        }

        // Update data
        $extracurricularImage->update($validated);

        return response()->json([
            'message' => 'Extracurricular image updated successfully',
            'data' => $extracurricularImage
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExtracurricularImage $extracurricularImage)
    {
        //
    }
}
