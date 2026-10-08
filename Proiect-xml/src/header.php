<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['currentuser']) && isset($_COOKIE['username'])) {
    require_once __DIR__ . '/user.php';
    foreach ($users as $u) {
        if ($u->getNume() === $_COOKIE['username'] && md5($u->getParola()) === ($_COOKIE['password'] ?? '')) {
            $_SESSION['currentuser'] = $u->getNume();
            $_SESSION['userrole']    = $u->role;
            break;
        }
    }
}
$isAdmin = isset($_SESSION['userrole']) && $_SESSION['userrole'] === 'admin';
?>
<!DOCTYPE HTML>
<html>
<head>
    <title><?php echo htmlspecialchars($pageTitle ?? 'Game Leaderboards'); ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
</head>
<body class="is-preload">
<div id="wrapper">
    <header id="header">
        <div class="inner">
            <a href="index.php" class="logo">
                <span class="symbol"><img src="images/logo.svg" alt="" /></span>
                <span class="title">Game Leaderboards</span>
            </a>
            <nav><ul><li><a href="#menu">Menu</a></li></ul></nav>
        </div>
    </header>

    <nav id="menu">
        <h2>Menu</h2>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php if (isset($_SESSION['currentuser'])): ?>
                <li><a href="logout.php">Log Out</a></li>
            <?php else: ?>
                <li><a href="login.php">Log In</a></li>
            <?php endif; ?>
            <li><a href="aboutus.php">About Us</a></li>
            <li><a href="xmlview.php">Leaderboard Overview</a></li>
            <?php if ($isAdmin): ?>
                <li><a href="adminpage.php">Admin</a></li>
            <?php endif; ?>
        </ul>
    </nav>
