<?php
session_start();
require_once "connection.php";

if(isset($_POST['upload']))
{
    if(isset($_FILES['imagine']) && isset($_POST['scor']))
    {
        // Create images directory if it doesn't exist
        if (!file_exists('./images')) {
            mkdir('./images', 0777, true);
        }
        
        $target = "./images/" . md5(uniqid(time())) . basename($_FILES['imagine']['name']);
        $score = $_POST['scor'];
        $username = $_SESSION['currentuser'] ?? 'anonymous';
        
        // Prepare document for MongoDB
        $bulk = new MongoDB\Driver\BulkWrite;
        $document = [
            '_id' => new MongoDB\BSON\ObjectID,
            'imagine' => $target,
            'scor' => $score,
            'nume' => $username
        ];
        $bulk->insert($document);
        
        try {
            $client->executeBulkWrite("$dbName.$collectionName", $bulk);
            
            // Move uploaded file
            if(move_uploaded_file($_FILES['imagine']['tmp_name'], $target))
            {
                header("Location: alanwake.php");
                exit;
            }
            else
            {
                // Log error but still redirect
                error_log("Failed to move uploaded file to: " . $target);
                header("Location: alanwake.php?error=upload_failed");
                exit;
            }
        } catch (Exception $e) {
            error_log("MongoDB Error: " . $e->getMessage());
            header("Location: alanwake.php?error=db_error");
            exit;
        }
    }
    else
    {
        header("Location: alanwake.php?error=missing_data");
        exit;
    }
}
else
{
    header("Location: alanwake.php");
    exit;
}
?>