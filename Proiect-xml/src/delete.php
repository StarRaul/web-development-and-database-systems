<?php
session_start();
if (!isset($_SESSION['currentuser']) || ($_SESSION['userrole'] ?? '') !== 'admin') {
    header('Location: index.php');
    exit;
}
require_once __DIR__ . '/xml_helper.php';

$id = $_GET['id'] ?? '';
if ($id !== '') {
    $entry = getPlacementById($id);
    if ($entry) {
        $imgPath = __DIR__ . '/' . ltrim($entry['imagine'], './');
        if (file_exists($imgPath) && strpos($imgPath, '/images/') !== false) {
            @unlink($imgPath);
        }
        deletePlacement($id);
    }
}

header('Location: adminpage.php');
exit;
