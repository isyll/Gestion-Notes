<?php

namespace Core;

class Router
{
    private Database $db;
    private array $path;
    private string $ns;

    public function __construct(string $ns, Database $db)
    {
        $this->db = $db;
        $this->ns = $ns;
    }

    public static function resolve(): array
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        return [$method, $uri];
    }

    public function register(
        string $name,
        array $handler,
        array $methods = [],
        string $path = null
    ): void {
        $methods = array_map(function ($value) {
            return strtoupper($value);
        }, $methods);

        $path = $path ?? "/$name";

        $this->path[$path] = array_combine(
            ['name', 'class', 'action', 'request_methods'],
            [$name, $handler[0], $handler[1], $methods]
        );
    }

    public function get(string $name): string|false
    {
        foreach ($this->path as $path => $value) {
            if ($value['name'] === $name)
                return $value['name'];
        }

        return false;
    }

    public function add404(array $handler)
    {
        $this->path['page404']['class']  = $handler[0];
        $this->path['page404']['action'] = $handler[1];
    }

    public function execute()
    {
        [$method, $uri] = self::resolve();

        if (isset($this->path[$uri])) {
            $class           = $this->path[$uri]['class'];
            $action          = $this->path[$uri]['action'];
            $request_methods = $this->path[$uri]['request_methods'];

            if (
                empty($request_methods) ||
                (!empty($request_methods) && in_array($method, $request_methods))
            ) {
                try {
                    eval("use {$this->ns}\\$class;(new $class(\$this->db, \$this))->$action();");
                }
                catch (\Exception $e) {
                    echo $e->getMessage();
                }
                return;
            }
        }

        header('HTTP/1.1 404 Not Found');

        if (isset($this->path['page404'])) {
            $class  = $this->path['page404']['class'];
            $action = $this->path['page404']['action'];

            eval("use {$this->ns}\\$class;(new $class(\$this->db))->$action();");
        }
    }

    public function getURLs()
    {
        $urls = [];

        foreach ($this->path as $path => $values) {
            if (!empty($values['name']))
                $urls[$values['name']] = $path;
        }

        return $urls;
    }

    public function getURL(string $name)
    {
        foreach ($this->path as $path => $values) {
            if ($values['name'] && $path !== 'page404')
                return $path;
        }

        return '';
    }
}