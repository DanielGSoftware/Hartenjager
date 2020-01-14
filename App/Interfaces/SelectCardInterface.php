<?php

namespace App\App\Interfaces;

use App\App\Models\Card;

/**
 * Bonus
 * If someone else would download this project and thinks to himself: "Hmm, I can make a service that
 * picks even better cards for the user to play". Then his service should implement this interface so that the rest
 * of the program will still work.
 *
 * Interface SelectCardInterface
 * @package App\App\Interfaces
 */

interface SelectCardInterface
{
    public function setup(array $playerCards, array $cardsInSet, int $turn): void;

    public function selectCard(): Card;

}