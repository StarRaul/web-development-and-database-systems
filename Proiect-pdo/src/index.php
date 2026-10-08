<?php
session_start();
if(isset($_COOKIE['username']) && isset($_COOKIE['password']))
	$_SESSION['currentuser'] = $_COOKIE['username'];
?>
<!DOCTYPE HTML>
<!--
	Phantom by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Main page</title>
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
									<span class="symbol"><img src="images/logo.svg" alt="" /></span><span class="title">Game Leaderboards</span>
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
							<header>
								<h1>Welcome to our site!<br />
								Test and compare your skills.</h1>
								<p>Here you can view the community's hard work in finishing our beloved video games.</p>
							</header>
							<section class="tiles">
								<article class="style1">
									<span class="image">
										<img src="images/alanwake2.jpg" alt="" />
									</span>
									<a href="alanwake.php">
										<h2>Alan Wake 2</h2>
										<div class="content">
											<p>View top scores in completing Alan Wake's story</p>
										</div>
									</a>
								</article>
								<article class="style2">
									<span class="image">
										<img src="images/residentevil.jpg" alt="" />
									</span>
									<a href="residentevil.php">
										<h2>Resident Evil 4</h2>
										<div class="content">
											<p>View top scores in accomplishing Leon S. Kennedy's mission</p>
										</div>
									</a>
								</article>
								<article class="style3">
									<span class="image">
										<img src="images/titanfall.jpg" alt="" />
									</span>
									<a href="titanfall.php">
										<h2>Titanfall 2</h2>
										<div class="content">
											<p>View top scores in Jack Cooper's attempt to stop the opposing forces</p>
										</div>
									</a>
								</article>
							</section>
						</div>
					</div>

				<!-- Footer -->
					<footer id="footer">
						<div class="inner">
							<section>
								<h2>Get in touch</h2>
								<form method="post" action="message.php">
									<div class="fields">
										<div class="field half">
											<input type="text" name="name" id="name" placeholder="Name" />
										</div>
										<div class="field half">
											<input type="text" name="email" id="email" placeholder="Email" />
										</div>
										<div class="field">
											<textarea name="mesaj" id="mesaj" placeholder="Message"></textarea>
										</div>
									</div>  
									<ul class="actions">
										<li><input name="submit" type="submit" value="Send" class="primary" /></li>
									</ul>
								</form>
							</section>
							<section>
								<h2>Share</h2>
								<ul class="icons">
									<li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="icon brands style2 fa-facebook-f"><span class="label">Facebook</span></a></li>
									<li><a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="icon brands style2 fa-twitter"><span class="label">Twitter</span></a></li>
								</ul>
							</section>
							<ul class="copyright">
								<li>&copy; Raul. All rights reserved</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
							</ul>
						</div>
					</footer>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>