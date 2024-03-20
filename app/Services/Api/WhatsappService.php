<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\Http;

class WhatsappService
{
    private $apiHost = 'http://whatsapp.hasilkarya.co.id/api/';

    public function sendMessage($number, $message)
    {
        return Http::post($this->apiHost.'send-message', [
            'api_key' => '1672a326944cb9c6bfef5ffbc764b5c4988752f6',
            'receiver' => $number,
            'data' => [
                'message' => $message,
            ],
        ]);
    }
}
