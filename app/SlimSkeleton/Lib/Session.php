<?php

namespace SlimSkeleton\Lib;

class Session
{
    public static function get(string $key, $default = null)
    {
        if(self::exists($key)) {
            return $_SESSION[$key];
        }

        return $default;
    }

    public static function exists(string $key)
    {
        return (isset($_SESSION[$key])) ? true : false;
    }

    public static function set(string $name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public static function destroy(string $key)
    {
        if(self::exists($key)) {
            unset($_SESSION[$key]);
        }
    }
}