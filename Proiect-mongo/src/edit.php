<?php
session_start();
require_once 'connection.php';

// Check if user is logged in
if(!isset($_SESSION['currentuser'])) {
    header('Location: login.php');
    exit;
}

// Check if ID is provided
if(!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = new MongoDB\BSON\ObjectID($_GET['id']);

// If form hasn't been submitted, display the form with current data
if (!isset($_POST['submit'])) {
    // Fetch the record to edit
    $filter = ['_id' => $id];
    $query = new MongoDB\Driver\Query($filter);
    $cursor = $client->executeQuery("$dbName.$collectionName", $query);
    $record = current($cursor->toArray());
    
    // Check if record exists
    if(!$record) {
        header('Location: alanwake.php');
        exit;
    }
    
    // Check if user is authorized to edit (owner or admin)
    if($_SESSION['currentuser'] != $record->nume && $_SESSION['currentuser'] != 'admin') {
        header('Location: alanwake.php');
        exit;
    }
} else {
    // Process the update
    $score = $_POST['scor'];
    $target = null;
    
    // Fetch current record to get old image path
    $filter = ['_id' => $id];
    $query = new MongoDB\Driver\Query($filter);
    $cursor = $client->executeQuery("$dbName.$collectionName", $query);
    $current = current($cursor->toArray());
    
    // Check if a new image was uploaded
    if (isset($_FILES['imagine']) && $_FILES['imagine']['error'] === UPLOAD_ERR_OK && $_FILES['imagine']['size'] > 0) {
        // Create images directory if it doesn't exist
        if (!file_exists('./images')) {
            mkdir('./images', 0777, true);
        }
        
        $target = "./images/" . md5(uniqid(time())) . basename($_FILES['imagine']['name']);
        
        // Move the new image
        if(move_uploaded_file($_FILES['imagine']['tmp_name'], $target)) {
            // Delete old image if it exists and is different from new one
            if($current && isset($current->imagine) && file_exists($current->imagine) && $current->imagine != $target) {
                unlink($current->imagine);
            }
        } else {
            // If moving fails, keep old image
            $target = $current->imagine;
        }
    } else {
        // Keep existing image
        $target = $current->imagine;
    }
    
    // Prepare update data
    $updateData = [
        'scor' => $score,
        'imagine' => $target
    ];
    
    // Update in MongoDB
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->update(
        ['_id' => $id],
        ['$set' => $updateData]
    );
    
    try {
        $client->executeBulkWrite("$dbName.$collectionName", $bulk);
        header('Location: alanwake.php');
        exit;
    } catch (Exception $e) {
        echo "Error updating record: " . $e->getMessage();
        exit;
    }
}
?>

<!DOCTYPE HTML>
<!-- Phantom by HTML5 UP -->
<html>
    <head>
        <title>Edit Score - Game Leaderboards</title>
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
                    <h1>Edit Your Post</h1>
                    
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $_GET['id']; ?>" enctype="multipart/form-data">
                        <div class="row gtr-uniform">
                            <!-- Score Field -->
                            <div class="col-12">
                                <label for="scor">Score:</label>
                                <input type="text" name="scor" id="scor" value="<?php echo htmlspecialchars($record->scor ?? ''); ?>" required />
                            </div>
                            
                            <!-- Image Upload -->
                            <div class="col-12">
                                <label for="imagine">New Image (optional):</label>
                                <input type="file" name="imagine" id="imagine" accept="image/*" />
                                <small>Leave empty to keep current image</small>
                            </div>
                            
                            <!-- Current Image Display -->
                            <?php if(isset($record->imagine) && $record->imagine): ?>
                            <div class="col-12">
                                <label>Current Image:</label><br>
                                <img src="<?php echo htmlspecialchars($record->imagine); ?>" width="200" height="200" style="border: 1px solid #ccc; padding: 5px;" />
                            </div>
                            <?php endif; ?>
                            
                            <!-- Hidden ID -->
                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                            
                            <!-- Buttons -->
                            <div class="col-12">
                                <ul class="actions">
                                    <li><input type="submit" name="submit" value="Update" class="primary" /></li>
                                    <li><a href="alanwake.php" class="button">Cancel</a></li>
                                </ul>
                            </div>
                        </div>
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