<?php
declare(strict_types=1);

class Blackjack {
    private Player $player;
    private Dealer $dealer;
    private Deck $deck;
    private string $winner;	

    public function __construct(Player $player, Deck $deck, Dealer $dealer) {
        $this->player = $player;
        $this->dealer = $dealer;
        $this->deck = $deck;
        $this->winner = "";
    }

    public function getPlayer() {
        return $this->player;
    }   

    public function getDealer() {
        return $this->dealer;
    }

    public function getDeck() {
        return $this->deck;
    }

    public function setWinner($winner) {
        $this->winner = $winner;
    }

    public function getWinner() {
        return $this->winner;
    }
}