<?php

namespace Core;

class SessionManager
{
    public static function start()
    {
        session_start();
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    public function remove(string|array $keys): void
    {
        if (!is_array($keys))
            $keys = [$keys];

        foreach ($keys as $key)
            if (isset($_SESSION[$key]))
                unset($_SESSION[$key]);
    }

    public function destroy()
    {
        session_destroy();
        $_SESSION = [];
    }

    public function newId(): bool
    {
        return session_regenerate_id();
    }
}
