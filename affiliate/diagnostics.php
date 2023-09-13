<?php
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.

$error_message = '';
$sucm = '';

//If the backup restore button is clicked check if the sql file is valid and delete old database records from database and upload new database file records
if(!empty($_POST)){
$newdb = $_FILES['db']['name'];
if($newdb !='') {
$dbfile = urlencode($newdb);
$target = "backup/".basename($dbfile);
move_uploaded_file($_FILES['db']['tmp_name'], $target);
$link->query('SET foreign_key_checks = 0');
if ($result = $link->query("SHOW TABLES"))
{
    while($row = $result->fetch_array(MYSQLI_NUM))
    {
        $link->query('DROP TABLE IF EXISTS '.$row[0]);
    }
}
$link->query('SET foreign_key_checks = 1');
$sql = file_get_contents("backup/".$dbfile);
if (mysqli_connect_errno()) { /* check connection */
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
/* execute multi query */
if ($link->multi_query($sql)) {
    $_SESSION['dbu'] = "on";
    $sucm = "Backup Restored Successfully, Kindly click on the Update Wizard to update database for changes";
} else {
   $error_message = "Error Restoring Backup, Please Check If The SQL File Is Not Corrupt, Else Contact Powerstone For Help!";
}
} else { $error_message = "No file uploaded, please upload an sql file!"; }                    
}
?><!doctype html><html><head><meta charset="utf-8"><title>Health Center | Affiliate Me  - <?php echo $version; ?></title><meta name="generator" content="WYSIWYG Web Builder 14 - http://www.wysiwygwebbuilder.com"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="diagnostics.css" rel="stylesheet"><script>
function ValidateLayer6()
{var regexp;var banner1=document.getElementById('banner1');if(!(banner1.disabled||banner1.style.display==='none'||banner1.style.visibility==='hidden'))
{var ext=banner1.value.substr(banner1.value.lastIndexOf('.'));if((ext.toLowerCase()!=".sql")&&(ext!=""))
{alert("The \"db\" field contains an unapproved filename.");return false;}}
return true;}</script><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="Html15"><?php
//Display the various PHP extension status in table form
 echo "<div class=\"nuser\"> <span style=\"color:#D3D3D3;font-family:Arial;font-size:17px;\">&nbsp;<i class=\"fa fa-thermometer-three-quarters\">&nbsp;</i> ".$lang['phpreq']."</span> <br><br>";
    echo "<table width=\"100%\" cellpadding=\"2\" cellsapcing =\"2\">";
        echo "<thead>";
           echo "<tr>";
echo "<th>".$lang['phpfeat']."</th><th width=\"16%\">".$lang['status']."</th><th class='nomob'>".$lang['studesc']."</th></tr>";
       echo "</thead>";
        echo "<tbody>";
        
            echo "<tr>";
                    echo "<td><strong>PHP Version</strong></td>";
                    
                    if ($phpv == 0) { echo "<td><span style=\"color:#32CD32;\"><div class=\"fa fa-check-circle\"></div>&nbsp;<strong>Ver: ". PHP_VERSION ."</strong></span></td><td class='nomob'>".$lang['phpokay']."</td>";} else { echo "<td><span style=\"color:#FF1493;\"><div class=\"fa fa-times-circle\"></div><strong>&nbsp;Ver: ". PHP_VERSION ."</strong></span></td><td class='nomob'>".$lang['phpnotokay']."</td>";}
                                      
                echo "</tr>";
                
                echo "<tr>";
                    echo "<td><strong>MySQL Version</strong></td>";
                    
                    echo "<td><span style=\"color:#32CD32;\"><div class=\"fa fa-check-circle\"></div>&nbsp;<strong>Ver: ". mysqli_get_server_info($link) ."</strong></span></td><td class='nomob'>".$lang['sqlokay']."</td>";
                                      
                echo "</tr>";
                
                echo "<tr>";
                    echo "<td><strong>Cron Job</strong></td>";
                    
                    if ($cron == 0) { echo "<td><span style=\"color:#32CD32;\"><div class=\"fa fa-check-circle\"></div>&nbsp;<strong>". timeAgo($ctime) ."</strong></span></td><td class='nomob'>".$lang['cronokay']."</td>";} else { echo "<td><span style=\"color:#FF1493;\"><div class=\"fa fa-times-circle\"></div><strong>&nbsp;Disabled</strong></span></td><td class='nomob'>".$lang['cronnotokay']."</td>";}
                                      
                echo "</tr>";
                
                echo "<tr>";
                    echo "<td><strong>mbstring</strong></td>";
                    
                    if ($mbl == 0) { echo "<td><span style=\"color:#32CD32;\"><div class=\"fa fa-check-circle\"></div>&nbsp;<strong>Enabled</strong></span></td><td class='nomob'>".$lang['mbokay']."</td>";} else { echo "<td><span style=\"color:#FF1493;\"><div class=\"fa fa-times-circle\"></div><strong>&nbsp;Disabled</strong></span></td><td class='nomob'>".$lang['mbnotokay']."</td>";}
                                      
                echo "</tr>";
                
                echo "<tr>";
                    echo "<td><strong>mysqli</strong></td>";
                    
                    if ($mql == 0) { echo "<td><span style=\"color:#32CD32;\"><div class=\"fa fa-check-circle\"></div>&nbsp;<strong>Enabled</strong></span></td><td class='nomob'>".$lang['sqliokay']."</td>";} else { echo "<td><span style=\"color:#FF1493;\"><div class=\"fa fa-times-circle\"></div><strong>&nbsp;Disabled</strong></span></td><td class='nomob'>".$lang['sqlinotokay']."</td>";}
                                      
                echo "</tr>";
                
                echo "<tr>";
                    echo "<td><strong>gd</strong></td>";
                    
                    if ($gd == 0) { echo "<td><span style=\"color:#32CD32;\"><div class=\"fa fa-check-circle\"></div>&nbsp;<strong>Enabled</strong></span></td><td class='nomob'>".$lang['gdokay']."</td>";} else { echo "<td><span style=\"color:#FF1493;\"><div class=\"fa fa-times-circle\"></div><strong>&nbsp;Disabled</strong></span></td><td class='nomob'>".$lang['gdnotokay']."</td>";}
                                      
                echo "</tr>";
                
                echo "<tr>";
                    echo "<td><strong>allow_url_fopen</strong></td>";
                    
                    if ($ulo == 0) {echo "<td><span style=\"color:#32CD32;\"><div class=\"fa fa-check-circle\"></div>&nbsp;<strong>Enabled</strong></span></td><td class='nomob'>".$lang['urlokay']."</td>";} else {echo "<td><span style=\"color:#FF1493;\"><div class=\"fa fa-times-circle\"></div><strong>&nbsp;Disabled</strong></span></td><td class='nomob'>".$lang['urlnotokay']."</td>";}
                                      
                echo "</tr>";
                
                echo "<tr>";
                    echo "<td><strong>file_uploads</strong></td>";
                    
                    if ($fpl == 0) {echo "<td><span style=\"color:#32CD32;\"><div class=\"fa fa-check-circle\"></div>&nbsp;<strong>Enabled</strong></span></td><td class='nomob'>".$lang['uplokay']."</td>";} else {echo "<td><span style=\"color:#FF1493;\"><div class=\"fa fa-times-circle\"></div><strong>&nbsp;Disabled</strong></span></td><td class='nomob'>".$lang['uplnotokay']."</td>";}
                                      
                echo "</tr>";
                
                echo "<tr>";
                    echo "<td><strong>upload_max_filesize</strong></td>";
                    
                    echo "<td><span style=\"color:#32CD32;\"><strong>"._Byte2Size(_GetMaxAllowedUploadSize())."</strong></span></td><td class='nomob'>".$lang['uplmax']." "._Byte2Size(_GetMaxAllowedUploadSize()).", ".$lang['adj']."</td>";
                                      
                echo "</tr>";
                
                echo "<tr>";
                
                $maxlifetime = ini_get("session.gc_maxlifetime"); $sec = "60"; $sdur = $maxlifetime/$sec;
                    echo "<td><strong>PHP Session Duration</strong></td>";
                    
                    echo "<td><span style=\"color:#32CD32;\"><strong>". $sdur . " Minutes</strong></span></td><td class='nomob'>".$lang['sesmax']." ". $sdur . " Minutes (".$maxlifetime." Seconds), ".$lang['adj']."</td>";
                                      
                echo "</tr>";
            
    echo "</tbody>";
    
            echo "</table>";
            
            
echo "<br><br><span style=\"color:#00BFFF;\">".$lang['exnote']."</span><br>";
            
            echo"</div>";

    ?></div><form name="Layer6" method="post" action="./admin.php?show=health" enctype="multipart/form-data" id="Layer2" onsubmit="return ValidateLayer6()"><input type="hidden" name="restore" value="1"><div id="Html6"><a href="./backup.php"><bu class="link"><i class="fa fa-database">&nbsp;</i>&nbsp;<?php echo $lang['dbdwld']; ?></bu></a></div><div id="Html9"><?php
//Display last backup status in a table
echo "<table>";
if ($bfreq > $lbu) { echo "<tr><th><img src='images/check.png'></th>" . "<th>" . "<span style=\"color:#87CEFA; font-size:15px;\">Backup Done!</span><br>" . "<span style=\"color:#FFFFFF;font-family:Tahoma;font-size:12px;\">You did your last database backup ".timeAgo($btime)." and this is safe per your settings!</span></th></tr>";} else {echo "<tr><td><img src='images/alert.png'></td>" . "<td>" . "<span style=\"color:#FF1493; font-size:15px;\"><strong>Database Backup Required!</strong></span><br>" . "<span style=\"color:#FFFFFF;font-family:Tahoma;font-size:12px;\">You did your last database backup ".timeAgo($btime).", according to your settings you must backup now!!!</span>" . "</td></tr>";}
echo "</table>";
?></div><input type="file" accept=".sql" name="db" id="banner1"><div id="Html12"><span style="color:#FF69B4;font-family:Arial;font-size:13px;">Select an SQL file from your computer and upload (Maximum file size is <?php echo _Byte2Size(_GetMaxAllowedUploadSize()); ?>)</span></div><div id="Html8"><a href="#" onclick="if(confirm('You are about to delete all current records from your database and you are advised to make a backup first, click OK if you wish to continue')){document.Layer6.submit();}else{return false;};"> <button class="link"><i class="fa fa-database">&nbsp;</i>&nbsp;<?php echo $lang['dbupl']; ?></button></a></div><div id="Html5"><span style="color:#FF69B4;font-family:Arial;font-size:16px;"><strong><?php echo $lang['sqlbackup']; ?></strong></span></div><div id="Html7"><span style="color:#FF69B4;font-family:Arial;font-size:16px;"><strong><?php echo $lang['sqlrestore']; ?></strong></span></div></form><div id="Html2"><a href="./admin.php?show=adv"><button class="link"><i class="fa fa-server">&nbsp;</i>&nbsp;<?php echo $lang['advanced']; ?></button></a></div><div id="Html11"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:12px;\"><center><i class=\"fa fa-check-circle-o\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
}
?><?php
if($error_message !='') {
echo "<div class=\"alert2\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:12px;\"><center><i class=\"fa fa-info-circle\">&nbsp;</i><strong>" . $error_message . "</strong></center></div></div>";
}
?></div><div id="Html1"><div style="color:#A9A9A9;font-family:Arial;font-size:13px; text-align:center;">Affiliate Me Version <?php echo $version; ?><br></div></div><div id="Html3"><div style="color:#A9A9A9;font-family:Arial;font-size:21px;text-align:center;">Powerstone Application Health Center</div></div><div id="Html4"><div style="color:#A9A9A9;font-family:Arial;font-size:21px;text-align:center;"><?php echo $lang['dbbackup']; ?></div></div></div></body></html>