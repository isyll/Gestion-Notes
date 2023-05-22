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

    public static function resolveRequest(): array
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = rawurldecode($_SERVER['REQUEST_URI']);

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        while ($uri[strlen($uri) - 1] === '/')
            $uri = substr($uri, 0, -1);

        return ['method' => $method, 'uri' => $uri];
    }

    public static function rms(string $str): string
    {
        return preg_replace('/\s/', '', $str);
    }

    public static function msg(string $value, string $type = 'success'): array
    {
        return [
            'type' => $type,
            'value' => $value
        ];
    }
}
