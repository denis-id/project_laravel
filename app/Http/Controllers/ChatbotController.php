<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        try {
            $apiKey = env('OPENAI_API_KEY');  
            $apiBase = env('OPENAI_API_BASE', 'https://api.together.ai/v1'); 

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->post("$apiBase/chat/completions", [
                'model' => 'mistralai/Mistral-7B-Instruct-v0.1', 
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                    ['role' => 'user', 'content' => $request->message]
                ],
                'max_tokens' => 100,
            ]);

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan di server',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}