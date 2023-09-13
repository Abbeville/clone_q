<?php
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
if(empty($link)){header('Location: ./admin.php'); exit;}
$error_message = '';
$sucm = '';
$subject = "";
$message = "";
if(!empty($_POST)){
//Define posted variables
$subject = urldecode($_POST["subject"]);
$message = urldecode($_POST["message"]);
//If form is posted with $_POST['send'], then save the email in database for robot to send
if(!empty($_POST["send"])) {
$subject = mysqli_real_escape_string($link, $_POST["subject"]);
$message = mysqli_real_escape_string($link, $_POST["message"]);
$sql70 = "INSERT INTO `emails` (`SUBJECT`, `MESSAGE`, `DATE`, `RENUM`, `STATUS`) 
VALUES ('$subject','$message','$time','0','inprogess')";
$result = mysqli_query($link, $sql70);
$subject = "";
$message = "";
$sucm = 'Message queued and will soon be sent by robot in less than 5 minutes';
   }
}
?><!doctype html><html><head><meta charset="utf-8"><title>Newsletter | Affiliate Me - <?php echo $version; ?></title><meta name="robots" content="noindex, nofollow"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="font-awesome.min.css" rel="stylesheet"><link href="email.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="wb_Form1"><form name="Form1" method="post" action="./admin.php?show=email" id="Form1"><div id="Html3"><input class="send" type="submit" name="send" value="<?php echo $lang['send']; ?>"></div><input type="text" id="Editbox1" name="subject" value="<?php echo $subject; ?>" autofocus spellcheck="true" required placeholder="<?php echo $lang['subject']; ?>"><div id="wb_FontAwesomeIcon1"><div id="FontAwesomeIcon1"><i class="fa fa-history"></i></div></div><div id="bodymsg"><div style="font-size:13px;" class="page-wrapper box-content"><textarea class="content" name="message"><?php echo $message; ?></textarea></div><script>
$(document).ready(function(){$('.content').richText();});</script></div><div id="Html4"><span style="color:#00BFFF;font-family:Arial;font-size:16px;"><strong><?php echo $lang['msgbody']; ?>:</strong></span></div><div id="Html5"><span style="font-size:16px;"><strong><a href="./admin.php?show=robot"><?php echo $lang['sentmsgs']; ?></a></strong></span></div><div id="Html2"><span style="color:#00BFFF;font-family:Arial;font-size:16px;"><strong><?php echo $lang['emsubj']; ?>:</strong></span></div></form></div><div id="Html8"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:12px;\"><center><i class=\"fa fa-check-circle-o\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
}
?><?php
if($error_message !='') {
echo "<div class=\"alert2\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:12px;\"><center><i class=\"fa fa-info-circle\">&nbsp;</i><strong>" . $error_message . "</strong></center></div></div>";
}
?></div><div id="Html23"><div style="color:#A9A9A9;font-family:Arial;font-size:13px; text-align:center;">Affiliate Me Version <?php echo $version; ?><br></div></div><div id="Html1"><div style="color:#A9A9A9;font-family:Arial;font-size:21px;text-align:center;"><?php echo $lang['brns']; ?></div></div></div></body></html>