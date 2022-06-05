<?php

namespace core;

use core\helpers\GenerateToken;
use Exception;

class Session
{
    public static function exists($name): bool
    {
        return isset($_SESSION[$name]);
    }

    public static function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public static function get($name)
    {
        if (self::exists($name) && !empty($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return false;
    }

    public static function delete($name)
    {
        unset($_SESSION[$name]);
    }


    /**
     * @throws Exception
     */
    public static function createCsrfToken()
    {
        $token = GenerateToken::CreateToken();
        self::set('_token', $token);
        return $token;
    }

    /**
     * @throws Exception
     */
    public static function csrfCheck()
    {
        $request = new Request();
        $check = $request->get('_token');
        if (self::exists('_token') && self::get('_token') == $check) {
            return true;
        }
        Router::redirect('auth/badToken');
    }

}