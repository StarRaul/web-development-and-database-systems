<?php
session_start();
require_once "connection.php";

if(isset($_POST['upload'])) {
    if(isset($_FILES['imagine']) && isset($_POST['joc'])) {
        $joc = $_POST['joc'];
        // Validate game value
        $jocuriPermise = ['alanwake', 'titanfall', 'residentevil'];
        if(!in_array($joc, $jocuriPermise)) {
            header("Location: upload.php");
            exit;
        }

        $target = "./images/" . md5(uniqid(time())) . basename($_FILES['imagine']['name']);
        $text = $_POST['text'];
        $sql = "INSERT INTO placements(imagine, scor, nume, joc) VALUES('$target', '$text', '" . $_SESSION['currentuser'] . "', '$joc')";
        mysqli_query($con, $sql);

        if(move_uploaded_file($_FILES['imagine']['tmp_name'], $target)) {
            header("Location: " . $joc . ".php");
        } else {
            header("Location: upload.php");
        }
    } else {
        header("Location: upload.php");
    }
}
