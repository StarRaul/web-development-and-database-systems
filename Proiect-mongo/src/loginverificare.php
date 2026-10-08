<?php
session_start();
include 'user.php';

$userfound = false;

if(isset($_POST['sum']))
{
    if($_POST['sum'] != $_POST['correctsum'])
    {
        header('Location: wrong_captcha.php');
    }
    else
    {
        if((isset($_POST['username'])) && (isset($_POST['password'])) && (isset($_POST['sum'])))
        {
            foreach($users as $u)
            {
                if(($u->getNume() == $_POST['username']) && ($u->getParola() == $_POST['password']))
                {
                    $userfound = true;
                    break;
                }
            }
            if($userfound)
            {
                if(isset($_POST['rememberme']))
                {
                    setcookie('username', $_POST['username'], time() + 60*60*24*365);
                    setcookie('password', md5($_POST['password']), time() + 60*60*24*365);
                }
                else
                {
                    setcookie('username', $_POST['username'], false);
                    setcookie('password', md5($_POST['password']), false);
                }
                $_SESSION['currentuser'] = $_POST['username'];
                header('Location: index.php');
            } else { header('Location: usernamepassworderror.php'); }
        } else { header('Location: usernamepassworderror.php'); }
    }
} else { header('Location: wrong_captcha.php'); }
?>