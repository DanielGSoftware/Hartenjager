<?php

namespace App\App;

use App\App\Models\Card;
use App\App\Models\User;
use App\App\Services\CardService;
use App\App\Services\SelectCardService;

class BlackMaid
{
    private array $users = [];
    private array $cardsInSet = [];

    private CardService $cardService;
    private selectCardService $selectCardService;

    public function setup()
    {
        $this->users = User::all();

        $this->cardService = new CardService();
        $this->cardService->setup();
        $this->users = $this->cardService->assignCards($this->users);
        $this->selectCardService = new SelectCardService();
    }

    public function startGame()
    {
        // Check if a user has reached over 50 points
        while (true) {
            if ($this->checkIfGameEnds()) {
                die();
            } else {
                if (!$this->usersHaveCards()) {
                    $this->users = $this->cardService->assignCards($this->users);
                }
                $this->playRound();
            }
        }

    }

    protected function playRound()
    {
        $this->cardsInSet = [];
        $turn = 1;
        foreach ($this->users as $key => $user) {
            $this->selectCardService->setCards($user->cards);
            $this->selectCardService->setCardsInSet($this->cardsInSet);
            $this->selectCardService->setTurn($turn);

            $card = $this->selectCardService->selectCard();
            $this->playCard($card, $user,);
            $this->removeCardFromUser($card, $key);
            $turn++;
        }
        $this->assignPenaltyPoints();
        echo '<br/> ';
    }


    private function playCard(Card $card, User $user): void
    {
        $this->cardsInSet[] = $card;
        echo "<pre> {$user->name} has played ";
        echo beautifyCardHtml($card);
    }

    private function removeCardFromUser(Card $card, int $userKey): bool
    {
        $cardCategory = ($card->category !== 'hearts') ? 'otherCategories' : $card->category;
        $user = $this->users[$userKey];

        foreach ($user->cards[$cardCategory] as $key => $userCard) {
            if ($userCard->id === $card->id) {
                //unset($this->users[$userKey]->cards[$cardCategory][$key]);
                $cardsArr = $this->users[$userKey]->cards[$cardCategory];
                $this->users[$userKey]->cards[$cardCategory] = array_splice($cardsArr, $key, $key);
                return true;
            }
        }

        return false;
    }

    private function checkIfGameEnds(): bool
    {
        foreach ($this->users as $user) {
            if (isset($user->penaltyPoints) && $user->penaltyPoints >= 50) {
                echo "<pre> Game ended. {$user->name} lost the game!";
                return true;
            }
        }
        return false;
    }

    private function calculatePenaltyPoints(): int
    {
        $penaltyPoints = 0;
        foreach ($this->cardsInSet as $card) {
            $penaltyPoints += $card->penalty_points;
        }

        return $penaltyPoints;
    }

    private function assignPenaltyPoints(): void
    {
        $highestCard = highestCardInSet($this->cardsInSet);
        $user = $highestCard->user;
        $user->penaltyPoints += $this->calculatePenaltyPoints();
        echo "<pre> {$user->name} has won this round.";
    }

    private function usersHaveCards(): bool
    {
        if (empty($this->users[0]->cards)) {
            return false;
        }
        return true;
    }

}