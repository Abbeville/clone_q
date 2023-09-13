<?php
// Powerstone Affiliate Me, Version 5.0.1 https://www.powerstonegh.com.
include "db.php";
if(empty($dbserver)){header('Location: /index.php'); exit;}
date_default_timezone_set($tzone);
$time = time();
$link = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbdatabase);

//Generate session token
session_start();
if(empty($_SESSION["token"])){$_SESSION["token"]=rand(11111, 99999);}
$token = $_SESSION["token"];

//Check for activation key
$actcode = mysqli_real_escape_string($link, $_GET['activate']);
$sql4="SELECT * FROM users WHERE RKEY = '" . $actcode . "' ";
$result=mysqli_query($link, $sql4);
$emp=mysqli_num_rows($result);
if( empty($actcode) || $emp == 0)
{
exit('Activation expired!');
}
$error_message = '';
$sucm = '';
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
mysqli_set_charset($link,"utf8");
if(!empty($_POST) && $_POST["token"]==$token && strtolower($_SERVER['HTTP_HOST'])==strtolower(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST))){
$password = mysqli_real_escape_string($link, $_POST['password']);
$confirmpassword = mysqli_real_escape_string($link, isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : '');
//validate submitted data from form
   if ($password != $confirmpassword)
   {
      $error_message = $lang["mispass"];
   }
   else
   if (!preg_match("/^[A-Za-z0-9_&}{!@.#^%*?$]{1,50}$/", $password))
   {
      $error_message = $lang["invpass"];
   }
if (empty($error_message)){
$cpass = password_hash($password, PASSWORD_BCRYPT);
$mysql_table = "users";
$sql100 = "UPDATE users SET PASSWORD='" . $cpass . "' WHERE RKEY = '" . $actcode . "' ";
$result = mysqli_query($link, $sql100);
$sucm = $lang["paschange"];
   }
}
?><!doctype html><html><head><meta charset="utf-8"><title><?php echo $lang["change_pass"];?></title><meta name="robots" content="noindex, nofollow"><meta name="generator" content="Powerstone"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="reset.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script><script src="wwb14.min.js"></script><link href="font-awesome.min.css" rel="stylesheet"><link href="<?php echo $favicon; ?>" rel="shortcut icon" type="image/x-generic"><?php echo urldecode($ganal); ?></head><body><div id="container"><div id="Html5"><script>
function passwordStrength(password)
{var desc=new Array();desc[0]="Very Weak";desc[1]="Weak";desc[2]="Better";desc[3]="Medium";desc[4]="Strong";desc[5]="Strongest";var score=0;if(password.length>4)score++;if((password.match(/[a-z]/))&&(password.match(/[A-Z]/)))score++;if(password.match(/[0-9]/))score++;if(password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))score++;if(password.length>8)score++;document.getElementById("passwordDescription").innerHTML=desc[score];document.getElementById("passwordStrength").className="strength"+score;function addclass(){var element=document.getElementById("confirmpassword");element.classList.add("disabled");}
function removeclass(){var element=document.getElementById("confirmpassword");element.classList.remove("disabled");}
if(document.getElementById("passwordDescription").innerHTML=='Better')signupform.confirmpassword.disabled=false;if(document.getElementById("passwordDescription").innerHTML=='Medium')signupform.confirmpassword.disabled=false;if(document.getElementById("passwordDescription").innerHTML=='Strong')signupform.confirmpassword.disabled=false;if(document.getElementById("passwordDescription").innerHTML=='Strongest')signupform.confirmpassword.disabled=false;if(document.getElementById("passwordDescription").innerHTML=='Weak')signupform.confirmpassword.disabled=true;if(document.getElementById("passwordDescription").innerHTML=='Very Weak')signupform.confirmpassword.disabled=true;if(document.getElementById("passwordDescription").innerHTML=='Better')removeclass()=true;if(document.getElementById("passwordDescription").innerHTML=='Medium')removeclass()=true;if(document.getElementById("passwordDescription").innerHTML=='Strong')removeclass()=true;if(document.getElementById("passwordDescription").innerHTML=='Strongest')removeclass()=true;if(document.getElementById("passwordDescription").innerHTML=='Weak')addclass()=true;if(document.getElementById("passwordDescription").innerHTML=='Very Weak')addclass()=true;}</script></div><div id="Html1"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:16px;\"><center><i class=\"fa fa-check-circle-o\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
echo "<script type=\"text/javascript\">
var wait=setTimeout(\"location.href='index.php';\",7000);</script>";
}
?><?php
if($error_message !='') {
echo "<div class=\"alert2\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:14px;\"><center><i class=\"fa fa-info-circle\">&nbsp;</i><strong>" . $error_message . "</strong></center></div></div>";
}
?></div><div id="Html10"><span style="color:#696969;font-family:Arial;font-size:15px;"><center><?php $cyear = date("Y"); echo "Copyright © " .$cyear ." " .$sitename. ", All Rights Reserved."; ?></center></span></div><div id="wb_Form1"><form name="signupform" method="post" action="./reset.php?activate=<?php echo $actcode; ?>" id="Form1" onsubmit="ShowObject('Html2', 1);ShowObject('Html11', 0);document.getElementById('Form1').submit();return false;"><input type="hidden" name="token" value="<?php echo $token; ?>"><input type="password" id="password" name="password" value="" tabindex="3" spellcheck="false" placeholder="<?php echo$lang['newpass'];?>" onkeyup="passwordStrength(this.value)"><input type="password" id="confirmpassword" name="confirmpassword" value="" tabindex="4" disabled spellcheck="false" placeholder="<?php echo $lang['copass'];?>" class="disabled"><div id="Html3"><div class="pwb"><div id="passwordStrength" class="strength0"><div id="passwordDescription">No Password Detected</div></div></div></div><div id="Html7"><div style="color:#1E90FF;font-family:Arial;font-size:17px;text-align:center;"><strong><?php echo $lang["change_pass"];?></strong></div></div><div id="Html8"><div style="color:#808080;font-family:Arial;font-size:9.3px;text-align:center;"><?php echo $lang['passmeter'];?></div></div><div id="Html2"><but class="button2" disabled><div class="fa fa-spinner fa-pulse"></div>&nbsp;&nbsp;Resetting...</but></div><div id="Html11"><button type="submit" class="button"><i class="fa fa-lock">&nbsp;</i>&nbsp;&nbsp;<?php echo $lang["change_pass"];?></button></div><div id="Html9"><div class="logo"><a href="./"><img src="<?php echo $logo; ?>" alt="Logo"></a></div></div></form></div></div></body></html>