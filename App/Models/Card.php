<?php

namespace App\App\Models;

use App\Core\Database\Model;

class Card extends Model
{
    public static string $tableName = 'cards_view';

    public int $id;
    public string $category;
    public string $type;
    public int $value;
    public int $penalty_points;
    public User $user;
}
