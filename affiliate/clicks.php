<?php if(empty($link)){header('Location: ./user.php'); exit;} ?><!doctype html><html><head><meta charset="utf-8"><title>User | Referral History</title><meta name="robots" content="noindex, nofollow"><meta name="generator" content="Powerstone"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="clicks.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="Html1"><?php
     $record_per_page = 14;
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
    $sql12 = "SELECT * FROM ref WHERE username = '" . $_SESSION['username'] . "' ORDER BY id DESC LIMIT $start_from, $record_per_page";
//Echo result set from database into table
    if($result = mysqli_query($link, $sql12)){
        if(mysqli_num_rows($result) > 0){
 echo "<div class='nuser'> <span style=\"color:#696969;font-family:Arial;font-size:16px;\">&nbsp;<i class=\"fa fa-hand-pointer-o\">&nbsp;</i> ".$lang['reflist']."</span> <br><br>";
    echo "<table id='myTable' width=\"100%\" cellpadding=\"2\" cellsapcing =\"2\">";
        echo "<thead>";
           echo "<tr>";
                
                    
                    
                    echo "<th>".strtoupper($lang['time'])."</th>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['country'])."</th>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['os'])."</td>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['browser'])."</th>";
                    
                    echo "<th>".strtoupper($lang['from'])."</th>";
                    
                    if($cpc == "on") {echo "<th>".strtoupper($lang['cpc'])." (".$currsym.")</th>";}
                    
                    echo "<th>".strtoupper($lang['sale'])."</th>";
                    
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
            while($row = mysqli_fetch_array($result)){
           
            $flag = "<img src='".$row['FLAG']."'>&nbsp;";
            $oslogo = "<img src='".$row['OSLOGO']."'>&nbsp;";
            $brlogo = "<img src='".$row['BROLOGO']."'>&nbsp;";
                echo "<tr>";
                
              //echo "<td>".$sn++."</td>";
              
              if($row['CPC']==''){$ucpc = "0.00";} else {$ucpc = $row['CPC'];}
              if($row['TIME']==''){$vtime = $row['TRN'];} else {$vtime = $row['TIME'];}
              if($row['REFER']=='direct'){$referer = "<strong>Direct Entry</stong>";} else {$referer = "<a href='".$row['REFER']."' target='_blank'>".mb_strimwidth(get_domain($row['REFER']), 0, 18, "...")."</a>";}
              if($row['SALE'] == "yes"){$sale="<span class='sale'>YES</span>";} else {$sale="No";}
                
                    echo "<td>" . timeAgo($vtime) . "</td>";
                    
                    echo "<td class='nomob'><span class='slogo'>" . $flag.mb_strimwidth($row['COUNTRY'], 0, 15, "...") . "</span></td>";
                    
                    echo "<td class='nomob'><span class='slogo'>" . $oslogo.mb_strimwidth($row['OS'], 0, 10, "...") . "</span></td>";
                    
                    echo "<td class='nomob'><span class='slogo'>" . $brlogo.mb_strimwidth($row['BROWSER'], 0, 10, "...") . "</span></td>";
                    
                    echo "<td>" . $referer . "</td>";
                    
                    if($cpc == "on") {echo "<td>" . $ucpc . "</td>";}
                    
                    echo "<td>" . $sale . "</td>";
                echo "</tr>";
            }
    echo "</tbody>";
            echo "</table></div>";
            // Close result set
            mysqli_free_result($result);
        } else{
            echo "<br><br><br><div style=\"color:#FF1493;font-family:Arial;font-size:25px; text-align: center;\"><strong>".$lang['noclick']."</strong></div><br>";
        }
    } 
    echo "<div class = 'nav'>";
            
    $page_query = "SELECT * FROM ref WHERE username = '" . $_SESSION['username'] . "' ORDER BY id DESC";
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
     echo "<a href='user.php?show=clicks&page=1' class='pg'>First</a>";
     echo "<a href='user.php?show=clicks&page=".($page - 1)."' class='pg'><<</a>";
    }
    for($i=$start_loop; $i<=$end_loop; $i++)
    {   if($i==$page){$cl="pgd";} else {$cl="pg";}    
     echo "<a href='user.php?show=clicks&page=$i' class='".$cl."'>".$i."</a>";
    }
    if($page < $end_loop)
    {
     echo "<a href='user.php?show=clicks&page=".($page + 1)."' class='pg'>>></a>";
     echo "<a href='user.php?show=clicks&page=".$total_pages."' class='pg'>Last</a>";
    }
    }
    echo "</div>";
    ?><br><br><div style="color:#696969;font-family:Arial;font-size:15px; text-align:center;"><?php echo "Copyright © " .$year ." " .$sitename. ", All Rights Reserved."; ?></div></div></div></body></html>