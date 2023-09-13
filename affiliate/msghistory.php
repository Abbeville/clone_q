<?php
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
if(empty($link)){header('Location: ./admin.php'); exit;}
//Get number of total users on system
$sql33 = "SELECT * FROM users WHERE ACESS != 'zblocked'";
$result = mysqli_query($link, $sql33);
$tusers=mysqli_num_rows($result);
?><!doctype html><html><head><meta charset="utf-8"><title>Newsletter Robot | Affiliate Me - <?php echo $version; ?></title><meta name="robots" content="noindex, nofollow"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="msghistory.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="Html15"><?php
$record_per_page = 12;
$page = '';
if(isset($_GET["page"]))
{
 $page = $_GET["page"];
}
else
{
 $page = 1;
}
$sn = (($page - 1) * $record_per_page) + 1;
$start_from = ($page-1)*$record_per_page; 
//Display emails from database into an html table
echo "<br>";
$sql44 = "SELECT * FROM emails ORDER BY ID DESC LIMIT $start_from, $record_per_page ";
    if($result = mysqli_query($link, $sql44)){
        if(mysqli_num_rows($result) > 0){
 echo "<div class=\"nuser\"> <span style=\"color:#D3D3D3;font-family:Arial;font-size:16px;\">&nbsp;<i class=\"fa fa-envelope\">&nbsp;</i> ".$lang['nshis']."</span> <br><br>";
    echo "<table id='myTable' width=\"100%\" cellpadding=\"2\" cellsapcing =\"2\">";
        echo "<thead>";
           echo "<tr>";
echo "<th class='nomob'>S/N</th><th>".strtoupper($lang['subject'])."</th><th class='nomob'>".strtoupper($lang['message'])."</th><th class='nomob'>".strtoupper($lang['created'])."</th><th class='nomob'>".strtoupper($lang['sento'])."</th><th>".strtoupper($lang['status'])."</th><th>".strtoupper($lang['open'])."</th></tr>";
       echo "</thead>";
        echo "<tbody>";
        
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                    echo "<td class='nomob'>".$sn++."</td>";
                    
                    echo "<td>" . mb_strimwidth($row['SUBJECT'], 0, 15, "...") . "</td>";
                    
                    $search = array('<','>');
                    $replace = array('&lt;','&gt;');
                    $messg =  str_replace($search, $replace, $row['MESSAGE']);
                    
                    echo "<td class='nomob'>" . mb_strimwidth($messg, 0, 20, "...") . "</td>";
                    
                    echo "<td class='nomob'>" . timeAgo($row['DATE']) . "</td>";
                    
                    echo "<td class='nomob'>" . $row['RENUM']. " of ".$tusers." Users</td>";
                    
                    if($row['STATUS'] == 'inprogess') {echo "<td><span style=\"color:#FF1493;\"><div class=\"fa fa-refresh fa-spin\"></div>&nbsp;".$lang['inprogress']."</span></td>";} else if($row['STATUS'] == 'done') {echo "<td><span style=\"color:#32CD32;\"><div class=\"fa fa-check-circle\"></div>&nbsp;<strong>".$lang['completed']."</strong></span></td>";} else {echo "<td><span style=\"color:#32CD32;\"><div class=\"fa fa-check-circle\"></div>&nbsp;<strong>".$lang['completed']."</strong></span></td>";}
                    
                   echo "<td><form name=\"form\" method=\"post\" action=\"./admin.php?show=email\"><input type=\"hidden\" name=\"subject\" value='". urlencode($row['SUBJECT']) ."'><input type=\"hidden\" name=\"message\" value='". urlencode($row['MESSAGE']) ."'><button class=\"button1\"><i class=\"fa fa-envelope-open\">&nbsp;</i></button></form></td>";
                echo "</tr>";
                
            }
    echo "</tbody>";
            echo "</table></div>";
            // Close result set
            mysqli_free_result($result);
        } else{
            echo "<span style=\"color:#FF1493;font-family:Arial;font-size:18px;\"><strong><br><center>No Emails Sent Yet!</center></strong></span>";
        }
    }
     
     
   echo "<div class = 'nav'>";
            
    $page_query = "SELECT * FROM emails ORDER BY ID DESC";
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
     echo "<a href='admin.php?show=robot&page=1' class='pg'>First</a>";
     echo "<a href='admin.php?show=robot&page=".($page - 1)."' class='pg'><<</a>";
    }
    for($i=$start_loop; $i<=$end_loop; $i++)
    {   if($i==$page){$cl="pgd";} else {$cl="pg";}    
     echo "<a href='admin.php?show=robot&page=$i' class='".$cl."'>".$i."</a>";
    }
    if($page < $end_loop)
    {
     echo "<a href='admin.php?show=robot&page=".($page + 1)."' class='pg'>>></a>";
     echo "<a href='admin.php?show=robot&page=".$total_pages."' class='pg'>Last</a>";
    }
    }
    echo "</div>";
    ?><br><div style="color:#A9A9A9;font-family:Arial;font-size:13px; text-align:center;">Affiliate Me Version <?php echo $version; ?><br><br></div></div><div id="Html1"><?php if(file_exists('lns.php')) {include "lns.php";} else {$estime = "1596473892";} ?><span style="color:#A9A9A9;font-family:Arial;font-size:20px;"><?php echo $lang['nsdest']; ?>:</span><span style="color:#00BFFF;font-family:Arial;font-size:16px;"> Last Email Was Sent By Robot <?php echo timeAgo($estime); ?></span></div></div></body></html>