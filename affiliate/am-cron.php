<?php 
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
include "db.php";
$link = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbdatabase);
date_default_timezone_set($tzone);
$date = date("Y-m-d");
$time = time();
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
//Get number of total users on system
$sql33 = "SELECT * FROM users WHERE ACESS != 'zblocked'";
$result = mysqli_query($link, $sql33);
$tusers=mysqli_num_rows($result);
?><!doctype html><html><head><meta charset="utf-8"><title>Cron</title><meta name="robots" content="noindex, nofollow"><link href="am-cron.css" rel="stylesheet"></head><body><!-- Commission converter --><div id="Html9" style="position:absolute;left:205px;top:86px;width:481px;height:83px;z-index:0"><?php
//search referals
$sql121 = "SELECT * FROM ref WHERE SALE = 'yes' && COMM > '0' && VCOMM != '0' && VDATE < CURDATE() LIMIT 1";
 if($result = mysqli_query($link, $sql121)){
 if(mysqli_num_rows($result) > 0){
 while($row = mysqli_fetch_array($result)){
$username = $row['USERNAME'];
$trn = $row['TRN'];
$comm = $row['COMM'];
//Select user's data from database and update their commission
$sql9 = "SELECT * FROM users WHERE USERNAME = '" . $username . "' ";
$result = mysqli_query($link, $sql9);
$ro = mysqli_fetch_array($result);
$combal = $ro['CREDIT'];
if($combal==''){$combal=0;}
$ncombal = $combal + $comm;
$sql67 = "UPDATE users SET CREDIT='" . $ncombal . "' WHERE USERNAME = '" . $username . "' ";
$result = mysqli_query($link, $sql67);
//update referral
$sql3 = "UPDATE ref SET COMM='0' WHERE TRN = '" . $trn . "'";
mysqli_query($link, $sql3);
//Update affiliate user
$sql2 = "INSERT INTO `notes` (`USERNAME`, `MESSAGE`,`STATUS`, `DATE`, `ICON`, `LINK`) VALUES ('$username','Good news, your earning for transaction $trn successfully converted to your balance.','1','$date','check.png','user.php?show=com')";
$result = mysqli_query($link, $sql2);
         }
      }
   }
?></div><!-- Cron Timer --><div id="Html1" style="position:absolute;left:205px;top:275px;width:481px;height:61px;z-index:1"><?php
$cf = dirname(__FILE__) .'/cron.php';
$file = fopen($cf, 'w');
      fwrite($file, '<?php');
      fwrite($file, "\r\n");
      fwrite($file, '$ctime');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $time);
      fwrite($file, '";');
      fclose($file);
?></div><!-- Newsletter Broadcaster --><div id="Html2" style="position:absolute;left:205px;top:180px;width:481px;height:83px;z-index:2"><?php
$wh = ($tusers / $mailimit) * 3600;
$sql = "SELECT * FROM users WHERE ACESS != 'zblocked' AND $time - LMS > $wh LIMIT $mailimit ";
$result = mysqli_query($link, $sql);
$ausers=mysqli_num_rows($result);
$all = array();
while($row = mysqli_fetch_array($result))
{
    $all[] = $row["EMAIL"];
}
//search uncompleted emails
$recnum = "";
$sql121 = "SELECT * FROM emails WHERE STATUS = 'inprogess' ORDER BY ID ASC LIMIT 1";
 if($result = mysqli_query($link, $sql121)){
 if(mysqli_num_rows($result) > 0){
 while($row = mysqli_fetch_array($result)){
$subject = $row['SUBJECT'];
$message = nl2br($row['MESSAGE']);
$date = $row['DATE'];
$recnum = $row['RENUM'];
         }
     }
     
 }
 
 if(file_exists(dirname(__FILE__) .'/lns.php')) {include "lns.php";} else {$estime = "1496473892";}
 if($ausers>0 && $recnum != "" && ($time - $estime) > '3600'){
//Set new email parameters for the email being sent
 $trec = $recnum + $ausers;
 if($trec == $tusers){$mstat = "done";} else {$mstat = "inprogess";}
 
//Use Email sender defined by admin
$body = $message;
if($smtpmail == 'on') {
$users = $all;
foreach($users as $email) {
$mail->FromName = $sitename;
$mail->addAddress($email);
$mail->Subject = $subject;
$mail->Body    = $body;
$mail->send();
$mail->ClearAllRecipients();
      }
   }
else {
 
$users = $all;
foreach($users as $email) {
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From:  ' . $sitename . ' <' . $semail .'>' . " \r\n";
mail($email,$subject,$message,$headers);
   }
}
   
//Update receivers' last message sent status
$sql100 = "UPDATE users SET LMS='".$time."' WHERE ACESS != 'zblocked' AND $time - LMS > $wh LIMIT $mailimit ";
$result = mysqli_query($link, $sql100);
//Update status of email
$sql101 = "UPDATE emails SET RENUM='".$trec."', STATUS='".$mstat."' WHERE DATE = '".$date."'";
$result = mysqli_query($link, $sql101);
//Write the last email sent time in php
$et = dirname(__FILE__) .'/lns.php';
$file = fopen($et, 'w');
      fwrite($file, '<?php');
      fwrite($file, "\r\n");
      fwrite($file, '$estime');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $time);
      fwrite($file, '";');
      fclose($file);
}
 
 ?></div></body></html>