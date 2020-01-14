<?php

namespace App\Core;

class Request
{
    /**
     * Get the request URI
     *
     * @return string
     */
    public static function uri(): string
    {
        return trim($_SERVER['REQUEST_URI'], '/');
    }

    /**
     * Get the request method
     * @return mixed
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}