<?php

namespace core\helpers;

class StringFormat
{
    public static function fromCamelCase($input): string
    {
        $pattern = '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!';

        preg_match_all($pattern, $input, $matches);
        $ret = $matches[0];
        foreach ($ret as $match) {
            $match = $match == strtoupper($match) ? strtolower($match): lcfirst($match);
        }
        return implode('_', $ret);
    }


    /**
     * Excerpt Function
     *
     * This function helps short Text Content;
     * Accept Two Params
     * @param [type] $text for the variable to short
     * @param int|string $length for number of length
     *
     * @return string
     */
    public static function Excerpt($text, $length = 15): string
    {
        return substr($text, 0, $length) . '...';
    }
}