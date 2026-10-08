<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Verificare cookie-uri pentru remember me
if (!isset($_SESSION['currentuser']) && isset($_COOKIE['username'])) {
    require_once __DIR__ . '/user.php';
    foreach ($users as $u) {
        if ($u->getNume() === $_COOKIE['username'] && md5($u->getParola()) === ($_COOKIE['password'] ?? '')) {
            $_SESSION['currentuser'] = $u->getNume();
            $_SESSION['userrole']    = $u->role;
            break;
        }
    }
}

$isAdmin   = isset($_SESSION['userrole']) && $_SESSION['userrole'] === 'admin';
$menuAdmin = $isAdmin ? '<li><a href="adminpage.php">Admin</a></li>' : '';
$menuAuth  = isset($_SESSION['currentuser'])
    ? '<li><a href="logout.php">Log Out</a></li>'
    : '<li><a href="login.php">Log In</a></li>';


$xmlString = '<?xml version="1.0" encoding="UTF-8"?>
<site xmlns:xlink="http://www.w3.org/1999/xlink">
    <page>Game Leaderboards</page>
    <intro>Here you can view the community\'s hard work in finishing our beloved video games.</intro>
    <links>
        <link xlink:type="simple" xlink:href="game.php?id=alanwake" xlink:show="replace" xlink:title="Alan Wake 2">
            <label>Alan Wake 2</label>
            <desc>View top scores in completing Alan Wake\'s story</desc>
            <image>images/alanwake2.jpg</image>
            <style>style1</style>
        </link>
        <link xlink:type="simple" xlink:href="game.php?id=residentevil" xlink:show="replace" xlink:title="Resident Evil 4">
            <label>Resident Evil 4</label>
            <desc>View top scores in accomplishing Leon S. Kennedy\'s mission</desc>
            <image>images/residentevil.jpg</image>
            <style>style2</style>
        </link>
        <link xlink:type="simple" xlink:href="game.php?id=titanfall" xlink:show="replace" xlink:title="Titanfall 2">
            <label>Titanfall 2</label>
            <desc>View top scores in Jack Cooper\'s attempt to stop the opposing forces</desc>
            <image>images/titanfall.jpg</image>
            <style>style3</style>
        </link>
    </links>
</site>';


$xslString = '<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:xlink="http://www.w3.org/1999/xlink">
<xsl:output method="html" encoding="UTF-8" indent="yes"/>
<xsl:param name="menuAuth"/>
<xsl:param name="menuAdmin"/>

<xsl:template match="/">
<xsl:text disable-output-escaping="yes">&lt;!DOCTYPE HTML&gt;</xsl:text>
<html>
<head>
    <title><xsl:value-of select="site/page"/></title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="assets/css/main.css"/>
    <noscript><link rel="stylesheet" href="assets/css/noscript.css"/></noscript>
</head>
<body class="is-preload">
<div id="wrapper">
    <header id="header">
        <div class="inner">
            <a href="index.php" class="logo">
                <span class="symbol"><img src="images/logo.svg" alt=""/></span>
                <span class="title">Game Leaderboards</span>
            </a>
            <nav><ul><li><a href="#menu">Menu</a></li></ul></nav>
        </div>
    </header>
    <nav id="menu">
        <h2>Menu</h2>
        <ul>
            <li><a href="index.php">Home</a></li>
            <xsl:value-of select="$menuAuth" disable-output-escaping="yes"/>
            <li><a href="aboutus.php">About Us</a></li>
            <li><a href="xmlview.php">Leaderboard Overview</a></li>
            <xsl:value-of select="$menuAdmin" disable-output-escaping="yes"/>
        </ul>
    </nav>
    <div id="main">
        <div class="inner">
            <header>
                <h1>Welcome to our site!<br/>Test and compare your skills.</h1>
                <p><xsl:value-of select="site/intro"/></p>
            </header>
            <section class="tiles">
                <xsl:apply-templates select="site/links/link"/>
            </section>
        </div>
    </div>
    <footer id="footer">
        <div class="inner">
            <section>
                <h2>Get in touch</h2>
                <form method="post" action="message.php">
                    <div class="fields">
                        <div class="field half">
                            <input type="text" name="name" placeholder="Name"/>
                        </div>
                        <div class="field half">
                            <input type="text" name="email" placeholder="Email"/>
                        </div>
                        <div class="field">
                            <textarea name="mesaj" placeholder="Message"></textarea>
                        </div>
                    </div>
                    <ul class="actions">
                        <li><input name="submit" type="submit" value="Send" class="primary"/></li>
                    </ul>
                </form>
            </section>
            <section>
                <h2>Share</h2>
                <ul class="icons">
                    <li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php" class="icon brands style2 fa-facebook-f"><span class="label">Facebook</span></a></li>
                    <li><a href="https://twitter.com/share" class="icon brands style2 fa-twitter"><span class="label">Twitter</span></a></li>
                </ul>
            </section>
            <ul class="copyright">
                <li>&#169; Raul. All rights reserved</li>
                <li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
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
</xsl:template>

<xsl:template match="link">
    <article class="{style}">
        <span class="image">
            <img src="{image}" alt="{label}"/>
        </span>
        <a href="{@xlink:href}">
            <h2><xsl:value-of select="label"/></h2>
            <div class="content">
                <p><xsl:value-of select="desc"/></p>
            </div>
        </a>
    </article>
</xsl:template>

</xsl:stylesheet>';


$xml = new DOMDocument();
$xml->loadXML($xmlString);

$xsl = new DOMDocument();
$xsl->loadXML($xslString);

$proc = new XSLTProcessor();
$proc->importStylesheet($xsl);
$proc->setParameter('', 'menuAuth',  $menuAuth);
$proc->setParameter('', 'menuAdmin', $menuAdmin);

echo $proc->transformToXML($xml);