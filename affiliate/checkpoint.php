<?php
// Powerstone Affiliate Me, Version 5.0.1 https://www.powerstonegh.com.
include "db.php";
if(empty($dbserver)){header('Location: /index.php'); exit;}
date_default_timezone_set($tzone);
$time = time();
$link = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbdatabase);
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
//Generate session token
session_start();
if(empty($_SESSION["token"])){$_SESSION["token"]=rand(11111, 99999);}
$token = $_SESSION["token"];
$actcode = mysqli_real_escape_string($link, $_GET['auth']);
$auth = isset($actcode) ? $actcode : '';

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

if (!isset($_SESSION["otp"])) {header("Location: ./index.php"); exit();}
//Select user's data from database
$sql = "SELECT * FROM users WHERE USERNAME = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
                    $username = $row['USERNAME'] ;
                    $email = $row['EMAIL'] ;
                    $fullname = $row['NAME'] ;
$sucm = '';
$error_message = '';

if(!empty($_POST) && $_POST["token"]==$token && strtolower($_SERVER['HTTP_HOST'])==strtolower(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST))){
$vercode = mysqli_real_escape_string($link, $_POST['code']);
if($vercode != '' && $vercode == $_SESSION["otp"]) {
$browid = $_SESSION["browid"];
setcookie("browser", $browid, time() + 3600*24*360);
$sucm = "Account Successfully Unlocked! Please Wait...";
unset($_SESSION["otp"]);
unset($_SESSION["browid"]);
   } else {
$error_message = "Invalid Verification Code";
   }
}

if(isset($_GET["action"]) && $_GET["action"] == "resend"){
$vc = mt_rand(1111, 9999);
$_SESSION["otp"] = $vc;

//Send Email
$message = '<meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Vibaze Charts</title>
      
  
    <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">Authentication.</span>
    <table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;" cellspacing="0" cellpadding="0" border="0">
      <tbody><tr>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
        <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
          <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">
            <!-- START CENTERED WHITE CONTAINER -->
            <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">
              <!-- START MAIN CONTENT AREA -->
              <tbody><tr>
                <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                  <table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" cellspacing="0" cellpadding="0" border="0">
                    <tbody><tr>
                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                        <div>
                        <div style="text-align:center;"><b><font color="#000000"><img alt="Logo" src="'.$prot.$domain.'/'.$logo.'" style="max-width:150px; max-height:150px;" align="middle"></font></b></div><br>
                        <div style="text-align:center;"><div style="text-align:center;"><b></div><b><font size="4" color="#000000">NEW AUTHENTICATION CODE</font></b><br></div>
                        <br>
                        <font color="#000000">Hello '.$fullname.',</font></div><font color="#000000"> with regards to the previous login attempt on your account from our website you asked that we send you a new authentication code and you can find this code below.<br>
                        
                        Your new authentication code is: <strong>'.$vc.'</strong> and you can equally use the button below to authenticate without having to copy and paste!<br><br></font><div><font color="#000000">Regards.</font></div>
                        <br>
                        <div style="text-align:center;"><a href="'.$prot.$domain.'/checkpoint.php?auth='.$vc.'" target="_blank" style="display: inline-block; color: #ffffff; background-color: #1E90FF; border: solid 1px #1E90FF; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #1E90FF;">Confirm</a><table width="200" cellspacing="0" cellpadding="0" border="0" align="center"></div>
                      </td>
                    </tr>
                  </tbody></table>
                </td>
              </tr>
            <!-- END MAIN CONTENT AREA -->
            </tbody></table>
          <!-- END CENTERED WHITE CONTAINER -->
          </div>
          
          <!-- START FOOTER -->
      <div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;">
       <table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" cellspacing="0" cellpadding="0" border="0">
        <tbody><tr>
        <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">&nbsp;You are receiving this message because you are a member of '.$domain.'.<br>Copyright © '.date("Y").'.<span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;"></span>
        </td>
       </tr>
      </tbody></table>
   </div>
   <!-- END FOOTER -->
          
        </td>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
      </tr>
    </tbody></table>
';

if($smtpmail == 'on') {


$subject = "New Browser Detected";

$body = $message;
$mail->FromName = $sitename;
$mail->addAddress($email);
$mail->Subject = $subject;
$mail->Body    = $body;
$mail->send();
} else {
$subject = "New Browser Detected";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From:  ' . $sitename . ' <' . $semail .'>' . " \r\n";
mail($email,$subject,$message,$headers);
   }
}

?><!doctype html><html><head><meta charset="utf-8"><title><?php echo $lang["chkpoint"];?></title><meta name="robots" content="noindex, nofollow"><meta name="generator" content="Powerstone"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="checkpoint.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script><script src="wwb14.min.js"></script><link href="font-awesome.min.css" rel="stylesheet"><link href="<?php echo $favicon; ?>" rel="shortcut icon" type="image/x-generic"><?php echo urldecode($ganal); ?></head><body><div id="container"><div id="Html1"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:16px;\"><center><i class=\"fa fa-check-circle-o\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
echo "<script type=\"text/javascript\">
var wait=setTimeout(\"location.href='user.php';\",7000);</script>";
}
?><?php
if($error_message !='') {
echo "<div class=\"alert2\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:14px;\"><center><i class=\"fa fa-info-circle\">&nbsp;</i><strong>" . $error_message . "</strong></center></div></div>";
}
?></div><div id="Html10"><span style="color:#696969;font-family:Arial;font-size:15px;"><center><?php $cyear = date("Y"); echo "Copyright © " .$cyear ." " .$sitename. ", All Rights Reserved."; ?></center></span></div><div id="wb_Form1"><form name="conform" method="post" action="./checkpoint.php" id="Form1" onsubmit="ShowObject('Html2', 1);ShowObject('Html11', 0);document.getElementById('Form1').submit();return false;"><input type="hidden" name="token" value="<?php echo $token; ?>"><div id="Html7"><div style="color:#1E90FF;font-family:Arial;font-size:17px;text-align:center;"><strong><?php echo $lang["chkpoint"];?></strong></div></div><div id="Html2"><but class="button2" disabled><div class="fa fa-spinner fa-pulse"></div>&nbsp;&nbsp;Processing...</but></div><div id="Html11"><button type="submit" class="button"><i class="fa fa-unlock">&nbsp;</i>&nbsp;&nbsp;<?php echo $lang["confirm"];?></button></div><div id="Html27"><div id="divOuter"><div id="divInner"><input id="partitioned" name="code" type="text" maxlength="4" autofocus placeholder="0000" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" onKeyPress="if(this.value.length==4) return false;" value="<?php echo $auth; ?>"></div></div></div><div id="Html3"><div style="color:#696969;font-family:Tahoma;font-size:15px;text-align:center;"><?php echo $lang['hello'];?><?php echo $fullname; ?>, <?php echo $lang['vercodepre'];?><?php echo $email; ?>, <?php echo $lang['checkva'];?></div></div><div id="Html4"><div style="color:#696969;font-family:Tahoma;font-size:13px;text-align:center;"><?php echo $lang['nocode'];?><strong><a href="/checkpoint.php?action=resend"><?php echo $lang['resend'];?></a></strong>!</div></div><div id="Html9"><div class="logo"><a href="./"><img src="<?php echo $logo; ?>" alt="Logo"></a></div></div></form></div></div></body></html>