<?php if(empty($link)){header('Location: ./user.php'); exit;} 
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
 $search = mysqli_real_escape_string($link, isset($_GET['id']) ? $_GET['id'] : '');
//Trash tickets when the trash button is clicked
if(!empty($_GET['trash'])){
$tra = mysqli_real_escape_string($link, $_GET['trash']);
$sql67 = "UPDATE tickets SET trash='1' WHERE tid = '" . $tra . "' AND username = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($link, $sql67);
}

$trash = 0;
$sql4 = "SELECT t1.* FROM tickets t1
  JOIN (SELECT tid, MAX(id) id FROM tickets GROUP BY tid) t2
    ON t1.id = t2.id AND t1.tid = t2.tid WHERE username = '" . $_SESSION['username'] . "' AND trash = '1' ";
$result=mysqli_query($link, $sql4);
$trash=mysqli_num_rows($result);

$tick = 0;
$sql5 = "SELECT t1.* FROM tickets t1
  JOIN (SELECT tid, MAX(id) id FROM tickets GROUP BY tid) t2
    ON t1.id = t2.id AND t1.tid = t2.tid WHERE username = '" . $_SESSION['username'] . "' AND trash = '0' ";
$result=mysqli_query($link, $sql5);
$tick=mysqli_num_rows($result);


?><!doctype html><html><head><meta charset="utf-8"><title>User | Support Tickets</title><meta name="robots" content="noindex, nofollow"><meta name="generator" content="Powerstone"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="font-awesome.min.css" rel="stylesheet"><link href="tickets.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="Html1"><?php
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

$start_from = ($page-1)*$record_per_page;

   // Attempt select query execution
    $sql = "SELECT t1.* FROM tickets t1
  JOIN (SELECT tid, MAX(id) id FROM tickets GROUP BY tid) t2
    ON t1.id = t2.id AND t1.tid = t2.tid WHERE username = '" . $_SESSION['username'] . "' && trash = '0' && `subject` LIKE '%$search%' ORDER BY id DESC LIMIT $start_from, $record_per_page";
    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
//Echo table with results
 echo "<div class='nuser'> <span style=\"color:#696969;font-family:Arial;font-size:16px;\">&nbsp;<i class=\"fa fa-ticket\">&nbsp;</i> ".$lang['ticklist']."</span> <br><br>";
    echo "<table id='myTable' width=\"100%\" cellpadding=\"2\" cellsapcing =\"2\">";
        echo "<thead>";
           echo "<tr>";
                
                    
                    
                    echo "<th>".strtoupper($lang['ticketid'])."</th>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['subject'])."</th>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['message'])."</th>";
                    echo "<th>".strtoupper($lang['status'])."</td>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['updated'])."</td>";
                    
                    echo "<th>".strtoupper($lang['delete'])."</th>";
                    
                    echo "<th>".strtoupper($lang['read'])."</th>";
                    
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
            while($row = mysqli_fetch_array($result)){
            
                echo "<tr>";
                
                    echo "<td>" . $row['tid'] . "</td>";
                    
                    echo "<td class='nomob'>" . mb_strimwidth($row['subject'], 0, 15, "...") . "</td>";
                    echo "<td class='nomob'>" . mb_strimwidth(strip_tags($row['message']), 0, 20, "...") . "</td>";
                    if($row['status']=='' && $row['status1']=='') {echo "<td>READ</td>";} else if($row['status']=='' && $row['status1']=='<cr>New!</cr>') {echo "<td><cm><i class=\"fa fa-reply\">&nbsp;</i>Unread</cm></td>";} else {echo "<td>" . $row['status'] . "</td>";}
                                        
                    echo "<td class='nomob'>" . timeAgo($row['time']) . "</td>";
                    
                    echo "<td><form name=\"formd\" method=\"get\" action=\"./user.php\"><input type=\"hidden\" name=\"show\" value=\"tickets\"><input type=\"hidden\" name=\"trash\" value=". $row['tid'] ."><a href=\"#\" onclick=\"if(confirm('You are about to send all conversations related to Ticket ID#". $row['tid'] ." to the trash bin, are you sure?')){document.formd.submit();}else{return false;};\"><button class=\"button2\"><i class=\"fa fa-trash\">&nbsp;</i></button></a></form></td>";
                    
                    echo "<td><form name=\"form\" method=\"get\" action=\"./user.php\"><input type=\"hidden\" name=\"show\" value=\"message\"><input type=\"hidden\" name=\"id\" value=". $row['tid'] ."><button class=\"button1\"><i class=\"fa fa-eye\">&nbsp;</i></button></form></td>";
                    
                echo "</tr>";
            }
    echo "</tbody>";
            echo "</table></div>";
            // Close result set
            mysqli_free_result($result);
        } else{
            echo "<br><br><span style=\"color:#FF1493;font-family:Arial;font-size:18px;\"><strong><br><center>".$lang['noticket']."<br><br><br><br></center></strong></span>";
        }
    } 
     
    echo "<div class = 'nav'>";
            
    $page_query = "SELECT t1.* FROM tickets t1
  JOIN (SELECT tid, MAX(id) id FROM tickets GROUP BY tid) t2
    ON t1.id = t2.id AND t1.tid = t2.tid WHERE username = '" . $_SESSION['username'] . "' && trash = '0' && `subject` LIKE '%$search%' ORDER BY id DESC";
    
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
     echo "<a href='user.php?show=tickets&page=1' class='pg'>First</a>";
     echo "<a href='user.php?show=tickets&page=".($page - 1)."' class='pg'><<</a>";
    }
    for($i=$start_loop; $i<=$end_loop; $i++)
    {   if($i==$page){$cl="pgd";} else {$cl="pg";}    
     echo "<a href='user.php?show=tickets&page=$i' class='".$cl."'>".$i."</a>";
    }
    if($page < $end_loop)
    {
     echo "<a href='user.php?show=tickets&page=".($page + 1)."' class='pg'>>></a>";
     echo "<a href='user.php?show=tickets&page=".$total_pages."' class='pg'>Last</a>";
    }
    }
    echo "</div>";
    ?><br><br><div style="color:#696969;font-family:Arial;font-size:15px; text-align:center;"><?php echo "Copyright © " .$year ." " .$sitename. ", All Rights Reserved."; ?></div></div><div id="Html2"><a href="./user.php?show=message"><button class="button0"><i class="fa fa-ticket">&nbsp;</i><?php echo $lang['nticket'];?></button></a></div><div id="Html3"><a href="./user.php?show=trash"><button class="buttonz"><i class="fa fa-trash">&nbsp;</i>&nbsp;<?php echo $lang['vtrash'];?> (<?php echo $trash; ?>)</button></a></div><div id="Html4"><button class="buttona"><i class="fa fa-ticket">&nbsp;</i>&nbsp;<?php echo $lang['tickets'];?> (<?php echo $tick; ?>)</button></div><div id="wb_Form2"><form name="Form1" method="get" action="./user.php" enctype="text/plain" id="Form2"><input type="hidden" name="show" value="tickets"><input type="text" id="Editbox2" name="id" value="" spellcheck="false" placeholder="<?php echo $lang['sticketid']; ?>"><div id="wb_sicon"><a href="#" onclick="document.getElementById('Form2').submit();return false;"><div id="sicon"><i class="fa fa-search"></i></div></a></div></form></div></div></body></html>