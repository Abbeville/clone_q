<?php
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
if(empty($link)){header('Location: ./admin.php'); exit;} 
//Define transaction id and user id when the get request is received from the form
$trid = "";
$uid = "";
if(isset($_GET['tid'])){
$trid = $_GET["tid"];
$uid = $_GET["uid"];
}
//Obtain transaction details from database using the transaction id
$sql32 = "SELECT * FROM withdrawals WHERE TRID = '" . $trid . "' ";
$result = mysqli_query($link, $sql32);
$row = mysqli_fetch_array($result);
                    $tid = $row['TRID'] ;
                    $amt = $row['AMT'] ;
                    $tdate = $row['DATE'] ;
                    $tstate = $row['STATUS'] ;
            if($row['METHOD']=='paypal'){$mmethod="<i class=\"fa fa-paypal\">&nbsp;</i>PayPal";} else if($row['METHOD']=='cheque'){$mmethod="<i class=\"fa fa-money\">&nbsp;</i>Cheque";} else if($row['METHOD']=='momo'){$mmethod="<i class=\"fa fa-money\">&nbsp;</i>MoMo";} else if($row['METHOD']=='bank'){$mmethod="<i class=\"fa fa-money\">&nbsp;</i>Bank";} else {$mmethod="<i class=\"fa fa-paypal\">&nbsp;</i>PayPal";}
            
            if($row['METHOD']=='paypal'){$address=$row['PAYPAL']; $ppl = "yes";} else if($row['METHOD']=='cheque'){$address=$row['CHEQUE']; $ppl = "";} else if($row['METHOD']=='momo'){$address=$row['MOMO']; $ppl = "";} else if($row['METHOD']=='bank'){$address=$row['CHEQUE']; $ppl = "";} else {$address=$row['PAYPAL']; $ppl = "yes";}

//Obtain customer's details from database
$sql34 = "SELECT * FROM users WHERE USERNAME = '" . $uid . "' ";
$result = mysqli_query($link, $sql34);
$row = mysqli_fetch_array($result);

                    $uphone = $row['PHONE'] ;
                    $user = $row['USERNAME'] ;
                    $email = $row['EMAIL'] ;
                    $name = $row['NAME'] ;
                    $uavatar = $row['AVATAR'] ;
                    $uonline = $row['ONLINE'] ;
                    $ubalance = $row['CREDIT'] ;
                    
//On payment successfull, alert the customer by notification and email based on admin's settings adn redirect admin to requests page
if(!empty($_GET['paid'])){
$user = $_GET['user'];
$sql35 = "SELECT * FROM users WHERE USERNAME = '" . $user . "' ";
$result = mysqli_query($link, $sql35);
$rowa = mysqli_fetch_array($result);
$fullname = $rowa['NAME'] ;
$sql101 = "UPDATE withdrawals SET STATUS='paid' WHERE TRID = '" . $_GET['paid'] . "' ";
$result = mysqli_query($link, $sql101);
$sql70 = "INSERT INTO `notes` (`USERNAME`, `MESSAGE`,`STATUS`, `DATE`, `ICON`, `LINK`) VALUES ('$user','Good news, your withdrawal request has been completed, kindly check from your account!','1','$date','check.png','user.php?show=withdraw')";
$result = mysqli_query($link, $sql70);
$email = $_GET['email'];
//Generate email
$sql9 = "SELECT * FROM etemplates WHERE NAME = '" . $affpaid . "' ";
$result = mysqli_query($link, $sql9);
$rw = mysqli_fetch_array($result);
$dbtmsg = $rw['MESSAGE'] ;

$variables = array();

$variables['sitename'] = $sitename;
$variables['fullname'] = $fullname;
$variables['transaction'] = $_GET['paid'];
$template = stripslashes($dbtmsg);
foreach($variables as $key => $value)
{
$template = str_replace('{{ '.$key.' }}', $value, $template);
}
$message = $template;
if($smtpmail == 'on') {


$subject = "Money Issued";

$body = $message;
$mail->FromName = $sitename;
$mail->addAddress($email);
$mail->Subject = $subject;
$mail->Body    = $body;
$mail->send();

} else {
$subject = "Money Issued";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From:  ' . $sitename . ' <' . $semail .'>' . " \r\n";
mail($email,$subject,$message,$headers);
}
header("Location:admin.php?show=req&paid=".$_GET['paid']."");
}
//On transaction cancelled, return the transaction amount back to user's account ballance and alert them both by notification and email
if(!empty($_GET['cancel'])){
$user = $_GET['user'];
$sql35 = "SELECT * FROM users WHERE USERNAME = '" . $user . "' ";
$result = mysqli_query($link, $sql35);
$rowa = mysqli_fetch_array($result);
$fullname = $rowa['NAME'] ;
$ubalance = $_GET['ubalance'];
$amt = $_GET['amt'];
$sql101 = "UPDATE withdrawals SET STATUS='cancelled' WHERE TRID = '" . $_GET['cancel'] . "' ";
$result = mysqli_query($link, $sql101);
$sql70 = "INSERT INTO `notes` (`USERNAME`, `MESSAGE`,`STATUS`, `DATE`, `ICON`, `LINK`) VALUES ('$user','Sorry, your withdrawal request has been cancelled, and your funds returned!','1','$date','alert.png','user.php?show=withdraw')";
$result = mysqli_query($link, $sql70);

$newbalance = $ubalance + $amt;

$sql68 = "UPDATE users SET CREDIT='" . $newbalance . "' WHERE USERNAME = '" . $user . "' ";
$result = mysqli_query($link, $sql68);

$email = $_GET['email'];
//send email
$sql9 = "SELECT * FROM etemplates WHERE NAME = '" . $affreject . "' ";
$result = mysqli_query($link, $sql9);
$rw = mysqli_fetch_array($result);
$dbtmsg = $rw['MESSAGE'] ;

$variables = array();

$variables['sitename'] = $sitename;
$variables['fullname'] = $fullname;
$variables['transaction'] = $_GET['cancel'];
$template = stripslashes($dbtmsg);
foreach($variables as $key => $value)
{
$template = str_replace('{{ '.$key.' }}', $value, $template);
}
$message = $template;
if($smtpmail == 'on') {


$subject = "Payment Cancelled";

$body = $message;
$mail->FromName = $sitename;
$mail->addAddress($email);
$mail->Subject = $subject;
$mail->Body    = $body;
$mail->send();

} else {
$subject = "Payment Cancelled";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From:  ' . $sitename . ' <' . $semail .'>' . " \r\n";
mail($email,$subject,$message,$headers);
}
header("Location:admin.php?show=req&cancel=".$_GET['cancel']."");
}
//Define Currencies
if($currsym == '$') {$curr="USD";}
else
if ($currsym == '€') {$curr="EUR";}
else
if ($currsym == '£') {$curr="GBP";}
else
if ($currsym == 'R$') {$curr="BRL";}
else
{$curr="CAD";}
$return = $prot . $domain . "/admin.php?show=proccess&paid=".$tid."&user=".$user."&email=".$email;
$cancel = $prot . $domain . "/admin.php?show=req";
?><!doctype html><html><head><meta charset="utf-8"><title>Process | Affiliate Me</title><meta name="robots" content="noindex, nofollow"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="process.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="Html2"><div style="color:#A9A9A9;font-family:Arial;font-size:13px; text-align:center;">Affiliate Me Version <?php echo $version; ?><br></div></div><div id="Layer1"><div id="Html6"><span style="color:#C0C0C0;font-size:16px;"><strong><?php echo $lang["transid"]; ?>: </strong><span style="color:#FFFFFF;"><?php echo $tid; ?></span><br><br><strong><?php echo $lang["withamt"]; ?>: </strong><span style="color:#FFFFFF;"><?php echo $currsym. number_format($amt); ?></span><br><br><strong><?php echo $lang["method"]; ?>: </strong><span style="color:#FFFFFF;"><?php echo $mmethod; ?></span><br><br><strong><?php echo $lang["payad"]; ?>: </strong><span style="color:#FFFFFF;"><?php echo $address; ?></span><br><br><strong><?php echo $lang["date"]; ?>: </strong><span style="color:#FFFFFF;"><?php echo $tdate; ?></span><br><br><strong><?php echo $lang["status"]; ?>: </strong><span style="color:#FFFFFF;"><?php echo $tstate; ?></span></span></div><div id="Html8"><div class="procontainer2"><img src="<?php echo 'avatars/'. $uavatar; ?>" onerror="this.src='images/defavat.png';"></div></div><div id="Html4"><span style="color:#C0C0C0;font-size:15px;"><strong><?php echo $lang["user"]; ?>: </strong><?php echo $user; ?><br><br><strong><?php echo $lang["name"]; ?>: </strong><?php echo $name; ?><br><br><strong><?php echo $lang["fone"]; ?>: </strong><?php echo $uphone; ?><br><br><strong><?php echo $lang["bal"]; ?>: </strong><?php echo $currsym.$ubalance; ?></span></div><div id="Html9"><?php
    $ut1 = $time;
    $ut2 = $uonline;
    $ulast = ($ut1 - $ut2);
    ?><?php if($ulast < '406') echo "<span class=\"pulse\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><span style=\"color:#32CD32;\">Online</span></strong></span>" ; else echo "<span class=\"offline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Offline</strong></span>" ; ?></div><div id="Html11"><?php if($tstate == 'pending') {echo "<a href=\"#\" onclick=\"if(confirm('You are about to cancel transaction " .$tid. ", there is no reverse after this is done, are you sure you wish to proceed?')){window.location.href='./admin.php?show=proccess&cancel=".$tid."&user=".$user."&email=".$email."&ubalance=".$ubalance."&amt=".$amt."';}else{return false;};\"> <bu class=\"can\"><i class=\"fa fa-times-circle\">&nbsp;</i>".$lang['canwith']."</bu></a>";} ?></div><div id="Html1"><?php 
if($sandbox == 'on'){$action = "https://www.sandbox.paypal.com/cgi-bin/webscr";} else {$action = "https://www.paypal.com/cgi-bin/webscr";}
if($tstate == 'pending' && $ppl == 'yes')
{
echo '<form name="PayPal1_form" method="post" action="'.$action.'" >
<input type="hidden" name="business" value="'. $address .'">
<input type="hidden" name="amount" value="'.$amt.'">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="item_name" value="Affiliate Withdrawal">
<input type="hidden" name="item_number" value="'.$tid.'">
<input type="hidden" name="currency_code" value="'.$curr.'">
<input type="hidden" name="return" value="'.$return.'">
<input type="hidden" name="cancel_return" value="'.$cancel.'">
<input type="hidden" name="undefined_quantity" value="0">
<input type="hidden" name="receiver_email" value="'.$address.'">
<input type="hidden" name="no_shipping" value="0">
<input type="hidden" name="no_note" value="1">
<button type="submit" class="pay"><i class="fa fa-paypal">&nbsp;</i>&nbsp;&nbsp;'.$lang["pay"].' '.$currsym.$amt.' </button>
</form>';
}
else
if($tstate == 'pending' && $ppl == '')
{
echo '<a href="'.$return.'"><button type="submit" class="pay"><i class="fa fa-money">&nbsp;</i>&nbsp;&nbsp;'.$lang["mark"].' </button></a>';
}
?></div><div id="Html3"><?php
if($ppl == 'yes')
{
echo '<span style="color:#FFC0CB;font-family:Arial;font-size:16px;"><strong>Important:</strong> '.$lang["ppnote"].'</span>';
}
else
{
echo '<span style="color:#FFC0CB;font-family:Arial;font-size:16px;"><strong>Important:</strong> '.$lang["chnote"].'</span>';
}
?></div><div id="Html5"><?php
if($ppl == 'yes' && $sandbox == 'on')
{
echo '<span style="color:#FF1493;font-family:Arial;font-size:16px;"><strong>PayPal Sandbox is on!!!</strong></span>';
}
?></div><div id="Html7"><div style="color:#D3D3D3;font-family:Arial;font-size:21px;text-align:center;"><strong><?php echo $lang["withdet"]; ?></strong></div></div><div id="Html10"><span style="color:#D3D3D3;font-family:Arial;font-size:15px;"><strong><?php echo $lang["usdet"]; ?></strong></span></div></div></div></body></html>