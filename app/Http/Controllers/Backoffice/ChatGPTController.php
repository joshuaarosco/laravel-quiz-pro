<?php

namespace App\Http\Controllers\Backoffice;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;


class ChatGPTController extends Controller
{
    public function __invoke(Request $request){
        $response = Http::withHeaders([
            "Content-Type" => "application/json",
            "Authorization" => "Bearer ".env('CHAT_GPT_KEY')
        ])->post('https://api.openai.com/v1/chat/completions',[
            "model" => "gpt-4",
            "messages" => [
                [
                    "role" => "user",
                    "content" => $request->post('content')
                ]
            ],
            "temperature" => 0,
            "max_tokens" => 2048
        ])->body();

        return response();
    }

}
