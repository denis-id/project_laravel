<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data' => $response->json()
                ], 200);
            }

            return response()->json([
                'success' => false,
                'error' => 'Gagal mendapatkan respons dari OpenAI API',
                'details' => $response->json()
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan di server',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}