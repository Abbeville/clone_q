<?php if(empty($link)){header('Location: ./user.php'); exit;} 
//Define search query
 $search = mysqli_real_escape_string($link, isset($_GET['id']) ? $_GET['id'] : '');
 $sucm ='';
$sucm ='';
$error_message ='';
//Select user's data from database
$sql = "SELECT * FROM users WHERE USERNAME = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);

                    $balance = $row['CREDIT'] ;
                    $avatar = $row['AVATAR'] ;
                    $online = $row['ONLINE'] ;
                    $phone = $row['PHONE'] ;
                    $username = $row['USERNAME'] ;
                    $paypal = $row['PAYPAL'] ;
                    $cheque = $row['CHEQUE'] ;
                    $momo = $row['MOMO'] ;
                    $bank = $row['BANK'] ;

if(!empty($_POST) && $_POST["token"]==$token && strtolower($_SERVER['HTTP_HOST'])==strtolower(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST))){
//Processing withdrawal cancellation
$tid = $_POST["id"];
$sql8 = "SELECT * FROM withdrawals WHERE TRID = '" . $tid . "' AND STATUS='pending' ";
$result = mysqli_query($link, $sql8);
$row = mysqli_fetch_array($result);
$ret = $row['AMT'] ;
$newbalance = $balance + $ret;

$sql67 = "UPDATE withdrawals SET STATUS='cancelled' WHERE TRID = '" . $tid . "' AND username = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($link, $sql67);
$sql68 = "UPDATE users SET CREDIT='" . $newbalance . "' WHERE USERNAME = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($link, $sql68);
$sucm ="Transaction ".$tid." funds sucessfully added back to your earnings";
$balance = $newbalance;

}

//Validating & Processing withdrawal
if(!empty($_GET['amt'])){
if($_GET['option'] == 'paypal') {$payout = $paypal;} else if($_GET['option'] == 'cheque') {$payout = $cheque;} else if($_GET['option'] == 'momo') {$payout = $momo;} else if($_GET['option'] == 'bank') {$payout = $bank; $cheque = $bank;}
$method = $_GET['option'];
if (!preg_match("/^[0.0-9.0]{1,50}$/", $_GET['amt'])) {$error_message = "Sorry, only numbers are allowed, kindly remove all other characters!";} else
if($mincash > $_GET['amt']) {$error_message = "The minimum withdrawal amount should not be less than ". $currsym . $mincash ."!";} else
if($balance < $_GET['amt']) {$error_message = "Sorry, you do not have enough balance, your current balance is ". $currsym . $balance ."!";} else
if($payout == '') {$error_message = "Sorry, please kindly go to Account settings and add your valid payout option details and come back to try again!";}
if (empty($error_message)){

$amt = mysqli_real_escape_string($link, $_GET['amt']);
$nbalance = $balance - $amt;
$sql67 = "UPDATE users SET CREDIT='" . $nbalance . "' WHERE username = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($link, $sql67);
$trid = $trprefix . time();
$sql2 = "INSERT INTO `withdrawals` (`USERNAME`, `TRID`, `AMT`, `PAYPAL`, `STATUS`, `DATE`, `CHEQUE`, `MOMO`, `METHOD`) VALUES 
('$username','$trid','$amt','$paypal','pending','$date','$cheque','$momo','$method')";
$result = mysqli_query($link, $sql2);

$sucm = $lang["withque"];
$balance = $nbalance;

//Sending an alert to admin about the withdrawal
$subject = "A new withdrawal request";
$message = "Hello, please you just received a new withdrawal request from ". $username .", kindly log into your affiliate dashboard to respond to this request, thanks.";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From:  ' . $sitename . ' <noreply@powerstonegh.com>' . " \r\n";
mail($semail,$subject,$message,$headers);
//If SMS alert withdrawal is on, then send SMS to admin
if($smswithdrawal == 'on') {
$msg = "You just received a withdrawal request from your affiliate " . $username . " for the amount of " . $currsym . $amt . " kindly log in to respond!";
$sender_id = "New+Rqst";
$date_time = "";
$msg1 = urlencode($msg);
$url = "https://apps.mnotify.net/smsapi?"
            . "key=$mnotifykey"
            . "&to=$phone"
            . "&msg=$msg1"
            . "&sender_id=$sender_id"
            . "&date_time=$date_time";
$response = file_get_contents($url) ;
      }
   }
}
?><!doctype html><html><head><meta charset="utf-8"><title>User | Withdraw Funds</title><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="font-awesome.min.css" rel="stylesheet"><link href="withdraw.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="wb_Form1"><form name="Form1" method="get" action="./user.php" id="Form1"><input type="hidden" name="show" value="withdraw"><input type="text" id="Editbox1" name="amt" value="" spellcheck="false" required placeholder="<?php echo $lang['mincash'];?> <?php echo $mincash; ?>"><div id="Html8"><button type="submit" class="cash"><i class="fa fa-money">&nbsp;</i>&nbsp;<?php echo $lang['withdraw'];?></button></div><div id="Html1"><?php
if($currsym == '$' || $currsym == '€'|| $currsym == '£' || $currsym == 'R$' || $currsym == 'C$'){$paymode = "paypal";} else if ($currsym == '₵') {$paymode = "momo";}
if($paymode == "paypal"){
echo '<input type="radio" id="paypal" name="option" value="paypal" required><label for="paypal" id="label">'.$lang["withpaypal"].'</label>&nbsp;&nbsp;';
} else 
if($paymode == "momo"){
echo '<input type="radio" id="momo" name="option" value="momo" required><label for="momo" id="label2">'.$lang["withmomo"].'</label>&nbsp;&nbsp;';
}
if($acheque == "on"){
echo '<input type="radio" id="cheque" name="option" value="cheque" required><label for="cheque" id="label3">'.$lang["withcheque"].'</label>';
}
if($bankpay == "yes"){
echo '<input type="radio" id="bank" name="option" value="bank" required><label for="bank" id="label4">'.$lang["withbank"].'</label>';
}
?></div><div id="Html3"><span style="color:#1E90FF;font-family:Arial;font-size:19px;"><?php echo $lang['withmuch'];?>:</span></div></form></div><div id="Html9"><?php
$record_per_page = 15;
$page = '';
if(isset($_GET["page"]))
{
 $page = $_GET["page"];
}
else
{
 $page = 1;
}

$start_from = ($page-1)*$record_per_page;
     
   // Attempt select query execution
    $sql12 = "SELECT * FROM withdrawals WHERE username = '" . $_SESSION['username'] . "' && `TRID` LIKE '%$search%' ORDER BY id DESC LIMIT $start_from, $record_per_page";
//Echo results from database into table
    if($result = mysqli_query($link, $sql12)){
        if(mysqli_num_rows($result) > 0){
 echo "<div class='nuser'> <span style=\"color:#696969;font-family:Arial;font-size:16px;\">&nbsp;<i class=\"fa fa-money\">&nbsp;</i> ".$lang['withis']."</span> <br><br>";
    echo "<table id='myTable' width=\"100%\" cellpadding=\"2\" cellsapcing =\"2\">";
        echo "<thead>";
           echo "<tr>";
                
                    
                    
                    echo "<th class='nomob'>".strtoupper($lang['transid'])."</th>";
                    
                    echo "<th>".strtoupper($lang['amount'])."</th>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['method'])."</td>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['payto'])."</th>";
                    
                    echo "<th>".strtoupper($lang['status'])."</td>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['action'])."</th>";
                    
                    echo "<th>".strtoupper($lang['support'])."</th>";
                    
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
            while($row = mysqli_fetch_array($result)){
            
            if($row['METHOD']=='paypal'){$mmethod="<i class=\"fa fa-paypal\">&nbsp;</i>PayPal";} else if($row['METHOD']=='cheque'){$mmethod="<i class=\"fa fa-money\">&nbsp;</i>Cheque";} else if($row['METHOD']=='momo'){$mmethod="<i class=\"fa fa-money\">&nbsp;</i>MoMo";} else if($row['METHOD']=='bank'){$mmethod="<i class=\"fa fa-money\">&nbsp;</i>Bank";} else {$mmethod="<i class=\"fa fa-paypal\">&nbsp;</i>PayPal";}
            
            if($row['METHOD']=='paypal'){$address=$row['PAYPAL'];} else if($row['METHOD']=='cheque'){$address=$row['CHEQUE'];} else if($row['METHOD']=='momo'){$address=$row['MOMO'];} else if($row['METHOD']=='bank'){$address=$row['CHEQUE'];} else {$address=$row['PAYPAL'];}
            
                echo "<tr>";
                
                    echo "<td class='nomob'>" . $row['TRID'] . "</td>";
                    
                    echo "<td>" . $currsym . $row['AMT'] . "</td>";
                    
                    echo "<td class='nomob'>" . $mmethod . "</td>";
                    echo "<td class='nomob'>" . mb_strimwidth(strip_tags($address), 0, 14, "...") . "</td>";
                    
                    if($row['STATUS'] == 'pending') {echo "<td><span style=\"color:#1E90FF;\"><div class=\"fa fa-refresh fa-spin\"></div>&nbsp;Pending</span></td>";} else if($row['STATUS'] == 'cancelled') {echo "<td><span style=\"color:#FF00FF;\"><div class=\"fa fa-times-circle\"></div>&nbsp;".$lang['cancelled']."</span></td>";} else if($row['STATUS'] == 'paid') {echo "<td><span style=\"color:#32CD32;\"><div class=\"fa fa-check-circle\"></div>&nbsp;<strong>".$lang['paid']."</strong></span></td>";}
                    
                    if($row['STATUS'] == 'pending') {echo "<td class='nomob'><form name=\"form\" method=\"post\" action=\"./user.php?show=withdraw\"><input type=\"hidden\" name=\"token\" value=". $token ."><input type=\"hidden\" name=\"id\" value=". $row['TRID'] ."><button class=\"button2\"><i class=\"fa fa-times-circle\">&nbsp;</i>&nbsp;".$lang['cancel']."</button></form></td>"; } else { echo "<td class='nomob'><button class=\"button3\"><i class=\"fa fa-times-circle\">&nbsp;</i>&nbsp;".$lang['cancel']."</button></td>"; }
                    
                    echo "<td><form name=\"form\" method=\"get\" action=\"./user.php\"><input type=\"hidden\" name=\"show\" value=\"message\"><input type=\"hidden\" name=\"subj\" value='My ticket is about Transaction ID#". $row['TRID'] ."'><button class=\"button1\"><i class=\"fa fa-comments\">&nbsp;</i></button></form></td>";
                    
                echo "</tr>";
            }
    echo "</tbody>";
            echo "</table></div>";
            // Close result set
            mysqli_free_result($result);
        } else{
            echo "<br><br><span style=\"color:#FF1493;font-family:Arial;font-size:18px;\"><strong><br><center>Sorry No Withdrawal History!<br><br><br><br></center></strong></span>";
        }
    } 

    echo "<div class = 'nav'>";
            
    $page_query = "SELECT * FROM withdrawals WHERE USERNAME = '" . $_SESSION['username'] . "' && `TRID` LIKE '%$search%' ";
    $page_result = mysqli_query($link, $page_query);
    $total_records = mysqli_num_rows($page_result);
    $total_pages = ceil($total_records/$record_per_page);
    $start_loop = $page;
    $difference = $total_pages - $page;
    if($total_pages - 1 < 5){$diff = $total_pages-1;} else {$diff = 5;}
    if($difference <= 5)
    {
     $start_loop = $total_pages - $diff;
    }
    $end_loop = $start_loop + $diff;
    if($total_records>$record_per_page) {
    if($page > 1)
    {
     echo "<a href='user.php?show=withdraw&page=1' class='pg'>First</a>";
     echo "<a href='user.php?show=withdraw&page=".($page - 1)."' class='pg'><<</a>";
    }
    for($i=$start_loop; $i<=$end_loop; $i++)
    {   if($i==$page){$cl="pgd";} else {$cl="pg";}    
     echo "<a href='user.php?show=withdraw&page=$i' class='".$cl."'>".$i."</a>";
    }
    if($page < $end_loop)
    {
     echo "<a href='user.php?show=withdraw&page=".($page + 1)."' class='pg'>>></a>";
     echo "<a href='user.php?show=withdraw&page=".$total_pages."' class='pg'>Last</a>";
    }
    }
    echo "</div>";
    ?><br><br><div style="color:#696969;font-family:Arial;font-size:15px; text-align:center;"><?php echo "Copyright © " .$year ." " .$sitename. ", All Rights Reserved."; ?></div><br><br></div><div id="Html2"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:12px;\"><center><i class=\"fa fa-check-circle-o\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
}
?><?php
if($error_message !='') {
echo "<div class=\"alert2\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:12px;\"><center><i class=\"fa fa-info-circle\">&nbsp;</i><strong>" . $error_message . "</strong></center></div></div>";
}
?></div><div id="wb_Form2"><form name="Form1" method="get" action="./user.php" enctype="text/plain" id="Form2"><input type="hidden" name="show" value="withdraw"><input type="text" id="Editbox2" name="id" value="" spellcheck="false" placeholder="<?php echo $lang['searchid']; ?>"><div id="wb_sicon"><a href="#" onclick="document.getElementById('Form2').submit();return false;"><div id="sicon"><i class="fa fa-search"></i></div></a></div></form></div><div id="Html4"><div style="color:#A9A9A9;font-family:Arial;font-size:19px;text-align:center;"><?php echo $lang['withis'];?></div></div><div id="Html5"><div style="color:#1E90FF;font-family:Arial;font-size:13px;"><?php echo $lang['withmuch'];?>:</div></div></div></body></html>