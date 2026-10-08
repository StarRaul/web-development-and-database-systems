<?php
$pageTitle = 'About Us';
require_once 'header.php';
?>

    <div id="main">
        <div class="inner">
            <h1>About Us</h1>
            <p>
                Welcome to <strong>Game Leaderboards</strong> — a place for gamers to track and compare
                their scores across some of the best titles out there.
            </p>
            <p>
                Upload your screenshot, post your score, and see where you rank against everyone else.
                Three games, one community.
            </p>
            <h2>Games</h2>
            <ul>
                <li><a href="game.php?id=alanwake">Alan Wake 2</a></li>
                <li><a href="game.php?id=residentevil">Resident Evil 4</a></li>
                <li><a href="game.php?id=titanfall">Titanfall 2</a></li>
            </ul>
        </div>
    </div>

<?php require_once 'footer.php'; ?>
