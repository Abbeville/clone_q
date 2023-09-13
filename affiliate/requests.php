<?php
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
$sucm = "";
if(empty($link)){header('Location: ./admin.php'); exit;} 
$search = mysqli_real_escape_string($link, isset($_GET['id']) ? $_GET['id'] : '');
//Function to alert admin on payment successfull
if(!empty($_GET['paid'])){
$sucm = "Transaction ".$_GET['paid']." has been paid successfully!";
}
//Function to alert admin on payment cancelled
if(!empty($_GET['cancel'])){
$error_message = "Transaction ".$_GET['cancel']." has been cancelled!";
}
?><!doctype html><html><head><meta charset="utf-8"><title>Requests | Affiliate Me</title><meta name="robots" content="noindex, nofollow"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="font-awesome.min.css" rel="stylesheet"><link href="requests.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="Html6"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:13px;\"><center><i class=\"fa fa-check-circle-o\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
}
?><?php
if($error_message !='') {
echo "<div class=\"alert2\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:13px;\"><center><i class=\"fa fa-info-circle\">&nbsp;</i><strong>" . $error_message . "</strong></center></div></div>";
}
?></div><div id="Html2"><?php
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
    $sql12 = "SELECT * FROM withdrawals WHERE `TRID` LIKE '%$search%' ORDER BY id DESC LIMIT $start_from, $record_per_page";
    if($result = mysqli_query($link, $sql12)){
        if(mysqli_num_rows($result) > 0){
 echo "<div class='nuser'> <span style=\"color:#D3D3D3;font-family:Arial;font-size:16px;\">&nbsp;<i class=\"fa fa-money\">&nbsp;</i>".$lang['paylist']."</span> <br><br>";
    echo "<table id='myTable' width=\"100%\" cellpadding=\"2\" cellsapcing =\"2\">";
        echo "<thead>";
           echo "<tr>";
                
                    
                    
                    echo "<th class='nomob'>".strtoupper($lang['transid'])."</th>";
                    
                    echo "<th>".strtoupper($lang['amount'])."</th>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['method'])."</th>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['payto'])."</th>";
                    echo "<th class='nomob'>".strtoupper($lang['date'])."</td>";
                    
                    echo "<th>".strtoupper($lang['status'])."</td>";
                    
                    echo "<th>".strtoupper($lang['process'])."</th>";
                    
                    
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
                    
                    echo "<td class='nomob'>" . $row['DATE'] . "</td>";
                    
                    if($row['STATUS'] == 'pending') {echo "<td><cr><strong>NEW REQUEST!</strong></cr></td>";} else if($row['STATUS'] == 'cancelled') {echo "<td><span style=\"color:#FF00FF;\"><div class=\"fa fa-times-circle\"></div>&nbsp;Cancelled</span></td>";} else if($row['STATUS'] == 'paid') {echo "<td><span style=\"color:#32CD32;\"><div class=\"fa fa-check-circle\"></div>&nbsp;<strong>Paid</strong></span></td>";}
                    
                    echo "<td><form name=\"form\" method=\"get\" action=\"./admin.php\"><input type=\"hidden\" name=\"show\" value='proccess'><input type=\"hidden\" name=\"tid\" value='". $row['TRID'] ."'><input type=\"hidden\" name=\"uid\" value='". $row['USERNAME'] ."'><button class=\"button1\"><i class=\"fa fa-eye\">&nbsp;</i></button></form></td>";
                    
                echo "</tr>";
            }
    echo "</tbody>";
            echo "</table></div>";
            // Close result set
            mysqli_free_result($result);
        } else{
            echo "<br><br><span style=\"color:#FF1493;font-family:Arial;font-size:18px;\"><strong><br><center>".$lang['nowith']."<br><br><br><br></center></strong></span>";
        }
    } 

   echo "<div class = 'nav'>";
            
    $page_query = "SELECT * FROM withdrawals WHERE `TRID` LIKE '%$search%' ORDER BY id DESC";
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
     echo "<a href='admin.php?show=req&page=1' class='pg'>First</a>";
     echo "<a href='admin.php?show=req&page=".($page - 1)."' class='pg'><<</a>";
    }
    for($i=$start_loop; $i<=$end_loop; $i++)
    {   if($i==$page){$cl="pgd";} else {$cl="pg";}    
     echo "<a href='admin.php?show=req&page=$i' class='".$cl."'>".$i."</a>";
    }
    if($page < $end_loop)
    {
     echo "<a href='admin.php?show=req&page=".($page + 1)."' class='pg'>>></a>";
     echo "<a href='admin.php?show=req&page=".$total_pages."' class='pg'>Last</a>";
    }
    }
    echo "</div>";
    ?><br><div style="color:#A9A9A9;font-family:Arial;font-size:13px; text-align:center;">Affiliate Me Version <?php echo $version; ?><br><br></div></div><div id="wb_Form2"><form name="Form1" method="get" action="./admin.php" enctype="text/plain" id="Form2"><input type="hidden" name="show" value="req"><input type="text" id="Editbox2" name="id" value="" spellcheck="false" placeholder="<?php echo $lang['searchtran']; ?>"><div id="wb_sicon"><a href="#" onclick="document.getElementById('Form2').submit();return false;"><div id="sicon"><i class="fa fa-search"></i></div></a></div></form></div><div id="Html1"><div style="color:#A9A9A9;font-family:Arial;font-size:21px;text-align:center;"><?php echo $lang['paylist']; ?></div></div></div></body></html>