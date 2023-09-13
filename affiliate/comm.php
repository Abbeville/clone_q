<?php
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
if(empty($link)){header('Location: ./admin.php'); exit;} 
$search = mysqli_real_escape_string($link, isset($_GET['id']) ? $_GET['id'] : '');
$sucm = "";
$error_message = "";
if(!empty($_POST['id'])){
$id = $_POST['id'];
$sql101 = "UPDATE ref SET VCOMM='0' WHERE TRN = '" . $id . "' ";
$result = mysqli_query($link, $sql101);
$sucm = "Commission ".$id." cancelled!";
}
if(!empty($_POST['rev'])){
$id = $_POST['rev'];
$sql9 = "SELECT * FROM ref WHERE TRN = '" . $id . "' ";
$result = mysqli_query($link, $sql9);
$ro = mysqli_fetch_array($result);
$rco = $ro['COMM'];
$sql101 = "UPDATE ref SET VCOMM='" . $rco . "' WHERE TRN = '" . $id . "' ";
$result = mysqli_query($link, $sql101);
$sucm = "Commission ".$id." restored!";
}
?><!doctype html><html><head><meta charset="utf-8"><title>Commissions | Affiliate Me</title><meta name="robots" content="noindex, nofollow"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="font-awesome.min.css" rel="stylesheet"><link href="comm.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="wb_Form2"><form name="Form1" method="get" action="./admin.php" enctype="text/plain" id="Form2"><input type="hidden" name="show" value="comm"><input type="text" id="Editbox2" name="id" value="" spellcheck="false" placeholder="<?php echo $lang['searchid']; ?>"><div id="wb_sicon"><a href="#" onclick="document.getElementById('Form2').submit();return false;"><div id="sicon"><i class="fa fa-search"></i></div></a></div></form></div><div id="Html6"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:13px;\"><center><i class=\"fa fa-check-circle-o\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
}
?><?php
if($error_message !='') {
echo "<div class=\"alert2\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:13px;\"><center><i class=\"fa fa-info-circle\">&nbsp;</i><strong>" . $error_message . "</strong></center></div></div>";
}
?></div><div id="Html1"><div style="color:#A9A9A9;font-family:Arial;font-size:21px;text-align:center;"><?php echo $lang['comlist']; ?></div></div><div id="Html2"><?php
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
    $sql12 = "SELECT * FROM ref WHERE SALE = 'yes' && `TRN` LIKE '%$search%' ORDER BY id DESC LIMIT $start_from, $record_per_page";
//Echo result set from database into table
    if($result = mysqli_query($link, $sql12)){
        if(mysqli_num_rows($result) > 0){
 echo "<div class='nuser'> <span style=\"color:#D3D3D3;font-family:Arial;font-size:16px;\">&nbsp;<i class=\"fa fa-dollar\">&nbsp;</i> ".$lang['comlist']."</span> <br><br>";
    echo "<table id='myTable' width=\"100%\" cellpadding=\"2\" cellsapcing =\"2\">";
        echo "<thead>";
           echo "<tr>";
                
                    
                    
                    echo "<th>".strtoupper($lang['usimg'])."</th>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['refid'])."</th>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['amount'])."</th>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['date'])."</th>";
                    echo "<th>".strtoupper($lang['status'])."</td>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['remtime'])."</td>";
                    
                    echo "<th>".strtoupper($lang['cancel'])."</th>";
                    
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
            while($row = mysqli_fetch_array($result)){
            
                echo "<tr>";
                
                    if($row['OID']==""){$oid = "Unknown";} else {$oid = $row['OID'];}
                
                    echo "<td><a href='admin.php?show=user&uid=" . $row['USERNAME'] . "'>" . $row['USERNAME'] . "</a></td>";
                    
                    echo "<td class='nomob'>" . $row['TRN'] . " <span class=\"tool\" data-tip=\"Referral ID: " . $row['TRN'] . " &#13;&#10;Affiliated Domain: " . $row['URL'] . "  &#13;&#10;PayPal or Payment Method Transaction ID: " . $oid . "\"  title=\"Affiliated Domain: " . $row['URL'] . "&#013;PayPal or Payment Method Transaction ID: " . $oid . "\"> <i class=\"fa fa-info-circle\"></i></span></td>";
                    
                    echo "<td class='nomob'>" . $currsym . $row['COMM'] . "</td>";
                    echo "<td class='nomob'>" . $row['DATE'] . "</td>";
                    
                    $dbdate = strtotime($row['VDATE']);
                    $datenow = strtotime($date);
                    if($row['COMM']=='0') {echo "<td><span style=\"color:#1E90FF;\">Converted</span></td>"; $rd = 'no';} else if($row['VCOMM']=='0') {echo "<td><span style=\"color:#FF00FF;\">Cancelled</span></td>"; $rd = 'pend';} else if($dbdate <= $datenow) {echo "<td><span style=\"color:#00FF00;\"><strong>Ready</strong></span></td>"; $rd = 'no';} else {echo "<td>Pending</td>"; $rd = 'yes';}
                                        
                    echo "<td class='nomob'>" . timeLeft($row['VDATE']) . "</td>";
                    
                     if($rd == 'yes') {echo "<td><form name=\"form\" method=\"post\" action=\"./admin.php?show=comm\"><input type=\"hidden\" name=\"id\" value=". $row['TRN'] ."><button class=\"button1\">".$lang['cancel']."</button></form></td>"; } else if($rd == 'pend') {echo "<td><form name=\"form\" method=\"post\" action=\"./admin.php?show=comm\"><input type=\"hidden\" name=\"rev\" value=". $row['TRN'] ."><button class=\"button1\">".$lang['restore']."</button></form></td>"; } else { echo "<td><button class=\"button2\">".$lang['cancel']."</button></td>"; }
                    echo "</tr>";
            }
    echo "</tbody>";
            echo "</table></div>";
            // Close result set
            mysqli_free_result($result);
        } else{
            echo "<br><br><br><div style=\"color:#FF1493;font-family:Arial;font-size:25px; text-align: center;\"><strong>".$lang['nosale']."</strong></div><br>";
        }
    } 
    
    
    echo "<div class = 'nav'>";
            
    $page_query = "SELECT * FROM ref WHERE username = '" . $_SESSION['username'] . "' && SALE = 'yes' && `TRN` LIKE '%$search%' ORDER BY id DESC";
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
     echo "<a href='admin.php?show=comm&page=1' class='pg'>First</a>";
     echo "<a href='admin.php?show=comm&page=".($page - 1)."' class='pg'><<</a>";
    }
    for($i=$start_loop; $i<=$end_loop; $i++)
    {   if($i==$page){$cl="pgd";} else {$cl="pg";}    
     echo "<a href='admin.php?show=comm&page=$i' class='".$cl."'>".$i."</a>";
    }
    if($page < $end_loop)
    {
     echo "<a href='admin.php?show=comm&page=".($page + 1)."' class='pg'>>></a>";
     echo "<a href='admin.php?show=comm&page=".$total_pages."' class='pg'>Last</a>";
    }
    }
    echo "</div>";
    
    ?><br><div style="color:#A9A9A9;font-family:Arial;font-size:13px; text-align:center;">Affiliate Me Version <?php echo $version; ?><br><br></div></div></div></body></html>