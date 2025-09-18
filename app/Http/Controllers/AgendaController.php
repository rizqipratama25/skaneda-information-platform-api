<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::all();
        return response()->json(['data' => $agendas]);
    }

    public function createAgenda(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'dateTime' => 'required|date_format:Y-m-d H:i:s',
        ]);


        $agenda = Agenda::create([
            'name' => $request->name,
            'dateTime' => $request->dateTime,
            'made_by' => $request->user()->id,
            'updated_by' => $request->user()->id
        ]);

        return response()->json(['data' => $agenda]);
    }

    public function updateAgenda($id, Request $request)
    {
        $agenda = Agenda::findOrFail($id);

        $validate = $request->validate([
            'name' => 'sometimes|string',
            'dateTime' => 'sometimes|date_format:Y-m-d H:i:s'
        ]);

        $agenda->update(array_merge(
            $validate,
            ["updated_by" => $request->user()->id]
        ));

        return response()->json([
            'message' => 'Berhasil update agenda',
            'data' => $agenda
        ]);
    }

    public function deleteAgenda($id, Request $request)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete(); // soft delete, tidak benar-benar hilang dari DB

        return response()->json([
            'message' => 'Agenda berhasil dihapus',
            'data' => $agenda
        ]);
    }
}
