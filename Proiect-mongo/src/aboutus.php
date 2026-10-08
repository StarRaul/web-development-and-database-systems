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
        <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ro_RO/sdk.js#xfbml=1&version=v22.0"></script>
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
							<section id="one">
								<div class="inner">
									<header class="major">
									<br><br>
									<svg height="260" width="1000">
										<defs>
											<linearGradient id="grad1">
												<stop offset="0%" stop-color="yellow" />
												<stop offset="100%" stop-color="red" />
											</linearGradient>
										</defs>
										<ellipse cx="170" cy="70" rx="170" ry="55" fill="url(#grad1)" id="elipsa" />
										<script>
										var elipsa = document.getElementById("elipsa");
										var currentHour = new Date().getHours();
										if (currentHour >= 6 && currentHour < 12) { elipsa.setAttribute("fill", "yellow"); } 
										else if (currentHour >= 12 && currentHour < 18) { elipsa.setAttribute("fill", "orange"); } 
										else if (currentHour >= 18 && currentHour < 21) { elipsa.setAttribute("fill", "red"); } 
										else {elipsa.setAttribute("fill", "darkblue"); }
									</script>
										<text fill="#ffffff" font-size="45" font-family="Montserrat" x="50" y="86">About Us</text>
										Sorry, your browser does not support inline SVG.
									</svg>
									<br><br>
									</header>
									<canvas id="myCanvas" width="835" height="100" style="border:1px solid #d3d3d3;">
									Your browser does not support the HTML canvas tag.</canvas>

									<script>
										var c = document.getElementById("myCanvas");
										var ctx = c.getContext("2d");
										ctx.font = "30px Montserrat";
										ctx.fillStyle = "Purple";
										ctx.fillText("This is the about page where you can find out more about us!", 10, 50);
									</script>
									<br><br>
									<iframe
                                    src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d836.4933399071697!2d27.57180999665062!3d47.174158072828924!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sro!4v1740645888377!5m2!1sen!2sro"
                                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                    <br><br>
                                    <iframe width="560" height="315" src="https://www.youtube.com/embed/VafTMsrnSTU?si=9fqfmnnPPWssDJ4e" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                    <br><br>
									<video width="560" height="315" controls>
									<source src="images/video.mp4" type="video/mp4">
									</video>
									<br><br>
									<audio controls>
									<source src="images/audio.mp3" type="audio/mpeg">
									</audio>
									<br><br>
								</div>
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
								<li>&copy; Raul. All rights reserved</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li><br/>
								ඞ
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