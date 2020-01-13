<?php

namespace App\App\Services;

use App\App\Interfaces\SelectCardInterface;
use App\App\Models\Card;

class SelectCardService implements SelectCardInterface
{
    private array $cards;
    private array $cardsInSet;
    private int $turn;
    private int $highestValInSet = 0;

    protected bool $userHasALowerCard = false;

    public function setCards(array $cards): void
    {
        $this->cards = $cards;
    }

    public function setCardsInSet(array $cardsInset): void
    {
        $this->cardsInSet = $cardsInset;
    }

    public function setTurn(int $turn): void
    {
        $this->turn = $turn;
    }

    public function selectCard(): Card
    {
        $this->setHighestValInSet();
        $this->filterCardsByCategory();
        $this->lowerOrHigherCards();

        $cards = sortCardsByValue($this->cards);
        if ($this->userHasALowerCard) {
            return $this->selectFromLowerCards($cards);
        }

        return $this->selectFromHigherCards($cards);
    }

    private function selectFromHigherCards($cards): Card
    {
        if ($this->turn === 4) {
            return end($cards);
        }
        return $cards[0];
    }

    private function selectFromLowerCards($cards): Card
    {
        return end($cards);
    }

    private function filterCardsByCategory(): void
    {
        if (array_key_exists('hearts', $this->cards)) {
            $this->cards = $this->cards['hearts'];
        } else {
            $this->cards = $this->cards['otherCategories'];
        }
    }

    /**
     * If the user has one or more cards with a lower value then the current hightest value
     *  in this set, then return those. Otherwise, return the cards with a higher value.
     */
    public function lowerOrHigherCards(): void
    {
        $cards = [];
        foreach ($this->cards as $card) {
            if ($card->value < $this->highestValInSet) {
                $cards[] = $card;
            }
        }

        if (count($cards) !== 0) {
            $this->cards = $cards;
            $this->userHasALowerCard = true;
        }
    }

    private function setHighestValInSet(): void
    {
        if (count($this->cardsInSet) !== 0 ) {
            $this->highestValInSet = highestCardInSet($this->cardsInSet)->value;
        }
    }

}
