<?php

namespace core;

class Cookie
{
    public static function get($name)
    {
        if (self::exists($name)) {
            return $_COOKIE[$name];
        }
        return false;
    }

    public static function set($name, $value, $expiry): bool
    {
        if (setCookie($name, $value, time() + $expiry, '/', "", false, true)) {
            return true;
        }
        return false;
    }

    public static function delete($name): bool
    {
        return self::set($name, '', -1);
    }

    public static function exists($name): bool
    {
        return isset($_COOKIE[$name]);
    }
}