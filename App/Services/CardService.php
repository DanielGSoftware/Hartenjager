<?php

namespace App\App\Services;

use App\App\Models\Card;

class CardService
{

    public array $cards = [];
    public array $cardsInSet = [];

    public function setup()
    {
        $this->cards = Card::all();
    }

    public function assignCards(array $users): array
    {
        shuffle($this->cards);
        $cardsToAssign = $this->cards;

        foreach ($users as $user) {
            $cards = array_splice($cardsToAssign, 0, 8);

            foreach ($cards as $card){
                $card->user = $user;
                echo beautifyCardHtml($card);
            }
            $user->setCards($cards);

            echo "<pre>{$user->name} has been given the following cards: ";

        }

        return $users;
    }

}