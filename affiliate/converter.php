<?php
ob_start();
?><!doctype html><html><head><meta charset="utf-8"><title>Referral Converter</title><meta name="robots" content="noindex, nofollow"><meta name="generator" content="Powerstone"><link href="converter.css" rel="stylesheet"></head><body><div id="container"><div id="Html1" style="position:absolute;left:348px;top:160px;width:277px;height:143px;z-index:0"><?php 
// Powerstone Affiliate Me, Version 3.0.6 https://www.powerstonegh.com.
include "db.php";
include "functions.php";
$idb = $dbserver;
if (empty($idb)){header("Location:installer.php");}
$link = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbdatabase);
$refer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$refer = get_domain($refer);
//start session and define the required variables
ini_set('session.cookie_lifetime', $sessdur);
session_start();
$sql1="SELECT * FROM domains WHERE DOMAIN = '" . $refer . "' ";
$result=mysqli_query($link, $sql1);
if(mysqli_num_rows($result) > 0){
    header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    header('Set-Cookie: cross-site-cookie=name; SameSite=None; Secure');

//check if the referer domain is valid and the user was actually refered by an affiliate 
if(!empty($_GET['amt'])){
$_SESSION['amt'] = $_GET['amt'];
$_SESSION['tid'] = $_GET['id'];

   }

}
?></div></div></body></html><?php
ob_end_flush();
?>