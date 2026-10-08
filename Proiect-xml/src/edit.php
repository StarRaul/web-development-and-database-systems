<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['currentuser']) || ($_SESSION['userrole'] ?? '') !== 'admin') {
    header('Location: index.php');
    exit;
}
require_once __DIR__ . '/xml_helper.php';

$id    = $_GET['id'] ?? $_POST['id'] ?? '';
$entry = getPlacementById($id);

if (!$entry) {
    header('Location: adminpage.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $scor = trim($_POST['scor']);
    $nume = trim($_POST['nume']);
    if (is_numeric($scor) && $nume !== '') {
        updatePlacement($id, $scor, $nume);
        header('Location: adminpage.php');
        exit;
    } else {
        $error = 'Score must be a number and player name cannot be empty.';
    }
}

$pageTitle = 'Edit Entry';
require_once 'header.php';
?>

    <div id="main">
        <div class="inner">
            <h1>Edit Entry</h1>

            <?php if ($error): ?>
                <p style="color:#e94560;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <div style="margin-bottom:20px;">
                <img src="<?php echo htmlspecialchars($entry['imagine']); ?>" width="120" height="120" alt="">
            </div>

            <form method="post" action="edit.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <div class="row gtr-uniform">
                    <div class="col-6 col-12-xsmall">
                        <input type="number" name="scor" placeholder="Score"
                               value="<?php echo htmlspecialchars($entry['scor']); ?>" required min="0" />
                    </div>
                    <div class="col-6 col-12-xsmall">
                        <input type="text" name="nume" placeholder="Player"
                               value="<?php echo htmlspecialchars($entry['nume']); ?>" required />
                    </div>
                    <div class="col-12">
                        <ul class="actions">
                            <li><input type="submit" name="save" value="Save" class="primary" /></li>
                            <li><a href="adminpage.php" class="button">Cancel</a></li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php require_once 'footer.php'; ?>
