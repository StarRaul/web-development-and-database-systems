<?php
session_start();
include 'connection.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['currentuser']) || $_SESSION['currentuser'] != 'admin') {
    header('Location: index.php');
    exit;
}

// Display any flash messages
if(isset($_SESSION['error'])) {
    echo '<div style="color: red; padding: 10px; margin: 10px 0; border: 1px solid red; background-color: #ffeeee;">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
if(isset($_SESSION['success'])) {
    echo '<div style="color: green; padding: 10px; margin: 10px 0; border: 1px solid green; background-color: #eeffee;">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}

// Base SQL query
$sql = 'SELECT * FROM placements';

// Handle search
if (isset($_POST["search"]) && !empty($_POST["search_box"])) {
    $search_term = $_POST["search_box"];
    // Use prepared statement with LIKE for partial matching
    $sql .= " WHERE nume LIKE :search_term";
    $stmt = $con->prepare($sql);
    $stmt->execute([':search_term' => '%' . $search_term . '%']);
} else {
    // No search, just execute simple query
    $stmt = $con->query($sql);
}

// Fetch all results
$results = $stmt->fetchAll();
?>
<!DOCTYPE HTML>
<!--
	Phantom by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Admin Page - Game Leaderboards</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<style>
			.admin-table {
				width: 100%;
				border-collapse: collapse;
			}
			.admin-table th {
				background-color: #f4f4f4;
				padding: 10px;
				text-align: left;
			}
			.admin-table td {
				padding: 10px;
				border-bottom: 1px solid #ddd;
			}
			.admin-table tr:hover {
				background-color: #f9f9f9;
			}
			.search-form {
				margin: 20px 0;
				padding: 15px;
				background-color: #f9f9f9;
				border-radius: 5px;
			}
			.action-links a {
				margin-right: 10px;
				color: #333;
				text-decoration: none;
			}
			.action-links a:hover {
				text-decoration: underline;
			}
			.action-links .edit {
				color: #2ecc71;
			}
			.action-links .delete {
				color: #e74c3c;
			}
		</style>
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
							<h1>Admin Page - Manage Placements</h1>
							
							<!-- Search Form -->
							<div class="search-form">
								<form name="search_form" method="post" action="adminpage.php">
									<label for="search_box">Search by Player Name:</label>
									<input type="text" name="search_box" id="search_box" value="<?php echo isset($_POST['search_box']) ? htmlspecialchars($_POST['search_box']) : ''; ?>" placeholder="Enter player name...">
									<input type="submit" name="search" value="Search" class="button primary">
									<?php if(isset($_POST["search"])): ?>
										<a href="adminpage.php" class="button">Clear Search</a>
									<?php endif; ?>
								</form>
							</div>
							
							<!-- Results count -->
							<p>Found <strong><?php echo count($results); ?></strong> record(s)</p>
							
							<!-- Data Table -->
							<table class="admin-table" width="100%" cellpadding="10" cellspacing="0">
								<thead>
									<tr>
										<th><strong>Image</strong></th>
										<th><strong>Score</strong></th>
										<th><strong>Player Name</strong></th>
										<th><strong>Actions</strong></th>
									</tr>
								</thead>
								<tbody>
									<?php if (empty($results)): ?>
										<tr>
											<td colspan="4" style="text-align: center; padding: 20px;">
												No records found.
											</td>
										</tr>
									<?php else: ?>
										<?php foreach ($results as $row): ?>
											<tr>
												<td>
													<img src="<?php echo htmlspecialchars($row["imagine"]); ?>" width="100" height="100" alt="User image" style="object-fit: cover; border-radius: 5px;">
												</td>
												<td><?php echo htmlspecialchars($row["scor"]); ?></td>
												<td><?php echo htmlspecialchars($row["nume"]); ?></td>
												<td class="action-links">
													<a href="edit.php?id=<?php echo $row['id']; ?>" class="edit">✏️ Edit</a> |
													<a href="delete.php?id=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this record? This action cannot be undone.')">🗑️ Delete</a>
												</td>
											</tr> 
										<?php endforeach; ?>
									<?php endif; ?>
								</tbody>
							</table>
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