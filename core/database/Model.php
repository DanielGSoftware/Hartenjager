<?php

namespace App\Core\Database;

use App\Core\App;

abstract class Model
{
    /**
     * @return mixed
     */
    public static function all()
    {
        return App::get('database')->selectAll(static::$tableName, static::class);
    }

}