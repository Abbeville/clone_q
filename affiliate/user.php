<?php
ob_start();
?><?php
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
include "db.php";
include "functions.php";
if ($dbserver == ''){header('Location: ./index.php');}
date_default_timezone_set($tzone);
$time = time();
$date = date("Y-m-d");
$year = date("Y");

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
if (session_id() == "")
{
   session_start();
}
if (!isset($_SESSION['username']))
{
   header('Location: ./index.php');
   exit;
}
if (isset($_SESSION['expires_by']))
{
   $expires_by = intval($_SESSION['expires_by']);
   if (time() < $expires_by)
   {
      $_SESSION['expires_by'] = time() + intval($_SESSION['expires_timeout']);
   }
   else
   {
      unset($_SESSION['username']);
      unset($_SESSION['expires_by']);
      unset($_SESSION['expires_timeout']);
      header('Location: ./index.php');
      exit;
   }
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
if (isset($_SESSION["otp"])) {header("Location: ./checkpoint.php"); exit();}
//Set validation token
if(empty($_SESSION["token"])){$_SESSION["token"]=rand(11111, 99999);}
$token = $_SESSION["token"];
//action to execute on logout
if(isset($_GET['action']) ? $_GET['action'] : '' == 'logout'){
$ded = '407';
$timeoff = time() - $ded;
$sql4 = "UPDATE users SET ONLINE='".$timeoff."' WHERE USERNAME = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($link, $sql4);
session_destroy();
header('Location: ./');
}
//Select user's data from database
$sql = "SELECT * FROM users WHERE USERNAME = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);

                    $balance = $row['CREDIT'] ;
                    $avatar = $row['AVATAR'] ;
                    $online = $row['ONLINE'] ;
                    $phone = $row['PHONE'] ;
                    $username = $row['USERNAME'] ;
                    $name = $row['NAME'] ;
                    $email = $row['EMAIL'] ;
                    $acess = $row['ACESS'] ;
                    $country = $row['COUNTRY'] ;
                    $website = $row['WEBSITE'] ;
                    

$notes=0;
$sql1="SELECT * FROM notes  WHERE USERNAME = '" . $_SESSION['username'] . "' AND status = '1' ";
$result=mysqli_query($link, $sql1);
$notes=mysqli_num_rows($result);

$msg=0;
$sql3="SELECT * FROM tickets  WHERE username = '" . $_SESSION['username'] . "' AND status = '<cr>New!</cr>' AND trash = '0' ";
$result=mysqli_query($link, $sql3);
$msg=mysqli_num_rows($result);

$ru=0;
$sql2="SELECT * FROM ref  WHERE USERNAME = '" . $_SESSION['username'] . "' ";
$result=mysqli_query($link, $sql2);
$ru=mysqli_num_rows($result);

$sa=0;
$sql2="SELECT * FROM ref  WHERE USERNAME = '" . $_SESSION['username'] . "' && SALE = 'yes' ";
$result=mysqli_query($link, $sql2);
$sa=mysqli_num_rows($result);


$sql = "SELECT 
SUM(VCOMM) AS inc, SUM(CPC) AS cpv
FROM   ref
WHERE  USERNAME = '$username' ";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);

    if($cpc == "on"){$income = $row['inc'] + $row['cpv'] ;} else {$income = $row['inc'];}
   
    if($income== '') $income = '0';

//Update last activity time in database
$sql100 = "UPDATE users SET ONLINE='".$time."' WHERE USERNAME = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($link, $sql100);

//Generate affiliate link for user
if($purl == 'on'){$afflink = $prot . $domain . "/aff/" . $_SESSION['username'];}
else
{$afflink = $prot . $domain . "/ref.php?ref=" . $_SESSION['username'];}
//Use affiliate link to generate QR code
include "qr/qrlib.php";

// create a QR Code with this text and display it

QRcode::png("$afflink", "$username."."png", 'L', 24, 1);




//Define Pages
if(empty(isset($_GET['show']) ? $_GET['show'] : ''))
{
include("dash.php");
}
else
if($_GET['show'] == 'banners')
{
include("banners.php");
}
else
if($_GET['show'] == 'clicks')
{
include("clicks.php");
}
else
if($_GET['show'] == 'com')
{
include("referrals.php");
}
else
if($_GET['show'] == 'logins')
{
include("loghistory.php");
}
else
if($_GET['show'] == 'settings')
{
include("usersettings.php");
}
else
if($_GET['show'] == 'withdraw')
{
include("withdraw.php");
}
else
if($_GET['show'] == 'tickets')
{
include("tickets.php");
}
else
if($_GET['show'] == 'trash')
{
include("trash.php");
}
else
if($_GET['show'] == 'message')
{
include("message.php");
}
else
if($_GET['show'] == 'notes')
{
include("allnotes.php");
}
else
{
include("notfound.php");
}
?><!doctype html><html><head><meta charset="utf-8"><title></title><meta name="robots" content="noindex, nofollow"><meta name="generator" content="Powerstone"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="font-awesome.min.css" rel="stylesheet"><link href="user.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script><script>
$1=jQuery.noConflict(true);</script><link href="<?php echo $favicon; ?>" rel="shortcut icon" type="image/x-generic"><?php echo urldecode($ganal); ?></head><body><div id="container"></div><div id="PageHeader"><div id="PageHeader_Container"><div id="avatarmenu"><div class="dropdown"><div class="pr"><img style="vertical-align:middle" src="avatars/<?php echo $avatar; ?>" onerror="this.src='images/defavat.png';" border="1">&nbsp;<div style="font-size:14px; color:#A9A9A9;" class="fa fa-sort-desc"></div></div><div class="dropdown-content"><?php
if($acess == "user"){echo "<a href=\"./user.php\" ><span style=\"font-family:Arial;font-size:17px;\"><div class=\"fa fa-user\"></div> ".$lang['dashboard']."</span></a>";}
else
if($acess == "admin" || $acess == "superadmin"){echo "<a href=\"./admin.php\" ><span style=\"font-family:Arial;font-size:17px;\"><div class=\"fa fa-tachometer\"></div> ".$lang['administrator']."</span></a><hr class='menu'>";}
?><a href="./user.php?show=banners"><span style="font-family:Arial;font-size:17px;"><div class="fa fa-link"></div>&nbsp;<?php echo $lang["mktools"]; ?></span></a><a href="./user.php?show=clicks"><span style="font-family:Arial;font-size:17px;"><div class="fa fa-hand-pointer-o">&nbsp;</div><?php echo $lang["clicks"]; ?></span></a><a href="./user.php?show=com"><span style="font-family:Arial;font-size:17px;"><div class="fa fa-dollar"></div>&nbsp;<?php echo $lang["earnings"]; ?></span></a><a href="./user.php?show=withdraw"><span style="font-family:Arial;font-size:17px;"><div class="fa fa-money"></div>&nbsp;<?php echo $lang["withfund"]; ?></span></a><hr class="menu"><a href="./user.php?show=settings"><span style="font-family:Arial;font-size:17px;"><div class="fa fa-gear"></div>&nbsp;<?php echo $lang["acset"]; ?></span></a><a href="./user.php?show=logins"><span style="font-family:Arial;font-size:17px;"><div class="fa fa-keyboard-o"></div>&nbsp;<?php echo $lang["loghis"]; ?></span></a><a href="./user.php?action=logout"><span style="color:#FF4500;font-family:Arial;font-size:17px;"><div class="fa fa-sign-out"></div>&nbsp;<?php echo strtoupper($lang["logout"]); ?></span></a></div></div></div><div id="msgss"><?php if($msg>0) echo "<ct>" . $msg . "</ct>"; ?></div><div id="wb_chaicon"><a class="inlink" href="user.php?show=tickets" title="You have (<?php  echo $msg; ?>) new messages"><div id="chaicon"><i class="fa fa-comments-o"></i></div></a></div><div id="wb_notebell"><script>
$(document).ready(function(){$("con.cicon").one('click',function(){$("#wait").css("display","block");});$(document).ajaxComplete(function(){$("#wait").css("display","none");});$("con").one('click',function(){$("#mynote").load("notes.php");});});</script><con class="cicon"><div id="notebell" title="You have (<?php  echo $notes; ?>) new notifications"><i class="fa fa-bell-o"></i></div></con><div id="popup" class="popup"><span class="popuptext" id="myPopup"><strong><span style="font-size:14px;">Your Notifications (<?php  echo $notes; ?> New)</span></strong><br><div id="wait"><center><br><img src="wait.gif" width="40" height="40"/><br><strong>Loading...</strong></center></div><span style="color:#000000;font-family:Tahoma;font-size:13px;"><div id="mynote"></div></span></span></div><script>
$("con.cicon").click(function(){if($("div#popup:first").is(":hidden")){$("div#popup").fadeIn("slow");}
else{$("div#popup").fadeOut("slow");}});var box=$('#popup');var login=$('.cicon');login.click(function(){box.show();return false;});$(document).click(function(){box.hide();});box.click(function(e){e.stopPropagation();});</script></div><div id="logo"><div class="logo"><a href="./user.php"><img src="<?php echo $logo; ?>" alt="Logo"></a></div></div><div id="balance"><span style="color:#c0c0c0;font-family:Arial;font-size:18px;"><?php echo $lang["balance"]; ?>: <a href="./user.php?show=withdraw"><?php echo $currsym; ?><?php if($balance>0) echo number_format($balance, 2); else echo '0.00'; ?></a></span></div><div id="notco"><?php if($notes>0) echo "<ct>" . $notes . "</ct>"; ?></div><div id="mmenu"><script src="wb.panel.min.js"></script><script>
$(document).ready(function()
{$("#PanelMenu1").panel({animate:true,animationDuration:200,animationEasing:'linear',dismissible:true,display:'overlay',position:'left',toggle:true});$("#PanelMenu1_markup ul li a").click(function(event)
{$.panel.hide($("#PanelMenu1_panel"));});});</script><div id="wb_PanelMenu1"><a href="#PanelMenu1_markup" id="PanelMenu1">
<span class="line"></span>
<span class="line"></span>
<span class="line"></span>
</a><div id="PanelMenu1_markup"><div id="PanelMenu1-logo"><img alt="" src="avatars/<?php echo $avatar; ?>" onerror="this.src='images/defavat.png';"></div><ul role="menu"><li class="divider" role="separator"></li><li role="menuitem"><a href="./user.php?show=banners"><i class="fa fa-link fa-fw"></i><span><?php echo $lang["mktools"]; ?></span></a></li><li role="menuitem"><a href="./user.php?show=clicks"><i class="fa fa-hand-pointer-o fa-fw"></i><span><?php echo $lang["clicks"]; ?></span></a></li><li role="menuitem"><a href="./user.php?show=com"><i class="fa fa-dollar fa-fw"></i><span><?php echo $lang["earnings"]; ?></span></a></li><li role="menuitem"><a href="./user.php?show=withdraw"><i class="fa fa-money fa-fw"></i><span><?php echo $lang["withfund"]; ?></span></a></li><li class="divider" role="separator"></li><li role="menuitem"><a href="./user.php?show=tickets"><i class="fa fa-comments fa-fw"></i><span><?php echo $lang["msgs"]; ?><?php if($msg>0) echo "<ct>" . $msg . "</ct>"; ?></span></a></li><li role="menuitem"><a href="./user.php?show=notes"><i class="fa fa-bell fa-fw"></i><span><?php echo $lang["notes"]; ?><?php if($notes>0) echo "<ct>" . $notes . "</ct>"; ?></span></a></li><li role="menuitem"><a href="./user.php?show=settings"><i class="fa fa-gear fa-fw"></i><span><?php echo $lang["acset"]; ?></span></a></li><li role="menuitem"><a href="./user.php?show=logins"><i class="fa fa-keyboard-o fa-fw"></i><span><?php echo $lang["loghis"]; ?></span></a></li><li role="menuitem"><a href="./user.php?action=logout"><i class="fa fa-sign-out fa-fw"></i><span><?php echo strtoupper($lang["logout"]); ?></span></a></li></ul></div></div></div><div id="Html23"><span style="color:#c0c0c0;font-family:Arial;font-size:18px;">Earnings: <a href="/user.php?show=withdraw"><?php echo $currsym; ?><?php if($balance>0) echo number_format($balance, 2); else echo '0.00'; ?></a></span></div></div></div></body></html><?php
ob_end_flush();
?>