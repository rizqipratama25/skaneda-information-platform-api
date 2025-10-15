<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FeedbackController extends Controller
{
    public function index()
    {
        $data = Cache::remember('feedbacks', 300, function () {
            $feedback = Feedback::all();
            return $feedback;
        });

        return response()->json($data);
    }

    public function store(Request $request)
    {
        Cache::forget('feedbacks');
        $request->validate([
            'message' => 'required|string',
        ]);


        $feedback = Feedback::create([
            'message' => $request->message,
        ]);

        return response()->json($feedback);
    }

    public function destroy($id)
    {
        Cache::forget('feedbacks');
        $feedback = Feedback::findOrFail($id);
        $feedback->delete(); // soft delete, tidak benar-benar hilang dari DB

        return response()->json([
            'message' => 'Feedback deleted successfully'
        ]);
    }
}
