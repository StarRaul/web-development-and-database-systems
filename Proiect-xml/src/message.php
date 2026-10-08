<?php
session_start();
require_once __DIR__ . '/xml_helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $name  = trim($_POST['name']  ?? '');
    $email = trim($_POST['email'] ?? '');
    $mesaj = trim($_POST['mesaj'] ?? '');

    if ($name !== '' && $email !== '' && $mesaj !== '') {
        addMessage($name, $email, $mesaj);
    }
}

header('Location: index.php');
exit;
