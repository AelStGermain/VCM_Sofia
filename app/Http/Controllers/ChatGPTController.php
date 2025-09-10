<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatGPTController extends Controller
{
    public function askChatGPT(Request $request)
    {
        $input = $request->input('prompt');
        $apiKey = env('OPENAI_API_KEY');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/responses', [
                'model' => 'gpt-4o-mini',
                'input' => $input,
                'store' => true
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['error' => $response->json('error.message') ?? 'Error en la petición a OpenAI'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error de conexión'], 500);
        }
    }
}
