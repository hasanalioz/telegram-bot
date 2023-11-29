<?php

namespace hasanalioz\core\telegram;

use hasanalioz\core\telegram;

class TelegramClient
{
    private $chatId;
    const API_URL = 'https://api.telegram.org/bot';

    public function __construct()
    {
        TelegramConfig::setToken('6807755694:AAHRplT63tcK3_F_XIvYi3xQZXWh7krwgyc');
    }

    public function setWebhook($url)
    {
        return $this->request('setWebhook', ['url' => $url]);
    }

    public function getData()
    {
        $data = json_decode(file_get_contents('php://input'));
        $this->chatId = $data->message->chat->id;
        return $data->message;
    }

    public function sendMessage($message)
    {
        return $this->request('sendMessage', [
            'chat_id' => $this->chatId,
            'text' => $message
        ]);
    }

    public function request($method, $posts)
    {
        $ch = curl_init();
        $url = self::API_URL . TelegramConfig::getToken() . '/' . $method;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($posts));

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }
}
