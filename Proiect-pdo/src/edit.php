<?php
session_start(); // Added session start
include 'connection.php';

// Check if user is logged in and is admin (since only admin should edit)
if (!isset($_SESSION['currentuser']) || $_SESSION['currentuser'] != 'admin') {
    header('Location: index.php');
    exit;
}

if (!isset($_POST['submit'])) {
    // Get record based on GET id for form display
    $sql = "SELECT * FROM placements WHERE id = :id";
    $stmt = $con->prepare($sql);
    $stmt->execute([':id' => $_GET['id']]);
    $record = $stmt->fetch();
    
    // Check if record exists
    if (!$record) {
        header('Location: index.php');
        exit;
    }
} else {
    // Form submitted: process update
    $id = $_POST['id'];
    $scor = $_POST['scor']; // No need for mysqli_real_escape_string with PDO
    
    // Validate score is numeric
    if (!is_numeric($scor)) {
        $_SESSION['error'] = "Score must be a number";
        header("Location: edit.php?id=" . $id);
        exit();
    }
    
    // Get previous image (in case no new image is uploaded)
    $sql2 = "SELECT * FROM placements WHERE id = :id";
    $stmt2 = $con->prepare($sql2);
    $stmt2->execute([':id' => $id]);
    $rec = $stmt2->fetch();

    // Check if a new image was uploaded
    if ($_FILES['imagine']['name'] != '' && $_FILES['imagine']['error'] == 0) {
        // Validate file type
        $extension = pathinfo($_FILES['imagine']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (!in_array(strtolower($extension), $allowed)) {
            $_SESSION['error'] = "Only JPG, PNG, and GIF files are allowed";
            header("Location: edit.php?id=" . $id);
            exit();
        }
        
        // Create secure filename
        $filename = md5(uniqid(time())) . '.' . $extension;
        $target = "./images/" . $filename;
        
        // Delete old image if it exists and is different from default
        if (file_exists($rec['imagine']) && $rec['imagine'] != $target) {
            unlink($rec['imagine']);
        }
        
        move_uploaded_file($_FILES['imagine']['tmp_name'], $target);
    } else {
        $target = $rec['imagine'];
    }

    // Update the record using PDO prepared statement
    $sql1 = "UPDATE placements SET scor = :scor, imagine = :imagine WHERE id = :id";
    $stmt1 = $con->prepare($sql1);
    $stmt1->execute([
        ':scor' => $scor,
        ':imagine' => $target,
        ':id' => $id
    ]);

    // Redirect after update
    $_SESSION['success'] = "Record updated successfully!";
    header('Location: alanwake.php'); // Changed to alanwake.php since that's where placements are shown
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
		<title>Edit Post - Game Leaderboards</title>
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
							
							<?php
							// Display error message if any
							if(isset($_SESSION['error'])) {
								echo '<div style="color: red; padding: 10px; margin: 10px 0; border: 1px solid red; background-color: #ffeeee;">' . $_SESSION['error'] . '</div>';
								unset($_SESSION['error']);
							}
							?>
							
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                                Score: <br> 
                                <input type="text" name="scor" value="<?php echo htmlspecialchars($record['scor']); ?>"><br>
                                
                                Image: <br> 
                                <input type="file" name="imagine"><br>
                                
                                Current Image:<br>
                                <img src="<?php echo htmlspecialchars($record['imagine']); ?>" width="100" height="100"><br>
                                
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
                                <input type="submit" name="submit" value="Edit Post" class="button primary">
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