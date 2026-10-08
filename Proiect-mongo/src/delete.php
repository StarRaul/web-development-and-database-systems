<?php
require_once "connection.php";

if (isset($_GET['id'])) {
    $id = new MongoDB\BSON\ObjectID($_GET['id']);
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->delete(['_id' => $id]);
    $client->executeBulkWrite("$dbName.$collectionName", $bulk);
}
header('location: index.php');
exit;
?>