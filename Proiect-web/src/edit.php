<?php
include 'connection.php';

if (!isset($_POST['submit'])) {
    // Get record based on GET id for form display
    $sql = "SELECT * FROM placements WHERE id = '{$_GET['id']}'";
    $result = mysqli_query($con, $sql);
    $record = mysqli_fetch_array($result);
} else {
    // Form submitted: process update
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($con, $_POST['scor']); // Sanitize input

    // Get previous image (in case no new image is uploaded)
    $sql2 = "SELECT * FROM placements WHERE id = '$id'";
    $result2 = mysqli_query($con, $sql2);
    $rec = mysqli_fetch_array($result2);

    // Check if a new image was uploaded
    if ($_FILES['imagine']['name'] != '') {
        $target = "./images/" . basename($_FILES['imagine']['name']);
        move_uploaded_file($_FILES['imagine']['tmp_name'], $target);
    } else {
        $target = $rec['imagine'];
    }

    // Update the record
    $sql1 = "UPDATE placements SET scor = '$title', imagine = '$target' WHERE id = '$id'";
    mysqli_query($con, $sql1) or die(mysqli_error($con));

    // Redirect after update
    header('Location: index.php');
    exit;
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
							<h1>Edit your post: </h1>
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                                Scor: <br> <input type="text" name="scor" value="<?php echo $record['scor'];?>"><br>
                                Imagine: <br> <input type="file" name="imagine" value="<?php echo $record['imagine'];?>"><br>
                                <img src="<?php echo $record['imagine'];?>" width="100" height="100"><br>
                                <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
                                <input type="submit" name="submit" value="edit">
                            </form>
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