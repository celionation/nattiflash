<?php

namespace core;

class Config
{
    private static array $config = [
        'version'               =>      '1.0.0',
        'root_dir'              =>      '/', // This will be / on live server
        'default_controller'    =>      'Blog',
        'default_layout'        =>      'default',
        'default_site_title'    =>      'NattiFlash',
        'db_host'               =>      '127.0.0.1', // Please use Ip address instead of domain names
        'db_name'               =>      'blog',
        'db_user'               =>      'root',
        'db_pass'               =>      '',
        'login_cookie_name'     =>      '765rdfghjkiuy4e'
    ];

    public static function get($key)
    {
        if (array_key_exists($key, $_ENV)) return $_ENV[$key];
        return array_key_exists($key, self::$config) ? self::$config[$key] : null;
    }
}