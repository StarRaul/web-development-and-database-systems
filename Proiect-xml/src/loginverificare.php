<?php
session_start();
require_once __DIR__ . '/user.php';

$userfound = false;
$foundUser = null;

if (isset($_POST['sum'])) {
    if ($_POST['sum'] != $_POST['correctsum']) {
        header('Location: login.php?error=captcha');
        exit;
    }

    if (isset($_POST['username'], $_POST['password'])) {
        foreach ($users as $u) {
            if ($u->getNume() === $_POST['username'] && $u->getParola() === $_POST['password']) {
                $userfound = true;
                $foundUser = $u;
                break;
            }
        }

        if ($userfound && $foundUser) {
            if (isset($_POST['rememberme'])) {
                setcookie('username', $_POST['username'], time() + 60 * 60 * 24 * 365);
                setcookie('password', md5($_POST['password']), time() + 60 * 60 * 24 * 365);
            } else {
                setcookie('username', $_POST['username'], 0);
                setcookie('password', md5($_POST['password']), 0);
            }
            $_SESSION['currentuser'] = $_POST['username'];
            $_SESSION['userrole']    = $foundUser->role;
            header('Location: index.php');
            exit;
        } else {
            header('Location: login.php?error=credentials');
            exit;
        }
    } else {
        header('Location: login.php?error=credentials');
        exit;
    }
} else {
    header('Location: login.php?error=captcha');
    exit;
}