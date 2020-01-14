<?php

namespace App\App\Models;

use App\App\Services\SelectCardService;
use App\Core\Database\Model;

class Player extends Model
{
    protected static string $tableName = 'players';

    public string $name;
    public int $penaltyPoints = 0;
    public int $key;

    private array $heartCards = [];
    private array $otherCards = [];

    private selectCardService $selectCardService;

    public function __construct()
    {
        $this->selectCardService = new SelectCardService();
    }

    public function playerHasNoCards(): bool
    {
        return (empty($this->getAllCards()));
    }

    /**
     * Sets the cards of this player. Heart cards are separated from the rest of the cards.
     * @param array $cards
     */
    public function setCards(array $cards): void
    {
        foreach ($cards as $card) {
            if ($card->category === 'hearts') {
                $this->heartCards[] = $card;
            } else {
                $this->otherCards[] = $card;
            }
        }
    }

    /**
     * Select a card from the player that he will play.
     * @param array $cardsInSet
     * @return Card
     */
    public function selectCard(array $cardsInSet): Card
    {
        $this->selectCardService->setup($this->getPlayCards(), $cardsInSet, $this->key);

        $card = $this->selectCardService->selectCard();
        $this->removeCardFromPlayer($card);

        return $card;
    }

    /**
     * If the player has heart cards return those. Else, return the rest of the cards.
     * @return array
     */
    private function getPlayCards(): array
    {
        return (empty($this->heartCards)) ? $this->otherCards : $this->heartCards;
    }

    /**
     * This function is used to remove the played card from the player.
     * @param Card $card
     */
    private function removeCardFromPlayer(Card $card): void
    {
        $cards = $this->getAllCards();
        $this->resetCards();

        foreach ($cards as $key => $userCard) {
            if ($userCard->id === $card->id) {
                unset($cards[$key]);
                $this->setCards($cards);
            }
        }
    }

    /**
     * Combines the heart cards and the cards with other categories.
     * @return array
     */
    private function getAllCards(): array
    {
        return array_merge($this->heartCards, $this->otherCards);
    }

    private function resetCards(): void
    {
        $this->otherCards = [];
        $this->heartCards = [];
    }

}