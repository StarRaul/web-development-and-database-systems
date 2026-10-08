<?php
session_start();
require_once __DIR__ . '/xml_helper.php';

$menuAuth = isset($_SESSION['currentuser'])
    ? '<li><a href="logout.php">Log Out</a></li>'
    : '<li><a href="login.php">Log In</a></li>';
$menuAdmin = (isset($_SESSION['userrole']) && $_SESSION['userrole'] === 'admin')
    ? '<li><a href="adminpage.php">Admin</a></li>'
    : '';

$xml = new DOMDocument();

$xml->validateOnParse = true;

$xml->load(XML_FILE);

$xsl = new DOMDocument();
$xsl->load(__DIR__ . '/xml/leaderboards.xsl'); 

$proc = new XSLTProcessor();
$proc->importStylesheet($xsl);
echo $proc->transformToXML($xml);