<?php
// Powerstone Affiliate Me, Version 5.0.1 https://www.powerstonegh.com.
if(file_exists('db.php'))
{include "db.php";
$link = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbdatabase);}
else
{$tzone = "Africa/Accra"; $dbserver = ''; $favicon ='images/dfavicon.png'; $ganal= ''; $locale = "en-us";}
date_default_timezone_set($tzone);
$time = time();
if ($dbserver == ''){include("installer.php");}
else
{
ini_set('session.cookie_lifetime', $sessdur);
session_start();
if(isset($_COOKIE['browser']))
{$browid = $_COOKIE['browser'];}
else
{$browid = $time; setcookie('browser', $time, time() + 3600*24*360);}

if(isset($_GET['locale']))
{
    $_SESSION['locale']= $_GET['locale'];
}
if(isset($_SESSION['locale']))
{
    $locale = $_SESSION['locale'];
}
else
{
    $locale = $locale;
}
if(file_get_contents("locale/".$locale.".php"))
{
    include "locale/".$locale.".php";
}
else
{
    include "locale/en-us.php";
}
include("login.php");
}
?><!doctype html><html><head><meta charset="utf-8"><title></title><link href="index.css" rel="stylesheet"><link href="<?php echo $favicon; ?>" rel="shortcut icon" type="image/x-generic"><?php echo urldecode($ganal); ?></head><body><div id="container"></div></body></html>