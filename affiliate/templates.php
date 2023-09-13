<?php
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
if(empty($link)){header('Location: ./admin.php'); exit;}
//Delete templates
$id = mysqli_real_escape_string($link, isset($_GET["del"]) ? $_GET["del"] : '');
if($id != '')
{
$sql67 = "DELETE FROM etemplates WHERE id = '" . $id . "' ";
$result = mysqli_query($link, $sql67);
$sql68 = "ALTER TABLE etemplates ENGINE=MyISAM";
$result3 = mysqli_query($link, $sql68);
$sucm = "Requested Template successfully deletd!";
}
?><!doctype html><html><head><meta charset="utf-8"><title>Email Templates | Affiliate Me - <?php echo $version; ?></title><meta name="robots" content="noindex, nofollow"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="templates.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="Html9"><?php
     
     $record_per_page = 10;
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
$query = "SELECT * FROM etemplates order by id DESC LIMIT $start_from, $record_per_page";
$result = mysqli_query($link, $query);
if(mysqli_num_rows($result)>0){
echo "<div class='nuser'> <span style=\"color:#C0C0C0;font-family:Arial;font-size:16px;\">&nbsp;<i class=\"fa fa-envelope\">&nbsp;</i> ".$lang['youremtemp']."</span> <br><br>";
    echo "<table id='myTable' width=\"100%\" cellpadding=\"2\" cellsapcing =\"2\">";
        echo "<thead>";
           echo "<tr>";
                
                    
                    
                    
                    
                    echo "<th width='30%' class='nomob'>".strtoupper($lang['pgname'])."</td>";
                    echo "<th width='30%'>".strtoupper($lang['type'])."</td>";
                    
                    echo "<th width='20%'>".strtoupper($lang['status'])."</td>";
                    
                    echo "<th width='10%'>".strtoupper($lang['delete'])."</td>";
                    
                    echo "<th width='10%'>".strtoupper($lang['edit'])."</td>";
                    
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
            while($row = mysqli_fetch_array($result)){
           
                echo "<tr>";
                
                $id = $row['ID'];
                
                $yesdel = "<span onclick=\"if(confirm('You are about to delete this template, are you sure you want to continue?')){window.location.href='./admin.php?show=templates&del=$id';}else{return false;}\" class=\"del\"><div class=\"fa fa-trash\">&nbsp;</div></span>";
                $actdel = "<span class=\"delo\"><div class=\"fa fa-trash\">&nbsp;</div></span>";
                if($row['TYPE'] == "signup"){$type = " <i class=\"fa fa-user\"></i> Sign Up";} else if($row['TYPE'] == "recovery"){$type = " <i class=\"fa fa-lock\"></i> Password Recovery";} else if($row['TYPE'] == "sales"){$type = " <i class=\"fa fa-envelope\"></i> Sales Alert";} else if($row['TYPE'] == "reply"){$type = " <i class=\"fa fa-comments-o\"></i> Ticket Reply";} else if($row['TYPE'] == "payout"){$type = " <i class=\"fa fa-dollar\"></i> Affiliate Payout Alert";} else if($row['TYPE'] == "paycancel"){$type = " <i class=\"fa fa-dollar\"></i> Payout Cancel Alert";}
                if($row['TYPE'] == "signup" && $row['NAME'] == $signupet){$status = "<cr><i class=\"fa fa-check\"></i> Selected</cr>"; $delbut = $actdel;} else if($row['TYPE'] == "recovery" && $row['NAME'] == $passrec){$status = "<cr><i class=\"fa fa-check\"></i> Selected</cr>"; $delbut = $actdel;} else if($row['TYPE'] == "reply" && $row['NAME'] == $titemp){$status = "<cr><i class=\"fa fa-check\"></i> Selected</cr>"; $delbut = $actdel;} else if($row['TYPE'] == "sales" && $row['NAME'] == $sale){$status = "<cr><i class=\"fa fa-check\"></i> Selected</cr>"; $delbut = $actdel;} else if($row['TYPE'] == "payout" && $row['NAME'] == $affpaid){$status = "<cr><i class=\"fa fa-check\"></i> Selected</cr>"; $delbut = $actdel;} else if($row['TYPE'] == "paycancel" && $row['NAME'] == $affreject){$status = "<cr><i class=\"fa fa-check\"></i> Selected</cr>"; $delbut = $actdel;} else {$status = "Archived"; $delbut = $yesdel;}
                    
                    
                    echo "<td class='nomob'>" . mb_strimwidth(ucwords($row['NAME']), 0, 20, "...") . "</td>";
                    echo "<td>" . $type . "</td>";
                    
                    echo "<td>" . $status . "</td>";
                    
                    echo "<td>" . $delbut . "</td>";
                    
                    echo "<td><a href='admin.php?show=editemp&id=".$id."'><span class=\"edit\"><div class=\"fa fa-edit\">&nbsp;</div></span></a></td>";
                    
                echo "</tr>";
            }
            
            echo "</tbody></table></div>";
            
            } else {echo "<br><br><br><div style=\"color:#FF1493;font-family:Arial;font-size:20px; text-align: center;\"><strong>No Templates Found!</strong></div><br>";}
            
            echo "&nbsp;";
            
    $page_query = "SELECT * FROM etemplates ORDER BY id DESC";
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
     echo "<a href='admin.php?show=etemp&page=1' class='pg'>First</a>";
     echo "<a href='admin.php?show=etemp&page=".($page - 1)."' class='pg'><<</a>";
    }
    for($i=$start_loop; $i<=$end_loop; $i++)
    {   if($i==$page){$cl="pgd";} else {$cl="pg";}    
     echo "<a href='admin.php?show=etemp&page=$i' class='".$cl."'>".$i."</a>";
    }
    if($page < $end_loop)
    {
     echo "<a href='admin.php?show=etemp&page=".($page + 1)."' class='pg'>>></a>";
     echo "<a href='admin.php?show=etemp&page=".$total_pages."' class='pg'>Last</a>";
    }
    }
     ?><br><br><div style="color:#A9A9A9;font-family:Arial;font-size:13px; text-align:center;">Affiliate Me Version <?php echo $version; ?><br></div><br></div><div id="Html10"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:12px;\"><center><i class=\"fa fa-check-circle-o\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
}
?></div><div id="Html13"><a href="admin.php?show=crtemp"><button class="adt"><i class="fa fa-envelope">&nbsp;</i>&nbsp;<?php echo $lang['addtemp']; ?></button></a></div></div></body></html>