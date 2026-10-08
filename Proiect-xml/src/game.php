<?php
$games = [
    'alanwake'    => 'Alan Wake 2',
    'residentevil'=> 'Resident Evil 4',
    'titanfall'   => 'Titanfall 2',
];

$gameId = $_GET['id'] ?? '';
if (!array_key_exists($gameId, $games)) {
    header('Location: index.php');
    exit;
}

$pageTitle = $games[$gameId];
require_once 'header.php';
require_once __DIR__ . '/xml_helper.php';

$placements = getPlacements($gameId);
?>

    <div id="main">
        <div class="inner">
            <h1><?php echo htmlspecialchars($games[$gameId]); ?></h1>

            <table width="60%" cellpadding="4" cellspacing="4" rules="rows">
                <tr>
                    <th>#</th>
                    <th>Screenshot</th>
                    <th>Score</th>
                    <th>Player</th>
                </tr>
                <?php if (empty($placements)): ?>
                    <tr><td colspan="4" style="padding:10px;">No scores posted yet.</td></tr>
                <?php else: ?>
                    <?php $rank = 1; foreach ($placements as $row): ?>
                        <tr>
                            <td><?php echo $rank++; ?></td>
                            <td><img src="<?php echo htmlspecialchars($row['imagine']); ?>" width="80" height="80" alt=""></td>
                            <td><?php echo htmlspecialchars($row['scor']); ?></td>
                            <td><?php echo htmlspecialchars($row['nume']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>

            <?php if (isset($_SESSION['currentuser'])): ?>
                <br>
                <a href="upload.php?game=<?php echo urlencode($gameId); ?>" class="button fit">Upload Score</a>
            <?php else: ?>
                <br><p><a href="login.php">Log in</a> to upload your score.</p>
            <?php endif; ?>
        </div>
    </div>

<?php require_once 'footer.php'; ?>
