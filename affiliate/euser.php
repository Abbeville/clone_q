<?php
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
if(empty($link)){header('Location: ./admin.php'); exit;}
//Get username
if(isset($_GET['uid'])){
$_SESSION['cuser'] = $_GET["uid"];
}
//Use the get username to display user's data into table
$sql = "SELECT * FROM users WHERE USERNAME = '" . $_SESSION['cuser'] . "' ";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
                    $uavatar = $row['AVATAR'] ;
                    $demail = $row['EMAIL'] ;
                    $passd = $row['PASSWORD'] ;
                    $ofone = $row['PHONE'] ;



$sucm = '';
mysqli_set_charset($link, 'utf8');
if(!empty($_POST)){

$fullname = mysqli_real_escape_string($link, $_POST["name"]);
$emailad = mysqli_real_escape_string($link, $_POST["email"]);
$fone = mysqli_real_escape_string($link, $_POST["phone"]);
$paypal = mysqli_real_escape_string($link, isset($_POST['paypal']) ? $_POST['paypal'] : '');
$pass = mysqli_real_escape_string($link, $_POST["pass"]);
$conpass = mysqli_real_escape_string($link, $_POST["conpass"]);
$acess = mysqli_real_escape_string($link, $_POST["acess"]);
$website = mysqli_real_escape_string($link, $_POST["website"]);
$cheque = mysqli_real_escape_string($link, isset($_POST['cheque']) ? $_POST['cheque'] : '');
$momo = mysqli_real_escape_string($link, isset($_POST['momo']) ? $_POST['momo'] : '');

//Validate posted user data
if ($pass != $conpass)
   {
      $error_message = $lang["mispass"];
   }
   else
if (!empty($pass) && !preg_match("/^[A-Za-z0-9_&}{!@.#^%*?$]{1,50}$/", $pass))
   {
      $error_message = $lang["invpass"];
   }
   else
if (!preg_match("/^[A-Za-z0-9_!@$.' &]{1,50}$/", $fullname))
   {
      $error_message = $lang["invname"];
   }
   else
if (!preg_match("/^.+@.+\..+$/", $emailad))
   {
      $error_message = $lang["invemail"];
   }
   else
if (strlen($fone) == 0)
   {
      $error_message = $lang["nofon"];
   }
   else
if ($_SESSION['right'] != 'superadmin')
   {
      $error_message = $lang["notaderr"];
   }
if ($_SESSION['cuser'] == 'admin' && $acess != 'superadmin')
   {
      $error_message = $lang["admindown"];
   }
//Check if email has not been used, else error out
$comail=0;
$sql3="SELECT * FROM users  WHERE EMAIL = '" . $emailad . "' ";
$result=mysqli_query($link, $sql3);
$comail=mysqli_num_rows($result);
if ($comail > 0)
   {   if ($emailad != $demail) {
      $error_message = $lang["usedmail"]; }
   }

//If there are no errors, update user's data
if (empty($error_message)){

$cpass = password_hash($pass, PASSWORD_BCRYPT);
if(empty($_POST["pass"])){ $cpass = $passd ; }

$sql9 = "UPDATE users SET NAME='".$fullname."', EMAIL='".$emailad."', PHONE='".$fone."', PAYPAL='".$paypal."', PASSWORD='".$cpass."', ACESS='".$acess."', WEBSITE='".$website."', CHEQUE='".$cheque."', MOMO='".$momo."' WHERE username = '" . $_SESSION['cuser'] . "' ";
$result = mysqli_query($link, $sql9);
$sucm = $lang["setsucess"];

   }

}

//Fetch user's data from mysql and display into form again
$sql = "SELECT * FROM users WHERE USERNAME = '" . $_SESSION['cuser'] . "' ";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
                    $uavatar = $row['AVATAR'] ;
                    $demail = $row['EMAIL'] ;
                    $passd = $row['PASSWORD'] ;
                    $ofone = $row['PHONE'] ;
                    $user = $row['USERNAME'] ;
                    $name = $row['NAME'] ;
                    $country = $row['COUNTRY'] ;
                    $join = $row['DATE'] ;
                    $access = $row['ACESS'] ;
                    $ucredit = $row['CREDIT'] ;
                    $website = $row['WEBSITE'] ;
                    $paypal = $row['PAYPAL'] ;
                    $cheque = $row['CHEQUE'] ;
                    $momo = $row['MOMO'] ;

//Enable or disable payment options
$pclass = '';
$pdiss = '';
$mclass = '';
$mdiss = '';
$cclass = '';
$cdiss = '';
if($paymode == "momo")
{
$pclass = 'readonly';
$pdiss = 'disabled';
}
else
if($paymode == "paypal")
{
$mclass = 'readonly';
$mdiss = 'disabled';
}
if($acheque == "")
{
$cclass = 'readonly';
$cdiss = 'disabled';
}
?><!doctype html><html><head><meta charset="utf-8"><title>Edit <?php echo $_SESSION['cuser'] ; ?></title><meta name="robots" content="noindex, nofollow"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="euser.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="wb_Form1"><form name="settings" method="post" action="./admin.php?show=user" enctype="multipart/form-data" id="Form1"><div id="Html9"><div class="prof"><img src="<?php echo 'avatars/'. $uavatar; ?>" onerror="this.src='images/defavat.png';"></div></div><input type="text" id="Editbox1" name="username" value="<?php echo $user; ?>" disabled autocomplete="off" spellcheck="false" class="disabled"><input type="text" id="Editbox2" name="name" value="<?php echo $name; ?>" tabindex="2" spellcheck="false"><input type="email" id="Editbox3" name="email" value="<?php echo $demail; ?>" tabindex="3" spellcheck="false"><input type="text" id="Editbox4" name="phone" value="<?php echo $ofone; ?>" tabindex="4" spellcheck="false"><input type="text" id="Editbox5" name="country" value="<?php echo $country; ?>" disabled spellcheck="false" class="disabled"><input type="url" id="Editbox6" name="website" value="<?php echo $website; ?>" tabindex="5" spellcheck="false"><input type="password" id="pass" name="pass" value="" tabindex="9" spellcheck="false" onkeyup="passwordStrength(this.value)"><input type="password" id="conpass" name="conpass" value="" tabindex="10" spellcheck="false"><div id="Html2"><button type="submit" class="save"><i class="fa fa-save">&nbsp;</i>&nbsp;<?php echo $lang['save'];?></button></div><div id="Html7"><?php
$member = $join;
echo "<span style=\"color:#00BFFF;font-family:Arial;font-size:16px;\"><strong>User Became a Member ".timeAgo($member)."</strong></span>";
?></div><div id="Html6"><span style="color:#DCDCDC;font-family:Arial;font-size:16px;"><strong><?php echo $lang["balance"]; ?>: <?php echo $currsym.number_format($ucredit, 2); ?></strong></span></div><select name="acess" size="1" id="Combobox1" tabindex="1"><option selected value="<?php echo $access; ?>"><?php if($access == 'superadmin') {echo "Super Administrator ( Has Full Control of System )";} else if ($access == 'admin') {echo "Administrator ( Has Limited Control of System)";} else if ($access == 'zblocked') {echo "Blocked (User Blocked)";} else {echo "User (Has Normal User Access)";} ?></option><option value="superadmin">Super Administrator ( Has Full Control of System )</option><option value="admin">Administrator ( Has Limited Control of System)</option><option value="user">User (Has Normal User Access)</option><option value="zblocked">Blocked (User Blocked)</option></select><input type="email" id="Editbox7" name="paypal" value="<?php echo $paypal; ?>" tabindex="6" spellcheck="false" <?php echo $pclass; ?> class="<?php echo $pclass; ?>" <?php echo $pdiss; ?>><textarea name="cheque" id="TextArea1" rows="2" cols="145" tabindex="7" spellcheck="false" placeholder="Mailing address of user" <?php echo $cclass; ?> class="<?php echo $cclass; ?>" <?php echo $cdiss; ?>><?php echo $cheque; ?></textarea><input type="text" id="Editbox8" name="momo" value="<?php echo $momo; ?>" tabindex="8" spellcheck="false" placeholder="No need to worry if you the admininstrator is not in Ghana!" <?php echo $mclass; ?> class="<?php echo $mclass; ?>" <?php echo $mdiss; ?>><div id="Html4"><span style="color:#696969;font-family:Arial;font-size:13px;"><strong><?php echo $lang['user'];?>:</strong></span></div><div id="Html5"><span style="color:#D3D3D3;font-family:Arial;font-size:13px;"><strong><?php echo $lang['acess'];?>:</strong></span></div><div id="Html8"><span style="color:#D3D3D3;font-family:Arial;font-size:13px;"><strong><?php echo $lang['name'];?>:</strong></span></div><div id="Html10"><span style="color:#D3D3D3;font-family:Arial;font-size:13px;"><strong><?php echo $lang['mail'];?>:</strong></span></div><div id="Html11"><span style="color:#D3D3D3;font-family:Arial;font-size:13px;"><strong><?php echo $lang['fone'];?>:</strong></span></div><div id="Html12"><span style="color:#696969;font-family:Arial;font-size:13px;"><strong><?php echo $lang['country'];?>:</strong></span></div><div id="Html13"><span style="color:#D3D3D3;font-family:Arial;font-size:13px;"><strong><?php echo $lang['web'];?>:</strong></span></div><div id="Html15"><span style="color:#D3D3D3;font-family:Arial;font-size:13px;"><strong><?php echo $lang['checkadd'];?>: </strong></span><span style="color:#FE00FE;font-family:Arial;font-size:13px;"><strong>(<?php echo $lang['checknote'];?>)</strong></span></div><div id="Html16"><span style="color:#D3D3D3;font-family:Arial;font-size:13px;"><strong><?php echo $lang['momonu'];?>:</strong></span></div><div id="Html17"><span style="color:#D3D3D3;font-family:Arial;font-size:13px;"><strong><?php echo $lang['newpass'];?>:</strong></span></div><div id="Html18"><span style="color:#D3D3D3;font-family:Arial;font-size:13px;"><strong><?php echo $lang['confnewpass'];?>:</strong></span></div><div id="Html14"><span style="color:#D3D3D3;font-family:Arial;font-size:13px;"><strong><?php echo $lang['paypalad'];?>:</strong></span></div></form></div><div id="Html1"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:12px;\"><center><i class=\"fa fa-check-circle-o\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
}
?><?php
if($error_message !='') {
echo "<div class=\"alert2\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:12px;\"><center><i class=\"fa fa-info-circle\">&nbsp;</i><strong>" . $error_message . "</strong></center></div></div>";
}
?></div><div id="Html3"><div style="color:#A9A9A9;font-family:Arial;font-size:13px; text-align:center;">Affiliate Me Version <?php echo $version; ?><br></div></div></div></body></html>