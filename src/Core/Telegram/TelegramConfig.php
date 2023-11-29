<?php

namespace hasanalioz\TelegramBot\Core\Telegram;

class TelegramConfig
{
    private static $token;

    public static function setToken($token)
    {
        self::$token = $token;
    }

    public static function getToken()
    {
        return self::$token;
    }
}