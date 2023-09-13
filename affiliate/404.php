<?php
// Powerstone Affiliate Me, Version 1.0.0 https://www.powerstonegh.com.
if(file_exists('db.php')){include "db.php";} else
{header('Location: /index.php'); exit;}
date_default_timezone_set($tzone);
$link = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbdatabase);
?><!doctype html><html><head><meta charset="utf-8"><title>Error 404</title><meta name="robots" content="noindex, nofollow"><meta name="generator" content="Powerstone"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="404.css" rel="stylesheet"></head><body><div id="container"><div id="Html1"><?php
//define host url and display error message
$url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
echo "<center><span style=\"color:#000000;font-family:Arial;font-size:20px;\"><strong>Error 404</strong><br>Sorry, that seem like a missing page, the URL: (".$url.") is currently not found on the server but we are working on fixing it soon!</span></center>" ;
$date = date("Y-m-d");
$time = date("G:i:s");
//insert error url into database
$sql = "INSERT INTO `errors` (`TYPE`, `DATE`, `TIME`, `URL`) VALUES ('404','$date','$time','$url')";
$result = mysqli_query($link, $sql);
?></div><div id="Html9"><div class="logo"><a href="./"><img src="<?php echo $logo; ?>" alt="Logo"></a></div></div></div></body></html>