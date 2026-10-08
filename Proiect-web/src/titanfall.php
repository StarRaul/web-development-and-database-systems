<?php
session_start();
include 'connection.php';
?>
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
					<h1>Titanfall 2</h1>
					<?php
						$joc = 'titanfall';
						$sql = "SELECT * FROM placements WHERE joc = '$joc'";
						$query = mysqli_query($con, $sql) or die(mysqli_error($con));
					?>
					<table width="50%" cellpadding="4" cellspacing="4" rules="rows">
						<tr>
							<th>Imagine</th>
							<th>Scor</th>
							<th colspan="3">Jucator</th>
						</tr>
						<?php while ($row = mysqli_fetch_array($query)) { ?>
						<tr style="border-bottom: 1px solid black;">
							<td><img src="<?php echo $row['imagine']; ?>" width="100" height="100"></td>
							<td><?php echo $row['scor']; ?></td>
							<td><?php echo $row['nume']; ?></td>
						</tr>
						<?php } ?>
					</table>
					<?php
					if(isset($_SESSION['currentuser'])) {
						echo "<p>Upload Another Post</p>";
						echo '<a href="upload.php" class="button fit">Upload</a>';
					}
					?>
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
