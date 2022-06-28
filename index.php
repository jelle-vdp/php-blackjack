<?php
declare(strict_types=1);

require 'Suit.php';
require 'Card.php';
require 'Deck.php';
require 'Player.php';
require 'Dealer.php';
require 'Blackjack.php';

session_start();

// function whatIsHappening() {
//     echo '<h2>$_GET</h2>';
//     var_dump($_GET);
//     echo '<h2>$_POST</h2>';
//     var_dump($_POST);
//     echo '<h2>$_COOKIE</h2>';
//     var_dump($_COOKIE);
//     echo '<h2>$_SESSION</h2>';
//     var_dump($_SESSION);
// };

// whatIsHappening();

function generateNewGame($keepTotalScore) {
    $deck = new Deck();
    $deck->shuffle();
    $player = new Player($deck);
    $deck->shuffle();
    $dealer = new Dealer($deck);
    $blackjackGame = new Blackjack($player, $deck, $dealer);
    $_SESSION["blackjack"] = $blackjackGame;
    if ($keepTotalScore){
        if(isset($_SESSION["blackjackWinsDealer"])){
            $blackjackGame->getDealer()->setWins($_SESSION["blackjackWinsDealer"]);
        }
        if(isset($_SESSION["blackjackWinsPlayer"])){
            $blackjackGame->getPlayer()->setWins($_SESSION["blackjackWinsPlayer"]);
        }
    }
    return $blackjackGame;
}

if(!isset($_SESSION["blackjack"])){
    $blackjackGame = generateNewGame(false);
    if ($blackjackGame->getDealer()->getScore() === 21){
        $blackjackGame->setWinner("Dealer");
        $blackjackGame->getDealer()->wins();
        $_SESSION["blackjackWinsDealer"] = $blackjackGame->getDealer()->getWins();
    } elseif ($blackjackGame->getPlayer()->getScore() === 21) {
        $blackjackGame->setWinner("Player");
        $blackjackGame->getPlayer()->wins();
        $_SESSION["blackjackWinsPlayer"] = $blackjackGame->getPlayer()->getWins();
    } elseif ($blackjackGame->getPlayer()->getScore() > 21){
        $blackjackGame->setWinner("Dealer");
        $blackjackGame->getDealer()->wins();
        $_SESSION["blackjackWinsDealer"] = $blackjackGame->getDealer()->getWins();
    } elseif ($blackjackGame->getDealer()->getScore() > 21){
        $blackjackGame->setWinner("Player");
        $blackjackGame->getPlayer()->wins();
        $_SESSION["blackjackWinsPlayer"] = $blackjackGame->getPlayer()->getWins();
    }
} else {
    $blackjackGame = $_SESSION["blackjack"];
    if ($blackjackGame->getDealer()->getScore() === 21){
        $blackjackGame->setWinner("Dealer");
        $blackjackGame->getDealer()->wins();
        $_SESSION["blackjackWinsDealer"] = $blackjackGame->getDealer()->getWins();
    } elseif ($blackjackGame->getPlayer()->getScore() === 21) {
        $blackjackGame->setWinner("Player");
        $blackjackGame->getPlayer()->wins();
        $_SESSION["blackjackWinsPlayer"] = $blackjackGame->getPlayer()->getWins();
    } elseif ($blackjackGame->getPlayer()->getScore() > 21){
        $blackjackGame->setWinner("Dealer");
        $blackjackGame->getDealer()->wins();
        $_SESSION["blackjackWinsDealer"] = $blackjackGame->getDealer()->getWins();
    } elseif ($blackjackGame->getDealer()->getScore() > 21){
        $blackjackGame->setWinner("Player");
        $blackjackGame->getPlayer()->wins();
        $_SESSION["blackjackWinsPlayer"] = $blackjackGame->getPlayer()->getWins();
    }
}


if (isset($_POST["hit"])) {
    $blackjackGame->getPlayer()->hit();

    if ($blackjackGame->getPlayer()->getLost() === true || $blackjackGame->getPlayer()->getScore() > 21 || $blackjackGame->getDealer()->getScore() === 21){
        $blackjackGame->setWinner("Dealer");
        $blackjackGame->getDealer()->wins();
        $_SESSION["blackjackWinsDealer"] = $blackjackGame->getDealer()->getWins();
    }
    
    if ($blackjackGame->getDealer()->getLost() === true || $blackjackGame->getDealer()->getScore() > 21 || $blackjackGame->getPlayer()->getScore() === 21){
        $blackjackGame->setWinner("Player");
        $blackjackGame->getPlayer()->wins();
        $_SESSION["blackjackWinsPlayer"] = $blackjackGame->getPlayer()->getWins();
    }
    header('Location:' . $_SERVER['PHP_SELF']);
}

if (isset($_POST["stand"])) {
    $blackjackGame->getDealer()->hitIfMin15();
    if ($blackjackGame->getDealer()->getScore() === 21 || $blackjackGame->getDealer()->getScore() >= $blackjackGame->getPlayer()->getScore()) {
        $blackjackGame->setWinner("Dealer");
        $blackjackGame->getDealer()->wins();
        $_SESSION["blackjackWinsDealer"] = $blackjackGame->getDealer()->getWins();
    } else {
        $blackjackGame->setWinner("Player");
        $blackjackGame->getPlayer()->wins();
        $_SESSION["blackjackWinsPlayer"] = $blackjackGame->getPlayer()->getWins();
    }
    header('Location:' . $_SERVER['PHP_SELF']);
}

if (isset($_POST["surrender"])) {
    $blackjackGame->setWinner("Dealer");
    $blackjackGame->getDealer()->wins();
    $_SESSION["blackjackWinsDealer"] = $blackjackGame->getDealer()->getWins();
    header('Location:' . $_SERVER['PHP_SELF']);
}

if (isset($_POST["reset"])) {
    session_destroy();
    header('Location:' . $_SERVER['PHP_SELF']);
}

if (isset($_POST["new-game"])) {
    $blackjackGame = generateNewGame(true);
    header('Location:' . $_SERVER['PHP_SELF']);
}

require 'blackjack-view.php';