<?php

use App\App\Models\Card;

function sortCardsByValue(array $cards): array
{
    usort($cards, static function ($a, $b) {
        return $a->value <=> $b->value;
    });
    return $cards;
}

function highestCardInSet(array $cardsInSet): Card
{
    $cardsInSet = sortCardsByValue($cardsInSet);
    return end($cardsInSet);
}

function beautifyCardHtml(Card $card)
{
    $categoryIcon = '';
    switch ($card->category) {
        case 'hearts':
            $categoryIcon = '&#x2764;';
            break;

        case 'diamonds':
            $categoryIcon = '&#x25C7;';
            break;

        case 'spades':
            $categoryIcon = '&#9824;';
            break;

        case 'clover':
            $categoryIcon = '&#x1f340;';
            break;
    }

    return "<br> <span class='icon'>{$categoryIcon}</span> {$card->type}";
}
