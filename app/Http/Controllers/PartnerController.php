<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PartnerController extends Controller
{
    public function index()
    {
        $data = Cache::remember('partners', 300, function () {
            $partner = Partner::paginate(10);
            return $partner;
        });

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        Cache::forget('partners');
        $partner = Partner::findOrFail($id);

        $validate = $request->validate([
            'name' => 'required|string',
        ]);

        $partner->update($validate);

        return response()->json([
            'message' => 'Partner updated successfully',
            'data' => $partner
        ]);
    }

    public function store(Request $request)
    {
        Cache::forget('partners');
        $request->validate([
            'name' => 'required|string',
        ]);


        $partner = Partner::create([
            'name' => $request->name,
        ]);

        return response()->json($partner);
    }

    public function destroy($id)
    {
        Cache::forget('partners');
        $partner = Partner::findOrFail($id);
        $partner->delete(); // soft delete, tidak benar-benar hilang dari DB

        return response()->json([
            'message' => 'Partner deleted successfully'
        ]);
    }
}
