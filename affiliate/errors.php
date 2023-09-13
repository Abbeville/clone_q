<?php
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
$sucm = '';
$error_message = '';
if(!empty($_POST)){
//Delete the error record using posted id
if(isset($_POST['ID'])) {
$sql67 = "DELETE FROM errors WHERE ID = '" . $_POST['ID'] . "' ";
$result = mysqli_query($link, $sql67);
$sql68 = "ALTER TABLE errors ENGINE=MyISAM";
$result3 = mysqli_query($link, $sql68);
$sucm ="Error ".$_POST['ID']." deleted from error records!";
} else {
//Delete all error records from database
$sql67 = "DELETE FROM errors";
$result = mysqli_query($link, $sql67);
$sql68 = "ALTER TABLE errors ENGINE=MyISAM";
$result3 = mysqli_query($link, $sql68);
$sucm ="All Error Records Deleted!";
   }
}
                    
?><!doctype html><html><head><meta charset="utf-8"><title>Error Logs | Affiliate Me</title><meta name="robots" content="noindex, nofollow"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="errors.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="Html15"><?php
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
$sql44 = "SELECT * FROM errors ORDER BY ID DESC LIMIT $start_from, $record_per_page";
    if($result = mysqli_query($link, $sql44)){
        if(mysqli_num_rows($result) > 0){
 echo "<div class=\"nuser\"> <span style=\"color:#D3D3D3;font-family:Arial;font-size:16px;\">&nbsp;<i class=\"fa fa-exclamation-triangle\">&nbsp;</i> ".$lang['eerrcords']."</span> <br><br>";
    echo "<table id='myTable' width=\"100%\" cellpadding=\"2\" cellsapcing =\"2\">";
        echo "<thead>";
           echo "<tr>";
echo "<th>".strtoupper($lang['type'])."</th><th>".strtoupper($lang['date'])."</th><th>".strtoupper($lang['time'])."</th><th>URL/INFO</th><th>".strtoupper($lang['action'])."</th></tr>";
       echo "</thead>";
        echo "<tbody>";
        
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                    
                    echo "<td>" . $row['TYPE'] . "</td>";
                    
                    echo "<td>" . $row['DATE'] . "</td>";
                    
                    echo "<td>" . $row['TIME'] . "</td>";
                    
                    echo "<td>" . mb_strimwidth($row['URL'], 0, 40, "..."). "</td>";
                    
                   echo "<td><form name=\"form\" method=\"post\" action=\"./admin.php?show=errors\"><input type=\"hidden\" name=\"ID\" value='". $row['ID'] ."'><button class=\"button1\"><i class=\"fa fa-trash\">&nbsp;</i></button></form></td>";
                echo "</tr>";
                
            }
    echo "</tbody>";
            echo "</table></div>";
            // Close result set
            mysqli_free_result($result);
        } else{
            echo "<span style=\"color:#FF1493;font-family:Arial;font-size:18px;\"><strong><br><center>No Errors Found Yet!</center></strong></span>";
        }
    } 
   echo "<div class = 'nav'>";
            
    $page_query = "SELECT * FROM errors ORDER BY ID DESC";
    
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
     echo "<a href='admin.php?show=errors&page=1' class='pg'>First</a>";
     echo "<a href='admin.php?show=errors&page=".($page - 1)."' class='pg'><<</a>";
    }
    for($i=$start_loop; $i<=$end_loop; $i++)
    {   if($i==$page){$cl="pgd";} else {$cl="pg";}    
     echo "<a href='admin.php?show=errors&page=$i' class='".$cl."'>".$i."</a>";
    }
    if($page < $end_loop)
    {
     echo "<a href='admin.php?show=errors&page=".($page + 1)."' class='pg'>>></a>";
     echo "<a href='admin.php?show=errors&page=".$total_pages."' class='pg'>Last</a>";
    }
    }
    echo "</div>";
    ?><br><div style="color:#A9A9A9;font-family:Arial;font-size:13px; text-align:center;">Affiliate Me Version <?php echo $version; ?><br><br></div></div><div id="Html4"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:14px;\"><center><i class=\"fa fa-check-circle-o\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
}
?></div><div id="wb_Form1"><form name="Form1" method="post" action="./admin.php?show=errors" id="Form1"><input type="submit" id="Button1" name="clear" value="<? echo $lang['clearerr']; ?>"></form></div></div></body></html>