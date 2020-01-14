<?php

namespace App\Core;

use RuntimeException;

class App
{
    /**
     * All registered keys.
     * @var array
     */
    protected static $registry = [];

    /**
     * Bind a new key connected to a value into the container.
     *
     * @param  string $key
     * @param  mixed  $value
     */
    public static function bind($key, $value): void
    {
        static::$registry[$key] = $value;
    }

    /**
     * Get a value that was bind in the container by its key.
     *
     * @param $key
     * @return mixed
     */
    public static function get($key)
    {
        if (! array_key_exists($key, static::$registry)) {
            throw new RuntimeException("No {$key} is bound in the container.");
        }

        return static::$registry[$key];
    }
}
