<?php

namespace Core;

class Helpers
{
    public static function getBaseURL(): string
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $url = 'https';
        else
            $url = 'http';

        $url .= "://{$_SERVER['HTTP_HOST']}";
        return $url;
    }

    public static function resolveRequest() : array
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        return ['method' => $method, 'uri' => $uri];
    }
}
