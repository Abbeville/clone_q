<?php if(empty($link)){header('Location: ./user.php'); exit;} 
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
//Define search query
 $search = mysqli_real_escape_string($link, isset($_GET['id']) ? $_GET['id'] : '');
$sucm ='';
if(!empty($_POST) && $_POST["token"]==$token && strtolower($_SERVER['HTTP_HOST'])==strtolower(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST))){
//Process commision retrieval
$rid = $_POST["id"];
$sql8 = "SELECT * FROM ref WHERE TRN = '" . $rid . "' ";
$result = mysqli_query($link, $sql8);
$row = mysqli_fetch_array($result);
$comm = $row['COMM'] ;
$nbalance = $balance + $comm;

$sql67 = "UPDATE ref SET COMM='0' WHERE TRN = '" . $rid . "' AND username = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($link, $sql67);
$sql68 = "UPDATE users SET CREDIT='" . $nbalance . "' WHERE USERNAME = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($link, $sql68);
$sucm ="Commission ".$rid." sucessfully added to your earnings";
$balance = $nbalance;
}

?><!doctype html><html><head><meta charset="utf-8"><title>User | Commision History</title><meta name="robots" content="noindex, nofollow"><meta name="generator" content="Powerstone"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="font-awesome.min.css" rel="stylesheet"><link href="referrals.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="wb_Form1"><form name="Form1" method="get" action="./user.php" enctype="text/plain" id="Form1"><input type="hidden" name="show" value="com"><input type="text" id="myInput" name="id" value="" spellcheck="false" placeholder="<?php echo $lang['searchid']; ?>"><div id="wb_sicon"><a href="#" onclick="document.getElementById('Form1').submit();return false;"><div id="sicon"><i class="fa fa-search"></i></div></a></div></form></div><div id="Html1"><?php
     $record_per_page = 11;
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
    $sql12 = "SELECT * FROM ref WHERE username = '" . $_SESSION['username'] . "' && SALE = 'yes' && `TRN` LIKE '%$search%' ORDER BY id DESC LIMIT $start_from, $record_per_page";
//Echo result set from database into table
    if($result = mysqli_query($link, $sql12)){
        if(mysqli_num_rows($result) > 0){
 echo "<div class='nuser'> <span style=\"color:#696969;font-family:Arial;font-size:16px;\">&nbsp;<i class=\"fa fa-dollar\">&nbsp;</i> ".$lang['comhis']."</span> <br><br>";
    echo "<table id='myTable' width=\"100%\" cellpadding=\"2\" cellsapcing =\"2\">";
        echo "<thead>";
           echo "<tr>";
                
                    
                    
                    echo "<th class='nomob'>".strtoupper($lang['refid'])."</th>";
                    
                    echo "<th>".strtoupper($lang['amount'])."</th>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['date'])."</th>";
                    echo "<th>".strtoupper($lang['status'])."</td>";
                    
                    echo "<th>".strtoupper($lang['remtime'])."</td>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['action'])."</th>";
                    
                    echo "<th>".strtoupper($lang['support'])."</th>";
                    
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
            while($row = mysqli_fetch_array($result)){
            
                echo "<tr>";
                
                    echo "<td class='nomob'>" . $row['TRN'] . "</td>";
                    
                    echo "<td>" . $currsym . $row['COMM'] . "</td>";
                    echo "<td class='nomob'>" . $row['DATE'] . "</td>";
                    
                    $dbdate = strtotime($row['VDATE']);
                    $datenow = strtotime($date);
                    if($row['COMM']=='0') {echo "<td><span style=\"color:#1E90FF;\">Converted</span></td>"; $rd = 'no';} else if($row['VCOMM']=='0') {echo "<td><span style=\"color:#FF00FF;\">Cancelled</span></td>"; $rd = 'no';} else if($dbdate <= $datenow) {echo "<td><span style=\"color:#006400;\"><strong>Ready</strong></span></td>"; $rd = 'yes';} else {echo "<td>Pending</td>"; $rd = 'no';}
                                        
                    echo "<td>" . timeLeft($row['VDATE']) . "</td>";
                    
                     if($rd == 'yes') {echo "<td class='nomob'><form name=\"form\" method=\"post\" action=\"./user.php?show=com\"><input type=\"hidden\" name=\"token\" value=". $token ."><input type=\"hidden\" name=\"id\" value=". $row['TRN'] ."><button class=\"button2\">Convert</button></form></td>"; } else { echo "<td class='nomob'><button class=\"button3\">Convert</button></td>"; }
                    
                    echo "<td><form name=\"form\" method=\"get\" action=\"./user.php\"><input type=\"hidden\" name=\"show\" value=\"message\"><input type=\"hidden\" name=\"subj\" value='My ticket is about referal ID#". $row['TRN'] ."'><button class=\"button1\"><i class=\"fa fa-comments\">&nbsp;</i></button></form></td>";
                    
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
     echo "<a href='user.php?show=com&page=1' class='pg'>First</a>";
     echo "<a href='user.php?show=com&page=".($page - 1)."' class='pg'><<</a>";
    }
    for($i=$start_loop; $i<=$end_loop; $i++)
    {   if($i==$page){$cl="pgd";} else {$cl="pg";}    
     echo "<a href='user.php?show=com&page=$i' class='".$cl."'>".$i."</a>";
    }
    if($page < $end_loop)
    {
     echo "<a href='user.php?show=com&page=".($page + 1)."' class='pg'>>></a>";
     echo "<a href='user.php?show=com&page=".$total_pages."' class='pg'>Last</a>";
    }
    }
    echo "</div>";
    
    ?><br><br><div style="color:#696969;font-family:Arial;font-size:15px; text-align:center;"><?php echo "Copyright © " .$year ." " .$sitename. ", All Rights Reserved."; ?></div></div><div id="Html2"><a href="./user.php?show=withdraw"><button class="with"><i class="fa fa-money">&nbsp;</i>&nbsp;<?php echo $lang['withfund']; ?></button></a></div><div id="Html3"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:14px;\"><center><i class=\"fa fa-check-circle-o\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
}
?></div></div></body></html>