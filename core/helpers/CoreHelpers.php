<?php

namespace core\helpers;

class CoreHelpers
{
    public static function dnd($data = [], $die = true): void
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        if ($die) {
            die;
        }
    }
}