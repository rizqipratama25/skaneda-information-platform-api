<?php

namespace App\Http\Controllers;

use App\Http\Resources\AgendaResource;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;


class AgendaController extends Controller
{
    public function index()
    {
        $data = Cache::remember('agenda', 300, function () {
            $agendas = Agenda::with(['createdBy', 'updatedBy', 'deletedBy'])->get();
            return AgendaResource::collection($agendas)->resolve();
        });

        return response()->json($data);
    }

    public function createAgenda(Request $request)
    {
        Cache::forget('agenda');
        $request->validate([
            'name' => 'required',
            'dateTime' => 'required|date_format:Y-m-d H:i:s',
        ]);


        $agenda = Agenda::create([
            'name' => $request->name,
            'dateTime' => $request->dateTime
        ]);

        return response()->json(['data' => new AgendaResource($agenda)]);
    }

    public function updateAgenda(Request $request, $id)
    {
        Cache::forget('agenda');
        $agenda = Agenda::findOrFail($id);

        $validate = $request->validate([
            'name' => 'sometimes|string',
            'dateTime' => 'sometimes|date_format:Y-m-d H:i:s'
        ]);

        $agenda->update($validate);

        return response()->json([
            'message' => 'Update agenda successfully',
            'data' => new AgendaResource($agenda)
        ]);
    }

    public function deleteAgenda($id)
    {
        Cache::forget('agenda');
        $agenda = Agenda::findOrFail($id);
        $agenda->delete(); // soft delete, tidak benar-benar hilang dari DB

        return response()->json([
            'message' => 'Delete agenda successfully'
        ]);
    }
}
