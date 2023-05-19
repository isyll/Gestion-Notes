<?php

namespace Core;

class Router
{
    private static array $paths;

    public static $namespace;
    public static Database $db;

    public static function resolve(): array
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        return [$method, $uri];
    }

    public static function register(
        string $name,
        array $handler,
        array $methods = [],
        string $path = null
    ): void {
        $methods = array_map(function ($value) {
            return strtoupper($value);
        }, $methods);

        $path = $path ?? "/$name";

        self::$paths[$path] = array_combine(
            ['name', 'class', 'action', 'request_methods'],
            [$name, $handler[0], $handler[1], $methods]
        );
    }

    public static function get(string $name): string|false
    {
        foreach (self::$paths as $path => $value) {
            if ($value['name'] === $name)
                return $value['name'];
        }

        return false;
    }

    public static function add404(array $handler)
    {
        self::$paths['page404']['class']  = $handler[0];
        self::$paths['page404']['action'] = $handler[1];
    }

    public static function execute()
    {
        [$method, $uri] = self::resolve();

        if (isset(self::$paths[$uri])) {
            $class           = self::$paths[$uri]['class'];
            $action          = self::$paths[$uri]['action'];
            $request_methods = self::$paths[$uri]['request_methods'];

            $ns = self::$namespace;
            $db = self::$db;

            if (
                empty($request_methods) ||
                (!empty($request_methods) && in_array($method, $request_methods))
            ) {
                try {
                    eval("use $ns\\$class;(new $class(\$db))->$action();");
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

            eval("use $ns\\$class;(new $class(\$db, self))->$action();");
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

    public function getURL(string $name)
    {
        foreach (self::$paths as $path => $values) {
            if ($values['name'] && $path !== 'page404')
                return $path;
        }

        return '';
    }
}