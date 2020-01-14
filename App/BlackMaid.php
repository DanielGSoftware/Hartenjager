<?php

namespace App\App;

use App\App\Models\Card;
use App\App\Models\Player;
use App\App\Services\CardService;

class BlackMaid
{
    private array $players = [];
    private array $cardsInSet = [];

    public function startGame(): void
    {
        $this->players = Player::all();

        while (!$this->checkIfGameEnds()) {
            if ($this->players[0]->playerHasNoCards()) {
                $this->assignCards();
            }
            $this->playRound();
        }
    }

    private function assignCards(): void
    {
        $this->players = CardService::assignCardsToPlayers($this->players);
    }

    /**
     * Shift the starting order for the players so that the next player will start the round.
     */
    private function shiftStartingPlayer(): void
    {
        $firstPlayer = array_shift($this->players);
        $this->players[3] = $firstPlayer;
    }

    private function playRound(): void
    {
        $this->cardsInSet = [];
        foreach ($this->players as $key => $player) {
            $player->key = $key;

            $card = $player->selectCard($this->cardsInSet);

            $this->playCard($card, $player);
        }

        $this->assignPenaltyPointsToPlayer();
        $this->shiftStartingPlayer();
        echo '<br/>';
    }


    private function playCard(Card $card, Player $player): void
    {
        $this->cardsInSet[] = $card;
        echo "<pre> {$player->name} has played ";

        echo beautifyCardHtml($card);
    }


    private function checkIfGameEnds(): bool
    {
        foreach ($this->players as $player) {
            if (isset($player->penaltyPoints) && $player->penaltyPoints >= 50) {
                echo "<pre> Game ended. {$player->name} lost the game!";
                return true;
            }
        }
        return false;
    }

    private function assignPenaltyPointsToPlayer(): void
    {
        $highestCard = highestCardInSet($this->cardsInSet);
        $player = $highestCard->player;
        $player->penaltyPoints += $this->calculatePenaltyPoints();
        echo "<pre> {$player->name} has won this round.";
    }

    private function calculatePenaltyPoints(): int
    {
        $penaltyPoints = 0;
        foreach ($this->cardsInSet as $card) {
            $penaltyPoints += $card->penalty_points;
        }
        return $penaltyPoints;
    }

}