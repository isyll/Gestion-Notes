<?php

namespace Core;

class Router
{
    private static array $paths;

    public static $namespace;
    public static Database $db;

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
        $db = self::$db;

        if ($match = self::match($uri)) {
            $class           = $match['class'];
            $action          = $match['action'];
            $request_methods = $match['request_methods'];
            $arg             = $match['arg'] ?? '';

            $empty = empty($request_methods);
            if (
                $empty ||
                (!$empty && in_array($method, $request_methods))
            ) {
                try {
                    eval("use $ns\\$class;(new $class(\$db))->$action('$arg');");
                }
                catch (\Exception $e) {
                    echo $e->getMessage();
                }
                return;
            }
        }

        header('HTTP/1.1 404 Not Found');

        if (isset(self::$paths['page404'])) {
            $class  = self::$paths['page404']['class'];
            $action = self::$paths['page404']['action'];

            eval("use $ns\\$class;(new $class(\$db))->$action();");
        }
    }

    public static function getURLs()
    {
        $urls = [];

        foreach (self::$paths as $path => $values) {
            if (!empty($values['name']))
                $urls[$values['name']] = $path;
        }

        return $urls;
    }

    public static function getURL(string $name): string
    {
        foreach (self::$paths as $path => $values) {
            if ($values['name'] === $name && $path !== 'page404')
                return $path;
        }

        return '';
    }

    private static function match(string $uri): array|false
    {
        if ($uri === '')
            $uri = '/';

        if (isset(self::$paths[$uri]))
            return self::$paths[$uri];
        else {
            foreach (self::$paths as $path => $data) {
                $parts    = explode('/', $path);
                $uriParts = explode('/', $uri);

                if (count($parts) !== count($uriParts)) {
                    continue;
                }

                $tmp = false;

                for ($i = 0, $c = count($parts); $i < $c; $i++) {
                    if (strlen($parts[$i]) && strlen($uriParts[$i])) {
                        if (
                            $parts[$i][0] !== '{' &&
                            $parts[$i][strlen($parts[$i]) - 1] !== '}'
                        ) {
                            if (strtolower(trim($uriParts[$i])) !== strtolower(trim($parts[$i]))) {
                                $tmp = true;
                                break;
                            }
                        } else {
                            $data['arg'] = $uriParts[$i];
                        }
                    } else {
                        $tmp = true;
                        break;
                    }
                }

                if ($tmp) {
                    continue;
                }

                return $data;
            }

            return false;
        }
    }

    private static function combine(array $data): array
    {
        extract($data);

        $handler = explode('@', $handler);
        return array_combine(
            [
                'name',
                'class',
                'action',
                'request_methods',
            ],
            [$name, $handler[0], $handler[1], $methods ?? []]
        );
    }
}
