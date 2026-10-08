<?php
session_start();
require_once 'connection.php';


if(!isset($_SESSION['currentuser']) || $_SESSION['currentuser'] != 'admin') {
    header('Location: index.php');
    exit;
}


$filter = [];
if (isset($_POST["search"]) && !empty($_POST["search_box"])) {
    $search_term = $_POST["search_box"];
    $filter = ['nume' => $search_term];
}


$query = new MongoDB\Driver\Query($filter);
$rows = $client->executeQuery("$dbName.$collectionName", $query);

$results = [];
foreach ($rows as $row) {
    $results[] = $row;
}
?>

<!DOCTYPE HTML>
<!-- Phantom by HTML5 UP -->
<html>
    <head>
        <title>Admin Page</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
    </head>
    <body class="is-preload">
        <div id="wrapper">
            <!-- Header and Menu same as before -->
            <header id="header">
                <div class="inner">
                    <a href="index.php" class="logo">
                        <span class="symbol"><img src="images/logo.svg" alt="" /></span>
                        <span class="title">Game Leaderboards</span>
                    </a>
                    <nav>
                        <ul>
                            <li><a href="#menu">Menu</a></li>
                        </ul>
                    </nav>
                </div>
            </header>

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
                    <h1>Admin Page</h1>
                    <br><br>
                    <form name="search_form" method="post" action="adminpage.php">
                        Search by Nume: <input type="text" name="search_box" value="<?php echo isset($_POST['search_box']) ? htmlspecialchars($_POST['search_box']) : ''; ?>">
                        <input type="submit" name="search" value="Search">
                        <?php if(isset($_POST['search'])): ?>
                            <a href="adminpage.php" style="margin-left: 10px;">Clear Search</a>
                        <?php endif; ?>
                    </form>
                    <br><br>
                    <table width="80%" cellpadding="10" cellspacing="10">
                        <tr>
                            <th><strong>Imagine</strong></th>
                            <th><strong>Scor</strong></th>
                            <th><strong>Nume</strong></th>
                            <th><strong>Actions</strong></th>
                        </tr>
                        <?php if(count($results) == 0): ?>
                        <tr>
                            <td colspan="4" style="text-align: center;">No records found</td>
                        </tr>
                        <?php endif; ?>
                        <?php foreach ($results as $row): ?>
                        <tr>
                            <td><img src="<?php echo htmlspecialchars($row->imagine); ?>" width="100" height="100" alt="Image"></td>
                            <td><?php echo htmlspecialchars($row->scor);?></td>
                            <td><?php echo htmlspecialchars($row->nume);?></td>
                            <td>
                                <a href="view.php?id=<?php echo $row->_id; ?>">View</a> |
                                <a href="edit.php?id=<?php echo $row->_id; ?>">Edit</a> |
                                <a href="delete.php?id=<?php echo $row->_id; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr> 
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>

            <!-- Footer same as before -->
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