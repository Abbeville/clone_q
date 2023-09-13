<?php if(empty($link)){header('Location: ./user.php'); exit;} 
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.

//Select user's data from database
$sql = "SELECT * FROM users WHERE USERNAME = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
                    $avatar = $row['AVATAR'] ;
                    $demail = $row['EMAIL'] ;
                    $passd = $row['PASSWORD'] ;
//Define prefix for avatar names and charset for db records
$pf = rand(111111, 999999);
$sucm = '';
mysqli_set_charset($link, 'utf8');
if(!empty($_POST) && $_POST["token"]==$token && strtolower($_SERVER['HTTP_HOST'])==strtolower(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST))){
$search = array('<','>');
$replace = array('&lt;','&gt;');

$fullname = mysqli_real_escape_string($link, str_replace($search, $replace, $_POST['name']));
$emailad = mysqli_real_escape_string($link, str_replace($search, $replace, $_POST['email']));
$fone = mysqli_real_escape_string($link, str_replace($search, $replace, $_POST['phone']));
$paypal = mysqli_real_escape_string($link, str_replace($search, $replace, isset($_POST['paypal']) ? $_POST['paypal'] : ''));
$pass = mysqli_real_escape_string($link, $_POST["pass"]);
$conpass = mysqli_real_escape_string($link, isset($_POST['conpass']) ? $_POST['conpass'] : '');
$website = mysqli_real_escape_string($link, str_replace($search, $replace, $_POST['website']));
$momo = mysqli_real_escape_string($link, str_replace($search, $replace, isset($_POST['momo']) ? $_POST['momo'] : ''));
$cheque = mysqli_real_escape_string($link, str_replace($search, $replace, isset($_POST['cheque']) ? $_POST['cheque'] : ''));
$bank = mysqli_real_escape_string($link, str_replace($search, $replace, isset($_POST['bank']) ? $_POST['bank'] : ''));
$dfa = isset($_POST['dfa']) ? $_POST['dfa'] : '';

if ($_FILES['file']['size'] > 99 && in_array(mime_type($_FILES['file']['tmp_name']), array('image/png', 'image/jpeg', 'image/gif', 'image/bmp'))) {$avatmime = 1;}
else if ($_FILES['file']['size'] > 99) {$avatmime = 0;} else {$avatmime = "";}

//Get avatar data and add prefix to it's name and upload
$fl = $_FILES['file']['name'];
$format = pathinfo($fl, PATHINFO_EXTENSION);
$avat = urlencode($pf."_".$fl);
$upl = "";
$formerr = "";
if($format != "bmp" && $format != "BMP" && $format != "gif" && $format != "GIF" && $format != "jpg" && $format != "JPG" && $format != "png" && $format != "PNG"){$formerr = 1;}
$target = "avatars/".basename($avat);
if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
$upl = "done";	}
//validate other submited form fields
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
   if ($fl != "" & ($avatmime == '0' || $formerr == '1'))
   {
      $error_message = 'Sorry, avatar is not a valid file, upload an image!';
   }
//Check if user email does not exists, else error out
$comail=0;
$sql3="SELECT * FROM users  WHERE EMAIL = '" . $emailad . "' ";
$result=mysqli_query($link, $sql3);
$comail=mysqli_num_rows($result);
if ($comail > 0)
   {   if ($emailad != $demail) {
      $error_message = $lang["usedmail"]; }
   }
//If there is an error, then delete the avatar just uploaded
if (!empty($error_message)){
$newavat = '/avatars/'.$avat;
unlink($_SERVER['DOCUMENT_ROOT'] .$newavat);
}
//If there is no error then define the directory location of the new avatar and delete the old avatar after which you can now ecrypt password and update new records of user to database
if (empty($error_message)){

if($fl == '')
{
$avat = $avatar;
}
if($upl == 'done')
{
$oldavat = '/avatars/'.$avatar;
unlink($_SERVER['DOCUMENT_ROOT'] .$oldavat);
}

$cpass = password_hash($pass, PASSWORD_BCRYPT);
if(empty($_POST["pass"])){ $cpass = $passd ; }
$sql9 = "UPDATE users SET AVATAR='".$avat."', NAME='".$fullname."', EMAIL='".$emailad."', PHONE='".$fone."', PAYPAL='".$paypal."', PASSWORD='".$cpass."', WEBSITE='".$website."', MOMO='".$momo."', CHEQUE='".$cheque."', BANK='".$bank."', DFA='".$dfa."' WHERE username = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($link, $sql9);
$sucm = $lang["setsucess"];

$sql = "SELECT * FROM users WHERE USERNAME = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);
   }

}
//Select user's data from database
                    $balance = $row['CREDIT'] ;
                    $avatar = $row['AVATAR'] ;
                    $online = $row['ONLINE'] ;
                    $phone = $row['PHONE'] ;
                    $username = $row['USERNAME'] ;
                    $demail = $row['EMAIL'] ;
                    $name = $row['NAME'] ;
                    $country = $row['COUNTRY'] ;
                    $paypal = $row['PAYPAL'] ;
                    $join = $row['DATE'] ;
                    $website = $row['WEBSITE'] ;
                    $momo = $row['MOMO'] ;
                    $cheque = $row['CHEQUE'] ;
                    $dfa = $row['DFA'] ;
                    $bank = $row['BANK'] ;
//Enable or disable payment options
$pclass = '';
$pdiss = '';
$mclass = '';
$mdiss = '';
$cclass = '';
$cdiss = '';
$bclass = '';
$bdiss = '';
if($currsym == '$' || $currsym == '€'|| $currsym == '£' || $currsym == 'R$' || $currsym == 'C$'){$paymode = "paypal";} else if ($currsym == '₵') {$paymode = "momo";}
if($currsym == '₦'){$pclass = 'readonly'; $pdiss = 'disabled'; $mclass = 'readonly'; $mdiss = 'disabled';}
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
if($bankpay == "")
{
$bclass = 'readonly';
$bdiss = 'disabled';
}
?><!doctype html><html><head><meta charset="utf-8"><title>User | Settings</title><meta name="robots" content="noindex, nofollow"><meta name="generator" content="Powerstone"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="usersettings.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="Html1"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:12px;\"><center><i class=\"fa fa-check-circle-o\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
}
?><?php
if($error_message !='') {
echo "<div class=\"alert2\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:12px;\"><center><i class=\"fa fa-info-circle\">&nbsp;</i><strong>" . $error_message . "</strong></center></div></div>";
}
?></div><div id="Html5"><script>
function passwordStrength(password)
{var desc=new Array();desc[0]="Very Weak";desc[1]="Weak";desc[2]="Better";desc[3]="Medium";desc[4]="Strong";desc[5]="Strongest";var score=0;if(password.length>4)score++;if((password.match(/[a-z]/))&&(password.match(/[A-Z]/)))score++;if(password.match(/[0-9]/))score++;if(password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))score++;if(password.length>8)score++;document.getElementById("passwordDescription").innerHTML=desc[score];document.getElementById("passwordStrength").className="strength"+score;function addclass(){var element=document.getElementById("conpass");element.classList.add("disabled");}
function removeclass(){var element=document.getElementById("conpass");element.classList.remove("disabled");}
if(document.getElementById("passwordDescription").innerHTML=='Better')settings.conpass.disabled=false;if(document.getElementById("passwordDescription").innerHTML=='Medium')settings.conpass.disabled=false;if(document.getElementById("passwordDescription").innerHTML=='Strong')settings.conpass.disabled=false;if(document.getElementById("passwordDescription").innerHTML=='Strongest')settings.conpass.disabled=false;if(document.getElementById("passwordDescription").innerHTML=='Weak')settings.conpass.disabled=true;if(document.getElementById("passwordDescription").innerHTML=='Very Weak')settings.conpass.disabled=true;if(document.getElementById("passwordDescription").innerHTML=='Better')removeclass()=true;if(document.getElementById("passwordDescription").innerHTML=='Medium')removeclass()=true;if(document.getElementById("passwordDescription").innerHTML=='Strong')removeclass()=true;if(document.getElementById("passwordDescription").innerHTML=='Strongest')removeclass()=true;if(document.getElementById("passwordDescription").innerHTML=='Weak')addclass()=true;if(document.getElementById("passwordDescription").innerHTML=='Very Weak')addclass()=true;}</script></div><div id="wb_Form1"><form name="settings" method="post" action="./user.php?show=settings" enctype="multipart/form-data" id="Form1"><input type="hidden" name="token" value="<?php echo $token; ?>"><div id="avatarcontainer"><div class="dropzone"><input accept=".bmp,.gif,.jpg,.png" title="Click to change picture" class="file" name="file" type="file" tabindex="1"><img id="profpi" src="<?php echo 'avatars/'. $avatar; ?>" onerror="this.src='images/defavat.png';"/><div class="overlay"><div class="avtext"><i class="fa fa-camera"></i> Drag an Image File Here or Click to Change (jpg, png, bmp, gif)</div></div></div></div><input type="text" id="Editbox1" name="username" value="<?php echo $username; ?>" disabled autocomplete="off" spellcheck="false" class="disabled"><input type="text" id="Editbox2" name="name" value="<?php echo $name; ?>" tabindex="2" spellcheck="false" placeholder="<?php echo $lang['fullname'];?>"><input type="email" id="Editbox3" name="email" value="<?php echo $demail; ?>" tabindex="5" spellcheck="false" placeholder="<?php echo $lang['email'];?>"><div id="Html3"><div class="pwb"><div id="passwordStrength" class="strength0"><div id="passwordDescription">No Password Detected</div></div></div></div><div id="Html7"><?php
$member = $join;
echo "<span style=\"color:#00BFFF;font-family:Arial;font-size:13px;\"><strong>You Became a Member ".timeAgo($member)."</strong></span>";
?></div><input type="text" id="Editbox5" name="country" value="<?php echo $country; ?>" disabled spellcheck="false" class="disabled"><input type="url" id="Editbox7" name="website" value="<?php echo $website; ?>" tabindex="4" spellcheck="false" placeholder="<?php echo $lang['website'];?>"><input type="password" id="pass" name="pass" value="" tabindex="10" spellcheck="false" placeholder="Password" onkeyup="passwordStrength(this.value)"><div id="Html6"><span style="color:#696969;font-family:Arial;font-size:13px;"><strong><?php echo $lang['user'];?>:</strong></span></div><div id="Html8"><span style="color:#696969;font-family:Arial;font-size:13px;"><strong><?php echo $lang['fullname'];?>:</strong></span></div><div id="Html10"><span style="color:#696969;font-family:Arial;font-size:13px;"><strong><?php echo mb_strimwidth($lang['website'], 0, 20, "...");?>:</strong></span></div><div id="Html11"><span style="color:#696969;font-family:Arial;font-size:13px;"><strong><?php echo $lang['cheque'];?>:</strong></span></div><div id="Html13"><span style="color:#696969;font-family:Arial;font-size:13px;"><strong><?php echo $lang['confnewpass'];?>:</strong></span><span style="color:#000000;font-family:Arial;font-size:13px;">(Will be </span><span style="color:#006400;font-family:Arial;font-size:13px;">active </span><span style="color:#000000;font-family:Arial;font-size:13px;">when password strength is at least &quot;Better&quot;)</span></div><div id="Html14"><span style="color:#696969;font-family:Arial;font-size:13px;"><strong><?php echo $lang['email'];?>:</strong></span></div><div id="Html15"><span style="color:#696969;font-family:Arial;font-size:13px;"><strong><?php echo $lang['country'];?>:</strong></span></div><div id="Html16"><span style="color:#696969;font-family:Arial;font-size:13px;"><strong><?php echo $lang['paypalad'];?>:</strong></span></div><div id="Html17"><span style="color:#696969;font-family:Arial;font-size:13px;"><strong><?php echo $lang['momonu'];?>:</strong></span></div><div id="dfac"><div style="color:#696969;font-family:Arial;font-size:13px;text-align:right;"><strong><?php echo $lang['dfa'];?>:</strong></div></div><textarea name="cheque" id="TextArea1" rows="2" cols="90" tabindex="8" spellcheck="true" placeholder="This should include your full name, street, town, state/country and valid postal code!" <?php echo $cclass; ?> class="<?php echo $cclass; ?>" <?php echo $cdiss; ?>><?php echo $cheque; ?></textarea><input type="email" id="Editbox6" name="paypal" value="<?php echo $paypal; ?>" tabindex="6" spellcheck="false" placeholder="eg. you@yourname.com" <?php echo $pclass; ?> class="<?php echo $pclass; ?>" <?php echo $pdiss; ?>><input type="text" id="Editbox8" name="momo" value="<?php echo $momo; ?>" tabindex="7" spellcheck="false" placeholder="eg. 0249679715 (John Doe)" <?php echo $mclass; ?> class="<?php echo $mclass; ?>" <?php echo $mdiss; ?>><div id="Html4"><span style="color:#696969;font-family:Arial;font-size:13px;"><strong><?php echo $lang['bank'];?>:</strong></span></div><div id="Html9"><span style="color:#696969;font-family:Arial;font-size:13px;"><strong><?php echo mb_strimwidth($lang['phone'], 0, 15, "...");?>:</strong></span></div><input type="text" id="Editbox4" name="phone" value="<?php echo $phone; ?>" tabindex="3" spellcheck="false" placeholder="<?php echo $lang['phone'];?>"><div id="Html2"><button type="submit" tabindex="13" class="save"><i class="fa fa-save">&nbsp;</i>&nbsp;<?php echo $lang['save'];?></button></div><textarea name="bank" id="TextArea2" rows="2" cols="90" tabindex="9" spellcheck="true" placeholder="This should include your full bank account details for bank transfer!" <?php echo $bclass; ?> class="<?php echo $bclass; ?>" <?php echo $bdiss; ?>><?php echo $bank; ?></textarea><div id="Html12"><span style="color:#696969;font-family:Arial;font-size:12px;"><strong><?php echo $lang['newpass'];?>: </strong></span><span style="color:#FF00FF;font-family:Arial;font-size:13px;"><strong>(<?php echo $lang['blank'];?>)</strong></span></div><div id="Html18"><?php
if($dfa == "yes") {$dfchecked = 'checked';} else {$dfchecked = '';}
?><label class="switch"><input type="checkbox" name="dfa" value="yes" <?php echo $dfchecked; ?> tabindex="12"><span class="slider round"></span></label></div><input type="password" id="conpass" name="conpass" value="" tabindex="11" disabled spellcheck="false" placeholder="Confirm Password" class="disabled"></form></div><div id="copyright"><div style="color:#696969;font-family:Arial;font-size:15px; text-align:center;"><?php echo "Copyright © " .$year ." " .$sitename. ", All Rights Reserved."; ?></div><br><br></div></div><script>
function readURL(input){if(input.files&&input.files[0]){var reader=new FileReader();reader.onload=function(e){$('#profpi').attr('src',e.target.result);}
reader.readAsDataURL(input.files[0]);}}
$(".file").change(function(){readURL(this);});</script></body></html>