<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Main page</title>
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
						<span class="symbol"><img src="images/logo.svg" alt="" /></span><span class="title">Game Leaderboards</span>
					</a>
					<nav><ul><li><a href="#menu">Menu</a></li></ul></nav>
				</div>
			</header>
			<nav id="menu">
				<h2>Menu</h2>
				<ul>
					<li><a href="index.php">Home</a></li>
					<?php
					if(isset($_SESSION['currentuser'])) {
						echo '<li><a href="logout.php">Log Out</a></li>';
					} else {
						echo '<li><a href="login.php">Log In</a></li>';
					}
					?>
					<li><a href="aboutus.php">About us</a></li>
					<?php if(isset($_SESSION['currentuser']) && $_SESSION['currentuser'] == 'admin') {
						echo '<li><a href="adminpage.php">Admin Page</a></li>';
					} ?>
				</ul>
			</nav>
			<div id="main">
				<div class="inner">
					<form method="post" action="save.php" enctype="multipart/form-data">
						<input type="hidden" name="size" value="100000">
						<div>
							<label for="joc">Selecteaza jocul:</label>
							<select name="joc" id="joc" required>
								<option value="">-- Alege jocul --</option>
								<option value="alanwake">Alan Wake 2</option>
								<option value="titanfall">Titanfall 2</option>
								<option value="residentevil">Resident Evil 4</option>
							</select>
						</div>
						<div>
							<input type="file" name="imagine">
						</div>
						<div>
							<input type="text" name="text" id="name" placeholder="scor" />
						</div>
						<div>
							<input type="submit" name="upload" value="upload image" class="button fit">
						</div>
					</form>
				</div>
			</div>
			<footer id="footer">
				<div class="inner">
					<ul class="copyright">
						<li>&copy; Raul. All rights reserved</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
					</ul>
				</div>
			</footer>
		</div>
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/browser.min.js"></script>
		<script src="assets/js/breakpoints.min.js"></script>
		<script src="assets/js/util.js"></script>
		<script src="assets/js/main.js"></script>
	</body>
</html>
