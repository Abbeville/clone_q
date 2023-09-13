<?php if(empty($link)){header('Location: ./admin.php'); exit;} $parse = "https://update.powerstonegh.com/parse.php?key={$uslk}&prod=am";
$conf = file_get_contents($parse);
$err = "";
$sucm = "";
if(isset($_GET['action']) == 'download')
{
if($conf==1)
{
/*the following 2 lines are not mandatory but we keep it to 
avoid risk of exceeding default execution time and mamory*/
ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');
/*url of zipped file at old server*/
$file = "https://update.powerstonegh.com?key={$uslk}";
/*what should it name at new server*/
$dest = 'update.zip';
/*get file contents and create same file here at new server*/
$data = file_get_contents($file);
$handle = fopen($dest,"wb");
fwrite($handle, $data);
fclose($handle);
$sucm .= "Software Download Successfull, ";
//Unzip the copied file
$unzip = new ZipArchive;
$out = $unzip->open($dest);
if ($out === TRUE) {
  $unzip->extractTo(getcwd());
  $unzip->close();
  $sucm .= "Software Extraction Successfull";
} else {
  $err = "Software Extraction Failed!";
}
//Delete the downloaded file
unlink($dest);

}
else
{
$err = "Wrong or Empty license key, please provide a correct 'Update Server License Key' in system settings!";
   }
}

//Version updaters
//Check for changes and update from old version
if(!file_exists('cversion.php')) {$vh = "on";} else if (version_compare($version, $cversion) > 0) {$vh = "on";} else {$vh = "off";}
$dbu = isset($_SESSION['dbu']) ? $_SESSION['dbu'] : '';
if($vh == "on" ||  $dbu == "on")
{
$sql10 = ("ALTER TABLE `ref` ADD COLUMN CITY VARCHAR( 255 ) NOT NULL, ADD COLUMN REGION VARCHAR( 255 ) NOT NULL, ADD COLUMN COUNTRY VARCHAR( 255 ) NOT NULL, ADD COLUMN IP VARCHAR( 255 ) NOT NULL, ADD COLUMN OS VARCHAR( 255 ) NOT NULL, ADD COLUMN TIME VARCHAR( 255 ) NOT NULL, ADD COLUMN BROWSER VARCHAR( 255 ) NOT NULL, ADD COLUMN FLAG VARCHAR( 255 ) NOT NULL, ADD COLUMN OSLOGO VARCHAR( 255 ) NOT NULL, ADD COLUMN BROLOGO VARCHAR( 255 ) NOT NULL, ADD COLUMN REFER VARCHAR( 255 ) NOT NULL, ADD COLUMN SALE VARCHAR( 5 ) NOT NULL");
$result = mysqli_query($link, $sql10);
$sql109 = "UPDATE ref SET SALE='yes' WHERE SALE = ''";
$result = mysqli_query($link, $sql109);
//Update login history table
$sql10 = ("ALTER TABLE `login` ADD COLUMN FLAG VARCHAR( 255 ) NOT NULL, ADD COLUMN OSLOGO VARCHAR( 255 ) NOT NULL, ADD COLUMN BROLOGO VARCHAR( 255 )");
$result = mysqli_query($link, $sql10);
//Update users table
$sql10 = ("ALTER TABLE `users` ADD COLUMN WEBSITE VARCHAR( 255 ) NOT NULL, ADD COLUMN MOMO VARCHAR( 255 ) NOT NULL, ADD COLUMN CHEQUE VARCHAR( 1255 )");
$result = mysqli_query($link, $sql10);

//Update withdrawal history table
$sql10 = ("ALTER TABLE `withdrawals` ADD COLUMN CHEQUE VARCHAR( 1255 ) NOT NULL, ADD COLUMN MOMO VARCHAR( 255 ) NOT NULL, ADD COLUMN METHOD VARCHAR( 255 )");
$result = mysqli_query($link, $sql10);

//Email history table
$sql10 = ("ALTER TABLE `emails` ADD COLUMN STATUS VARCHAR( 100 ) NOT NULL");
$result = mysqli_query($link, $sql10);

//Update ref table
$sql10 = ("ALTER TABLE `ref` ADD COLUMN CPC VARCHAR( 100 ) NOT NULL, ADD COLUMN URL VARCHAR( 500 ) NOT NULL, ADD COLUMN OID VARCHAR( 500 ) NOT NULL");
$result = mysqli_query($link, $sql10);
//Update login table v5.0.1
$sql10 = ("ALTER TABLE `login` ADD COLUMN BROWID VARCHAR( 50 ) NOT NULL");
$result = mysqli_query($link, $sql10);
//Update users table v5.0.1
$sql10 = ("ALTER TABLE `users` ADD COLUMN DFA VARCHAR( 50 ) NOT NULL, ADD COLUMN BANK VARCHAR( 5000 ) NOT NULL, ADD COLUMN RKEY VARCHAR( 5000 ) NOT NULL");
$result = mysqli_query($link, $sql10);

//Setting up cron
if ($cron == 1){
$output = shell_exec('crontab -l');
file_put_contents('/tmp/crontab.txt', $output.'*/5 * * * * /usr/local/bin/php '.$folder.'/am-cron.php >/dev/null 2>&1'.PHP_EOL);
echo exec('crontab /tmp/crontab.txt');
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
}
//Create Banners table
$sql2 = "CREATE TABLE `banners` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `alte` varchar(100) NOT NULL,
  `banner` varchar(575) NOT NULL,
  `width` varchar(50) NOT NULL,
  `height` varchar(75) NOT NULL,
  
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 ";
 $result = mysqli_query($link, $sql2);

//Create email templates table
$sql1 = "CREATE TABLE `etemplates` (
  `ID` int(9) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(150) NOT NULL,
  `TYPE` varchar(100) NOT NULL,
  `MESSAGE` varchar(9550) NOT NULL,
  
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 ";
 $result = mysqli_query($link, $sql1);

//Create domains table
$sql11 = "CREATE TABLE `domains` (
  `ID` int(9) NOT NULL AUTO_INCREMENT,
  `DOMAIN` varchar(250) NOT NULL,
  
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 ";
 $result = mysqli_query($link, $sql11);

//Update banner table
$sql10 = ("ALTER TABLE `banners` ADD COLUMN URL VARCHAR( 1000 ) NOT NULL");
$result = mysqli_query($link, $sql10);

//Update current version for updates
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
//Update the database for settings
if(empty($paymode)) {$paymode = "paypal";}
if(empty($acheque)) {$acheque = "";}
if(empty($mport)) {$mport = 465;}
if(empty($tos)) {$tos = "Coming Soon!";}
if(empty($tzone)) {$tzone = "Africa/Accra";}
if(empty($uslk)) {$uslk = "";}
if(empty($purl)) {$purl = "";}
if(empty($sessdur)) {$sessdur = "1440";}
if(empty($sandbox)) {$sandbox = "";}
if(empty($signupet)) {$signupet = "Signup";}
if(empty($titemp)) {$titemp = "Ticket";}
if(empty($sale)) {$sale = "Sale";}
if(empty($affpaid)) {$affpaid = "Payout";}
if(empty($affreject)) {$affreject = "Paycancel";}
if(empty($passrec)) {$passrec = "Password";}
if(empty($perc)) {$perc = "";}
if(empty($cpc)) {$cpc = "";}
if(empty($cpcv)) {$cpcv = "0.001";}
if(empty($locale)) {$locale = "en-us";}
$config = './db.php';
$file = fopen($config, 'w');
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
      fwrite($file, $logo);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$favicon');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $favicon);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$sitename');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $sitename);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$locale');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $locale);
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
      fwrite($file, $prot);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$currsym');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $currsym);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$bankpay');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $bankpay);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$acheque');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $acheque);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$trprefix');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $trprefix);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$mincash');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $mincash);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$comm');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $comm);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$vd');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $vd);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$red');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $red);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$perc');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $perc);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$cpc');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $cpc);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$cpcv');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $cpcv);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$mnotifykey');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $mnotifykey);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$smsid');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $smsid);
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
      fwrite($file, $smswithdrawal);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$smsticket');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $smsticket);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$fb');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $fb);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$tt');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $tt);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$smtpmail');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $smtpmail);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$mailhost');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $mailhost);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$musername');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $musername);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$mpassword');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $mpassword);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$mport');
      fwrite($file, ' = ');
      fwrite($file, $mport);
      fwrite($file, ';');
      fwrite($file, "\r\n");
      fwrite($file, '$mailimit');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $mailimit);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$semail');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $semail);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$signupet');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $signupet);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$titemp');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $titemp);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$sale');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $sale);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$affpaid');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $affpaid);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$affreject');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $affreject);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$passrec');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $passrec);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$capcha');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $capcha);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$tos');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $tos);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$bfreq');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $bfreq);
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
      fwrite($file, $uslk);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$purl');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $purl);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$sessdur');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $sessdur);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$sandbox');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $sandbox);
      fwrite($file, '";');
      fwrite($file, "\r\n");
      fwrite($file, '$ganal');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $ganal);
      fwrite($file, '";');
      fclose($file);
$_SESSION['dbu'] = "";
//add email templates
$query = "SELECT * FROM etemplates";
$resulte = mysqli_query($link, $query);
if(mysqli_num_rows($resulte)==0){
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
}
 $sucm .= "Your Software Update Was Successfull.";
   }
?><!doctype html><html><head><meta charset="utf-8"><title>Software Update | Affiliate Me - <?php echo $version; ?></title><meta name="robots" content="noindex, nofollow"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="updater.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script><script src="wwb14.min.js"></script></head><body><div id="container"><div id="Layer1"><div id="insall"><button class="ins" disabled><div class="fa fa-spinner fa-pulse"></div>&nbsp;&nbsp;Updating Software...</button></div><div id="Html1"><a href="#" onclick="ShowObject('Html1', 0);ShowObject('insall', 1);window.location.href='./admin.php?show=update&action=download';return false;"><button type="submit" class="button"><i class="fa fa-server">&nbsp;</i>&nbsp;&nbsp;Auto Update From Server</button></a></div><div id="Html2"><a href="https://www.codester.com/items/10615" target="_blank"><button type="submit" class="button"><i class="fa fa-download">&nbsp;</i>&nbsp;&nbsp;Download From Codester</button></a></div><div id="Html3"><a href="https://www.powerstonegh.com" target="_blank"><button type="submit" class="button"><i class="fa fa-download">&nbsp;</i>&nbsp;&nbsp;Download From Powerstone</button></a></div><div id="wb_affmeim"><img src="images/AMST.png" id="affmeim" alt=""></div><div id="Html7"><span style="color:#1E90FF;font-size:17px;"><?php echo $lang['clickbut']; ?></span></div></div><div id="Html8"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:15px;\"><center><i class=\"fa fa-check-circle-o\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
}
?><?php
if($err !='') {
echo "<div class=\"alert2\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:15px;\"><center><i class=\"fa fa-info-circle\">&nbsp;</i><strong>" . $err . "</strong></center></div></div>";
}
?></div><div id="Layer7"><div id="Html4"><?php
$llink = "https://update.powerstonegh.com/log.php?prod=am";
$cl = file_get_contents($llink);
if($cl != ''){echo $cl;} else {echo '<span style="color:#FF0000;font-family:Arial;font-size:13px;">Sorry, could not connect to update server!!! Update server must be offline, kindly try again in a few minutes.</span>';}
?></div><div id="Html6"><span style="color:#1E90FF;font-size:17px;"><?php echo $lang['changelog']; ?></span></div></div><div id="Html23"><div style="color:#A9A9A9;font-family:Arial;font-size:13px; text-align:center;">Affiliate Me Version <?php echo $version; ?><br></div></div><div id="Html5"><span style="color:#D3D3D3;font-family:Tahoma;font-size:18px;">Beat Cube <?php echo $lang['updwiz']; ?></span></div></div></body></html>