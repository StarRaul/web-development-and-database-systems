<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['currentuser']) || ($_SESSION['userrole'] ?? '') !== 'admin') {
    header('Location: index.php');
    exit;
}
require_once __DIR__ . '/xml_helper.php';

$search  = isset($_POST['search_box']) ? trim($_POST['search_box']) : null;
$results = getAllPlacements($search ?: null);

$pageTitle = 'Admin';
require_once 'header.php';
?>

    <div id="main">
        <div class="inner">
            <h1>Admin</h1>

            <form method="post" action="adminpage.php" style="margin-bottom:20px;">
                <input type="text" name="search_box" value="<?php echo htmlspecialchars($search ?? ''); ?>" placeholder="Search by player..." />
                <input type="submit" name="search" value="Search" class="button" />
                <?php if ($search): ?>
                    <a href="adminpage.php" class="button">Clear</a>
                <?php endif; ?>
            </form>

            <?php if (empty($results)): ?>
                <p>No entries found.</p>
            <?php else: ?>
            <table width="80%" cellpadding="10" cellspacing="0" style="border-collapse:collapse;">
                <tr>
                    <th style="text-align:left;border-bottom:2px solid #333;">Screenshot</th>
                    <th style="text-align:left;border-bottom:2px solid #333;">Score</th>
                    <th style="text-align:left;border-bottom:2px solid #333;">Player</th>
                    <th style="text-align:left;border-bottom:2px solid #333;">Game</th>
                    <th style="text-align:left;border-bottom:2px solid #333;"></th>
                </tr>
                <?php foreach ($results as $row): ?>
                <tr style="border-bottom:1px solid #222;">
                    <td><img src="<?php echo htmlspecialchars($row['imagine']); ?>" width="70" height="70" alt=""></td>
                    <td><?php echo htmlspecialchars($row['scor']); ?></td>
                    <td><?php echo htmlspecialchars($row['nume']); ?></td>
                    <td><?php echo htmlspecialchars($row['gameName']); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo urlencode($row['id']); ?>">Edit</a>
                        &nbsp;|&nbsp;
                        <a href="delete.php?id=<?php echo urlencode($row['id']); ?>"
                           onclick="return confirm('Delete this entry?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php endif; ?>
        </div>
    </div>

<?php require_once 'footer.php'; ?>
