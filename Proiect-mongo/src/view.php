<?php
require_once "connection.php";

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = new MongoDB\BSON\ObjectID($_GET['id']);
$filter = ['_id' => $id];
$query = new MongoDB\Driver\Query($filter);
$cursor = $client->executeQuery("$dbName.$collectionName", $query);
$doc = current($cursor->toArray());
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Score</title>
    <link rel="stylesheet" href="assets/css/main.css" />
</head>
<body>
    <div id="wrapper">
        <div id="main">
            <div class="inner">
                <h1>Score Details</h1>
                <p><strong>User:</strong> <?php echo htmlspecialchars($doc->nume ?? 'N/A'); ?></p>
                <p><strong>Score:</strong> <?php echo htmlspecialchars($doc->scor ?? 'N/A'); ?></p>
                <p><strong>Image:</strong><br>
                <img src="<?php echo htmlspecialchars($doc->imagine ?? ''); ?>" width="300"></p>
                <a href="index.php" class="button">Back</a>
            </div>
        </div>
    </div>
</body>
</html>