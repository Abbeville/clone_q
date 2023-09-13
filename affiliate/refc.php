<?php
ob_start();
?><!doctype html><html><head><meta charset="utf-8"><title>Referral Converter</title><meta name="robots" content="noindex, nofollow"><meta name="generator" content="Powerstone"><link href="refc.css" rel="stylesheet"></head><body><div id="container"><div id="Html1" style="position:absolute;left:348px;top:160px;width:277px;height:143px;z-index:0"><?php 
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
include "db.php";
include "functions.php";
$idb = $dbserver;
if (empty($idb)){header("Location:installer.php");}
//SMTP Email Config
require_once("mailer/autoload.php"); 
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = $mailhost;
$mail->SMTPAuth = true;
$mail->Username = $musername;
$mail->Password = $mpassword;
$mail->SMTPSecure = 'ssl';
$mail->Port = $mport;
$mail->From = $semail;
$mail->addReplyTo($semail);
$mail->isHTML(true);

$link = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbdatabase);
//start session and define the required variables
ini_set('session.cookie_lifetime', $sessdur);
session_start();
//Check if session has expired
$sesstime = isset($_SESSION['trn']) ? $_SESSION['trn'] : '0';
if(time()-$sesstime > $sessdur) {session_destroy(); exit();}
date_default_timezone_set($tzone);
$date = date("Y-m-d");
$time = date("G:i:s");
$stime = time();
$user = mysqli_real_escape_string($link, isset($_SESSION['ref']) ? $_SESSION['ref'] : '');
//check if the referer domain is valid and the user was actually refered by an affiliate and add the records to database
$refer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$refer = get_domain($refer);
$sql1="SELECT * FROM domains WHERE DOMAIN = '" . $refer . "' ";
$result=mysqli_query($link, $sql1);
if(mysqli_num_rows($result) > 0){
if ($user != ''){
$vdate = date("Y-m-d", strtotime(" +".$vd." days"));
if($perc == "on" && !empty($_SESSION['amt'])){
$comm = round(sprintf('%f', floatval($comm * $_SESSION['amt'])), 2);
$tid = $_SESSION['tid'];
} else {$comm = $comm; $tid="";}
//Update database records
$sql2 = "UPDATE ref SET COMM='".$comm."', VCOMM='".$comm."', DATE='".$date."', VDATE='".$vdate."', OID='".$tid."', SALE='yes' WHERE USERNAME = '".$user."' &&  TRN = '".$_SESSION['trn']."'";
$result = mysqli_query($link, $sql2);
   
//alert the affiliate that their link was used and they've earned a commision     
$sql2 = "INSERT INTO `notes` (`USERNAME`, `MESSAGE`,`STATUS`, `DATE`, `ICON`, `LINK`) VALUES ('$user','Good news, a new user just signed up using your affiliate link','1','$date','check.png','user.php?show=com')";
$result = mysqli_query($link, $sql2);
//Email the affiliate about their sale!
$sql9 = "SELECT * FROM users WHERE USERNAME = '" . $user . "' ";
$result = mysqli_query($link, $sql9);
$ro = mysqli_fetch_array($result);
$fullname = $ro['NAME'];
$emailad = $ro['EMAIL'];
$sql9 = "SELECT * FROM etemplates WHERE NAME = '" . $sale . "' ";
$result = mysqli_query($link, $sql9);
$rw = mysqli_fetch_array($result);
$dbtmsg = $rw['MESSAGE'] ;

$variables = array();

$variables['sitename'] = $sitename;
$variables['fullname'] = $fullname;

$variables['credit'] = $currsym.$comm;

$template = stripslashes($dbtmsg);

foreach($variables as $key => $value)
{
$template = str_replace('{{ '.$key.' }}', $value, $template);
}
$mesg = $template;

//Proccess the message using admin's email settings
if($smtpmail == 'on') {
$subject = "New Signup";
$body = $mesg;
$mail->FromName = $sitename;
$mail->addAddress($emailad);
$mail->Subject = $subject;
$mail->Body    = $body;
$mail->send();
} else {
$subject = "New Signup";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From:  ' . $sitename . ' <' . $semail .'>' . " \r\n";
mail($emailad,$subject,$mesg,$headers);
  } 
mysqli_close($link); 
//Destroy session to prevent user from earning more than once per a click   
   session_destroy();
   }
}
?></div></div></body></html><?php
ob_end_flush();
?>