<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatBotController extends Controller
{

    public function ask(Request $request)
    {
        $user = User::where('id', $request->user()->id)->first();
        if ($user) {

            $question = $request->input('question');

            if (!$question) {
                return SendResponse(400,'قم بادخال السؤال',[]);
            }

            $url='https://ali-saleh-22-chat.hf.space/ask';
            $response = Http::withHeaders([
                // 'Authorization' => config('services.chatbot.token'),
                'Content-Type' => 'application/json',
            ])->post($url, [
                'question' => $question
            ]);

            if ($response->failed()) {
                return SendResponse(500,' حدث خطا اثناء الارسال ل AI ',[]);
            }

            $aiResponse = $response->json()['response'] ?? 'رد غير معروف من الـ AI';

            return SendResponse(200,' هذا هوا رد AI ', $aiResponse);

        }
    }
}
