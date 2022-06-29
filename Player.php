<?php
declare(strict_types=1);

class Player {
    private array $cards;
    private bool $lost;
    private int $cardCount;
    private int $score;
    private int $wins;

    public function __construct(Deck $deck) {
        $this->cards = $deck->getCards();
        $this->cardCount = 2;
        $this->score = $deck->getCards()[0]->getValue() + $deck->getCards()[1]->getValue();
        $this->lost = $this->score > 21;
        $this->wins = 0;
    }

    public function hit(){
        $this->cardCount++;
        $this->calculateScore();
    }

    public function surrender(){
        $this->lost = true;
    }

    public function calculateScore(){
        $this->score = 0;
        for($i = 0; $i < $this->getCardCount(); $i++){
            $this->score += $this->getCards()[$i]->getValue();
        }
    }

    public function getCardCount(){
        return $this->cardCount;
    }
    
    public function getScore(){
        return $this->score;
    }

    public function setScore($score){
        $this->score = $score;
    }

    public function getCards(){
        return $this->cards;
    }

    public function getLost(){
        return $this->lost;
    }

    public function setLost($lost){
        $this->lost = $lost;
    }

    public function wins(){
        $this->wins += 1;
    }

    public function getWins(){
        return $this->wins;
    }
    
    public function setWins($wins){
        $this->wins = $wins;
    }
    
}