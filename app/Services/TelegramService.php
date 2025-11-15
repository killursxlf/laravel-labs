<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    public function sendMessage(string $text, ?int $chatId = null): void
    {
        $token  = config('services.telegram.bot_token');
        $chatId = $chatId ?? config('services.telegram.chat_id');

        if (!$token || !$chatId) {
            Log::warning('Telegram: token or chat_id is not set');
            return;
        }

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $response = Http::post($url, [
            'chat_id'    => $chatId,
            'text'       => $text,
            'parse_mode' => 'HTML',
        ]);

        Log::info('Telegram message sent', [
            'chat_id' => $chatId,
            'text'    => $text,
            'status'  => $response->status(),
            'body'    => $response->body(),
        ]);

        $response->throw();
    }
}
