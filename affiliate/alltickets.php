<?php if(empty($link)){header('Location: ./admin.php'); exit;} ?><!doctype html><html><head><meta charset="utf-8"><title>Tickets | Affiliate Me - <?php echo $version; ?></title><meta name="robots" content="noindex, nofollow"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="font-awesome.min.css" rel="stylesheet"><link href="alltickets.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="Html2"><?php
$search = mysqli_real_escape_string($link, isset($_GET['id']) ? $_GET['id'] : '');
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
echo "<br>";

   // Attempt select query execution
    $sql = "SELECT t1.* FROM tickets t1
  JOIN (SELECT tid, MAX(id) id FROM tickets GROUP BY tid) t2
    ON t1.id = t2.id AND t1.tid = t2.tid WHERE trash = '0' && `subject` LIKE '%$search%' ORDER BY id DESC LIMIT $start_from, $record_per_page";
    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
//Display data from database into table
 echo "<div class='nuser'> <span style=\"color:#D3D3D3;font-family:Arial;font-size:16px;\">&nbsp;<i class=\"fa fa-ticket\">&nbsp;</i> ".$lang['ticklist']."</span> <br><br>";
    echo "<table id='myTable' width=\"100%\" cellpadding=\"2\" cellsapcing =\"2\">";
        echo "<thead>";
           echo "<tr>";
                
                    
                    
                    echo "<th>".strtoupper($lang['ticketid'])."</th>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['subject'])."</th>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['message'])."</th>";
                    echo "<th>".strtoupper($lang['status'])."</td>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['updated'])."</td>";
                    
                    echo "<th>READ</th>";
                    
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
            while($row = mysqli_fetch_array($result)){
            
                    $sql22="SELECT * FROM tickets WHERE trash = '0' && status1 = '<cr>New!</cr>' && tid = '".$row['tid']."' ";
                    $cct=mysqli_query($link, $sql22);
                    $ct=mysqli_num_rows($cct);
            
                echo "<tr>";
                
                    echo "<td>" . $row['tid'] . "</td>";
                    
                    echo "<td class='nomob'>" . mb_strimwidth($row['subject'], 0, 15, "...") . "</td>";
                    echo "<td class='nomob'>" . mb_strimwidth($row['message'], 0, 20, "...") . "</td>";
                    if($row['status']=='' && $row['status1']=='') {echo "<td>READ</td>";} else if($row['status1']=='' && $row['status']=='<cr>New!</cr>') {echo "<td><cm><i class=\"fa fa-reply\">&nbsp;</i>Unread</cm></td>";} else if($row['status1']=='<cr>New!</cr>') {echo "<td><strong><cr>" . $ct . " NEW</cr></strong></td>";} else {echo "<td><strong>" . $row['status1'] . "</strong></td>";}
                                        
                    echo "<td class='nomob'>" . timeAgo($row['time']) . "</td>";
                    echo "<td><form name=\"form\" method=\"get\" action=\"./admin.php\"><input type=\"hidden\" name=\"show\" value='reply'><input type=\"hidden\" name=\"id\" value=". $row['tid'] ."><input type=\"hidden\" name=\"uid\" value=". $row['username'] ."><button class=\"button1\"><i class=\"fa fa-eye\">&nbsp;</i></button></form></td>";
                    
                echo "</tr>";
            }
    echo "</tbody>";
            echo "</table></div>";
            // Close result set
            mysqli_free_result($result);
        } else{
            echo "<br><br><span style=\"color:#FF1493;font-family:Arial;font-size:18px;\"><strong><br><center>Sorry You Have No Support <i class=\"fa fa-ticket\">&nbsp;</i>Tickets!<br><br><br><br></center></strong></span>";
        }
    } 
   echo "<div class = 'nav'>";
            
    $page_query = "SELECT t1.* FROM tickets t1
  JOIN (SELECT tid, MAX(id) id FROM tickets GROUP BY tid) t2
    ON t1.id = t2.id AND t1.tid = t2.tid WHERE trash = '0' && `subject` LIKE '%$search%' ORDER BY id DESC";
    
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
     echo "<a href='admin.php?show=tickets&page=1' class='pg'>First</a>";
     echo "<a href='admin.php?show=tickets&page=".($page - 1)."' class='pg'><<</a>";
    }
    for($i=$start_loop; $i<=$end_loop; $i++)
    {   if($i==$page){$cl="pgd";} else {$cl="pg";}    
     echo "<a href='admin.php?show=tickets&page=$i' class='".$cl."'>".$i."</a>";
    }
    if($page < $end_loop)
    {
     echo "<a href='admin.php?show=tickets&page=".($page + 1)."' class='pg'>>></a>";
     echo "<a href='admin.php?show=tickets&page=".$total_pages."' class='pg'>Last</a>";
    }
    }
    echo "</div>";
    ?><br><div style="color:#A9A9A9;font-family:Arial;font-size:13px; text-align:center;">Affiliate Me Version <?php echo $version; ?><br><br></div></div><div id="wb_Form2"><form name="Form1" method="get" action="./admin.php" enctype="text/plain" id="Form2"><input type="hidden" name="show" value="tickets"><input type="text" id="Editbox2" name="id" value="" spellcheck="false" placeholder="<?php echo $lang['sticketid'];?>"><div id="wb_sicon"><a href="#" onclick="document.getElementById('Form2').submit();return false;"><div id="sicon"><i class="fa fa-search"></i></div></a></div></form></div><div id="Html1"><div style="color:#A9A9A9;font-family:Arial;font-size:21px;text-align:center;"><?php echo $lang['ticklist']; ?></div></div></div></body></html>