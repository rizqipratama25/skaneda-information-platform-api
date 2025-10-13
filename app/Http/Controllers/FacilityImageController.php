<?php

namespace App\Http\Controllers;

use App\Models\FacilityImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FacilityImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Cache::remember('facility-images', 300, function () {
            $facility = FacilityImage::all();
            return $facility;
        });

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Cache::forget('facility-images');
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
        $image = FacilityImage::findOrFail($id);
        $image->delete();
        
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
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Cache::forget('facility-images');
        $image = FacilityImage::findOrFail($id);
        $image->delete(); 

        return response()->json([
            'message' => 'Gambar Fasilitas berhasil dihapus'
        ]);
    }
}
