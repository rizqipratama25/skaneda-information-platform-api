<?php

namespace App\Http\Controllers;

use App\Models\FacilityImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
        Cache::forget('facilities');
        Cache::forget('facilities-admin');
        if (FacilityImage::where('facility_id', $request->facility_id)->count() == 3) {
            return response()->json(['message' => 'The maximum number of images allowed is 3'], 400);
        }

        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'facility_id' => 'required|integer'
        ]);

        $manager = new ImageManager(new Driver());

        $image = $manager->read($request->file('image'))->toWebp(quality: 85);
        $filename = Str::uuid() . '.' . 'webp';

        Storage::disk('public')->put('facility_images/' . $filename, $image->toString());

        $facilityImage = FacilityImage::create([
            'image' => 'facility_images/' . $filename,
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
        // Ambil record
        $facilityImage = FacilityImage::findOrFail($id); // Ganti nama variabel

        // Validasi
        $validated = $request->validate([
            'facility_id' => 'sometimes|integer',
            'image'       => 'sometimes|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Tentukan facility target (dari request atau gunakan yang lama)
        $targetFacilityId = $validated['facility_id'] ?? $facilityImage->facility_id;

        // Hitung jumlah gambar lain di facility yang sama (kecualikan record ini)
        $count = FacilityImage::where('facility_id', $targetFacilityId)
            ->where('id', '!=', $facilityImage->id)
            ->count();

        if ($count >= 3) {
            return response()->json([
                'message' => 'The maximum number of images allowed is 3'
            ], 400);
        }

        // Jika ada file baru, hapus file lama lalu simpan yang baru
        if ($request->hasFile('image')) {
            // Hapus file lama jika ada
            if (!empty($facilityImage->image)) {
                Storage::disk('public')->delete($facilityImage->image);
            }

            // Simpan file baru ke storage/app/public/facility_images
            $manager = new ImageManager(new Driver());

            $processedImage = $manager->read($request->file('image'))->toWebp(quality: 85); // Ganti nama
            $filename = Str::uuid() . '.webp';

            Storage::disk('public')->put('facility_images/' . $filename, $processedImage->toString());

            // Simpan path relatif ke kolom image
            $facilityImage->image = 'facility_images/' . $filename;
        }

        // Update facility_id
        $facilityImage->facility_id = $targetFacilityId;
        $facilityImage->save();

        // Bersihkan cache terkait
        Cache::forget('facility-images');
        Cache::forget('facilities');
        Cache::forget('facilities-admin');

        return response()->json($facilityImage->fresh(), 200);
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
