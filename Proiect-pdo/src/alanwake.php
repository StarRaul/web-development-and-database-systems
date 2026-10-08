<?php
session_start();
include 'connection.php';

// Display any flash messages
if(isset($_SESSION['error'])) {
    echo '<div style="color: red; padding: 10px; margin: 10px 0; border: 1px solid red; background-color: #ffeeee;">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
if(isset($_SESSION['success'])) {
    echo '<div style="color: green; padding: 10px; margin: 10px 0; border: 1px solid green; background-color: #eeffee;">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
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
		<title>Alan Wake 2 - Leaderboard</title>
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
							<h1>Alan Wake 2</h1>
							<?php
								// PDO query - no need for or die() since we set exception mode
								$sql = 'SELECT * FROM placements ORDER BY scor DESC'; // Added ORDER BY for better display
								$stmt = $con->query($sql);
							?>
							<table width="50%" cellpadding="4" cellspacing="4" rules="rows">
								<tr>
									<th>Image</th>
									<th>Score</th>
									<th colspan="3">Player</th>
								</tr>
								<?php
								// PDO fetch - using FETCH_ASSOC which we set in connection
								while ($row = $stmt->fetch()) {
								?>
								<tr style="border-bottom: 1px solid black;">
									<td><img src="<?php echo htmlspecialchars($row['imagine']); ?>" width="100" height="100" alt="User submission"></td>
									<td><?php echo htmlspecialchars($row['scor']); ?></td>
									<td><?php echo htmlspecialchars($row['nume']); ?></td>
								</tr>
								<?php 
								}
								
								// Check if no results
								if($stmt->rowCount() == 0) {
									echo '<tr><td colspan="3" style="text-align: center;">No scores yet. Be the first to upload!</td></tr>';
								}
								?>
							</table>
							<?php
							if(isset($_SESSION['currentuser']))
							{
							echo "<p>Upload Another Post</p>";
							echo '<a href="upload.php" class="button fit">Upload</a>';
							}
							?>
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