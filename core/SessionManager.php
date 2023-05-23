<?php

namespace Core;

class SessionManager
{
    public static function start()
    {
        session_start();
    }

    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    public static function remove(string|array $keys): void
    {
        if (!is_array($keys))
            $keys = [$keys];

        foreach ($keys as $key)
            unset($_SESSION[$key]);
    }

    public static function destroy()
    {
        session_destroy();
        $_SESSION = [];
    }

    public static function newId(): bool
    {
        return session_regenerate_id();
    }
}
