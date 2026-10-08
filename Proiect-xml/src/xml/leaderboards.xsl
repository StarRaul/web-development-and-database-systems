<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="UTF-8" indent="yes"/>

<xsl:param name="menuAuth"/>
<xsl:param name="menuAdmin"/>

<xsl:template match="/">
<xsl:text disable-output-escaping="yes">&lt;!DOCTYPE HTML&gt;</xsl:text>
<html>
<head>
    <title>Leaderboard Overview</title>
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
                <h1><xsl:value-of select="leaderboards/metadata/title"/></h1>
                <p><xsl:value-of select="leaderboards/metadata/description"/></p>
            </header>
            
            <xsl:apply-templates select="leaderboards/metadata/formula"/>
            <xsl:apply-templates select="leaderboards/metadata/logo"/>
            
            <h2>All Games</h2>
            <section class="tiles">
                <xsl:apply-templates select="leaderboards/games/game"/>
            </section>
        </div>
    </div>

    <footer id="footer">
        <div class="inner">
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

<xsl:template match="formula">
    <div style="margin:20px 0;padding:15px 20px;background:rgba(255,255,255,0.04);border-left:3px solid rgba(255,255,255,0.15);border-radius:4px;">
        <xsl:copy-of select="*"/>
    </div>
</xsl:template>

<xsl:template match="logo">
    <div style="margin:10px 0 20px;">
        <xsl:copy-of select="*"/>
    </div>
</xsl:template>

<xsl:template match="game">
    <xsl:variable name="style">
        <xsl:choose>
            <xsl:when test="position() = 1">style1</xsl:when>
            <xsl:when test="position() = 2">style2</xsl:when>
            <xsl:otherwise>style3</xsl:otherwise>
        </xsl:choose>
    </xsl:variable>
    
    <article class="{$style}">
        <span class="image">
            <img src="{image}" alt="{n}"/>
        </span>
        <a href="game.php?id={@id}">
            <h2><xsl:value-of select="n"/></h2>
            <div class="content">
                <p><xsl:value-of select="description"/></p>
                <xsl:choose>
                    <xsl:when test="placements/placement">
                        <p><xsl:value-of select="count(placements/placement)"/> scores posted</p>
                    </xsl:when>
                    <xsl:otherwise>
                        <p>No scores yet</p>
                    </xsl:otherwise>
                </xsl:choose>
            </div>
        </a>
    </article>
</xsl:template>

</xsl:stylesheet>