<?php if(empty($link)){header('Location: ./user.php'); exit;} ?><!doctype html><html><head><meta charset="utf-8"><title>User | Login History</title><meta name="robots" content="noindex, nofollow"><meta name="generator" content="Powerstone"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="loghistory.css" rel="stylesheet"><?php

$did = mysqli_real_escape_string($link, isset($_GET["revoke"]) ? $_GET["revoke"] : '');
if($did != '')
{
$sql67 = "DELETE FROM login WHERE BROWID = '" . $did . "' && USERNAME = '" . $username . "' ";
$result = mysqli_query($link, $sql67);
$sql68 = "ALTER TABLE login ENGINE=MyISAM";
$result3 = mysqli_query($link, $sql68);
}
?><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="Html1"><?php
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
$sql = "SELECT t1.* FROM login t1
  JOIN (SELECT BROWID, MAX(id) id FROM login GROUP BY BROWID) t2
    ON t1.id = t2.id AND t1.BROWID = t2.BROWID WHERE USERNAME = '" . $_SESSION['username'] . "' order by id DESC LIMIT $start_from, $record_per_page";
    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
 echo "<div class='nuser'> <span style=\"color:#696969;font-family:Arial;font-size:16px;\">&nbsp;<i class=\"fa fa-keyboard-o\">&nbsp;</i> ".$lang["logins"]."</span> <br><br>";
    echo "<table id='myTable' width=\"100%\" cellpadding=\"2\" cellsapcing =\"2\">";
        echo "<thead>";
           echo "<tr>";
                
                    
                    
                    
                    echo "<th>LAST LOGIN</th>";
                    
                    echo "<th class='nomob'>COUNTRY</th>";
                    echo "<th class='nomob'>OS PLATFORM</td>";
                    
                    echo "<th>BROWSER</th>";
                    
                    echo "<th class='nomob'>ACCESS TIMES</td>";
                    
                    echo "<th>LOGOUT</th>";
                    
                    
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
            while($row = mysqli_fetch_array($result)){
            
            $flag = "<img src='".$row['FLAG']."'>&nbsp;";
            $oslogo = "<img src='".$row['OSLOGO']."'>&nbsp;";
            $brlogo = "<img src='".$row['BROLOGO']."'>&nbsp;";
            $brid = $row['BROWID'];
            
            $sql7="SELECT * FROM login  WHERE USERNAME = '" . $_SESSION['username'] . "' && BROWID = '".$brid."' ";
            $resulte=mysqli_query($link, $sql7);
            $times=mysqli_num_rows($resulte);
            
            $browid = $_COOKIE['browser'];
            if($brid == $browid){$thebrowser = "<span style='color:#32CD32;'>This Browser</span>";} else {$thebrowser = mb_strimwidth($row['BROWSER'], 0, 13, "...");}
                    
                    
                echo "<tr>";
                    
                    echo "<td>" . timeAgo($row['TIME']) . "</td>";
                    
                    echo "<td class='nomob'><span class='slogo'>" . $flag.mb_strimwidth($row['COUNTRY'], 0, 12, "...") . "</span></td>";
                    echo "<td class='nomob'><span class='slogo'>" . $oslogo.mb_strimwidth($row['OS'], 0, 10, "...") . "</span></td>";
                    
                    echo "<td><span class='slogo'>" . $brlogo.$thebrowser. "</span></td>";
                    
                    echo "<td class='nomob'>" . $times . " Time(s)</td>";
                    
                    
                    echo "<td><button onclick=\"if(confirm('You are about to delete this browser entirely from your account, authentication may be required to use this browser again, are you sure you want to continue?')){window.location.replace('user.php?show=logins&revoke=".$brid."');}else{return false;}\" class=\"button1\"><i class=\"fa fa-lock\">&nbsp;</i></button></td>";
                    
                echo "</tr>";
            }
    echo "</tbody>";
            echo "</table></div>";
            // Close result set
            mysqli_free_result($result);
        } else{
            echo "<br><br><span style=\"color:#FF1493;font-family:Arial;font-size:18px;\"><strong><br><center>No login History! You Deleted All Browsers!<br><br><br><br></center></strong></span>";
        }
    } 
    
    
    echo "<div class = 'nav'>";
            
    $sqlz = "SELECT t1.* FROM login t1
  JOIN (SELECT BROWID, MAX(id) id FROM login GROUP BY BROWID) t2
    ON t1.id = t2.id AND t1.BROWID = t2.BROWID WHERE USERNAME = '" . $_SESSION['username'] . "' ";
    $page_result = mysqli_query($link, $sqlz);
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
     echo "<a href='user.php?show=logins&page=1' class='pg'>First</a>";
     echo "<a href='user.php?show=logins&page=".($page - 1)."' class='pg'><<</a>";
    }
    for($i=$start_loop; $i<=$end_loop; $i++)
    {   if($i==$page){$cl="pgd";} else {$cl="pg";}    
     echo "<a href='user.php?show=logins&page=$i' class='".$cl."'>".$i."</a>";
    }
    if($page < $end_loop)
    {
     echo "<a href='user.php?show=logins&page=".($page + 1)."' class='pg'>>></a>";
     echo "<a href='user.php?show=logins&page=".$total_pages."' class='pg'>Last</a>";
    }
    }
    echo "</div>";
    ?><br><br><div style="color:#696969;font-family:Arial;font-size:15px; text-align:center;"><?php echo "Copyright © " .$year ." " .$sitename. ", All Rights Reserved."; ?></div></div></div></body></html>