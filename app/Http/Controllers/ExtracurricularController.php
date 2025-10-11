<?php

namespace App\Http\Controllers;

use App\Models\Extracurricular;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExtracurricularController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Extracurricular::all();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('image')->store('extracurricular_images', 'public');

        $defaultStatusId = Status::firstOrCreate(['status' => 'Active'])->id;

        $data = Extracurricular::create([
            'name' => $request->name,
            'image' => $path,
            'status_id' => $request->status_id ?? $defaultStatusId
        ]);

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Extracurricular $extracurricular)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $image = Extracurricular::findOrFail($id);
        $image->delete();

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('image')->store('extracurricular_images', 'public');

        $defaultStatusId = Status::firstOrCreate(['status' => 'Active'])->id;

        $data = Extracurricular::create([
            'name' => $request->name,
            'image' => $path,
            'status_id' => $request->status_id ?? $defaultStatusId
        ]);

        return response()->json($data, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $extracurricular = Extracurricular::findOrFail($id);
        if ($extracurricular->image) {
            // Jika menggunakan Storage facade (untuk file di storage/app/public)
            Storage::disk('public')->delete($extracurricular->image);
        }
        $extracurricular->delete(); 

        return response()->json([
            'message' => 'Delete successfully'
        ]);
    }
}
