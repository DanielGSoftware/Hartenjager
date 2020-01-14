<?php

namespace App\App\Services;

use App\App\Interfaces\SelectCardInterface;
use App\App\Models\Card;

/**
 * This service is responsible for picking the best card that a player can play in certain situations.
 * Class SelectCardService
 */
class SelectCardService implements SelectCardInterface
{
    private $playerCards;
    private array $cardsInSet = [];
    private int $turn;
    private int $highestValInSet = 0;

    private bool $playerHasALowerCard = false;

    public function setup(array $playerCards, array $cardsInSet, int $turn): void
    {
        $this->playerCards = $playerCards;
        $this->cardsInSet = $cardsInSet;
        $this->turn = $turn;
        $this->setHighestValInSet();
        $this->useLowerOrHigherCards();
    }

    /**
     * Select the best possible card for the player.
     * @return Card
     */
    public function selectCard(): Card
    {
        $playerCards = sortCardsByValue($this->playerCards);
        if ($this->playerHasALowerCard) {
            return $this->selectFromLowerCards($playerCards);
        }
        return $this->selectFromHigherCards($playerCards);
    }

    /**
     * If a player only has cards with a higher value, this function
     * will be used to choose the best option.
     * @param $cards
     * @return Card
     */
    private function selectFromHigherCards($cards): Card
    {
        if ($this->turn === 4) {
            return end($cards);
        }
        return $cards[0];
    }

    /**
     * If a player has cards with a lower value, this function
     * will be used to choose the best option.
     * @param $cards
     * @return Card
     */
    private function selectFromLowerCards($cards): Card
    {
        return end($cards);
    }

    /**
     * Check if the player has cards with a lower or a higher value then the current highest card value
     * in this set.
     */
    public function useLowerOrHigherCards(): void
    {
        foreach ($this->playerCards as $card) {
            if ($card->value <= $this->highestValInSet) {
                $cards[] = $card;
            }
        }
        if (isset($cards)) {
            $this->playerCards = $cards;
            $this->playerHasALowerCard = true;
        }
    }

    /**
     * Set $highestValInSet to the highest card value in the current set.
     */
    private function setHighestValInSet(): void
    {
        if (count($this->cardsInSet) !== 0) {
            $this->highestValInSet = highestCardInSet($this->cardsInSet)->value;
        }
    }

}
