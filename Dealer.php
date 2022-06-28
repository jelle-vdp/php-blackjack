<?php
declare(strict_types=1);

class Dealer extends Player
{

    public function __construct(Deck $deck){
        parent::__construct($deck);
    }

    function hitIfMin15(){    
        while (parent::getScore() <= 15) {
            parent::hit();
        }
    }
};