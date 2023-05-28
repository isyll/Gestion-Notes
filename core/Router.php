<?php

namespace Core;

class Router
{
    private static array $paths;
    public static string $namespace;
    public static string $current = '';
    public static string $title = '';

    public static function register(
        string $name,
        string $handler,
        array $methods = [],
        string $path = null
    ): void {
        $methods = array_map(function ($value) {
            return strtoupper($value);
        }, $methods);

        $path = $path ?? "/$name";

        self::$paths[$path] = self::combine([
            'name' => $name,
            'handler' => $handler,
            'request_methods' => $methods
        ]);
    }

    public static function loadConfig(array $config)
    {
        foreach ($config as $route => $data)
            self::$paths[$route] = self::combine($data);
    }

    public static function execute()
    {
        [$method, $uri] = array_values(Helpers::resolveRequest());

        $ns = self::$namespace;

        if ($match = self::match($uri)) {
            $class           = $match['class'];
            $action          = $match['action'];
            $request_methods = $match['request_methods'];

            $args = '';
            if (isset($match['arg'])) {
                foreach ($match['arg'] as $name => $value) {
                    $args .= "$name:'$value',";
                }
            }

            if (
                empty($request_methods) ||
                (!empty($request_methods) && in_array($method, $request_methods))
            ) {
                self::$current = $match['name'] ?? '';
                self::$title   = $match['title'] ?? '';

                eval("use $ns\\$class;(new $class())->$action($args);");
                return;
            }
        }

        header('HTTP/1.1 404 Not Found');

        if (isset(self::$paths['page404'])) {
            $class  = self::$paths['page404']['class'];
            $action = self::$paths['page404']['action'];

            self::$current = $match['name'] ?? '';
            self::$title   = $match['title'] ?? '';

            eval("use $ns\\$class;(new $class())->$action();");
        }
    }

    public static function getURLs()
    {
        $urls = [];

        foreach (self::$paths as $path => $values) {
            if (!empty($values['name']))
                if ($pos = strpos($path, '{')) {
                    $path = substr($path, 0, $pos);
                }
            $urls[$values['name']] = $path;
        }

        return $urls;
    }

    public static function getAPIRoutes()
    {
        $urls = [];

        foreach (self::$paths as $path => $values) {
            if (!empty($values['name']))
                if (str_starts_with($path, '/api')) {
                    if ($pos = strpos($path, '{')) {
                        $path = substr($path, 0, $pos);
                    }
                    $urls[$values['name']] = $path;
                }
        }

        return $urls;
    }

    private static function match(string $uri): array|false
    {
        if ($uri === '')
            $uri = '/';

        if (isset(self::$paths[$uri])) {
            return self::$paths[$uri];
        } else {
            foreach (self::$paths as $path => $data) {
                $parts    = Helpers::explodeUrl($path);
                $uriParts = Helpers::explodeUrl($uri);

                if (count($parts) !== count($uriParts)) {
                    continue;
                }

                $tmp = false;

                for ($i = 0, $c = count($parts); $i < $c; $i++) {
                    if ($parts[$i] !== '') {
                        if ($parts[$i][0] !== '{' || substr($parts[$i], -1) !== '}') {
                            if (strtolower($uriParts[$i]) !== strtolower($parts[$i])) {
                                $tmp = true;
                                break;
                            }
                        } else {
                            $data['arg'][substr($parts[$i], 1, -1)] = $uriParts[$i];
                        }
                    } else {
                        $tmp = true;
                        continue;
                    }
                }

                if ($tmp)
                    continue;

                return $data;
            }

            return false;
        }
    }

    private static function combine(array $data): array
    {
        extract($data);

        $handler = explode('@', $handler);
        $methods = array_map(function ($item) {
            return strtoupper($item);
        }, $methods ?? []);

        return array_combine(
            [
                'name',
                'class',
                'action',
                'request_methods',
                'title'
            ],
            [$name, $handler[0], $handler[1], $methods, $title ?? NULL]
        );
    }
}
