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

if (!isset($_SESSION["compareCards"])){
    $_SESSION["compareCards"] = false;
};

if (!isset($_SESSION["blackjack"])){
    $blackjackGame = generateNewGame(false);
} else {
    $blackjackGame = $_SESSION["blackjack"];
} 

if ($blackjackGame->getPlayer()->getScore() > 21){
    $blackjackGame->getPlayer()->setLost(true);
} else if ($blackjackGame->getDealer()->getScore() === 21){
    $blackjackGame->getPlayer()->setLost(true);
} else if ($_SESSION["compareCards"] === true){
    if($blackjackGame->getDealer()->getScore() >= $blackjackGame->getPlayer()->getScore()){
        $blackjackGame->getPlayer()->setLost(true);
    } else {
        $blackjackGame->getDealer()->setLost(true);
    }
    $_SESSION["compareCards"] = false;
}

if ($blackjackGame->getDealer()->getScore() > 21){
    $blackjackGame->getDealer()->setLost(true);
} else if ($blackjackGame->getPlayer()->getScore() === 21){
    $blackjackGame->getDealer()->setLost(true);
} else if ($_SESSION["compareCards"] === true){
    if($blackjackGame->getDealer()->getScore() >= $blackjackGame->getPlayer()->getScore()){
        $blackjackGame->getPlayer()->setLost(true);
    } else {
        $blackjackGame->getDealer()->setLost(true);
    }
    $_SESSION["compareCards"] = false;
}

if ($blackjackGame->getPlayer()->getLost() === true){
    $blackjackGame->setWinner("Dealer");
    $blackjackGame->getDealer()->wins();
    $_SESSION["blackjackWinsDealer"] = $blackjackGame->getDealer()->getWins();
}

if ($blackjackGame->getDealer()->getLost() === true){
    $blackjackGame->setWinner("Player");
    $blackjackGame->getPlayer()->wins();
    $_SESSION["blackjackWinsPlayer"] = $blackjackGame->getPlayer()->getWins();
}
$_SESSION["dontDoubleCheck"] = false;




if (isset($_POST["hit"])) {
    $blackjackGame->getPlayer()->hit();
    header('Location:' . $_SERVER['PHP_SELF']);
}

if (isset($_POST["stand"])) {
    $blackjackGame->getDealer()->hitIfMin15();
    $_SESSION["compareCards"] = true;
    header('Location:' . $_SERVER['PHP_SELF']);
}

if (isset($_POST["surrender"])) {
    $blackjackGame->getPlayer()->setLost(true);
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