<?php

namespace Core;

class Helpers
{
    public static function redirectSite(string $location): void
    {
        $base = self::getBaseURL();

        $location = $base . $location;

        header("Location: $location");
        exit;
    }

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

        while (substr($uri, -1) === '/')
            $uri = substr($uri, 0, -1);

        return ['method' => $method, 'uri' => $uri];
    }

    public static function rms(string $str): string
    {
        return preg_replace('/\s/', '', $str);
    }

    public static function rmms(string $str): string
    {
        return preg_replace('/\s+/', ' ', trim($str));
    }

    public static function msg(string $value, string $type = 'success'): array
    {
        return [
            'type' => $type,
            'value' => $value
        ];
    }

    public static function randomFileName(string $filename): string
    {
        $ext    = pathinfo($filename, PATHINFO_EXTENSION);
        $random = uniqid('pp_') . ".$ext";
        return $random;
    }

    public static function minifyHtml(string $buffer): string
    {
        $search = [
            '/\>[^\S ]+/s',
            '/[^\S ]+\</s',
            '/(\s)+/s',
            '/<!--(.|\s)*?-->/'
        ];

        $replace = [
            '>',
            '<',
            '\\1',
            ''
        ];

        return preg_replace($search, $replace, $buffer);
    }

    public static function explodeUrl(string $url): array
    {
        if ($url[0] === '/')
            $url = substr($url, 1);
        if (substr($url, -1) === '/')
            $url = substr($url, 0, -1);

        return array_map(
            function ($item) {
                return trim($item);
            },
            explode('/', $url)
        );
    }
}
