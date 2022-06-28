<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackjack game</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php if ($blackjackGame->getWinner() !== ""): ?>
        <div class="overlay">
            <div class="overlay-content">
                <h3>Game over</h3>
                <p class="overlay__winner"><b><?= $blackjackGame->getWinner(); ?></b> wins</p>
                <p class="overlay__score-player">Player's score: <?= $blackjackGame->getPlayer()->getScore(); ?></p>
                <p class="overlay__score-dealer">Dealer's score: <?= $blackjackGame->getDealer()->getScore(); ?></p>
                <form method="post">
                    <button type="submit" name="new-game">Play again</button>
                </form>
            </div>
        </div>
    <?php endif ?>
    <main>
        <h1>Blackjack game</h1>
        <section class="blackjack-wrapper">
            <div class="player player--dealer">
                <h2>Dealer</h2>
                <!-- <p class="player-score__description">Current wins:</p>
                <p class="player-score__output">
                    <?= $blackjackGame->getDealer()->getWins(); ?>
                </p> -->
                <figure class="cards-wrapper cards-wrapper--dealer">
                    <figcaption class="player-card__description">Dealer's first card:</figcaption>
                    <?= $blackjackGame->getDealer()->getCards()[0]->getUnicodeCharacter(true); ?>
                </figure>
            </div>
            <div class="player player--you">
                <h2>You</h2>
                <!-- <p class="player-score__description">Current wins:</p>
                <p class="player-score__output">
                    <?= $blackjackGame->getPlayer()->getWins(); ?>
                </p> -->
                <div class="cards-wrapper">
                    <p class="player-card__description">Your cards:</p>
                    <div class="cards-wrapper--you">
                        <?php
                            for($i = 0; $i < $blackjackGame->getPlayer()->getCardCount(); $i++) {
                                echo $blackjackGame->getPlayer()->getCards()[$i]->getUnicodeCharacter(true);
                            }
                        ?>
                    </div>
                    <p>Your score:</p>
                    <p>
                        <?= $blackjackGame->getPlayer()->getScore();?>
                    </p>
                </div>
            </div>
        </section>
        <form class="blackjack-form" method="post">
            <button type="submit" name="hit">Hit</button>
            <button type="submit" name="stand">Stand</button>
            <button type="submit" name="surrender">Surrender</button>
        </form>
        
        <!-- <form class="reset-form" method="post">
            <button type="submit" name="reset">Reset the whole game</button>
            <p>(Including the times you or the dealer have won)</p>
        </form> -->
    </main>
</body>
</html>