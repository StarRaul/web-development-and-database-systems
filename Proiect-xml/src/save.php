<?php
session_start();
require_once __DIR__ . '/xml_helper.php';

if (!isset($_SESSION['currentuser'])) {
    header('Location: login.php');
    exit;
}

$validGames = ['alanwake', 'residentevil', 'titanfall'];
$gameId = $_POST['game'] ?? 'alanwake';
if (!in_array($gameId, $validGames)) $gameId = 'alanwake';

if (isset($_POST['upload']) && isset($_FILES['imagine']) && isset($_POST['scor'])) {
    $file = $_FILES['imagine'];
    $scor = trim($_POST['scor']);
    $nume = $_SESSION['currentuser'];

    // verificare basic student-style
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($ext, $allowedExts) && is_numeric($scor)) {
        $filename = time() . '_' . rand(1000, 9999) . '.' . $ext;
        $target   = __DIR__ . '/images/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $target)) {
            addPlacement($gameId, './images/' . $filename, $scor, $nume);
        }
    }
}

header("Location: game.php?id=$gameId");
exit;