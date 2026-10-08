<?php
session_start();
setcookie('username', '', time() - 3600);
unset($_COOKIE['username']);
setcookie('password', '', time() - 3600);
unset($_COOKIE['password']);
unset($_SESSION['currentuser']);
unset($_SESSION['userrole']);
session_destroy();
header('Location: index.php');
exit;
