<?php

namespace App\Controllers;

use App\App\BlackMaid;


class PagesController
{

    public function home(): void
    {
        $blackMaid = new BlackMaid();
        $blackMaid->startGame();
        // You would return your view here, but since the php files use echo we dont need one,
    }

}
