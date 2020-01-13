<?php

namespace App\Controllers;

use App\App\BlackMaid;


class PagesController
{

    public function home()
    {
        $hartenJager = new BlackMaid();
        $hartenJager->setup();
        $hartenJager->startGame();
        // You would return your view here
    }

}
