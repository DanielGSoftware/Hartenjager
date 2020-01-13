<?php

namespace App\App\Services;

use App\App\Models\Card;
use App\App\Models\User;

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
            echo "<pre>{$user->name} has been given the following cards: ";
            foreach ($cards as $card) {
                echo beautifyCardHtml($card);
            }
            $classifiedCards = $this->classifyCardsByCategory($user, $cards);
            $user->cards = $classifiedCards;
        }

        return $users;
    }

    private function classifyCardsByCategory(User $user, array $cards): array
    {
        foreach ($cards as $card) {
            $card->user = $user;
            if ($card->category !== 'hearts') {
                $sortedCards['otherCategories'][] = $card;
            } else {
                $sortedCards[$card->category][] = $card;
            }
        }

        return $sortedCards;

    }


}