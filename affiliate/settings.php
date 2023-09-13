<?php
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
if(empty($link)){header('Location: ./admin.php'); exit;}
$sucm = "";
$error_message = "";
$percstate = $perc;
if(!empty($_POST)){
//Define posted data from settings form
if($smtpmail == isset($_POST['smtp']) && $mailhost == $_POST["mhost"] && $musername == $_POST["muser"] && $mpassword == $_POST["mpass"] && $mport == $_POST["mport"]) {$mstat =0;} else {$mstat =1;}
$maxses = ini_get("session.gc_maxlifetime");
$sitename = $_POST["sitename"];
$domain = $_POST["domain"];
$sitename = $_POST["sitename"];
$prot = isset($_POST['ssl']) ? $_POST['ssl'] : '';
$currsym = $_POST["curr"];
$trprefix = $_POST["tpref"];
$mincash = $_POST["mincash"];
$commn = $_POST["comm"];
$vd = $_POST["vd"];
$red = $_POST["red"];
$key = $_POST["key"];
$mnotifykey = $_POST["mkey"];
$smsid = $_POST["smsid"];
$phone = $_POST["phone"];
$smswithdrawal = isset($_POST['walert']) ? $_POST['walert'] : '';
$smsticket = isset($_POST['talert']) ? $_POST['talert'] : '';
$fb = $_POST["fb"];
$tt = $_POST["tt"];
$smtpmail = isset($_POST['smtp']) ? $_POST['smtp'] : '';
$mailhost = $_POST["mhost"];
$musername = $_POST["muser"];
$mpassword = $_POST["mpass"];
$mailimit = $_POST["mlimit"];
$semail = $_POST["smail"];
$capcha = isset($_POST['capcha']) ? $_POST['capcha'] : '';
$tos = urlencode($_POST["tos"]);
$bfreq = $_POST["bfreq"];
$ganal = urlencode($_POST["ganal"]);
$uslk = $_POST["ulik"];
$tzone = $_POST["timezone"];
$purl = isset($_POST['purl']) ? $_POST['purl'] : '';
$sessdur = $_POST["sesd"];
$bankpay = isset($_POST['bank']) ? $_POST['bank'] : '';
$acheque = isset($_POST['acheque']) ? $_POST['acheque'] : '';
$sandbox = isset($_POST['sandbox']) ? $_POST['sandbox'] : '';
$mport = $_POST["mport"];
$locale = $_POST["locale"];
$perc = $_POST["perc"];
$cpc = $_POST["cpc"];
$cpcv = $_POST["cpcv"];
$signupet = $_POST["signupet"];
$titemp = $_POST["titemp"];
$sale = $_POST["sale"];
$affpaid = $_POST["affpaid"];
$affreject = $_POST["affreject"];
$passrec = $_POST["passrec"];
if($perc == ""){$comm = $commn;} else if($perc == "on" && $percstate == "") {$comm = round(sprintf('%f', floatval($commn/100)),2);}  else if($perc == "on" && $comm == $commn) {$comm = $commn;} else {$comm = round(sprintf('%f', floatval($commn/100)),2);}
if($mnotifykey =='') {$smswithdrawal = ''; $smsticket = '';}
if($prot =='') {$prot = 'http://';}
if($domain =='') {$domain = $_SERVER['HTTP_HOST'];}
if($currsym == '₦') {$bankpay = 'yes';} else {$bankpay = $bankpay;}
if($sessdur =='') {$sessdur = $maxses;} else {$sessdur = $sessdur;}
//Validate posted data to ensure user is providing correct details for storage
if ($_SESSION['right'] != 'superadmin')
   {
      $error_message = $lang["setad"];
   }
   else
if (!preg_match("/^[A-Za-z0-9_!@$.' &]{1,50}$/", $sitename))
   {
      $error_message = $lang["snamerr"];
   }
   else
if (!preg_match("/^[A-Za-z0-9\/\-_. ]+$/", $domain))
   {
      $error_message = $lang["urlerr"];
   }
   else
if (!preg_match("/^[A-Za-z0-9_!@$.' &]{1,50}$/", $trprefix))
   {
      $error_message = $lang["preferr"];
   }
   else
if (!preg_match("/^[0-9. ]+$/", $commn))
   {
      $error_message = $lang["comerr"];
   }
   else
if ($commn <=0)
   {
      $error_message = $lang["nocomerr"];
   }
   else
if (empty($red))
   {
      $error_message = $lang["storerr"];
   }
   else
if (empty($cpcv))
   {
      $error_message = $lang["nocpc"];
   }
   else
if (!empty($mnotifykey) && !preg_match("/^[A-Za-z0-9@._]+$/", $mnotifykey))
   {
      $error_message = $lang["mkeyerr"];
   }
   else
if (!empty($mnotifykey) && !preg_match("/^[A-Za-z0-9_!@$ &]{1,50}$/", $smsid))
   {
      $error_message = $lang["smsiderr"] ;
   }
   else
if (!empty($mnotifykey) && !preg_match("/^[0-9,+]+$/", $phone))
   {
      $error_message = $lang["nofon"];
   }
   else
if (!preg_match("/^[A-Za-z0-9\/\-_. ]+$/", $mailhost))
   {
      $error_message = $lang["hosterr"];
   }
   else
if (empty($tos))
   {
      $error_message = $lang["notos"];
   }
   else
if (!empty($uslk) && !preg_match("/^[A-Za-z0-9_!@^$ &]{1,50}$/", $uslk))
   {
      $error_message = $lang["licerr"];
   }
   else
if ($sessdur > $maxses)
   {
      $error_message = $lang["seserr"]." ".$maxses." seconds";
   }
   else
if ($mstat == 1 && $smtpmail=='on')
   {
//Check to confirm if SMTP details are correct, else error out
$to = $musername;

$subject = "SMTP Settings";

$body = "This is to confirm that your smtp settings were successful";
$mail->FromName = $sitename;
$mail->addAddress($to);
$mail->Port = $mport;
$mail->Host = $mailhost;
$mail->Username = $musername;
$mail->Password = $mpassword;
$mail->Subject = $subject;
$mail->Body    = $body;
if(!$mail->send()) {
  $error_message = $lang["smtperr"];
 }
}
//If there are no errors detected, then upload logo image if user selected a new logo and save the data to db.php
if (empty($error_message)){

$slogo = $_FILES['logo']['name'];
if($slogo !='') {
$extension = pathinfo($slogo, PATHINFO_EXTENSION);
$nlogo = "logo.".$extension;
$target = "images/".basename($nlogo);
move_uploaded_file($_FILES['logo']['tmp_name'], $target);
$logo = $target; }

$sfav = $_FILES['favicon']['name'];
if($sfav !='') {
$extension = pathinfo($sfav, PATHINFO_EXTENSION);
$nfav = "favicon.".$extension;
$target2 = "images/".basename($nfav);
move_uploaded_file($_FILES['favicon']['tmp_name'], $target2);
$favicon = $target2; }

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
$sucm = 'Your settings have been successfully Saved!';
}
}
?><!doctype html><html><head><meta charset="utf-8"><title>Settings | Affiliate Me  - <?php echo $version; ?></title><meta name="robots" content="noindex, nofollow"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="font-awesome.min.css" rel="stylesheet"><link href="settings.css" rel="stylesheet"><script>
function ValidateSettings()
{var regexp;var banner1=document.getElementById('banner1');if(!(banner1.disabled||banner1.style.display==='none'||banner1.style.visibility==='hidden'))
{var ext=banner1.value.substr(banner1.value.lastIndexOf('.'));if((ext.toLowerCase()!=".gif")&&(ext.toLowerCase()!=".ico")&&(ext.toLowerCase()!=".png")&&(ext!=""))
{alert("The \"favicon\" field contains an unapproved filename.");return false;}}
var FileUpload1=document.getElementById('FileUpload1');if(!(FileUpload1.disabled||FileUpload1.style.display==='none'||FileUpload1.style.visibility==='hidden'))
{var ext=FileUpload1.value.substr(FileUpload1.value.lastIndexOf('.'));if((ext.toLowerCase()!=".gif")&&(ext.toLowerCase()!=".png")&&(ext!=""))
{alert("The \"logo\" field contains an unapproved filename.");return false;}}
return true;}</script><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><!-- view pass --><div id="Html16"><script>
function myFunction1(){var x=document.getElementById("mkey");if(x.type==="password"){x.type="text";}else{x.type="password";}}</script><script>
function myFunction2(){var x=document.getElementById("skey");if(x.type==="password"){x.type="text";}else{x.type="password";}}</script><script>
function myFunction3(){var x=document.getElementById("uskey");if(x.type==="password"){x.type="text";}else{x.type="password";}}</script></div><div id="Html8"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:12px;\"><center><i class=\"fa fa-check-circle-o\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
}
?><?php
if($error_message !='') {
echo "<div class=\"alert2\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:12px;\"><center><i class=\"fa fa-info-circle\">&nbsp;</i><strong>" . $error_message . "</strong></center></div></div>";
}
?></div><div id="Html23"><div style="color:#A9A9A9;font-family:Arial;font-size:13px; text-align:center;">Affiliate Me Version <?php echo $version; ?><br></div></div><div id="wb_Form1"><form name="Settings" method="post" action="./admin.php?show=settings" enctype="multipart/form-data" id="Form1" onsubmit="if(!ValidateSettings()) return false;rev();document.getElementById('Form1').submit();return false;"><div id="Html2"><?php
if($prot == 'https://') {$checked = 'checked';} else {$checked = '';}
?><label class="switch"><input type="checkbox" name="ssl" value="https://" <?php echo $checked; ?>><span class="slider round"></span></label></div><hr id="Line2"><div id="Html9"><div class="logo"><img src="<?php echo $logo; ?>?upd=<?php echo $time; ?>" alt="Logo"></div></div><div id="Html6"><div class="fav"><img src="<?php echo $favicon; ?>?upd=<?php echo $time; ?>" alt="Favicon"></div></div><input type="file" accept=".gif,.ico,.png" name="favicon" id="banner1"><input type="file" accept=".gif,.png" name="logo" id="FileUpload1"><input type="text" id="Editbox1" name="sitename" value="<?php echo $sitename; ?>" spellcheck="false" placeholder="Site Name"><select name="curr" size="1" id="Combobox1"><option value="<?php echo $currsym; ?>"><?php if($currsym == '$') {echo "($) US Dollar";} else if ($currsym == '€') {echo "(€) Euro";} else if ($currsym == '£') {echo "(£) British Pound";} else if ($currsym == 'R$') {echo "(BRL) Brazilian real";} else  if ($currsym == 'C$')  {echo "(C$) Canadian Dollar";} else   if ($currsym == '₵') {echo "(GH₵) Ghana Cedis";} if ($currsym == '₦') {echo "(₦) Nigerian Naira";} ?></option><optgroup label="Non PayPal Currencies"><option value="₦">(₦) Nigerian Naira</option><option value="₵">(₵) Ghana Cedis</option></optgroup><optgroup label="PayPal Currencies"><option value="$">($) US Dollar</option><option value="€">(€) Euro</option><option value="£">(£) British Pound</option><option value="C$">(C$) Canadian Dollar</option><option value="R$">(BRL) Brazilian real</option></optgroup></select><input type="text" id="Editbox2" name="tpref" value="<?php echo $trprefix; ?>" maxlength="2" spellcheck="false" placeholder="TR ID Prefix"><input type="text" id="Editbox4" name="comm" value="<?php if($perc=='on') {echo ($comm*100);} else { echo $comm;} ?>" spellcheck="false" placeholder="Commision amt"><input type="number" id="Editbox5" name="vd" value="<?php echo $vd; ?>" spellcheck="false" placeholder="Days to wait" min="1"><input type="url" id="Editbox6" name="red" value="<?php echo $red; ?>" spellcheck="false" placeholder="Store URL"><div id="Html11"><?php
if($smswithdrawal == 'on') {$checked = 'checked';} else {$checked = '';}
?><label class="switch"><input type="checkbox" name="walert" value="on" <?php echo $checked; ?>><span class="slider round"></span></label></div><hr id="Line4"><input type="password" id="mkey" name="mkey" value="<?php echo $mnotifykey; ?>" spellcheck="false" placeholder="mNotify Key"><input type="text" id="Editbox9" name="smsid" value="<?php echo $smsid; ?>" maxlength="11" spellcheck="false" placeholder="SMS ID"><div id="Html12"><?php
if($smsticket == 'on') {$checked = 'checked';} else {$checked = '';}
?><label class="switch"><input type="checkbox" name="talert" value="on" <?php echo $checked; ?>><span class="slider round"></span></label></div><div id="wb_FontAwesomeIcon9"><a href="#" onclick="myFunction1();return false;"><div id="FontAwesomeIcon9"><i class="fa fa-eye"></i></div></a></div><input type="password" id="uskey" name="ulik" value="<?php echo $uslk; ?>" spellcheck="false" placeholder="Update Server License key"><!-- PHP Timezones --><div id="Html1"><?php
$regions = array(
    'Africa' => DateTimeZone::AFRICA,
    'America' => DateTimeZone::AMERICA,
    'Antarctica' => DateTimeZone::ANTARCTICA,
    'Asia' => DateTimeZone::ASIA,
    'Atlantic' => DateTimeZone::ATLANTIC,
    'Australia' => DateTimeZone::AUSTRALIA,
    'Europe' => DateTimeZone::EUROPE,
    'Indian' => DateTimeZone::INDIAN,
    'Pacific' => DateTimeZone::PACIFIC
);
$timezones = array();
foreach ($regions as $name => $mask)
{
    $zones = DateTimeZone::listIdentifiers($mask);
    foreach($zones as $timezone)
    {
		// Lets sample the time there right now
		$time = new DateTime(NULL, new DateTimeZone($timezone));
		// Us dumb Americans can't handle millitary time
		$ampm = $time->format('H') > 12 ? ' ('. $time->format('g:i a'). ')' : '';
		// Remove region name and add a sample time
		$timezones[$name][$timezone] = substr($timezone, strlen($name) + 1) . ' - ' . $time->format('H:i') . $ampm;
	}
}
// View
print '<select name="timezone" id="tz">';
print '<option value="' . $tzone . '">' . $tzone . '-Current</option>' . "\n";
foreach($timezones as $region => $list)
{   
	print '<optgroup label="' . $region . '">' . "\n";
	foreach($list as $timezone => $name)
	{
		print '<option value="' . $timezone . '">' . $name . '</option>' . "\n";
	}
	print '</optgroup>' . "\n";
}
print '</select>';
?></div><input type="number" id="Editbox8" name="sesd" value="<?php echo $sessdur; ?>" spellcheck="false" placeholder="Session Duration in Seconds"><div id="Html5"><?php
if($purl == 'on') {$puchecked = 'checked';} else {$puchecked = '';}
?><label class="switch"><input type="checkbox" name="purl" value="on" <?php echo $puchecked; ?>><span class="slider round"></span></label></div><div id="Html7"><?php
if($acheque == 'on') {$cchecked = 'checked';} else {$cchecked = '';}
?><label class="switch"><input type="checkbox" name="acheque" value="on" <?php echo $cchecked; ?>><span class="slider round"></span></label></div><div id="Html13"><?php
if($bankpay == 'yes') {$bankchecked = 'checked';} else {$bankchecked = '';}
?><label class="switch"><input type="checkbox" name="bank" value="yes" <?php echo $bankchecked; ?>><span class="slider round"></span></label></div><div id="Html14"><?php
if($sandbox == 'on') {$schecked = 'checked';} else {$schecked = '';}
?><label class="switch"><input type="checkbox" name="sandbox" value="on" <?php echo $schecked; ?>><span class="slider round"></span></label></div><input type="text" id="Editbox18" name="domain" value="<?php echo $domain; ?>" spellcheck="false" placeholder="Site Domain Name"><input type="text" id="Editbox10" name="phone" value="<?php echo $phone; ?>" spellcheck="false" placeholder="eg. +233249679715"><div id="wb_FontAwesomeIcon2"><a href="#" onclick="myFunction3();return false;"><div id="FontAwesomeIcon2"><i class="fa fa-eye"></i></div></a></div><hr id="Line3"><hr id="Line5"><input type="number" id="Editbox15" name="mlimit" value="<?php echo $mailimit; ?>" spellcheck="false" required placeholder="Emails per Hour" min="1"><input type="password" id="skey" name="mpass" value="<?php echo $mpassword; ?>" spellcheck="false" placeholder="SMTP Password"><div id="wb_FontAwesomeIcon1"><a href="#" onclick="myFunction2();return false;"><div id="FontAwesomeIcon1"><i class="fa fa-eye"></i></div></a></div><div id="Html3"><?php
if($smtpmail == 'on') {$checked = 'checked';} else {$checked = '';}
?><label class="switch"><input type="checkbox" name="smtp" value="on" <?php echo $checked; ?>><span class="slider round"></span></label></div><input type="url" id="Editbox12" name="tt" value="<?php echo $tt; ?>" spellcheck="false" placeholder="Twitter URL"><input type="url" id="Editbox11" name="fb" value="<?php echo $fb; ?>" spellcheck="false" placeholder="Facebook URL"><div id="Html33"><?php
$dir = "locale";
/* Hide this */
$hideName = array('.','..','.DS_Store');    
// Sort in ascending order - this is default
$files = scandir($dir);
/* While this to there no more files are */
echo '<select name="locale" id="lan">';
echo '<option value="' . $locale . '">' . $locale . ' (Selected)</option>' . "\n";
foreach($files as $filename) {
    if(!in_array($filename, $hideName)){
       /* echo the name of the files */
       
  $str_explode=explode(".",$filename);
  $ffile = $str_explode[0];
  
  
  echo '<option value="' . $ffile . '">' . $ffile . '</option>' . "\n";
    
    }
}
echo '</select>';
 
 ?></div><div id="Html34"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["locale"]; ?>:</span></div><div id="Html151"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["signupet"]; ?>:</span></div><div id="Html150"><?php
$sql = "SELECT * FROM etemplates WHERE TYPE = 'signup' ";
$result = mysqli_query($link, $sql);
$yourArr = array();
while($row = mysqli_fetch_array($result))
{
    $yourArr[] = "<option value='" .$row["NAME"] . "'>" .ucwords($row["NAME"])."</option>";
}
echo '<select name="signupet" id="temp">';
echo '<option value="' . $signupet . '">'.ucwords($signupet).' (Selected)</option>' . "\n";
foreach($yourArr as $mdata) {
echo $mdata;
}
echo '</select>';
?></div><div id="Html157"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["affreject"]; ?>:</span></div><div id="Html156"><?php
$sql = "SELECT * FROM etemplates WHERE TYPE = 'paycancel' ";
$result = mysqli_query($link, $sql);
$yourArr = array();
while($row = mysqli_fetch_array($result))
{
    $yourArr[] = "<option value='" .$row["NAME"] . "'>" .ucwords($row["NAME"])."</option>";
}
echo '<select name="affreject" id="temp">';
echo '<option value="' . $affreject . '">'.ucwords($affreject).' (Selected)</option>' . "\n";
foreach($yourArr as $mdata) {
echo $mdata;
}
echo '</select>';
?></div><div id="Html15"><?php
if($perc == 'on') {$percchecked = 'checked';} else {$percchecked = '';}
?><label class="switch"><input type="checkbox" name="perc" value="on" <?php echo $percchecked; ?>><span class="slider round"></span></label></div><div id="Html17"><?php
if($cpc == 'on') {$cpcchecked = 'checked';} else {$cpcchecked = '';}
?><label class="switch"><input type="checkbox" name="cpc" value="on" <?php echo $cpcchecked; ?>><span class="slider round"></span></label></div><input type="number" id="Editbox3" name="mincash" value="<?php echo $mincash; ?>" spellcheck="false" placeholder="Minimum Cashout" min="1"><input type="number" id="Editbox7" name="cpcv" value="<?php echo $cpcv; ?>" spellcheck="false" placeholder="CPC amt" step="0.00001"><div id="Html212"><button id="save" type="submit" class="save show"><i class="fa fa-save"></i>&nbsp;&nbsp;<?php echo $lang['save_settings'];?></button><button id="saving" class="saving hide" disabled><i class="fa fa-spinner fa-pulse"></i>&nbsp;&nbsp;<?php echo $lang['pls_wait'];?></button></div><div id="Html210"><button id="save3" type="submit" class="save show"><i class="fa fa-save"></i>&nbsp;&nbsp;<?php echo $lang['save_settings'];?></button><button id="saving3" class="saving hide" disabled><i class="fa fa-spinner fa-pulse"></i>&nbsp;&nbsp;<?php echo $lang['pls_wait'];?></button></div><div id="Html209"><button id="save4" type="submit" class="save show"><i class="fa fa-save"></i>&nbsp;&nbsp;<?php echo $lang['save_settings'];?></button><button id="saving4" class="saving hide" disabled><i class="fa fa-spinner fa-pulse"></i>&nbsp;&nbsp;<?php echo $lang['pls_wait'];?></button></div><div id="Html10"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["logo"]; ?>:</span></div><div id="Html18"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["logo"]; ?>:</span></div><div id="Html19"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["timezone"]; ?>:</span></div><div id="Html20"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["preurl"]; ?>:</span></div><div id="Html21"><span style="color:#D3D3D3;font-size:13px;">Company Logo 130X90 Minimum:</span></div><div id="Html22"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["favupl"]; ?>:</span></div><div id="Html24"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["sesdur"]; ?>:</span></div><div id="Html25"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["ssl"]; ?>:</span></div><div id="Html27"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["currency"]; ?>:</span></div><div id="Html28"><span style="color:#A9A9A9;font-family:Arial;font-size:21px;"><?php echo $lang["genset"]; ?></span></div><div id="Html29"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["sitename"]; ?>:</span></div><div id="Html30"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["appdom"]; ?>:</span></div><div id="Html31"><span style="color:#A9A9A9;font-family:Arial;font-size:21px;"><?php echo $lang["payset"]; ?></span></div><div id="Html32"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["enchek"]; ?>:</span></div><div id="Html35"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["bankpay"]; ?>:</span></div><div id="Html36"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["payopt"]; ?>:</span></div><div id="Html37"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["tidp"]; ?>:</span></div><div id="Html39"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["sandbox"]; ?>:</span></div><div id="Html40"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["comv"]; ?>:</span></div><div id="Html41"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["mincashv"]; ?>:</span></div><div id="Html42"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["wdays"]; ?>:</span></div><div id="Html43"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["encpc"]; ?>:</span></div><div id="Html44"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["cpcamt"]; ?>:</span></div><div id="Html45"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["defstore"]; ?></span></div><div id="Html46"><span style="color:#A9A9A9;font-family:Arial;font-size:21px;"><?php echo $lang["smsset"]; ?></span></div><div id="Html47"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["smskey"]; ?>:</span></div><div id="Html48"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["withalert"]; ?>:</span></div><div id="Html49"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["smsid"]; ?>:</span></div><div id="Html50"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["tickalert"]; ?>:</span></div><div id="Html51"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["admifon"]; ?>:</span></div><div id="Html52"><span style="color:#A9A9A9;font-family:Arial;font-size:21px;"><?php echo $lang["socset"]; ?></span></div><div id="Html53"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["fb"]; ?>:</span></div><div id="Html54"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["tt"]; ?>:</span></div><div id="Html26"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["uslk"]; ?>:</span></div><div id="Html65"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["backfreq"]; ?>:</span></div><select name="bfreq" size="1" id="backfreq"><option value="<?php echo $bfreq; ?>"><?php if($bfreq == '3') {echo "Every 3 Days";} else if ($bfreq == '7') {echo "Every Week";} else if ($bfreq == '14') {echo "Every 2 Weeks";} else {echo "Every Month";} ?></option><option value="3">Every 3 Days</option><option value="7">Every Week</option><option value="14">Every 2 Weeks</option><option value="30">Every Month</option></select><div id="Html4"><?php
if($capcha == 'on') {$checked = 'checked';} else {$checked = '';}
?><label class="switch"><input type="checkbox" name="capcha" value="on" <?php echo $checked; ?>><span class="slider"></span></label></div><div id="Html68"><span style="color:#FF1493;font-family:Arial;font-size:13px;"><?php echo $lang["readoc"]; ?></span></div><div id="Html211"><button id="save2" type="submit" class="save show"><i class="fa fa-save"></i>&nbsp;&nbsp;<?php echo $lang['save_settings'];?></button><button id="saving2" class="saving hide" disabled><i class="fa fa-spinner fa-pulse"></i>&nbsp;&nbsp;<?php echo $lang['pls_wait'];?></button></div><div id="Html55"><span style="color:#A9A9A9;font-family:Arial;font-size:21px;"><?php echo $lang["emset"]; ?></span></div><div id="Html56"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["smtp"]; ?>:</span></div><div id="Html57"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["smtpass"]; ?>:</span></div><div id="Html58"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["mailimit"]; ?>:</span></div><div id="Html155"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["affpaid"]; ?>:</span></div><div id="Html154"><?php
$sql = "SELECT * FROM etemplates WHERE TYPE = 'payout' ";
$result = mysqli_query($link, $sql);
$yourArr = array();
while($row = mysqli_fetch_array($result))
{
    $yourArr[] = "<option value='" .$row["NAME"] . "'>" .ucwords($row["NAME"])."</option>";
}
echo '<select name="affpaid" id="temp">';
echo '<option value="' . $affpaid . '">'.ucwords($affpaid).' (Selected)</option>' . "\n";
foreach($yourArr as $mdata) {
echo $mdata;
}
echo '</select>';
?></div><div id="Html161"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["salesalert"]; ?>:</span></div><div id="Html160"><?php
$sql = "SELECT * FROM etemplates WHERE TYPE = 'sales' ";
$result = mysqli_query($link, $sql);
$yourArr = array();
while($row = mysqli_fetch_array($result))
{
    $yourArr[] = "<option value='" .$row["NAME"] . "'>" .ucwords($row["NAME"])."</option>";
}
echo '<select name="sale" id="temp">';
echo '<option value="' . $sale . '">'.ucwords($sale).' (Selected)</option>' . "\n";
foreach($yourArr as $mdata) {
echo $mdata;
}
echo '</select>';
?></div><div id="Html63"><span style="color:#A9A9A9;font-family:Arial;font-size:21px;"><?php echo $lang["misc"]; ?></span></div><div id="Html64"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["regcapt"]; ?>:</span></div><div id="Html67"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["tos"]; ?>:</span></div><div id="Html159"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["titemp"]; ?>:</span></div><div id="Html153"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["passrec"]; ?>:</span></div><div id="Html208"><button id="save5" type="submit" class="save show"><i class="fa fa-save"></i>&nbsp;&nbsp;<?php echo $lang['save_settings'];?></button><button id="saving5" class="saving hide" disabled><i class="fa fa-spinner fa-pulse"></i>&nbsp;&nbsp;<?php echo $lang['pls_wait'];?></button></div><hr id="Line6"><div id="Html158"><?php
$sql = "SELECT * FROM etemplates WHERE TYPE = 'reply' ";
$result = mysqli_query($link, $sql);
$yourArr = array();
while($row = mysqli_fetch_array($result))
{
    $yourArr[] = "<option value='" .$row["NAME"] . "'>" .ucwords($row["NAME"])."</option>";
}
echo '<select name="titemp" id="temp">';
echo '<option value="' . $titemp . '">'.ucwords($titemp).' (Selected)</option>' . "\n";
foreach($yourArr as $mdata) {
echo $mdata;
}
echo '</select>';
?></div><div id="Html152"><?php
$sql = "SELECT * FROM etemplates WHERE TYPE = 'recovery' ";
$result = mysqli_query($link, $sql);
$yourArr = array();
while($row = mysqli_fetch_array($result))
{
    $yourArr[] = "<option value='" .$row["NAME"] . "'>" .ucwords($row["NAME"])."</option>";
}
echo '<select name="passrec" id="temp">';
echo '<option value="' . $passrec . '">'.ucwords($passrec).' (Selected)</option>' . "\n";
foreach($yourArr as $mdata) {
echo $mdata;
}
echo '</select>';
?></div><textarea name="tos" id="TextArea2" rows="2" cols="149" spellcheck="false" placeholder="Terms of Service"><?php echo urldecode($tos); ?></textarea><div id="Html207"><button id="save6" type="submit" class="save show"><i class="fa fa-save"></i>&nbsp;&nbsp;<?php echo $lang['save_settings'];?></button><button id="saving6" class="saving hide" disabled><i class="fa fa-spinner fa-pulse"></i>&nbsp;&nbsp;<?php echo $lang['pls_wait'];?></button></div><textarea name="ganal" id="TextArea1" rows="1" cols="28" spellcheck="false" placeholder="Google Analytics"><?php echo urldecode($ganal); ?></textarea><div id="Html66"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["ganal"]; ?>:</span></div><hr id="Line1"><div id="Html59"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["smtphost"]; ?>:</span></div><input type="text" id="Editbox13" name="mhost" value="<?php echo $mailhost; ?>" spellcheck="false" placeholder="eg. mail.mysite.com"><div id="Html60"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["smtport"]; ?>:</span></div><input type="number" id="Editbox16" name="mport" value="<?php echo $mport; ?>" spellcheck="false" placeholder="SMTP Port Number" min="1"><input type="email" id="Editbox17" name="smail" value="<?php echo $semail; ?>" spellcheck="false" placeholder="System Email"><div id="Html62"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["semail"]; ?>:</span></div><input type="email" id="Editbox14" name="muser" value="<?php echo $musername; ?>" spellcheck="false" placeholder="SMTP Username"><div id="Html61"><span style="color:#D3D3D3;font-size:13px;"><?php echo $lang["smtpuser"]; ?>:</span></div></form></div><div id="Html38"><div style="color:#A9A9A9;font-family:Arial;font-size:24px;text-align:center;"><?php echo $lang['apset'];?></div></div></div></body></html><script>
function rev(){var element=document.getElementById("save");element.classList.remove("show");element.classList.add("hide");var element=document.getElementById("saving");element.classList.remove("hide");element.classList.add("show");var element=document.getElementById("save2");element.classList.remove("show");element.classList.add("hide");var element=document.getElementById("saving2");element.classList.remove("hide");element.classList.add("show");var element=document.getElementById("save3");element.classList.remove("show");element.classList.add("hide");var element=document.getElementById("saving3");element.classList.remove("hide");element.classList.add("show");var element=document.getElementById("save4");element.classList.remove("show");element.classList.add("hide");var element=document.getElementById("saving4");element.classList.remove("hide");element.classList.add("show");var element=document.getElementById("save5");element.classList.remove("show");element.classList.add("hide");var element=document.getElementById("saving5");element.classList.remove("hide");element.classList.add("show");var element=document.getElementById("save6");element.classList.remove("show");element.classList.add("hide");var element=document.getElementById("saving6");element.classList.remove("hide");element.classList.add("show");var element=document.getElementById("save7");element.classList.remove("show");element.classList.add("hide");}</script>