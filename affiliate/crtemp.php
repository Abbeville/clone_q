<?php
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
if(empty($link)){header('Location: ./admin.php'); exit;}
$error_message ="";
$sucm = "";
if(!empty($_POST) && strtolower($_SERVER['HTTP_HOST'])==strtolower(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST))){
$nam = mysqli_real_escape_string($link, $_POST['name']);
$tp = $_POST['type'];
$message = mysqli_real_escape_string($link, $_POST['message']);
//Check for duplicate titles
$sql20="SELECT * FROM etemplates WHERE NAME = '" . $nam . "'";
$result=mysqli_query($link, $sql20);
$dn=mysqli_num_rows($result);
if($tp == 1){$typ = "signup";} else if($tp == 2){$typ = "recovery";} else if($tp == 3){$typ = "reply";} else if($tp == 4){$typ = "sales";} else if($tp == 5){$typ = "payout";} else if($tp == 6){$typ = "paycancel";}
   if (!preg_match("/^[A-Za-z0-9_!@$]{1,50}$/", $nam))
   {
      $error_message = "Invalid Email Name (Name must be one word)";
   }
else
   if($tp == 0)
   {
      $error_message = "Please Choose Email Type!";
   }
else
   if($dn > 0)
   {
      $error_message = "Name Already Used, Choose Another!";
   }
if (empty($error_message)){
$mysql_table= "etemplates";
$sql5 = "INSERT INTO $mysql_table (`NAME`, `TYPE`, `MESSAGE`) VALUES ('$nam', '$typ', '$message')";
$result = mysqli_query($link, $sql5);
$sucm = "Email Template Successfully Created, Go To Settings To Set It Up!";
   }
}
?><!doctype html><html><head><meta charset="utf-8"><title>Create Email Templates | Affiliate Me - <?php echo $version; ?></title><meta name="robots" content="noindex, nofollow"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="crtemp.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="Html10"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:12px;\"><center><i class=\"fa fa-check-circle-o\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
}
if($error_message !='') {
echo "<div class=\"alert2\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:12px;\"><center><i class=\"fa fa-info-circle\">&nbsp;</i><strong>" . $error_message . "</strong></center></div></div>";
}
?></div><div id="wb_Form1"><form name="Form1" method="post" action="admin.php?show=crtemp" enctype="multipart/form-data" id="Form1" onsubmit="rev();document.getElementById('Form1').submit();return false;"><input type="text" id="Editbox1" name="name" value="" autofocus spellcheck="false" required placeholder="<? echo $lang['newemnam']; ?>"><select name="type" size="1" id="options"><option value="0"><?php echo $lang['emtype']; ?></option><option value="1">Signup</option><option value="2">Password Recovery</option><option value="3">Ticket Reply Alert</option><option value="4">Affilite Sales Alert</option><option value="5">Payout Completed</option><option value="6">Payout Cancelled</option></select><div id="Html2"><div style="font-size:13px;" class="page-wrapper box-content"><textarea class="content" name="message"><?php echo $mess; ?></textarea></div><script>
$(document).ready(function(){$('.content').richText();});</script></div><div id="Html1"><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;"><strong><?php echo $lang["var"]; ?>:</strong></span><br><div class="var" id="1"><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;"><?php echo $lang['sitename']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ sitename }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['user_name']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ fullname }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['user']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ username }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['userpass']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ password }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['sysmail']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ semail }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['logo']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;"><?php echo $prot.$domain."/".$logo; ?></span></div><div class="var" id="2"><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;"><?php echo $lang['sitename']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ sitename }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['user_name']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ fullname }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['user']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ username }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['recover']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ recover }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['sysmail']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ semail }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['logo']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;"><?php echo $prot.$domain."/".$logo; ?></span></div><div class="var" id="3"><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;"><?php echo $lang['sitename']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ sitename }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['user_name']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ fullname }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['tisub']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ subject }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['tickmes']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ message }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['tid']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ ticket }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['logo']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;"><?php echo $prot.$domain."/".$logo; ?></span></div><div class="var" id="4"><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;"><?php echo $lang['sitename']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ sitename }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['user_name']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ fullname }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['cradd']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ credit }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['logo']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;"><?php echo $prot.$domain."/".$logo; ?></span></div><div class="var" id="5"><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;"><?php echo $lang['sitename']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ sitename }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['user_name']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ fullname }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['transid']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ transaction }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['logo']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;"><?php echo $prot.$domain."/".$logo; ?></span></div><div class="var" id="6"><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;"><?php echo $lang['sitename']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ sitename }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['user_name']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ fullname }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['transid']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;">{{ transaction }}</span><span style="color:#D3D3D3;font-family:Tahoma;font-size:13px;">, <?php echo $lang['logo']; ?>: </span><span style="color:#00CED1;font-family:Tahoma;font-size:13px;"><?php echo $prot.$domain."/".$logo; ?></span></div><script>
document.getElementById('options').onchange=function(){var i=1;var myDiv=document.getElementById(i);while(myDiv){myDiv.style.display='none';myDiv=document.getElementById(++i);}
document.getElementById(this.value).style.display='block';};</script></div><div id="paybut"><button id="save" type="submit show" class="butt"><i class="fa fa-save">&nbsp;</i>&nbsp;<?php echo $lang['crtemp']; ?></button><button id="saving" class="button2 hide" disabled><div class="fa fa-spinner fa-pulse"></div>&nbsp;&nbsp;<?php echo $lang['pls_wait']; ?></button><script>
function rev(){var element=document.getElementById("save");element.classList.remove("show");element.classList.add("hide");var element=document.getElementById("saving");element.classList.remove("hide");element.classList.add("show");}</script></div></form></div></div></body></html>