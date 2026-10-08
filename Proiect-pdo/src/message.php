<?php
	function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

	$numeErr = $emailErr = $mesajErr = "";
    $nume = $email = $mesaj = "";
    $err = 0;

	if(isset($_POST["submit"])){
        if(empty($_POST["name"]))
        {
            $numeErr = "Name is required";
            $err = 1;
        }
        else {
            $nume = test_input($_POST["name"]);
            if(!preg_match("/^[a-zA-Z]*$/", $nume)){
                $numeErr = "Only alphabets and white space are allowed";
                $err = 1;
            }
        }

        if(empty($_POST["email"]))
        {
            $emailErr = "Email is required";
            $err = 1;
        }
        else {
            $email = test_input($_POST["email"]);

			$regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z]{2,}$/';

            if(!preg_match($regex, $email)){
                
                $err = 1;
                $emailErr = "Invalid email format";
            }
        }

        if(empty($_POST["mesaj"]))
        {
            $err = 1;
            $mesajErr = "Message is required";
        }
        else {
            $mesaj = test_input($_POST["mesaj"]);
        }
    }
?>

<!DOCTYPE HTML>
<!--
	Phantom by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Message</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">
		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<div class="inner">

							<!-- Logo -->
								<a href="index.php" class="logo">
									<span class="symbol"><img src="images/logo.svg" alt="" /></span><span class="title">Cartea recordurilor</span>
								</a>

							<!-- Nav -->
								<nav>
									<ul>
										<li><a href="#menu">Menu</a></li>
									</ul>
								</nav>

						</div>
					</header>

				<!-- Menu -->
					<nav id="menu">
						<h2>Menu</h2>
						<ul>
							<li><a href="index.php">Home</a></li>
							<?php

							if(isset($_SESSION['currentuser']))
							{
								echo '<li><a href="logout.php">Log Out</a></li>';
							} 
							else 
							{
								echo '<li><a href="login.php">Log In</a></li>';
							}

							?>
							<li><a href="aboutus.php">About us</a></li>
							<?php if(isset($_SESSION['currentuser']) && $_SESSION['currentuser'] == 'admin')
							{
								echo '<li><a href="adminpage.php">Admin Page</a></li>';
							} ?>
						</ul>
					</nav>

				<!-- Main -->
					<div id="main">
						<div class="inner">
							<h1>
                                <?php
									if($err == 0)
									{
										echo 'Message sent successfully!';
									}
									else
									{
										echo 'Error: ' . $numeErr . ' ' . $emailErr .  ' ' . $mesajErr;
									}?>
                                    </h1>
                                    <a href="index.php" class="button primary">Main page</a>
						</div>
					</div>
			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>