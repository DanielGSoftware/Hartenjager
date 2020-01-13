<?php

namespace App\App\Models;

use App\Core\Database\Model;

class User extends Model
{
    public static string $tableName = 'users';

    public string $name;
    public int $penaltyPoints = 0;
    public array $cards = [];

}