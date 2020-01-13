<?php

namespace App\App\Interfaces;

use App\App\Models\Card;

interface SelectCardInterface
{
    public function selectCard(): Card;

    public function setCards(array $cards): void;

    public function setCardsInSet(array $cards): void;

    public function setTurn(int $turn): void;


}