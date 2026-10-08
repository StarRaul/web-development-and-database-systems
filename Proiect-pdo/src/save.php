<?php
session_start();
require_once "connection.php";

if(isset($_POST['upload']))
{
    // Check if user is logged in
    if(!isset($_SESSION['currentuser'])) {
        header("Location: login.php");
        exit();
    }
    
    // Validate inputs
    if(isset($_FILES['imagine']) && $_FILES['imagine']['error'] == 0 && isset($_POST['scor']))
    {
        $scor = $_POST['scor'];
        

        if(!is_numeric($scor)) {
            $_SESSION['error'] = "Score must be a number";
            header("Location: alanwake.php");
            exit();
        }
        

        $extension = pathinfo($_FILES['imagine']['name'], PATHINFO_EXTENSION);
        $filename = md5(uniqid(time())) . '.' . $extension;
        $target = "./images/" . $filename;
        

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if(!in_array(strtolower($extension), $allowed)) {
            $_SESSION['error'] = "Only JPG, PNG, and GIF files are allowed";
            header("Location: alanwake.php");
            exit();
        }
        

        $sql = "INSERT INTO placements (imagine, scor, nume) VALUES (:imagine, :scor, :nume)";
        $stmt = $con->prepare($sql);
        

        $result = $stmt->execute([
            ':imagine' => $target,
            ':scor' => $scor,
            ':nume' => $_SESSION['currentuser']
        ]);
        
        if($result && move_uploaded_file($_FILES['imagine']['tmp_name'], $target))
        {
            $_SESSION['success'] = "Score uploaded successfully!";
            header("Location: alanwake.php");
            exit();
        }
        else
        {
            $_SESSION['error'] = "Failed to upload image or save to database";
            header("Location: alanwake.php");
            exit();
        }
    }
    else
    {
        $_SESSION['error'] = "Please select an image and enter a score";
        header("Location: alanwake.php");
        exit();
    }
}
?>