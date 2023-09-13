<?php
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
if(empty($link)){header('Location: ./admin.php'); exit;}
$sucm = "";
                    
//Send SMS when admin posts it using mNotify API
if(!empty($_POST)){
$mesg = $_POST["message"];
$phones = $_POST["phones"];
$sender_id = urlencode($smsid);
$date_time = "";

$msg1 = urlencode($mesg);
$url = "https://apps.mnotify.net/smsapi?"
            . "key=$mnotifykey"
            . "&to=$phones"
            . "&msg=$msg1"
            . "&sender_id=$sender_id"
            . "&date_time=$date_time";
$response = file_get_contents($url) ;
$sucm = 'Message Sent, Check your mNotify Account For Status, Thanks';
}
?><!doctype html><html><head><meta charset="utf-8"><title>SMS | Affiliate Me - <?php echo $version; ?></title><meta name="robots" content="noindex, nofollow"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="sms.css" rel="stylesheet"><script>
function Validatesms()
{var regexp;var TextArea1=document.getElementById('TextArea1');if(!(TextArea1.disabled||TextArea1.style.display==='none'||TextArea1.style.visibility==='hidden'))
{if(TextArea1.value=="")
{alert("You cannot send an empty message!");TextArea1.focus();return false;}}
var Editbox1=document.getElementById('Editbox1');if(!(Editbox1.disabled||Editbox1.style.display==='none'||Editbox1.style.visibility==='hidden'))
{if(Editbox1.value=="")
{alert("Please enter a value for the \"phones\" field.");Editbox1.focus();return false;}}
return true;}</script><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="footnote"><div style="color:#A9A9A9;font-family:Arial;font-size:13px; text-align:center;">Affiliate Me Version <?php echo $version; ?><br></div></div><div id="wb_Form1"><form name="sms" method="post" action="./admin.php?show=sms" id="Form1" onsubmit="return Validatesms()"><div id="Html6"><button type="submit" class="send"><i class="fa fa-paper-plane">&nbsp;</i>&nbsp;<?php echo $lang['send']; ?></button></div><textarea name="message" id="TextArea1" rows="14" cols="109" spellcheck="false"></textarea><?php
//Select phone number of users from database and fetch them into a comma seperated array for use in the text field
$sql = "SELECT * FROM users WHERE ACESS != 'zblocked' ";
$result = mysqli_query($link, $sql);
$ausers=mysqli_num_rows($result);
$yourArr = array();
$all = array();
while($row = mysqli_fetch_array($result))
{
    $yourArr[] = "<option value='" .$row["PHONE"] . "'>" .$row["USERNAME"] . "</option>";
    $all[] = $row["PHONE"];
}
$mdata = implode("<br>",$yourArr);
$mall = implode(",",$all);
echo "<datalist id=\"fone\"><option value='" .$mall . "'>All Users (Total of " .$ausers . ")</option>" .$mdata . "</datalist>";
?><input type="text" id="Editbox1" name="phones" value="" autocomplete="off" spellcheck="false" placeholder="<? echo $lang['dbclick']; ?>" list="fone"><div id="Html2"><span style="color:#DCDCDC;font-family:Arial;font-size:16px;"><?php echo $lang['dbnote']; ?></span></div><div id="Html1"><span style="color:#DCDCDC;font-family:Arial;font-size:16px;"><?php echo $lang['message']; ?></span><span style="color:#FF1493;font-family:Arial;font-size:16px;">(<?php echo $lang['longsms']; ?>)</span></div></form></div><div id="Html4"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:12px;\"><center><i class=\"fa fa-check-circle-o\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
}
?></div></div></body></html>