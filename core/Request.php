<?php

namespace core;

class Request
{
    public function isPost(): bool
    {
        return $this->getRequestMethod() === 'POST';
    }

    public function isPut(): bool
    {
        return $this->getRequestMethod() === 'PUT';
    }

    public function isGet(): bool
    {
        return $this->getRequestMethod() === 'GET';
    }

    public function isDelete(): bool
    {
        return $this->getRequestMethod() === 'DELETE';
    }

    public function isPatch(): bool
    {
        return $this->getRequestMethod() === 'PATCH';
    }

    public function getRequestMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @param bool $input
     * @return array|false|string
     */
    public function get(bool $input = false)
    {
        if (!$input) {
            $data = [];
            foreach ($_REQUEST as $field => $value) {
                $data[$field] = self::sanitize($value);
            }
            return $data;
        }
        return array_key_exists($input, $_REQUEST) ? self::sanitize($_REQUEST[$input]) : false;
    }

    public static function sanitize($dirty): string
    {
        return htmlentities(trim($dirty), ENT_QUOTES, "UTF-8");
    }
}