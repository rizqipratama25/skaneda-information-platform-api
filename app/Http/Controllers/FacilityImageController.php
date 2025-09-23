<?php

namespace App\Http\Controllers;

use App\Models\FacilityImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FacilityImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = FacilityImage::all();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (FacilityImage::where('facility_id', $request->facility_id)->count() == 3) {
            return response()->json(['message' => 'The maximum number of images allowed is 3'], 400);
        }

        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'facility_id' => 'required|integer'
        ]);

        $path = $request->file('image')->store('facility_images', 'public');

        $facilityImage = FacilityImage::create([
            'image' => $path,
            'facility_id' => $request->facility_id
        ]);

        return response()->json($facilityImage, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(FacilityImage $facilityImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = FacilityImage::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update fields lain
        $post->fill($request->only(['title', 'content']));

        // Handle image update
        if ($request->hasFile('image')) {
            // Hapus image lama jika ada
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }

            // Upload image baru
            $imagePath = $request->file('image')->store('facility_images', 'public');
            $post->image = $imagePath;
        }

        $post->save();

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully',
            'data' => $post
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
    }
}
