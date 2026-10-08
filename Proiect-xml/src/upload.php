<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['currentuser'])) {
    header('Location: login.php');
    exit;
}

$gameId     = $_GET['game'] ?? 'alanwake';
$validGames = ['alanwake' => 'Alan Wake 2', 'residentevil' => 'Resident Evil 4', 'titanfall' => 'Titanfall 2'];
if (!array_key_exists($gameId, $validGames)) $gameId = 'alanwake';
$gameName = $validGames[$gameId];

$pageTitle = 'Upload Score';
require_once 'header.php';
?>

    <div id="main">
        <div class="inner">
            <h1><?php echo htmlspecialchars($gameName); ?></h1>
            <form method="post" action="save.php" enctype="multipart/form-data">
                <input type="hidden" name="game" value="<?php echo htmlspecialchars($gameId); ?>">
                <div class="row gtr-uniform">
                    <div class="col-6 col-12-xsmall">
                        <label>Screenshot:</label><br>
                        <input type="file" name="imagine" accept="image/*" required>
                    </div>
                    <div class="col-6 col-12-xsmall">
                        <input type="number" name="scor" placeholder="Score" required min="0" />
                    </div>
                    <div class="col-12">
                        <ul class="actions">
                            <li><input type="submit" name="upload" value="Upload" class="primary" /></li>
                            <li><a href="game.php?id=<?php echo urlencode($gameId); ?>" class="button">Cancel</a></li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php require_once 'footer.php'; ?>
