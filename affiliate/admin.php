<?php
ob_start();
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
include "db.php";
include "version.php";
include "cron.php";
include "functions.php";
// Checking version changes
if(!file_exists('cversion.php') && $_GET['show'] != 'update'){header("Location:admin.php?show=update");}
else
{include "cversion.php";}
if (version_compare($version, $cversion) > 0 && $_GET['show'] != 'update') {header("Location:admin.php?show=update");}
if ($dbserver == ''){header('Location: ./index.php');}
$folder = dirname(__FILE__);
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
date_default_timezone_set($tzone);
$time = time();
$year = date("Y");
$date = date("Y-m-d");
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
//Restrict page access to only admin and super admin
if ($_SESSION['right'] != 'admin' && $_SESSION['right'] != 'superadmin') header("Location: ./user.php");
//Select user's data from database
$sql = "SELECT * FROM users WHERE USERNAME = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);

                    $balance = $row['CREDIT'] ;
                    $avatar = $row['AVATAR'] ;
                    $online = $row['ONLINE'] ;
                    $phone = $row['PHONE'] ;
                    $username = $row['USERNAME'] ;
                    
//Fetch results for all dashboard counters
$users=0;
$sql2="SELECT * FROM users WHERE ACESS = 'user'";
$result=mysqli_query($link, $sql2);
$users=mysqli_num_rows($result);

$usersonline=0;
$sql3 = "SELECT * FROM users WHERE ACESS = 'user' AND $time - online < '406' ";
$result=mysqli_query($link, $sql3);
$usersonline=mysqli_num_rows($result);
$nusers=0;
$sql32 = "SELECT * FROM users WHERE ACESS = 'user' AND $time - DATE < '604800' ";
$result=mysqli_query($link, $sql32);
$nusers=mysqli_num_rows($result);

$admins=0;
$sql4="SELECT * FROM users WHERE acess != 'user' && acess != 'zblocked' ";
$result=mysqli_query($link, $sql4);
$admins=mysqli_num_rows($result);

$adminsonline=0;
$sql5 = "SELECT * FROM users WHERE acess != 'user' && acess != 'zblocked' AND $time - online < '406' ";
$result=mysqli_query($link, $sql5);
$adminsonline=mysqli_num_rows($result);

$tickets = 0;
$sql6 = "SELECT t1.* FROM tickets t1
  JOIN (SELECT tid, MAX(id) id FROM tickets GROUP BY tid) t2
    ON t1.id = t2.id AND t1.tid = t2.tid WHERE trash = '0' ";
$result=mysqli_query($link, $sql6);
$tickets=mysqli_num_rows($result);

$msg=0;
$sql7="SELECT * FROM tickets  WHERE status1 = '<cr>New!</cr>' AND trash = '0' ";
$result=mysqli_query($link, $sql7);
$msg=mysqli_num_rows($result);

$nreq=0;
$sql8 = "SELECT * FROM withdrawals WHERE STATUS = 'pending'";
$result=mysqli_query($link, $sql8);
$nreq=mysqli_num_rows($result);

$payout=0;
$sql9 = "SELECT * FROM withdrawals WHERE STATUS = 'paid'";
$result=mysqli_query($link, $sql9);
$payout=mysqli_num_rows($result);

$errors=0;
$sql10 = "SELECT * FROM errors ";
$result=mysqli_query($link, $sql10);
$errors=mysqli_num_rows($result);


//Update last activity time in database
$sql100 = "UPDATE users SET ONLINE='".$time."' WHERE USERNAME = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($link, $sql100);
//Check PHP compatibility features, backup and SMS balance details and alert admin
if (version_compare(PHP_VERSION, '5.5.3') >= 0) {$phpv = 0;} else {$phpv = 1;}
if (extension_loaded('mbstring')) {$mbl = 0;} else {$mbl = 1;}
if (extension_loaded('mysqli')) {$mql = 0;} else {$mql = 1;}
if (extension_loaded('gd')) {$gd = 0;} else {$gd = 1;}
if( ini_get('allow_url_fopen') ) {$ulo = 0;} else {$ulo = 1;}
if( ini_get('file_uploads') ) {$fpl = 0;} else {$fpl = 1;}
if($ctime != '') {$cron = 0;} else {$cron = 1;}
$hci = $phpv+$mbl+$mql+$ulo+$fpl+$gd+$cron;
if ($hci == 0) {$ha = 0;} else {$ha = 1;}

if(file_exists('backup/backup.php')) {include "backup/backup.php";} else {$btime = "1496473892";}
if($mnotifykey != ""){$burl = "https://apps.mnotify.net/smsapi/balance?key=".$mnotifykey."";
$smsbalance = file_get_contents($burl);} else {$smsbalance = 0;}
$dr = time() - $btime;
$lbu = round($dr / 86400 );

if (version_compare($version, $uversion) >= 0) {$va = 0;} else {$va = 1;}
if ($smsbalance > 0){$sa = 0;} else if($mnotifykey == '') {$sa = 0;} else {$sa = 1;}
if ($bfreq > $lbu) {$ba = 0;} else {$ba = 1;}
$alerts = $ha+$va+$sa+$ba;
//Set Page menu active styles
$active1 = "";
$active2 = "";
$active3 = "";
$active4 = "";
$active5 = "";
$active6 = "";
$active7 = "";
$active8 = "";
$active9 = "";
$active10 = "";
$active11 = "";
$active12 = "";
$active13 = "";
$active14 = "";
$active15 = "";
//Define Pages
if(empty($_GET['show']))
{
include("dashboard.php");
$active1 = "active";
}
else
if($_GET['show'] == 'users')
{
include("users.php");
$active2 = "active";
}
else
if($_GET['show'] == 'user')
{
include("euser.php");
$active2 = "active";
}
else
if($_GET['show'] == 'tickets')
{
include("alltickets.php");
$active3 = "active";
}
else
if($_GET['show'] == 'reply')
{
include("reply.php");
$active3 = "active";
}
else
if($_GET['show'] == 'req')
{
include("requests.php");
$active4 = "active";
}
else
if($_GET['show'] == 'proccess')
{
include("process.php");
$active4 = "active";
}
else
if($_GET['show'] == 'comm')
{
include("comm.php");
$active5 = "active";
}
else
if($_GET['show'] == 'map')
{
include("map.php");
$active6 = "active";
}
else
if($_GET['show'] == 'tools')
{
include("tools.php");
$active7 = "active";
}
else
if($_GET['show'] == 'email')
{
include("email.php");
$active8 = "active";
}
else
if($_GET['show'] == 'robot')
{
include("msghistory.php");
$active8 = "active";
}
else
if($_GET['show'] == 'sms')
{
include("sms.php");
$active9 = "active";
}
else
if($_GET['show'] == 'errors')
{
include("errors.php");
$active10 = "active";
}
else
if($_GET['show'] == 'settings')
{
include("settings.php");
$active11 = "active";
}
else
if($_GET['show'] == 'health')
{
include("diagnostics.php");
$active12 = "active";
}
else
if($_GET['show'] == 'adv')
{
include("advanced.php");
$active12 = "active";
}
else
if($_GET['show'] == 'update')
{
include("updater.php");
$active13 = "active";
}
else
if($_GET['show'] == 'templates')
{
include("templates.php");
$active14 = "active";
}
else
if($_GET['show'] == 'crtemp')
{
include("crtemp.php");
$active14 = "active";
}
else
if($_GET['show'] == 'editemp')
{
include("editemp.php");
$active14 = "active";
}
else
if($_GET['show'] == 'domains')
{
include("domains.php");
$active15 = "active";
}
else
{
include("pnf.php");
}
//Online Indicator
    $time = time();
    $t1 = $time;
    $t2 = $online;
    $last = ($t1 - $t2);
?><!doctype html><html><head><meta charset="utf-8"><title></title><meta name="robots" content="noindex, nofollow"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="font-awesome.min.css" rel="stylesheet"><link href="admin.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script><script>
$1=jQuery.noConflict(true);</script><link rel="stylesheet" href="richtext/richtext.min.css"><script src="richtext/jquery.richtext.js"></script></head><body><div id="container"><!-- fixed sidebar --><div id="sidebar"><div class="sidenav"><center><span style="color:#1E90FF;font-family:Arial;font-size:20px;"><?php echo $lang['navigation'];?></span></center><br><a class="<?php echo $active1; ?>" href="./admin.php"><div class="fa fa-tachometer"></div> <?php echo $lang['dashboard'];?></a><a class="<?php echo $active2; ?>" href="./admin.php?show=users"><div class="fa fa-users"></div> <?php echo $lang['affiliates'];?>	<?php if($nusers>0) echo "<cr style=\"margin-right: 30px; float: right;\">" . $nusers . " NEW</cr>"; ?></a><a class="<?php echo $active3; ?>" href="./admin.php?show=tickets"><div class="fa fa-comments-o"></div> <?php echo $lang['tickmess'];?> <?php if($msg>0) echo "<cl style=\"margin-right: 30px; float: right;\">" . $msg . " NEW</cl>"; ?></a><a class="<?php echo $active4; ?>" href="./admin.php?show=req"><div class="fa fa-paypal"></div> <?php echo $lang['req'];?> <?php if($nreq>0) echo "<cr style=\"margin-right: 30px; float: right;\">" . $nreq . " NEW</cr>"; ?></a><a class="<?php echo $active5; ?>" href="./admin.php?show=comm"><div class="fa fa-shopping-cart"></div> <?php echo $lang['commissions'];?></a><hr><a class="<?php echo $active15; ?>" href="./admin.php?show=domains"><div class="fa fa-globe"></div> <?php echo $lang['afdom'];?></a><a class="<?php echo $active7; ?>" href="./admin.php?show=tools"><div class="fa fa-link"></div> <?php echo $lang['mktools'];?></a><a class="<?php echo $active6; ?>" href="./admin.php?show=map"><div class="fa fa-map-marker"></div> <?php echo $lang['affmap'];?></a><a class="<?php echo $active8; ?>" href="./admin.php?show=email"><div class="fa fa-envelope"></div> <?php echo $lang['news'];?></a><a class="<?php echo $active9; ?>" href="./admin.php?show=sms"><div class="fa fa-envelope-o"></div> <?php echo $lang['bcsms'];?></a><hr><a class="<?php echo $active14; ?>" href="./admin.php?show=templates"><div class="fa fa-envelope-square"></div> <?php echo $lang['etemplates'];?></a><a class="<?php echo $active10; ?>" href="./admin.php?show=errors"><div class="fa fa-exclamation-triangle"></div> <?php echo $lang['errlog'];?></a><a class="<?php echo $active11; ?>" href="./admin.php?show=settings"><div class="fa fa-gear fa-spin"></div> <?php echo $lang['apset'];?></a><a class="<?php echo $active12; ?>" href="./admin.php?show=health"><div class="fa fa-thermometer-half"></div> <?php echo $lang['health'];?></a><a class="<?php echo $active13; ?>" href="./admin.php?show=update"><div class="fa fa-code"></div> <?php echo $lang['updater'];?> <?php if (version_compare($version, $uversion) < 0) echo "<cr style=\"margin-right: 30px; float: right;\"> NEW</cr>"; ?></a><hr><a href="./user.php"><div class="fa fa-user"></div> <?php echo $lang['swuser'];?></a><a href="./user.php?action=logout"><div class="fa fa-sign-out"></div> <?php echo $lang['logout'];?></a><br><br><span style="color:#6D7192;font-family:Arial;font-size:12px;"><center><?php echo "Copyright © 2018 - " .$year ."<br>
  PTS Technologies, All<br>
  Rights Reserved."; ?></center></span><br><br><br><br><br></div></div></div><div id="PageHeader1"><div id="PageHeader1_Container"><div id="wb_helpicon"><a href="https://support.powerstonegh.com/affme.php" rel="nofollow" target="_blank" title="Get Help!"><div id="helpicon"><i class="fa fa-question-circle-o"></i></div></a></div><div id="wb_infoicon"><con class="cicon"><div id="infoicon" title="You have <?php  echo $alerts; ?> alert(s)"><i class="fa fa-exclamation-circle"></i></div></con><div id="popup" class="popup"><span class="popuptext" id="myPopup"><strong><span style="font-size:14px;"><?php if($alerts>0) {echo "You Have " . $alerts . " Issue(s) To Resolve Quick!";} else { echo "Your App Is Running Smoothly!";} ?></span></strong><br><?php
if($mnotifykey == ''){$sclass = "inactive";} else {$sclass = "";}
//Use variables defined to create table and indicate alerts where neccessary
echo "<table class=\"notes\">";
if (version_compare($version, $uversion) >= 0) { echo " <tr><th><img src='images/check.png'></th>" . "<th><a href='./admin.php?show=update'>" . "<span style=\"color:#87CEFA;font-size:13px;\">Affiliate Me is Up To Date!</span><br>" . "<span style=\"color:#FFFFFF;font-family:Tahoma;font-size:12px;\">You are using the latest version of Affiliate Me, which is version ".$version."</span></a></th></tr>";} else {echo "<tr><td><img src='images/alert.png'></td>" . "<td><a href='./admin.php?show=update'>" . "<span style=\"color:#FF1493; font-size:13px;\"><strong>Software Update Required!</strong></span><br>" . "<span style=\"color:#FFFFFF;font-family:Tahoma;font-size:12px;\">There is a new version of Affiliate Me available, which is version ".$uversion.", download from your account and update now!</span>" . "</a></td></tr>";}
if ($smsbalance > 0) { echo "<tr><th><img src='images/check.png'></th>" . "<th><a href='https://apps.mnotify.net' target='_blank'>" . "<span style=\"color:#87CEFA; font-size:13px;\">SMS Balance!</span><br>" . "<span style=\"color:#FFFFFF;font-family:Tahoma;font-size:12px;\">" . $smsbalance . " SMS Remaining</span></a></th></tr>";} else {echo "<tr class='".$sclass."'><td><img src='images/alert.png'></td>" . "<td><a href='https://apps.mnotify.net' target='_blank'>" . "<span style=\"color:#FF1493; font-size:13px;\"><strong>SMS Balance is Low!</strong></span><br>" . "<span style=\"color:#FFFFFF;font-family:Tahoma;font-size:12px;\">You are either low on SMS or you have not yet started using SMS alert, you can click here to start and top up now!</span>" . "</a></td></tr>";}
if ($bfreq > $lbu) { echo "<tr><th><img src='images/check.png'></th>" . "<th><a href='./admin.php?show=health'>" . "<span style=\"color:#87CEFA; font-size:13px;\">Backup Done!</span><br>" . "<span style=\"color:#FFFFFF;font-family:Tahoma;font-size:12px;\">You did your last database backup ".timeAgo($btime)."!</span></a></th></tr>";} else {echo "<tr><td><img src='images/alert.png'></td>" . "<td><a href='./admin.php?show=health'>" . "<span style=\"color:#FF1493; font-size:13px;\"><strong>Database Backup Required!</strong></span><br>" . "<span style=\"color:#FFFFFF;font-family:Tahoma;font-size:12px;\">You did your last database backup ".timeAgo($btime)." You have to backup now!!!</span>" . "</a></td></tr>";}
if ($hci == 0) { echo "<tr><th><img src='images/check.png'></th>" . "<th><a href='./admin.php?show=health'>" . "<span style=\"color:#87CEFA; font-size:13px;\">PHP Requirements Are Met!</span><br>" . "<span style=\"color:#FFFFFF;font-family:Tahoma;font-size:12px;\">Self diagnostics shows that your App should run smoothly with no issues!</span></a></th></tr>";} else {echo "<tr><td><img src='images/alert.png'></td>" . "<td><a href='./admin.php?show=health'>" . "<span style=\"color:#FF1493;\"><strong>Health Center Attention Required!</strong></span><br>" . "<span style=\"color:#FFFFFF;font-family:Tahoma;font-size:12px;\">Yor application may not function well, you are currently having ".$hci." PHP issue(s), kindly check the Health Center for details!!!</span>" . "</a></td></tr>";}
echo "</table>";
?></span></div><script>
$1("con.cicon").click(function(){if($1("div#popup:first").is(":hidden")){$1("div#popup").fadeIn("slow");}
else{$1("div#popup").fadeOut("slow");}});var box=$1('#popup');var login=$1('.cicon');login.click(function(){box.show();return false;});$1(document).click(function(){box.hide();});box.click(function(e){e.stopPropagation();});</script></div><div id="wb_Image1"><a href="./admin.php"><img src="images/affiliate_me.png" id="Image1" alt=""></a></div><div id="infobar"><span style="color:#A9A9A9;font-family:Arial;font-size:20px;">Administrator Control Panel   </span><span style="color:#00BFFF;font-family:Arial;font-size:13px;">Affiliate Me Ver <?php echo $version; ?></span></div><div id="avatarmenu"><div class="dropdown"><div class="pr"><img style="vertical-align:middle" src="avatars/<?php echo $avatar; ?>" onerror="this.src='images/defavat.png';" border="2">&nbsp;<div style="font-size:14px;" class="fa fa-sort-desc"></div></div><div class="dropdown-content"><br><a href="./user.php"><span style="color:#FFFFFF;font-family:Arial;font-size:17px;"><div class="fa fa-user"></div>&nbsp;<?php echo $lang['swuser'];?></span></a><a href="./admin.php?show=settings"><span style="color:#FFFFFF;font-family:Arial;font-size:17px;"><div class="fa fa-gear fa-spin"></div>&nbsp;<?php echo $lang['apset'];?></span></a><hr><a href="./user.php?action=logout"><span style="color:#FF4500;font-family:Arial;font-size:17px;"><div class="fa fa-sign-out"></div>&nbsp;<?php echo strtoupper($lang['logout']);?></span></a></div></div></div><div id="online"><?php if($last < '406') {echo "<span class=\"pulse\"></span>" ;} else {echo "<span class=\"offline\"></span>" ;} ?></div><div id="online2"><?php if($last < '406') {echo "<strong><span style=\"color:#32CD32; font-size:15px;\">Online</span></strong>" ;} else {echo "<strong><span style=\"color:#696969; font-size:15px;\">Offline</span></strong>" ;} ?></div><div id="notes"><?php if($alerts>0) echo "<cr>" . $alerts . "</cr>"; ?></div><div id="mmenu"><script src="wb.panel.min.js"></script><script>
$(document).ready(function()
{$("#PanelMenu1").panel({animate:true,animationDuration:200,animationEasing:'linear',dismissible:true,display:'overlay',position:'left',toggle:true});$("#PanelMenu1_markup ul li a").click(function(event)
{$.panel.hide($("#PanelMenu1_panel"));});});</script><div id="wb_PanelMenu1"><a href="#PanelMenu1_markup" id="PanelMenu1">
<span class="line"></span>
<span class="line"></span>
<span class="line"></span>
</a><div id="PanelMenu1_markup"><div id="PanelMenu1-logo"><img alt="" src="avatars/<?php echo $avatar; ?>" onerror="this.src='images/defavat.png';"></div><ul role="menu"><li class="divider" role="separator"></li><li role="menuitem"><a href="./admin.php"><i class="fa fa-tachometer fa-fw"></i><span><?php echo $lang['dashboard'];?></span></a></li><li role="menuitem"><a href="./admin.php?show=users"><i class="fa fa-users fa-fw"></i><span><?php echo $lang['affiliates'];?>&nbsp;<?php if($nusers>0) echo "<cr>" . $nusers . " NEW</cr>"; ?></span></a></li><li role="menuitem"><a href="./admin.php?show=tickets"><i class="fa fa-cube fa-fw"></i><span><?php echo $lang['tickmess'];?>&nbsp;<?php if($msg>0) echo "<cl>" . $msg . " NEW</cl>"; ?></span></a></li><li role="menuitem"><a href="./admin.php?show=req"><i class="fa fa-paypal fa-fw"></i><span><?php echo $lang['req'];?>&nbsp;<?php if($nreq>0) echo "<cr>" . $nreq . " NEW</cr>"; ?></span></a></li><li role="menuitem"><a href="./admin.php?show=comm"><i class="fa fa-money fa-fw"></i><span><?php echo $lang['commissions'];?></span></a></li><li class="divider" role="separator"></li><li role="menuitem"><a href="./admin.php?show=map"><i class="fa fa-globe fa-fw"></i><span><?php echo $lang['afdom'];?></span></a></li><li role="menuitem"><a href="./admin.php?show=map"><i class="fa fa-map fa-fw"></i><span><?php echo $lang['affmap'];?></span></a></li><li role="menuitem"><a href="./admin.php?show=tools"><i class="fa fa-link fa-fw"></i><span><?php echo $lang['mktools'];?></span></a></li><li role="menuitem"><a href="./admin.php?show=email"><i class="fa fa-envelope fa-fw"></i><span><?php echo $lang['news'];?></span></a></li><li role="menuitem"><a href="./admin.php?show=sms"><i class="fa fa-envelope-o fa-fw"></i><span><?php echo $lang['bcsms'];?></span></a></li><li class="divider" role="separator"></li><li role="menuitem"><a href="./admin.php?show=settings"><i class="fa fa-envelope-square fa-fw"></i><span><?php echo $lang['etemplates'];?></span></a></li><li role="menuitem"><a href="./admin.php?show=settings"><i class="fa fa-gear fa-fw"></i><span><?php echo $lang['apset'];?></span></a></li><li role="menuitem"><a href="./admin.php?show=health"><i class="fa fa-thermometer-half fa-fw"></i><span><?php echo $lang['health'];?></span></a></li><li role="menuitem"><a href="./admin.php?show=update"><i class="fa fa-code fa-fw"></i><span><?php echo $lang['updater'];?></span></a></li><li class="divider" role="separator"></li><li role="menuitem"><a href="./user.php"><i class="fa fa-user fa-fw"></i><span><?php echo $lang['swuser'];?></span></a></li><li role="menuitem"><a href="./user.php?action=logout"><i class="fa fa-sign-out fa-fw"></i><span><?php echo $lang['logout'];?></span></a></li></ul></div></div></div></div></div></body></html><?php
ob_end_flush();
?>