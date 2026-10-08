<?php
session_start();
include 'connection.php';

// Check if user is logged in and is admin (only admin should delete)
if (!isset($_SESSION['currentuser']) || $_SESSION['currentuser'] != 'admin') {
    $_SESSION['error'] = "You don't have permission to delete records";
    header('Location: index.php');
    exit;
}

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "No record ID provided";
    header('Location: index.php');
    exit;
}

try {
    // Start transaction (optional but good practice for multiple operations)
    $con->beginTransaction();
    
    // First, get the image path to delete the file
    $sql1 = "SELECT imagine FROM placements WHERE id = :id";
    $stmt1 = $con->prepare($sql1);
    $stmt1->execute([':id' => $_GET['id']]);
    $row = $stmt1->fetch();
    
    // Check if record exists
    if ($row) {
        // Delete the image file if it exists
        if (file_exists($row['imagine'])) {
            unlink($row['imagine']);
        }
        
        // Delete the database record
        $sql2 = "DELETE FROM placements WHERE id = :id";
        $stmt2 = $con->prepare($sql2);
        $stmt2->execute([':id' => $_GET['id']]);
        
        // Commit transaction
        $con->commit();
        
        $_SESSION['success'] = "Record deleted successfully";
    } else {
        $_SESSION['error'] = "Record not found";
    }
    
} catch (PDOException $e) {
    // Rollback transaction on error
    $con->rollBack();
    $_SESSION['error'] = "Delete failed: " . $e->getMessage();
}

// Redirect back
header('Location: alanwake.php'); // Changed to alanwake.php since that's where placements are shown
exit;
?>