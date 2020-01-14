<?php

namespace App\App\Services;

use App\App\Models\Card;

class CardService
{
    public static array $cards = [];

    public static function assignCardsToPlayers(array $players): array
    {
        if (empty(static::$cards)) {
            static::$cards = Card::all();
        }

        shuffle(static::$cards);
        $cardsToAssign = static::$cards;

        foreach ($players as $player) {
            $cards = array_splice($cardsToAssign, 0, 8);

            echo "<pre>{$player->name} has been given the following cards: ";
            foreach ($cards as $card) {
                $card->player = $player;
                echo beautifyCardHtml($card);
            }
            $player->setCards($cards);
        }

        return $players;
    }

}