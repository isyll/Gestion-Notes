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

        if (isset(self::$paths[$uri])) {
            $class           = self::$paths[$uri]['class'];
            $action          = self::$paths[$uri]['action'];
            $request_methods = self::$paths[$uri]['request_methods'];

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
            if ($values['name'] && $path !== 'page404')
                return $path;
        }

        return '';
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
