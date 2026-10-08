<?php
$pageTitle = 'Login';
require_once 'header.php';
$n1 = rand(1, 9);
$n2 = rand(1, 9);

$errorMsg = '';
if (isset($_GET['error'])) {
    if ($_GET['error'] === 'captcha') {
        $errorMsg = 'Incorrect math answer. Please try again.';
    } elseif ($_GET['error'] === 'credentials') {
        $errorMsg = 'Incorrect username or password.';
    }
}
?>

    <div id="main">
        <div class="inner">
            <h1>Login</h1>
            
            <?php if ($errorMsg): ?>
                <p style="color:#e94560; font-weight:bold; margin-bottom: 15px; padding: 10px; border-left: 3px solid #e94560; background: rgba(233, 69, 96, 0.1);">
                    <?php echo htmlspecialchars($errorMsg); ?>
                </p>
            <?php endif; ?>

            <form method="post" action="loginverificare.php">
                <div class="row gtr-uniform">
                    <div class="col-6 col-12-xsmall">
                        <input type="text" name="username" placeholder="Username" required />
                    </div>
                    <div class="col-6 col-12-xsmall">
                        <input type="password" name="password" placeholder="Password" required />
                    </div>
                    <div class="col-6 col-12-xsmall">
                        <input type="text" name="sum" placeholder="<?php echo "$n1 + $n2 = "; ?>" required />
                    </div>
                    <input type="hidden" name="correctsum" value="<?php echo $n1 + $n2; ?>">
                    <div class="col-6 col-12-xsmall">
                        <input type="checkbox" name="rememberme" id="rememberme" checked>
                        <label for="rememberme">Remember me</label>
                    </div>
                    <div class="col-12">
                        <ul class="actions">
                            <li><input type="submit" value="Log In" class="primary" /></li>
                        </ul>
                    </div>
                </div>
            </form>

        </div>
    </div>

<?php require_once 'footer.php'; ?>