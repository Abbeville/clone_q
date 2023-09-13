<?php if(empty($link)){header('Location: ./admin.php'); exit;} ?><!doctype html><html><head><meta charset="utf-8"><title>Users | Affiliate Me - <?php echo $version; ?></title><meta name="robots" content="noindex, nofollow"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="font-awesome.min.css" rel="stylesheet"><link href="users.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="usrs"><?php
$search = mysqli_real_escape_string($link, isset($_GET['search']) ? $_GET['search'] : '');
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
$sn = (($page - 1) * $record_per_page) + 1; //Serial Number commented out for space!
$start_from = ($page-1)*$record_per_page;
echo "<br>";

$sql44 = "SELECT * FROM users WHERE `USERNAME` LIKE '%$search%' || `NAME` LIKE '%$search%' ORDER BY ACESS, ID DESC LIMIT $start_from, $record_per_page";
    if($result = mysqli_query($link, $sql44)){
        if(mysqli_num_rows($result) > 0){
 echo "<div class=\"nuser\"> <span style=\"color:#D3D3D3;font-family:Arial;font-size:16px;\">&nbsp;<i class=\"fa fa-users\">&nbsp;</i> ".$lang['afflist']."</span> <br><br>";
    echo "<table id='myTable' width=\"100%\" cellpadding=\"2\" cellsapcing =\"2\">";
        echo "<thead>";
           echo "<tr>";
//Display list of users in an html table
echo "<th>".$lang['usimg']."</th><th>".$lang['user']."</th><th class='nomob'>".$lang['name']."</th><th class='nomob'>".$lang['fone']."</th><th>".$lang['acess']."</th><th class='nomob'>".$lang['seen']."</th><th>".$lang['edituser']."</th></tr>";
       echo "</thead>";
        echo "<tbody>";
        
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                    echo "<td><img src='avatars/". $row['AVATAR'] ."' onerror=\"this.src='images/defavat.png';\" border=\"1\" class =\"pro2\"></td>";
                    
                    echo "<td>" . $row['USERNAME'] . "</td>";
                    
                    echo "<td class='nomob'>" . mb_strimwidth($row['NAME'], 0, 30, "..."); if($time - $row['DATE'] < '604800'){echo "&nbsp;<cr>NEW</cr>";} echo "</td>";
                    
                    echo "<td class='nomob'>" . $row['PHONE'] . "</td>";
                    
                    if($row['ACESS'] == 'superadmin') {echo "<td><span style=\"color:#FF1493;font-size:14px;\"><strong>SUPER ADMIN</strong></span></td>";} else if ($row['ACESS'] == 'admin') {echo "<td><span style=\"color:#FFD700;font-size:14px;\"><strong>ADMIN</strong></span></td>";} else if ($row['ACESS'] == 'user') {echo "<td><span style=\"color:#F0F0F0;font-size:14px;\">User</span></td>";} else {echo "<td><span style=\"color:#F0F0F0;font-size:14px;\">Blocked</span></td>";}
                    
                    $useen = $time - $row['ONLINE'];
                    
                    if($useen < '406') {echo "<td class='nomob'><span class=\"pulse\">&nbsp;&nbsp;&nbsp;&nbsp;<span style=\"color:#32CD32;\">Online</span></span></td>" ;} else {echo "<td class='nomob'>".timeAgo($row['ONLINE'])."</td>" ;}
                   
                   echo "<td><form name=\"form\" method=\"get\" action=\"./admin.php\"><input type=\"hidden\" name=\"show\" value='user'><input type=\"hidden\" name=\"uid\" value='". $row['USERNAME'] ."'><button class=\"button1\"><i class=\"fa fa-edit\">&nbsp;</i></button></form></td>";
                echo "</tr>";
            }
    echo "</tbody>";
            echo "</table></div>";
            // Close result set
            mysqli_free_result($result);
        } else{
            echo "<span style=\"color:#FF1493;font-family:Arial;font-size:18px;\"><strong><br><center>No Users Found!</center></strong></span>";
        }
    } 
    $page_query = "SELECT * FROM users WHERE `USERNAME` LIKE '%$search%' || `NAME` LIKE '%$search%' ORDER BY id DESC";
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
     echo "<a href='admin.php?show=users&page=1' class='pg'>First</a>";
     echo "<a href='admin.php?show=users&page=".($page - 1)."' class='pg'><<</a>";
    }
    for($i=$start_loop; $i<=$end_loop; $i++)
    {   if($i==$page){$cl="pgd";} else {$cl="pg";}    
     echo "<a href='admin.php?show=users&page=$i' class='".$cl."'>".$i."</a>";
    }
    if($page < $end_loop)
    {
     echo "<a href='admin.php?show=users&page=".($page + 1)."' class='pg'>>></a>";
     echo "<a href='admin.php?show=users&page=".$total_pages."' class='pg'>Last</a>";
    }
    }
    ?><br><div style="color:#A9A9A9;font-family:Arial;font-size:13px; text-align:center;">Affiliate Me Version <?php echo $version; ?><br></div></div><div id="wb_Form2"><form name="Form1" method="get" action="./admin.php" enctype="text/plain" id="Form2"><input type="hidden" name="show" value="users"><input type="text" id="myInput" onkeyup="myFunction();myFunction1();return false;" name="search" value="" spellcheck="false" placeholder="<?php echo $lang['searchname']; ?>"><div id="wb_sicon"><a href="#" onclick="document.getElementById('Form2').submit();return false;"><div id="sicon"><i class="fa fa-search"></i></div></a></div></form></div><div id="Html1"><div style="color:#A9A9A9;font-family:Arial;font-size:21px;text-align:center;"><?php echo $lang['afflist']; ?></div></div></div></body></html>