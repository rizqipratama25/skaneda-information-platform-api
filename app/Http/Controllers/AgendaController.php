<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgendaController extends Controller
{
    public function buatAgenda(Request $request) {
        $request->validate([
            'name' => 'required',
            'dateTime' => 'required|date_format:Y-m-d H:i:s',
        ]);
        

        $user = Agenda::create([
            'name' => $request->name,
            'dateTime' => $request->dateTime
        ]);

        return response()->json(['data' => $user]);
    }
}
