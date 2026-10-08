<?php
session_start();
require_once 'connection.php';

$query = new MongoDB\Driver\Query([]);
$rows = $client->executeQuery("$dbName.$collectionName", $query);
?>

<!DOCTYPE HTML>
<!-- Phantom by HTML5 UP -->
<html>
    <head>
        <title>Alan Wake 2 Leaderboard</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
    </head>
    <body class="is-preload">
        <div id="wrapper">
            <!-- Header -->
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
                    // Display success/error messages
                    if(isset($_GET['error'])) {
                        $error_msg = [
                            'upload_failed' => 'File upload failed. Please try again.',
                            'db_error' => 'Database error. Please try again.',
                            'missing_data' => 'Missing file or score data.'
                        ];
                        if(isset($error_msg[$_GET['error']])) {
                            echo '<p style="color: red;">' . $error_msg[$_GET['error']] . '</p>';
                        }
                    }
                    ?>
                    
                    <table width="50%" cellpadding="4" cellspacing="4" rules="rows">
                        <tr>
                            <th>Imagine</th>
                            <th>Scor</th>
                            <th>Jucator</th>
                            <th>Actions</th>
                        </tr>
                        <?php
                        $count = 0;
                        foreach ($rows as $row) {
                            $count++;
                        ?>
                        <tr style="border-bottom: 1px solid black;">
                            <td><img src="<?php echo htmlspecialchars($row->imagine); ?>" width="100" height="100"></td>
                            <td><?php echo htmlspecialchars($row->scor); ?></td>
                            <td><?php echo htmlspecialchars($row->nume); ?></td>
                            <td>
                                <a href="view.php?id=<?php echo $row->_id; ?>">View</a>
                                <?php if(isset($_SESSION['currentuser']) && $_SESSION['currentuser'] == $row->nume || $_SESSION['currentuser'] == 'admin'): ?>
                                    | <a href="edit.php?id=<?php echo $row->_id; ?>">Edit</a>
                                    | <a href="delete.php?id=<?php echo $row->_id; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php 
                        }
                        
                        if($count == 0) {
                            echo '<tr><td colspan="4" style="text-align: center;">No entries yet. Be the first to upload!</td></tr>';
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