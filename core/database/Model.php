<?php

namespace App\Core\Database;

use App\Core\App;

abstract class Model
{
    private $queryBuilder;

    public function __construct()
    {
        $this->queryBuilder = App::get('database');
    }

    public function find(int $id)
    {
        return $this->queryBuilder->find($this->tableName, $id);
    }

    public static function all()
    {
        return App::get('database')->selectAll(static::$tableName, static::class);
    }

}