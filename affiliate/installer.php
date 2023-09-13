<?php if(file_exists('db.php')) {header('Location: /index.php'); exit;} ?><?php
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
$error_message = '';
$sucm = '';
$password = '';
$fullname = '';
$email = '';
$dbdatabase = '';
$dbusername = '';
$dbpassword = '';
include "version.php";
$domain = $_SERVER['HTTP_HOST'];
/*Get user ip address*/
$ip_address=$_SERVER['REMOTE_ADDR'];
 
/*Get user ip address details with geoplugin.net*/
$geopluginURL='http://www.geoplugin.net/php.gp?ip='.$ip_address;
$addrDetailsArr = unserialize(file_get_contents($geopluginURL));
 
/*Get City name by return array*/
$city = $addrDetailsArr['geoplugin_city'];
 
/*Get Country name by return array*/
$country = $addrDetailsArr['geoplugin_countryName'];
 
/*Comment out these line to see all the posible details*/
/*echo '<pre>';
print_r($addrDetailsArr);
die();*/
 
if(!$city){
   $city='Not Define';
}if(!$country){
   $country='Please select Country!';
}
$mip = $ip_address;
$cdc = "https://ipapi.co/".$mip."/country_calling_code";
$ccode = file_get_contents($cdc);

//Define the database config and system settings variables
$maxses = ini_get("session.gc_maxlifetime");
$folder = dirname(__FILE__);
if(!shell_exec("cut -d. -f1 /proc/uptime") || !exec("uptime")){ $cronco = "Funtion shell_exec() and/or exec() seems to be disabled on the server due to security reasons, please contact your host to enable it so that Affiliate Me can automatically set up cron job, but if your host refuses to enable this function for you, then you will have to set up cron job manually using the command:<br> <code><q>*/5 * * * * /usr/local/bin/php '.$folder.'/am-cron.php >/dev/null 2>&1</q></code> <br>, note that Affiliate Me needs cron job to perform automations and without it some features may not work, thanks!"; } else {$cronco = "";}
if(!empty($_POST)){
   $dbserver = $_POST['server'];
   $dbdatabase = $_POST['database'];
   $dbusername = $_POST['dbuser'];
   $dbpassword = $_POST['dbpass'];

$link = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbdatabase);
    if($link === false){
$error_message = "Oops, Could not connect to database . " . mysqli_connect_error(); }
   else{
   $username = $_POST['username'];
   $email = mysqli_real_escape_string($link, $_POST['email']);
   $password = mysqli_real_escape_string($link, $_POST['password']);
   $fullname = mysqli_real_escape_string($link, $_POST['fullname']);
   $phone = mysqli_real_escape_string($link, $_POST['phone']);
   $country = $_POST['country'];
   $avatar = $_POST['avatar'];
   $credit = $_POST['credit']; 
//Validate the submitted inputs
   if (!preg_match("/^[A-Za-z0-9_!@$]{1,50}$/", $username))
   {
      $error_message = 'Username is not valid, please check and try again!';
   }
   else
   if (!preg_match("/^[A-Za-z0-9_&}{!@.#^%*?$]{1,50}$/", $password))
   {
      $error_message = 'Invalid password, password space is either empty or you used unsupported special 
characters, try again!';
   }
   else
   if (!preg_match("/^[A-Za-z0-9_!@$.' &]{1,50}$/", $fullname))
   {
      $error_message = 'Fullname is not valid, please check and try again!';
   }
   else
   if (!preg_match("/^.+@.+\..+$/", $email))
   {
      $error_message = 'Email is not a valid email address. Please check and try again.';
   }
   else
   if (strlen($phone) == 0)
   {
      $error_message = 'Please enter your phone number with country code';
   }
   else
   if ($phone == '+233')
   {
      $error_message = 'Please enter your valid phone number starting with country code!';
   } }
// if no errors are detected, create mysql tables for the app
if (empty($error_message)){
$sql1 = "CREATE TABLE `users` (
  `ID` int(9) NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(50) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `PASSWORD` varchar(150) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `PHONE` varchar(75) NOT NULL,
  `COUNTRY` varchar(75) NOT NULL,
  `PAYPAL` varchar(100) NOT NULL,
  `AVATAR` varchar(200) NOT NULL,
  `CREDIT` varchar(60) NOT NULL,
  `ACESS` varchar(50) NOT NULL,
  `ONLINE` varchar(75) NOT NULL,
  `DATE` varchar(75) NOT NULL,
  `LMS` varchar(75) NOT NULL,
  `WEBSITE` varchar(255) NOT NULL,
  `MOMO` varchar(255) NOT NULL,
  `CHEQUE` varchar(1255) NOT NULL,
  `DFA` varchar(50) NOT NULL,
  `BANK` varchar(5000) NOT NULL,
  `RKEY` varchar(500) NOT NULL,
  
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 ";
 $result = mysqli_query($link, $sql1);
$sql2 = "CREATE TABLE `tickets` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `name` varchar(75) NOT NULL,
  `userid` varchar(50) NOT NULL,
  `email` varchar(75) NOT NULL,
  `tid` varchar(75) NOT NULL,
  `subject` varchar(75) NOT NULL,
  `status` varchar(50) NOT NULL,
  `status1` varchar(50) NOT NULL,
  `message` varchar(60000) NOT NULL,
  `time` varchar(50) NOT NULL,
  `divs` varchar(75) NOT NULL,
  `class` varchar(75) NOT NULL,
  `times` varchar(75) NOT NULL,
  `file` varchar(100) NOT NULL,
  `trash` tinyint(1) NOT NULL,
  
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 ";
 $result = mysqli_query($link, $sql2);

$sql3 = "CREATE TABLE `ref` (
  `ID` int(9) NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(50) NOT NULL,
  `TRN` varchar(100) NOT NULL,
  `COMM` varchar(150) NOT NULL,
  `VCOMM` varchar(100) NOT NULL,
  `DATE` varchar(75) NOT NULL,
  `VDATE` varchar(75) NOT NULL,
  `CITY` varchar(255) NOT NULL,
  `REGION` varchar(255) NOT NULL,
  `COUNTRY` varchar(255) NOT NULL,
  `IP` varchar(255) NOT NULL,
  `OS` varchar(255) NOT NULL,
  `TIME` varchar(255) NOT NULL,
  `BROWSER` varchar(255) NOT NULL,
  `FLAG` varchar(255) NOT NULL,
  `OSLOGO` varchar(255) NOT NULL,
  `BROLOGO` varchar(255) NOT NULL,
  `REFER` varchar(255) NOT NULL,
  `SALE` varchar(5) NOT NULL,
  `CPC` varchar(100) NOT NULL,
  `URL` varchar(500) NOT NULL,
  `OID` varchar(100) NOT NULL,
  
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 ";
 $result = mysqli_query($link, $sql3);

$sql4 = "CREATE TABLE `notes` (
  `ID` int(9) NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(50) NOT NULL,
  `MESSAGE` varchar(100) NOT NULL,
  `STATUS` varchar(150) NOT NULL,
  `DATE` varchar(100) NOT NULL,
  `ICON` varchar(75) NOT NULL,
  `LINK` varchar(75) NOT NULL,
  
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 ";
 $result = mysqli_query($link, $sql4);

$sql5 = "CREATE TABLE `withdrawals` (
  `ID` int(9) NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(50) NOT NULL,
  `TRID` varchar(100) NOT NULL,
  `AMT` varchar(150) NOT NULL,
  `PAYPAL` varchar(100) NOT NULL,
  `STATUS` varchar(75) NOT NULL,
  `DATE` varchar(75) NOT NULL,
  `CHEQUE` varchar(1255) NOT NULL,
  `MOMO` varchar(255) NOT NULL,
  `METHOD` varchar(255) NOT NULL,
  
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 ";
 $result = mysqli_query($link, $sql5);

$sql6 = "CREATE TABLE `emails` (
  `ID` int(9) NOT NULL AUTO_INCREMENT,
  `SUBJECT` varchar(75) NOT NULL,
  `MESSAGE` varchar(60000) NOT NULL,
  `DATE` varchar(100) NOT NULL,
  `RENUM` varchar(75) NOT NULL,
  `STATUS` varchar(100) NOT NULL,
  
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 ";
 $result = mysqli_query($link, $sql6);

$sql7 = "CREATE TABLE `errors` (
  `ID` int(9) NOT NULL AUTO_INCREMENT,
  `TYPE` varchar(50) NOT NULL,
  `DATE` varchar(100) NOT NULL,
  `TIME` varchar(150) NOT NULL,
  `URL` varchar(100) NOT NULL,
  
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 ";
 $result = mysqli_query($link, $sql7);
$sql8 = "CREATE TABLE `login` (
  `ID` int(9) NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(50) NOT NULL,
  `CITY` varchar(100) NOT NULL,
  `COUNTRY` varchar(150) NOT NULL,
  `IP` varchar(100) NOT NULL,
  `OS` varchar(255) NOT NULL,
  `DATE` varchar(75) NOT NULL,
  `TIME` varchar(75) NOT NULL,
  `BROWSER` varchar(255) NOT NULL,
  `FLAG` varchar(255) NOT NULL,
  `OSLOGO` varchar(255) NOT NULL,
  `BROLOGO` varchar(255) NOT NULL,
  `BROWID` varchar(50) NOT NULL,
  
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 ";
 $result = mysqli_query($link, $sql8);
$sql9 = "CREATE TABLE `banners` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `alte` varchar(100) NOT NULL,
  `banner` varchar(575) NOT NULL,
  `width` varchar(50) NOT NULL,
  `height` varchar(75) NOT NULL,
  `URL` varchar(9000) NOT NULL,
  
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 ";
 $result = mysqli_query($link, $sql9);

$sql10 = "CREATE TABLE `etemplates` (
  `ID` int(9) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(150) NOT NULL,
  `TYPE` varchar(100) NOT NULL,
  `MESSAGE` varchar(9550) NOT NULL,
  
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 ";
 $result = mysqli_query($link, $sql10);

$sql11 = "CREATE TABLE `domains` (
  `ID` int(9) NOT NULL AUTO_INCREMENT,
  `DOMAIN` varchar(250) NOT NULL,
  
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 ";
 $result = mysqli_query($link, $sql11);

//now add the super admin's details to the user database
$cpass = password_hash($password, PASSWORD_BCRYPT);
$mysql_table = "users";
$sql = "INSERT INTO $mysql_table (`USERNAME`, `EMAIL`, `PASSWORD`, `NAME`, `PHONE`, `COUNTRY`, `PAYPAL`, `AVATAR`, `CREDIT`, `ACESS`, `ONLINE`, `DATE`, `LMS`, `WEBSITE`, `MOMO`, `CHEQUE`, `DFA`, `BANK`, `RKEY`) VALUES ('$username', '$email', '$cpass','$fullname','$phone','$country','','$avatar','$credit','superadmin','$time','$time','$time','$domain','','','','','')";
$result = mysqli_query($link, $sql);

//now create and write the system congigurarions to the db.php file for the app to use and echo app successfully installed
$config = './db.php';
$file = fopen($config, 'a');
      fwrite($file, '<?php');
      fwrite($file, "\r\n");
      fwrite($file, '$dbserver');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $dbserver);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$dbdatabase');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $dbdatabase);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$dbusername');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $dbusername);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$dbpassword');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $dbpassword);
      fwrite($file, '";');
      fwrite($file, "\r\n");

      fwrite($file, "\r\n");
      fwrite($file, '$logo');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'images/aflogo.png');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$favicon');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'images/dfavicon.png');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$sitename');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'Affiliate Me');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$locale');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'en-us');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$domain');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $domain);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$prot');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'http://');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$currsym');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, '$');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$bankpay');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, '');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$acheque');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, '');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$trprefix');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'AM');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$mincash');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, '2');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$comm');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, '0.2');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$vd');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, '14');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$red');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'https://www.powerstonegh.com');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$perc');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'on');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$cpc');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'on');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$cpcv');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, '0.001');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$mnotifykey');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, '');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$smsid');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'Aff Me');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$phone');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $phone);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$smswithdrawal');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, '');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$smsticket');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, '');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$fb');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'https://www.facebook.com/powerstonegh');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$tt');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'https://www.twitter.com/powerstonegh');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$smtpmail');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, '');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$mailhost');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'mail.example.com');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$musername');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'email@email.com');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$mpassword');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'email_password');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$mport');
      fwrite($file, ' = ');
      fwrite($file, '465');
      fwrite($file, ';');
      fwrite($file, "\r\n");
      fwrite($file, '$mailimit');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, '50');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$semail');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'support@yourdomain.com');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$signupet');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'Signup');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$titemp');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'Ticket');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$sale');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'Sale');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$affpaid');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'Payout');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$affreject');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'Paycancel');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$passrec');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'Password');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$capcha');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'on');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$tos');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'Coming soon');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$bfreq');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, '3');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$tzone');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $tzone);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$uslk');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, '');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$purl');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, '');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$sessdur');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $maxses);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$sandbox');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, 'on');
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$ganal');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, '');
      fwrite($file, '";');
      fclose($file);

//Create email templates
$passrec = '<table id="backgroundTable" class="bgBody" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
<tr>
<td>
<table class="container" width="620" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td>
<div class="movableContent">
</div><table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
</tr></tbody></table><table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
</tr>
<tr>
<td width="200" valign="top">&nbsp;</td>
<td width="200" valign="top" align="center">
<div class="contentEditableContainer contentImageEditable">
<div class="contentEditable" align="center"><img src="https://demo.powerstonegh.com/affme/images/logo.png" alt="Logo" style="cursor: default;" width="155" height="155"></div>
</div>
</td>
<td width="200" valign="top">&nbsp;</td>
</tr>
<tr>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
</tr>
</tbody>
</table>

<h2 align="center">New Password<br></h2><table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody><tr>
<td width="400" align="center">
<div class="contentEditableContainer contentTextEditable">
<div class="contentEditable" align="left">
<font color="#000000"><span style="font-size:16px;">Hi {{ fullname }},<br>
<br>
You just entered your email to reset your password, please click the button below to change your password, but if you did not trigger this action then please ignore this email, thanks.</span></font>
</div>
</div>
</td>
</tr>
</tbody></table>
<table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td width="200">&nbsp;</td>
<td style="padding-top: 25px;" width="200" align="center">
<a href="{{ recover }}" target="_blank" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;">Reset Password</a><table width="200" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>


</tr>
</tbody>
</table>
</td>
<td width="200">&nbsp;</td>
</tr>
</tbody>
</table>
<div class="movableContent">
<table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td style="padding-top: 65px;" colspan="2" width="100%"><hr style="height: 1px; border: none; color: #333; background-color: #ddd;"></td>
</tr>
<tr>
<td style="padding-bottom: 20px;" width="60%" valign="middle" height="70">
<div class="contentEditableContainer contentTextEditable">
<div class="contentEditable" align="left"><span style="font-size: 13px; color: #181818; font-family: Helvetica, Arial, sans-serif; line-height: 200%;">PTS Technologies, Ghana</span> <span style="font-size: 13px; color: #181818; font-family: Helvetica, Arial, sans-serif; line-height: 200%;"></span><br> <span style="font-size: 13px; color: #181818; font-family: Helvetica, Arial, sans-serif; line-height: 200%;"> <a style="text-decoration: none; color: #555;" href="./#NOP">You are receiving this email because you are a member of Beat Cube<br></a></span></div>
</div>
</td>
<td style="padding-bottom: 20px;" width="40%" valign="top" height="70" align="right">&nbsp;</td>
</tr>
</tbody>
</table>
</div>
</td></tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>';



$signup = '<table id="backgroundTable" class="bgBody" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
<tr>
<td>
<div class="movableContent">
</div><table class="container" width="620" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
</tr></tbody></table><table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
</tr></tbody></table><table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
</tr>
<tr>
<td width="200" valign="top">&nbsp;</td>
<td width="200" valign="top" align="center">
<div class="contentEditableContainer contentImageEditable">
<div class="contentEditable" align="center"><img src="https://demo.powerstonegh.com/affme/images/logo.png" alt="Logo" style="cursor: default;" width="155" height="155"></div>
</div>
</td>
<td width="200" valign="top">&nbsp;</td>
</tr>
<tr>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
</tr>
</tbody>
</table>

<h2 align="center">New Account<br></h2><table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody><tr>
<td width="400" align="center">
<div class="contentEditableContainer contentTextEditable">
<div class="contentEditable" align="left">
<font color="#000000"><span style="font-size:16px;">Hi {{ fullname }},<br>
<br>
You are welcome to {{ sitename }}, this is an automated email to confirm to you that your account was successfully created, your login details are below.</span></font></div><div class="contentEditable" align="left"><b><font color="#000000"><span style="font-size:16px;">Username: {{ username }}</span></font></b></div><div class="contentEditable" align="left"><b><font color="#000000"><span style="font-size:16px;">Password {{ password }}</span></font></b></div><div class="contentEditable" align="left"><font color="#000000"><span style="font-size:16px;">Please kindly keep your login credentials safe, thanks for choosing us!<br></span></font>
</div>
</div>
</td>
</tr>
</tbody></table>
<table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td width="200">&nbsp;</td>
<td style="padding-top: 25px;" width="200" align="center">
<a href="https://mydomain.com/login.php" target="_blank" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;">Login</a><table width="200" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>


</tr>
</tbody>
</table>
</td>
<td width="200">&nbsp;</td>
</tr>
</tbody>
</table>
<div class="movableContent">
<table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td style="padding-top: 65px;" colspan="2" width="100%"><hr style="height: 1px; border: none; color: #333; background-color: #ddd;"></td>
</tr>
<tr>
<td style="padding-bottom: 20px;" width="60%" valign="middle" height="70">
<div class="contentEditableContainer contentTextEditable">
<div class="contentEditable" align="left"><span style="font-size: 13px; color: #181818; font-family: Helvetica, Arial, sans-serif; line-height: 200%;">PTS Technologies, Ghana</span> <span style="font-size: 13px; color: #181818; font-family: Helvetica, Arial, sans-serif; line-height: 200%;"></span><br> <span style="font-size: 13px; color: #181818; font-family: Helvetica, Arial, sans-serif; line-height: 200%;"> <a style="text-decoration: none; color: #555;" href="./#NOP">You are receiving this email because you are a member of {{ sitename }}<br></a></span></div>
</div>
</td>
<td style="padding-bottom: 20px;" width="40%" valign="top" height="70" align="right">&nbsp;</td>
</tr>
</tbody>
</table>
</div>
</td></tr>
</tbody>
</table>';


$reply ='<div class="movableContent">
</div><table id="backgroundTable" class="bgBody" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>

</tbody></table><table class="container" width="620" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
</tr></tbody></table><table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
</tr></tbody></table><table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
</tr>
<tr>
<td width="200" valign="top">&nbsp;</td>
<td width="200" valign="top" align="center">
<div class="contentEditableContainer contentImageEditable">
<div class="contentEditable" align="center"><img src="https://demo.powerstonegh.com/affme/images/logo.png" alt="Logo" style="cursor: default;" width="155" height="155"></div>
</div>
</td>
<td width="200" valign="top">&nbsp;</td>
</tr>
<tr>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
</tr>
</tbody>
</table>

<h2 align="center">New Message<br></h2><table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody><tr>
<td width="400" align="center">
<div class="contentEditableContainer contentTextEditable">
<div class="contentEditable" align="left">
<font color="#000000"><span style="font-size:16px;">Hi {{ fullname }},<br>
you just received a new message from support on your ticket #{{ ticket }} with subject: {{ subject }},</span></font></div><div class="contentEditable" align="left"><font color="#000000"><span style="font-size:16px;">The message reads:</span></font></div><div class="contentEditable" align="left"><br><font color="#000000"><span style="font-size:16px;"><span style="color:#00CED1;font-family:Arial;font-size:13px;">{{ message }}</span></span></font></div><div class="contentEditable" align="left"><font color="#000000"><span style="font-size:16px;"><span style="color:#00CED1;font-family:Arial;font-size:13px;"><font color="#000000">You can click the button below to login and reply, thanks!</font><br></span></span></font>
</div>
</div>
</td>
</tr>
</tbody></table>
<table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td width="200">&nbsp;</td>
<td style="padding-top: 25px;" width="200" align="center">
<a href="https://mydomain.com/login.php" target="_blank" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;">Login</a><table width="200" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>


</tr>
</tbody>
</table>
</td>
<td width="200">&nbsp;</td>
</tr>
</tbody>
</table>
<div class="movableContent">
<table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td style="padding-top: 65px;" colspan="2" width="100%"><hr style="height: 1px; border: none; color: #333; background-color: #ddd;"></td>
</tr>
<tr>
<td style="padding-bottom: 20px;" width="60%" valign="middle" height="70">
<div class="contentEditableContainer contentTextEditable">
<div class="contentEditable" align="left"><span style="font-size: 13px; color: #181818; font-family: Helvetica, Arial, sans-serif; line-height: 200%;">PTS Technologies, Ghana</span> <span style="font-size: 13px; color: #181818; font-family: Helvetica, Arial, sans-serif; line-height: 200%;"></span><br> <span style="font-size: 13px; color: #181818; font-family: Helvetica, Arial, sans-serif; line-height: 200%;"> <a style="text-decoration: none; color: #555;" href="./#NOP">You are receiving this email because you are a member of {{ sitename }}<br></a></span></div>
</div>
</td>
<td style="padding-bottom: 20px;" width="40%" valign="top" height="70" align="right">&nbsp;</td>
</tr>
</tbody>
</table>
</div>';

$ssale ='<div class="movableContent">
</div><table id="backgroundTable" class="bgBody" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>

</tbody></table><table class="container" width="620" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
</tr></tbody></table><table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
</tr></tbody></table><table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
</tr>
<tr>
<td width="200" valign="top">&nbsp;</td>
<td width="200" valign="top" align="center">
<div class="contentEditableContainer contentImageEditable">
<div class="contentEditable" align="center"><img src="https://demo.powerstonegh.com/affme/images/logo.png" alt="Logo" style="cursor: default;" width="155" height="155"></div>
</div>
</td>
<td width="200" valign="top">&nbsp;</td>
</tr>
<tr>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
</tr>
</tbody>
</table>

<h2 align="center">Account Credited<br></h2><table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody><tr>
<td width="400" align="center">
<div class="contentEditableContainer contentTextEditable">
<div class="contentEditable" align="left">
<font color="#000000"><span style="font-size:16px;">Hi {{ fullname }},</span></font></div><div class="contentEditable" align="left"><font color="#000000"><span style="font-size:16px;">Your account has just been automatically credited with {{ credit }} as a result of a sale generated using your affiliate link, you will have to wait for 14 days after which the funds will be available in your account for withdrawal, you can login using the button below to check the status, thanks<br></span></font></div></div>
</td>
</tr>
</tbody></table>
<table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td width="200">&nbsp;</td>
<td style="padding-top: 25px;" width="200" align="center">
<a href="https://beatcube.powerstonegh.com/login.php" target="_blank" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;">Login</a><table width="200" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>


</tr>
</tbody>
</table>
</td>
<td width="200">&nbsp;</td>
</tr>
</tbody>
</table>
<div class="movableContent">
<table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td style="padding-top: 65px;" colspan="2" width="100%"><hr style="height: 1px; border: none; color: #333; background-color: #ddd;"></td>
</tr>
<tr>
<td style="padding-bottom: 20px;" width="60%" valign="middle" height="70">
<div class="contentEditableContainer contentTextEditable">
<div class="contentEditable" align="left"><span style="font-size: 13px; color: #181818; font-family: Helvetica, Arial, sans-serif; line-height: 200%;">PTS Technologies, Ghana</span> <span style="font-size: 13px; color: #181818; font-family: Helvetica, Arial, sans-serif; line-height: 200%;"></span><br> <span style="font-size: 13px; color: #181818; font-family: Helvetica, Arial, sans-serif; line-height: 200%;"> <a style="text-decoration: none; color: #555;" href="./#NOP">You are receiving this email because you are a member of {{ sitename }}<br></a></span></div>
</div>
</td>
<td style="padding-bottom: 20px;" width="40%" valign="top" height="70" align="right">&nbsp;</td>
</tr>
</tbody>
</table>
</div>';


$payout = '<div class="movableContent">
</div><table id="backgroundTable" class="bgBody" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>

</tbody></table><table class="container" width="620" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
</tr></tbody></table><table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
</tr></tbody></table><table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
</tr>
<tr>
<td width="200" valign="top">&nbsp;</td>
<td width="200" valign="top" align="center">
<div class="contentEditableContainer contentImageEditable">
<div class="contentEditable" align="center"><img src="https://demo.powerstonegh.com/affme/images/logo.png" alt="Logo" style="cursor: default;" width="155" height="155"></div>
</div>
</td>
<td width="200" valign="top">&nbsp;</td>
</tr>
<tr>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
</tr>
</tbody>
</table>

<h2 align="center">Money Issued<br></h2><table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody><tr>
<td width="400" align="center">
<div class="contentEditableContainer contentTextEditable">
<div class="contentEditable" align="left">
<font color="#000000"><span style="font-size:16px;">Hi {{ fullname }},</span></font></div><div class="contentEditable" align="left"><font color="#000000"><span style="font-size:16px;">Your transaction {{ transaction }} has been completed and your money has been issued, check your payment processor or you can contact us if you need any help!<br></span></font></div></div>
</td>
</tr>
</tbody></table>
<table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td width="200">&nbsp;</td>
<td style="padding-top: 25px;" width="200" align="center">
<a href="https://mydomain.com/login.php" target="_blank" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;">Login</a><table width="200" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>


</tr>
</tbody>
</table>
</td>
<td width="200">&nbsp;</td>
</tr>
</tbody>
</table>
<div class="movableContent">
<table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td style="padding-top: 65px;" colspan="2" width="100%"><hr style="height: 1px; border: none; color: #333; background-color: #ddd;"></td>
</tr>
<tr>
<td style="padding-bottom: 20px;" width="60%" valign="middle" height="70">
<div class="contentEditableContainer contentTextEditable">
<div class="contentEditable" align="left"><span style="font-size: 13px; color: #181818; font-family: Helvetica, Arial, sans-serif; line-height: 200%;">PTS Technologies, Ghana</span> <span style="font-size: 13px; color: #181818; font-family: Helvetica, Arial, sans-serif; line-height: 200%;"></span><br> <span style="font-size: 13px; color: #181818; font-family: Helvetica, Arial, sans-serif; line-height: 200%;"> <a style="text-decoration: none; color: #555;" href="./#NOP">You are receiving this email because you are a member of {{ sitename }}<br></a></span></div>
</div>
</td>
<td style="padding-bottom: 20px;" width="40%" valign="top" height="70" align="right">&nbsp;</td>
</tr>
</tbody>
</table>
</div>';

$paycan = '<div class="movableContent">
</div><table id="backgroundTable" class="bgBody" width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>

</tbody></table><table class="container" width="620" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
</tr></tbody></table><table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
</tr></tbody></table><table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
</tr>
<tr>
<td width="200" valign="top">&nbsp;</td>
<td width="200" valign="top" align="center">
<div class="contentEditableContainer contentImageEditable">
<div class="contentEditable" align="center"><img src="https://demo.powerstonegh.com/affme/images/logo.png" alt="Logo" style="cursor: default;" width="155" height="155"></div>
</div>
</td>
<td width="200" valign="top">&nbsp;</td>
</tr>
<tr>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
<td width="200">&nbsp;</td>
</tr>
</tbody>
</table>

<h2 align="center">Payment Cancelled<br></h2><table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody><tr>
<td width="400" align="center">
<div class="contentEditableContainer contentTextEditable">
<div class="contentEditable" align="left">
<font color="#000000"><span style="font-size:16px;">Hi {{ fullname }},</span></font></div><div class="contentEditable" align="left"><font color="#000000"><span style="font-size:16px;">Your transaction ID# {{ transaction }} has been cancelled and your money has been returned to your balance, this is because of a technical issue, please kindly log into your account using the button below and open a ticket on the transaction for details!<br></span></font></div></div>
</td>
</tr>
</tbody></table>
<table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td width="200">&nbsp;</td>
<td style="padding-top: 25px;" width="200" align="center">
<a href="https://mydomain.com/login.php" target="_blank" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;">Login</a><table width="200" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>


</tr>
</tbody>
</table>
</td>
<td width="200">&nbsp;</td>
</tr>
</tbody>
</table>
<div class="movableContent">
<table class="container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
<tbody>
<tr>
<td style="padding-top: 65px;" colspan="2" width="100%"><hr style="height: 1px; border: none; color: #333; background-color: #ddd;"></td>
</tr>
<tr>
<td style="padding-bottom: 20px;" width="60%" valign="middle" height="70">
<div class="contentEditableContainer contentTextEditable">
<div class="contentEditable" align="left"><span style="font-size: 13px; color: #181818; font-family: Helvetica, Arial, sans-serif; line-height: 200%;">PTS Technologies, Ghana</span> <span style="font-size: 13px; color: #181818; font-family: Helvetica, Arial, sans-serif; line-height: 200%;"></span><br> <span style="font-size: 13px; color: #181818; font-family: Helvetica, Arial, sans-serif; line-height: 200%;"> <a style="text-decoration: none; color: #555;" href="./#NOP">You are receiving this email because you are a member of {{ sitename }}<br></a></span></div>
</div>
</td>
<td style="padding-bottom: 20px;" width="40%" valign="top" height="70" align="right">&nbsp;</td>
</tr>
</tbody>
</table>
</div>';

$list = "$passrec|*|$signup|*|$reply|*|$ssale|*|$payout|*|$paycan";
$titles = "Password|*|Signup|*|Ticket|*|Sale|*|Payout|*|Paycancel";
$types = "recovery|*|signup|*|reply|*|sales|*|payout|*|paycancel";

$items = explode('|*|',$list);
$itles = explode('|*|',$titles);
$typs = explode('|*|',$types);
foreach($items as $indx => $value) {
$message = $items[$indx];
$nam = $itles[$indx];
$typ = $typs[$indx];
$mysql_table= "etemplates";
$sql55 = "INSERT INTO $mysql_table (`NAME`, `TYPE`, `MESSAGE`) VALUES ('$nam', '$typ', '$message')";
$result = mysqli_query($link, $sql55);
}
mysqli_close($link);

//set up cron
if(shell_exec("cut -d. -f1 /proc/uptime") && exec("uptime")){
$output = shell_exec('crontab -l');
file_put_contents('/tmp/crontab.txt', $output.'*/5 * * * * /usr/local/bin/php '.$folder.'/am-cron.php >/dev/null 2>&1'.PHP_EOL);
exec('crontab /tmp/crontab.txt'); }
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
$vf = 'cversion.php';
$file = fopen($vf, 'w');
      fwrite($file, '<?php');
      fwrite($file, "\r\n");
      fwrite($file, '$cversion');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $version);
      fwrite($file, '";');
      fclose($file);
$sucm = 'Yay! Affiliate Me is successfully installed, taking you to the login page...';
   }
}
?><!doctype html><html><head><meta charset="utf-8"><title>Install Affiliate Me</title><meta name="robots" content="noindex, nofollow"><meta name="generator" content="Powerstone"><link href="font-awesome.min.css" rel="stylesheet"><link href="installer.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script><script src="transition.min.js"></script><script src="modal.min.js"></script><script src="wwb14.min.js"></script></head><body><div id="container"><div id="Html1" style="position:absolute;left:203px;top:5px;width:565px;height:50px;z-index:31"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:16px;\"><center><i class=\"fa fa-check-circle-o\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
echo "<script type=\"text/javascript\">
var wait=setTimeout(\"location.href='index.php';\",7000);</script>";
}
?><?php
if($error_message !='') {
echo "<div class=\"alert2\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:14px;\"><center><i class=\"fa fa-info-circle\">&nbsp;</i><strong>" . $error_message . "</strong></center></div></div>";
}
?></div><div id="wb_Image1" style="position:absolute;left:420px;top:64px;width:130px;height:89px;z-index:32;"><a href="/"><img src="images/affiliate_me.png" id="Image1" alt=""></a></div><div id="wb_Text1" style="position:absolute;left:265px;top:153px;width:440px;height:38px;text-align:center;z-index:33;"><span style="color:#1E90FF;font-family:Arial;font-size:16px;"><strong>Welcome to Affiliate Me installer wizard, please fill in the fields below to install your software!</strong></span></div><!-- view pass --><div id="Html15" style="position:absolute;left:32px;top:419px;width:100px;height:105px;z-index:34"><script>
function myFunction1(){var x=document.getElementById("dbpass");if(x.type==="password"){x.type="text";}else{x.type="password";}}</script><script>
function myFunction2(){var x=document.getElementById("password");if(x.type==="password"){x.type="text";}else{x.type="password";}}</script></div><div id="wb_Form1" style="position:absolute;left:208px;top:203px;width:553px;height:920px;z-index:35;"><form name="signupform" method="post" action="./index.php" id="Form1" onsubmit="ShowObject('Html5', 1);ShowObject('Html4', 0);document.getElementById('Form1').submit();return false;"><input type="hidden" name="avatar" value=""><input type="hidden" name="credit" value="0"><input type="password" id="password" style="position:absolute;left:52px;top:636px;width:363px;height:22px;z-index:0;" name="password" value="<?php echo $password; ?>" tabindex="7" spellcheck="false" placeholder="Password" onkeyup="passwordStrength(this.value)"><input type="text" id="fullname" style="position:absolute;left:52px;top:592px;width:399px;height:22px;z-index:1;" name="fullname" value="<?php echo $fullname; ?>" tabindex="6" spellcheck="false" placeholder="Your full Name"><input type="text" id="username" style="position:absolute;left:51px;top:548px;width:400px;height:22px;z-index:2;" name="username" value="admin" tabindex="5" readonly autocomplete="off" spellcheck="false" placeholder="admin"><input type="email" id="email" style="position:absolute;left:52px;top:681px;width:400px;height:22px;z-index:3;" name="email" value="<?php echo $email; ?>" tabindex="8" spellcheck="false" placeholder="Valid Email"><select name="country" size="1" id="country" style="position:absolute;left:52px;top:770px;width:446px;height:32px;z-index:4;" tabindex="10"><option selected value="<?php echo $country; ?>"><?php echo $country; ?></option><option value="Afghanistan">Afghanistan</option><option value="Aland Islands">Aland Islands</option><option value="Albania">Albania</option><option value="Algeria">Algeria</option><option value="American Samoa">American Samoa</option><option value="Andorra">Andorra</option><option value="Angola">Angola</option><option value="Anguilla">Anguilla</option><option value="Antarctica">Antarctica</option><option value="Antigua and Barbuda">Antigua and Barbuda</option><option value="Argentina">Argentina</option><option value="Armenia">Armenia</option><option value="Aruba">Aruba</option><option value="Australia">Australia</option><option value="Austria">Austria</option><option value="Azerbaijan">Azerbaijan</option><option value="Bahamas">Bahamas</option><option value="Bahrain">Bahrain</option><option value="Bangladesh">Bangladesh</option><option value="Barbados">Barbados</option><option value="Belarus">Belarus</option><option value="Belgium">Belgium</option><option value="Belize">Belize</option><option value="Benin">Benin</option><option value="Bermuda">Bermuda</option><option value="Bhutan">Bhutan</option><option value="Bolivia">Bolivia</option><option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option><option value="Botswana">Botswana</option><option value="Bouvet Island">Bouvet Island</option><option value="Brazil">Brazil</option><option value="British Indian Ocean Territory">British Indian Ocean Territory</option><option value="Brunei Darussalam">Brunei Darussalam</option><option value="Bulgaria">Bulgaria</option><option value="Burkina Faso">Burkina Faso</option><option value="Burundi">Burundi</option><option value="Cambodia">Cambodia</option><option value="Cameroon">Cameroon</option><option value="Canada">Canada</option><option value="Cape Verde">Cape Verde</option><option value="Cayman Islands">Cayman Islands</option><option value="Central African Republic">Central African Republic</option><option value="Chad">Chad</option><option value="Chile">Chile</option><option value="China">China</option><option value="Christmas Island">Christmas Island</option><option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option><option value="Colombia">Colombia</option><option value="Comoros">Comoros</option><option value="Congo">Congo</option><option value="Cook Islands">Cook Islands</option><option value="Costa Rica">Costa Rica</option><option value="Cote D'Ivoire">Cote D'Ivoire</option><option value="Croatia">Croatia</option><option value="Cuba">Cuba</option><option value="Cyprus">Cyprus</option><option value="Czech Republic">Czech Republic</option><option value="Denmark">Denmark</option><option value="Djibouti">Djibouti</option><option value="Dominica">Dominica</option><option value="Dominican Republic">Dominican Republic</option><option value="Ecuador">Ecuador</option><option value="Egypt">Egypt</option><option value="El Salvador">El Salvador</option><option value="Equatorial Guinea">Equatorial Guinea</option><option value="Eritrea">Eritrea</option><option value="Estonia">Estonia</option><option value="Ethiopia">Ethiopia</option><option value="Falkland Islands">Falkland Islands</option><option value="Faroe Islands">Faroe Islands</option><option value="Fiji">Fiji</option><option value="Finland">Finland</option><option value="France">France</option><option value="French Guiana">French Guiana</option><option value="French Polynesia">French Polynesia</option><option value="French Southern Territories">French Southern Territories</option><option value="Gabon">Gabon</option><option value="Gambia">Gambia</option><option value="Georgia">Georgia</option><option value="Germany">Germany</option><option value="Ghana">Ghana</option><option value="Gibraltar">Gibraltar</option><option value="Greece">Greece</option><option value="Greenland">Greenland</option><option value="Grenada">Grenada</option><option value="Guadeloupe">Guadeloupe</option><option value="Guam">Guam</option><option value="Guatemala">Guatemala</option><option value="Guinea">Guinea</option><option value="Guinea-Bissau">Guinea-Bissau</option><option value="Guyana">Guyana</option><option value="Haiti">Haiti</option><option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option><option value="Vatican City">Vatican City</option><option value="Honduras">Honduras</option><option value="Hong Kong">Hong Kong</option><option value="Hungary">Hungary</option><option value="Iceland">Iceland</option><option value="India">India</option><option value="Indonesia">Indonesia</option><option value="Iran">Iran</option><option value="Iraq">Iraq</option><option value="Ireland">Ireland</option><option value="Israel">Israel</option><option value="Italy">Italy</option><option value="Jamaica">Jamaica</option><option value="Japan">Japan</option><option value="Jordan">Jordan</option><option value="Kazakhstan">Kazakhstan</option><option value="Kenya">Kenya</option><option value="Kiribati">Kiribati</option><option value="South Korea">South Korea</option><option value="North Korea">North Korea</option><option value="Kuwait">Kuwait</option><option value="Kyrgyzstan">Kyrgyzstan</option><option value="Laos">Laos</option><option value="Latvia">Latvia</option><option value="Lebanon">Lebanon</option><option value="Lesotho">Lesotho</option><option value="Liberia">Liberia</option><option value="Libya">Libya</option><option value="Liechtenstein">Liechtenstein</option><option value="Lithuania">Lithuania</option><option value="Luxembourg">Luxembourg</option><option value="Macao">Macao</option><option value="Macedonia">Macedonia</option><option value="Madagascar">Madagascar</option><option value="Malawi">Malawi</option><option value="Malaysia">Malaysia</option><option value="Maldives">Maldives</option><option value="Mali">Mali</option><option value="Malta">Malta</option><option value="Marshall Islands">Marshall Islands</option><option value="Martinique">Martinique</option><option value="Mauritania">Mauritania</option><option value="Mauritius">Mauritius</option><option value="Mayotte">Mayotte</option><option value="Mexico">Mexico</option><option value="Micronesia">Micronesia</option><option value="Moldova">Moldova</option><option value="Monaco">Monaco</option><option value="Mongolia">Mongolia</option><option value="Montserrat">Montserrat</option><option value="Morocco">Morocco</option><option value="Mozambique">Mozambique</option><option value="Myanmar">Myanmar</option><option value="Namibia">Namibia</option><option value="Nauru">Nauru</option><option value="Nepal">Nepal</option><option value="Netherlands">Netherlands</option><option value="Netherlands Antilles">Netherlands Antilles</option><option value="New Caledonia">New Caledonia</option><option value="New Zealand">New Zealand</option><option value="Nicaragua">Nicaragua</option><option value="Niger">Niger</option><option value="Nigeria">Nigeria</option><option value="Niue">Niue</option><option value="Norfolk Island">Norfolk Island</option><option value="Northern Mariana Islands">Northern Mariana Islands</option><option value="Norway">Norway</option><option value="Oman">Oman</option><option value="Pakistan">Pakistan</option><option value="Palau">Palau</option><option value="Palestinian Territory">Palestinian Territory</option><option value="Panama">Panama</option><option value="Papua New Guinea">Papua New Guinea</option><option value="Paraguay">Paraguay</option><option value="Peru">Peru</option><option value="Philippines">Philippines</option><option value="Pitcairn">Pitcairn</option><option value="Poland">Poland</option><option value="Portugal">Portugal</option><option value="Puerto Rico">Puerto Rico</option><option value="Qatar">Qatar</option><option value="Reunion">Reunion</option><option value="Romania">Romania</option><option value="Russian Federation">Russian Federation</option><option value="Rwanda">Rwanda</option><option value="Saint Helena">Saint Helena</option><option value="Saint Kitts And Nevis">Saint Kitts And Nevis</option><option value="Saint Lucia">Saint Lucia</option><option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option><option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option><option value="Samoa">Samoa</option><option value="San Marino">San Marino</option><option value="Sao Tome and Principe">Sao Tome and Principe</option><option value="Saudi Arabia">Saudi Arabia</option><option value="Senegal">Senegal</option><option value="Serbia and Montenegro">Serbia and Montenegro</option><option value="Seychelles">Seychelles</option><option value="Sierra Leone">Sierra Leone</option><option value="Singapore">Singapore</option><option value="Slovakia">Slovakia</option><option value="Slovenia">Slovenia</option><option value="Solomon Islands">Solomon Islands</option><option value="Somalia">Somalia</option><option value="South Africa">South Africa</option><option value="Spain">Spain</option><option value="Spratly Islands">Spratly Islands</option><option value="Sri Lanka">Sri Lanka</option><option value="Sudan">Sudan</option><option value="Suriname">Suriname</option><option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option><option value="Swaziland">Swaziland</option><option value="Sweden">Sweden</option><option value="Switzerland">Switzerland</option><option value="Syrian Arab Republic">Syrian Arab Republic</option><option value="Taiwan">Taiwan</option><option value="Tajikistan">Tajikistan</option><option value="Tanzania">Tanzania</option><option value="Thailand">Thailand</option><option value="Timor-Leste">Timor-Leste</option><option value="Togo">Togo</option><option value="Tokelau">Tokelau</option><option value="Tonga">Tonga</option><option value="Trinidad and Tobago">Trinidad and Tobago</option><option value="Tunisia">Tunisia</option><option value="Turkey">Turkey</option><option value="Turkmenistan">Turkmenistan</option><option value="Turks and Caicos Islands">Turks and Caicos Islands</option><option value="Tuvalu">Tuvalu</option><option value="Uganda">Uganda</option><option value="Ukraine">Ukraine</option><option value="United Arab Emirates">United Arab Emirates</option><option value="United Kingdom">United Kingdom</option><option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option><option value="United States">United States</option><option value="Uruguay">Uruguay</option><option value="Uzbekistan">Uzbekistan</option><option value="Vanuatu">Vanuatu</option><option value="Venezuela">Venezuela</option><option value="Vietnam">Vietnam</option><option value="Virgin Islands">Virgin Islands</option><option value="Wallis and Futuna">Wallis and Futuna</option><option value="Western Sahara">Western Sahara</option><option value="Yemen">Yemen</option><option value="Zambia">Zambia</option><option value="Zimbabwe">Zimbabwe</option></select><input type="text" id="phone" style="position:absolute;left:52px;top:726px;width:400px;height:22px;z-index:5;" name="phone" value="<?php if(empty($phone)) {echo $ccode;} else { echo $phone; }?>" tabindex="9" spellcheck="false" placeholder="Valid Phone Number Must Start With Country Code"><div id="wb_Text3" style="position:absolute;left:163px;top:520px;width:223px;height:19px;text-align:center;z-index:6;"><span style="color:#696969;font-family:Arial;font-size:17px;"><strong>Your Admin Details</strong></span></div><div id="wb_FontAwesomeIcon2" style="position:absolute;left:53px;top:551px;width:34px;height:27px;text-align:center;z-index:7;"><div id="FontAwesomeIcon2"><i class="fa fa-user"></i></div></div><div id="wb_FontAwesomeIcon3" style="position:absolute;left:53px;top:595px;width:34px;height:27px;text-align:center;z-index:8;"><div id="FontAwesomeIcon3"><i class="fa fa-user-circle-o"></i></div></div><div id="wb_FontAwesomeIcon4" style="position:absolute;left:53px;top:639px;width:34px;height:27px;text-align:center;z-index:9;"><div id="FontAwesomeIcon4"><i class="fa fa-key"></i></div></div><div id="wb_FontAwesomeIcon6" style="position:absolute;left:53px;top:684px;width:34px;height:27px;text-align:center;z-index:10;"><div id="FontAwesomeIcon6"><i class="fa fa-envelope"></i></div></div><div id="wb_FontAwesomeIcon7" style="position:absolute;left:49px;top:729px;width:34px;height:27px;text-align:center;z-index:11;"><div id="FontAwesomeIcon7"><i class="fa fa-phone-square"></i></div></div><div id="wb_FontAwesomeIcon8" style="position:absolute;left:49px;top:773px;width:34px;height:27px;text-align:center;z-index:12;"><div id="FontAwesomeIcon8"><i class="fa fa-map-marker"></i></div></div><div id="wb_FontAwesomeIcon1" style="position:absolute;left:459px;top:640px;width:39px;height:25px;text-align:center;z-index:13;"><a href="#" onclick="myFunction2();return false;"><div id="FontAwesomeIcon1"><i class="fa fa-eye"></i></div></a></div><input type="text" id="server" style="position:absolute;left:51px;top:325px;width:400px;height:22px;z-index:14;" name="server" value="<?php if(empty($dbserver)) {echo 'localhost';} else { echo $dbserver; }?>" tabindex="1" autofocus spellcheck="false" placeholder="DB Server"><input type="text" id="database" style="position:absolute;left:51px;top:369px;width:400px;height:22px;z-index:15;" name="database" value="<?php echo $dbdatabase; ?>" tabindex="2" autofocus spellcheck="false" placeholder="Database Name"><input type="text" id="dbuser" style="position:absolute;left:51px;top:414px;width:400px;height:22px;z-index:16;" name="dbuser" value="<?php echo $dbusername; ?>" tabindex="3" autofocus spellcheck="false" placeholder="Database Username"><input type="password" id="dbpass" style="position:absolute;left:51px;top:458px;width:363px;height:22px;z-index:17;" name="dbpass" value="<?php echo $dbpassword ; ?>" tabindex="4" autofocus spellcheck="false" placeholder="Database Password"><div id="wb_Text2" style="position:absolute;left:163px;top:294px;width:223px;height:19px;text-align:center;z-index:18;"><span style="color:#696969;font-family:Arial;font-size:17px;"><strong>Your Database Details</strong></span></div><div id="wb_FontAwesomeIcon5" style="position:absolute;left:53px;top:461px;width:34px;height:27px;text-align:center;z-index:19;"><div id="FontAwesomeIcon5"><i class="fa fa-key"></i></div></div><div id="wb_FontAwesomeIcon9" style="position:absolute;left:459px;top:462px;width:39px;height:25px;text-align:center;z-index:20;"><a href="#" onclick="myFunction1();return false;"><div id="FontAwesomeIcon9"><i class="fa fa-eye"></i></div></a></div><div id="wb_FontAwesomeIcon10" style="position:absolute;left:53px;top:330px;width:34px;height:27px;text-align:center;z-index:21;"><div id="FontAwesomeIcon10"><i class="fa fa-server"></i></div></div><div id="wb_FontAwesomeIcon11" style="position:absolute;left:53px;top:372px;width:34px;height:27px;text-align:center;z-index:22;"><div id="FontAwesomeIcon11"><i class="fa fa-database"></i></div></div><div id="wb_FontAwesomeIcon12" style="position:absolute;left:53px;top:417px;width:34px;height:27px;text-align:center;z-index:23;"><div id="FontAwesomeIcon12"><i class="fa fa-user"></i></div></div><div id="Html2" style="position:absolute;left:51px;top:54px;width:445px;height:228px;z-index:24"><?php
//check php compatibility and defiine variables for them
$dirperm = substr(sprintf("%o",fileperms("./")),-4);
if (version_compare(PHP_VERSION, '5.5.3') >= 0) {$phpv = 0;} else {$phpv = 1;}
if (extension_loaded('mbstring')) {$mbl = 0;} else {$mbl = 1;}
if (extension_loaded('mysqli')) {$mql = 0;} else {$mql = 1;}
if (extension_loaded('gd')) {$gd = 0;} else {$gd = 1;}
if( ini_get('allow_url_fopen') ) {$ulo = 0;} else {$ulo = 1;}
if( ini_get('file_uploads') ) {$fpl = 0;} else {$fpl = 1;}
if($dirperm == "0755" || $dirperm == "0750") {$dp = 0;} else {$dp = 1;}
$alert = $phpv+$mbl+$mql+$gd+$ulo+$fpl+$dp;

//use the defined variables to display the php feature status in a table
 echo "<div class=\"nuser\">";
    echo "<table width=\"100%\" cellpadding=\"2\" cellsapcing =\"2\">";
        echo "<thead>";
           echo "<tr>";
echo "<th>PHP Feature</th><th>Status</th></tr>";
       echo "</thead>";
        echo "<tbody>";
        
            echo "<tr>";
                    echo "<td><strong>PHP Version</strong></td>";
                    
                    if ($phpv == 0) { echo "<td><span style=\"color:#32CD32;\"><div class=\"fa fa-check-circle\"></div>&nbsp;<strong>Ver: ". PHP_VERSION ."</strong></span></td>";} else { echo "<td><span style=\"color:#FF1493;\"><div class=\"fa fa-times-circle\"></div><strong>&nbsp;Ver: ". PHP_VERSION ."</strong></span></td>";}
                                      
                echo "</tr>";
                
                echo "<tr>";
                    echo "<td><strong>mbstring</strong></td>";
                    
                    if ($mbl == 0) { echo "<td><span style=\"color:#32CD32;\"><div class=\"fa fa-check-circle\"></div>&nbsp;<strong>Enabled</strong></span></td>";} else { echo "<td><span style=\"color:#FF1493;\"><div class=\"fa fa-times-circle\"></div><strong>&nbsp;Disabled</strong></span></td>";}
                                      
                echo "</tr>";
                
                echo "<tr>";
                    echo "<td><strong>mysqli</strong></td>";
                    
                    if ($mql == 0) { echo "<td><span style=\"color:#32CD32;\"><div class=\"fa fa-check-circle\"></div>&nbsp;<strong>Enabled</strong></span></td>";} else { echo "<td><span style=\"color:#FF1493;\"><div class=\"fa fa-times-circle\"></div><strong>&nbsp;Disabled</strong></span></td>";}
                                      
                echo "</tr>";
                
                echo "<tr>";
                    echo "<td><strong>allow_url_fopen</strong></td>";
                    
                    if ($ulo == 0) {echo "<td><span style=\"color:#32CD32;\"><div class=\"fa fa-check-circle\"></div>&nbsp;<strong>Enabled</strong></span></td>";} else {echo "<td><span style=\"color:#FF1493;\"><div class=\"fa fa-times-circle\"></div><strong>&nbsp;Disabled</strong></span></td>";}
                                      
                echo "</tr>";
                
                echo "<tr>";
                    echo "<td><strong>file_uploads</strong></td>";
                    
                    if ($fpl == 0) {echo "<td><span style=\"color:#32CD32;\"><div class=\"fa fa-check-circle\"></div>&nbsp;<strong>Enabled</strong></span></td>";} else {echo "<td><span style=\"color:#FF1493;\"><div class=\"fa fa-times-circle\"></div><strong>&nbsp;Disabled</strong></span></td>";}
                                      
                echo "</tr>";
                
                echo "<tr>";
                    echo "<td><strong>gd</strong></td>";
                    
                    if ($gd == 0) {echo "<td><span style=\"color:#32CD32;\"><div class=\"fa fa-check-circle\"></div>&nbsp;<strong>Enabled</strong></span></td>";} else {echo "<td><span style=\"color:#FF1493;\"><div class=\"fa fa-times-circle\"></div><strong>&nbsp;Disabled</strong></span></td>";}
                                      
                echo "</tr>";
                
                echo "<tr>";
                    echo "<td><strong>Directory Permission</strong></td>";
                    
                    if ($dp == 0) {echo "<td><span style=\"color:#32CD32;\"><div class=\"fa fa-check-circle\"></div>&nbsp;<strong>".$dirperm."</strong></span></td>";} else {echo "<td><span style=\"color:#FF1493;\"><div class=\"fa fa-times-circle\"></div><strong>&nbsp;".$dirperm."</strong></span></td>";}
                                      
                echo "</tr>";
                
            
    echo "</tbody>";
    
            echo "</table>";
            
            
            echo"</div>";


    ?></div><div id="wb_Text4" style="position:absolute;left:148px;top:22px;width:255px;height:19px;text-align:center;z-index:25;"><span style="color:#696969;font-family:Arial;font-size:17px;"><strong>PHP Requirements Status</strong></span></div><div id="Html3" style="position:absolute;left:28px;top:871px;width:496px;height:34px;z-index:26"><?php
if($alert!=0) {
echo "<center><span style=\"color:#FF1493;\">Warning: You have PHP requirement issue(s), proceeding with installation might make your app malfunction!</span></center>";
}
?></div><div id="Html4" style="position:absolute;left:51px;top:817px;width:446px;height:42px;z-index:27"><button type="submit" class="button">Install</button></div><div id="Html5" style="position:absolute;left:51px;top:817px;width:447px;height:42px;visibility:hidden;z-index:28"><butt class="button2" disabled><div class="fa fa-spinner fa-pulse"></div>&nbsp;&nbsp;Installing Affiliate Me...</butt></div></form></div><div id="Html10" style="position:absolute;left:208px;top:1137px;width:555px;height:51px;z-index:36"><span style="color:#808080;font-family:Arial;font-size:14px;"><center>Affiliate Me Software, a Product of Powerstone (PTS Technologies, Ghana)<br><?php $cyear = date("Y"); echo "Copyright © 2018 - " .$cyear ." PTS Technologies, All Rights Reserved."; ?></center></span><br><br></div><form name="Layer1" method="post" action="./admin.php?show=beats" enctype="multipart/form-data" id="cron" class="modal fade" role="dialog" style="overflow:auto;text-align:left;"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><div id="wb_Text5" style="position:absolute;left:97px;top:11px;width:273px;height:24px;text-align:center;z-index:29;"><span style="color:#FF1493;font-family:Tahoma;font-size:20px;"><strong>Important!!!</strong></span></div><div id="Html6" style="position:absolute;left:22px;top:51px;width:422px;height:255px;z-index:30"><span style="color:#1E90FF;font-family:Arial;font-size:16px;"><br><?php echo $cronco; ?></span></div></div></div></div></form></div></body></html><?php if($cronco !='') {
echo "<script>
$('#cron').modal('show');</script>";
}
?>