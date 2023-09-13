<?php
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
include "db.php";
if(empty($dbserver)){header('Location: /index.php'); exit;}

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
$error_message = '';
$sucm = '';
$newpassword = "";
session_start();

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

mysqli_set_charset($link, 'utf8');
if(empty($_SESSION["token"])){$_SESSION["token"]=rand(11111, 99999);}
$token = $_SESSION["token"];
if(!empty($_POST) && $_POST["token"]==$token && strtolower($_SERVER['HTTP_HOST'])==strtolower(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST))){
$email = mysqli_real_escape_string($link, $_POST['email']);
//check if the submitted email exists, else error out
$conn = new mysqli($dbserver,$dbusername,$dbpassword,$dbdatabase);
$counter=0;
$sql3="SELECT * FROM users  WHERE EMAIL = '" . $email . "' ";
$result=mysqli_query($conn, $sql3);
$counter=mysqli_num_rows($result);
if ($counter == 0)
   {
      $error_message = $lang["recerr"];
   }
//if email exists, then generate new password and send to the user's email as well as store the new password in the database
if (empty($error_message)){


$sql = "SELECT * FROM users WHERE EMAIL = '" . $email . "' ";
$result = mysqli_query($link, $sql);

$row = mysqli_fetch_array($result);
$username = $row['USERNAME'] ;
$fullname = $row['NAME'] ;

//Generate activation code
$actcode = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 25);
$reclink = $prot.$domain."/reset.php?activate=".$actcode;
$sql100 = "UPDATE users SET RKEY='" . $actcode . "' WHERE EMAIL = '" . $email . "' ";
$result = mysqli_query($link, $sql100);
//generate email to send to user
$sql9 = "SELECT * FROM etemplates WHERE NAME = '" . $passrec . "' ";
$result = mysqli_query($link, $sql9);
$rw = mysqli_fetch_array($result);
$dbtmsg = $rw['MESSAGE'] ;

$variables = array();


$variables['sitename'] = $sitename;

$variables['semail'] = $semail;

$variables['fullname'] = $fullname;


$variables['username'] = $username;


$variables['recover'] = $reclink;


$template = stripslashes($dbtmsg);



foreach($variables as $key => $value)

{

$template = str_replace('{{ '.$key.' }}', $value, $template);

}
$message = $template;
//Send email using the admin's configurations
if($smtpmail == 'on') {


$subject = "Your New Password";

$body = $message;
$mail->FromName = $sitename;
$mail->addAddress($email);
$mail->Subject = $subject;
$mail->Body    = $body;
$mail->send();
} else {
$subject = "Your New Password";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From:  ' . $sitename . ' <' . $semail .'>' . " \r\n";
mail($email,$subject,$message,$headers);
}

$sucm =  $lang["prerec"].$email.$lang["endrec"];

   }
}
    // Close connection
    mysqli_close($link);
?><!doctype html><html><head><meta charset="utf-8"><title>Password Recovery | <?php echo $sitename; ?></title><meta name="generator" content="Powerstone"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="%3C%3Fphp%20echo%20%24favicon%3B%20%3F%3E" rel="shortcut icon" type="image/x-icon"><link href="font-awesome.min.css" rel="stylesheet"><link href="passrecover.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script><script src="wwb14.min.js"></script><link href="<?php echo $favicon; ?>" rel="shortcut icon" type="image/x-generic"></head><body><div id="container"><div id="wb_Form1"><form name="recover" method="post" action="./passrecover.php" id="Form1" onsubmit="ShowObject('Html1', 0);ShowObject('Html2', 1);document.getElementById('Form1').submit();return false;"><input type="hidden" name="token" value="<?php echo $token; ?>"><div id="Html2"><but class="button2" disabled><span><div class="fa fa-refresh fa-spin"></div></span>&nbsp;&nbsp;<?php echo $lang['sending'];?></but></div><input type="email" id="email" name="email" value="" autofocus spellcheck="false" placeholder="<?php echo $lang['email'];?>"><div id="wb_FontAwesomeIcon1"><div id="FontAwesomeIcon1"><i class="fa fa-envelope"></i></div></div><div id="Html1"><button type="submit" class="button"><i class="fa fa-paper-plane">&nbsp;</i>&nbsp;<?php echo $lang["sendpass"];?></button></div><div id="Html9"><div class="logo"><a href="./"><img src="<?php echo $logo; ?>" alt="Logo"></a></div></div></form></div><div id="Html4"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:14px;\"><center><i class=\"fa fa-check-circle\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
echo "<script type=\"text/javascript\">
var wait=setTimeout(\"location.href='index.php';\",10000);</script>";
}
?><?php
if($error_message !='') {
echo "<div class=\"alert2\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:14px;\"><center><i class=\"fa fa-info-circle\">&nbsp;</i><strong>" . $error_message . "</strong></center></div></div>";
}
?></div><div id="Html3"><div style="color:#000000;font-family:Arial;font-size:13px;text-align:center;"><strong><a href="./index.php"><?php echo $lang['backlog'];?></a></strong></div></div></div></body></html>