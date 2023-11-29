<?php

namespace Core\Tmdb;

class TmdbConfig
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
