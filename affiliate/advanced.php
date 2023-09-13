<?php if(empty($link)){header('Location: ./admin.php'); exit;} ?><!doctype html><html><head><meta charset="utf-8"><title>Server Status | Affiliate Me  - <?php echo $version; ?></title><meta name="generator" content="WYSIWYG Web Builder 14 - http://www.wysiwygwebbuilder.com"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="advanced.css" rel="stylesheet"></head><body><div id="container"><div id="Layer2"><div id="Html15"><div style="color:#87CEFA;font-family:Arial;font-size:16px;text-align:center;"><?php echo $lang['storagestate']; ?></div><div class="progs"><?php include "drive.php"; ?><div class="prgtext"><?php echo $dp; ?>% Disk Used</div><div class="prgbar"></div><div class="prginfo"><span style="float:left; font-size:14px;"><?php echo "$du of $dt used"; ?></span><span style="float:right; font-size:14px;"><?php echo "$df of $dt free"; ?></span><span style="clear:both;"></span></div></div></div><div id="Html4"><div style="color:#87CEFA;font-family:Arial;font-size:16px;text-align:center;"><?php echo $lang['loadstate']; ?></div><br><br><?php
//Funtion to determine server uptime and load status
if(exec("uptime")){
$reguptime = trim(exec("uptime"));
if ($reguptime) {
if (preg_match("/, *(\d) (users?), .*: (.*), (.*), (.*)/", $reguptime, $uptime)) {
$users1 = $uptime[1];
$users2 = $uptime[2];
$loadnow = $uptime[3];
$load15 = $uptime[4];
$load30 = $uptime[5];
} else {
$users1 = "Unavailable";
$users2 = "--";
$loadnow = "Unavailable";
$load15 = "--";
$load30 = "--";
   }
 }
echo "<span style=\"color:#32CD32;font-family:Arial;font-size:16px;\"><strong>Server Load:</strong></span> <span style=\"color:#C0C0C0;font-family:Arial;font-size:16px;\"> $loadnow (Currently)  $load15 (15 minutes ago) and $load30 (30 min ago)</span>";
} else {echo "<span style=\"color:#32CD32;font-family:Tahoma;font-size:16px;\"><strong>Server Load:</strong></span> <span style=\"color:#FF1493;font-family:Arial;font-size:16px;\"> Failed to Check Server Load, Function <strong>exec()</strong> Disabled On Server</span>";}
echo "<br /><br />";
if(shell_exec("cut -d. -f1 /proc/uptime")){
$uptime = shell_exec("cut -d. -f1 /proc/uptime");
$days = floor($uptime/60/60/24);
$hours = str_pad($uptime/60/60%24,2,"0",STR_PAD_LEFT);
$mins = str_pad($uptime/60%60,2,"0",STR_PAD_LEFT);
$secs = str_pad($uptime%60,2,"0",STR_PAD_LEFT);
echo "<span style=\"color:#32CD32;font-family:Arial;font-size:16px;\"><strong>Server Uptime:</strong></span> <span style=\"color:#C0C0C0;font-family:Arial;font-size:16px;\">Server up for $days Days, $hours hours $mins minutes and $secs Seconds</span>";
} else {echo "<span style=\"color:#32CD32;font-family:Arial;font-size:16px;\"><strong>Server Uptime:</strong></span> <span style=\"color:#FF1493;font-family:Tahoma;font-size:16px;\"> Failed to Check Server Uptime, Function <strong>shell_exec()</strong> Disabled On Server</span>";}
?></div><div id="Html6"><div style="color:#87CEFA;font-family:Arial;font-size:16px;text-align:center;"><?php echo $lang['genstate']; ?></div><?php
/*
*   +------------------------------------------------------------------------------+
*       CPANEL STATUS SCRIPT                                                                         
*   +------------------------------------------------------------------------------+
*       Author(s): Crooty.co.uk (Adam C)                                   
*   +------------------------------------------------------------------------------+
*/ 

//configure script
$timeout = "1";
//set service checks
$port[1] = "80";       $service[1] = "Apache";                  $ip[1] ="";
$port[2] = "21";       $service[2] = "FTP";                     $ip[2] ="";
$port[3] = "3306";     $service[3] = "MYSQL";                   $ip[3] ="";
$port[4] = "25";       $service[4] = "Email(POP3)";             $ip[4] ="";
$port[5] = "143";      $service[5] = "Email(IMAP)";             $ip[5] ="";
$port[6] = "2095";     $service[6] = "Webmail";                 $ip[6] ="";
$port[7] = "2082";     $service[7] = "cPanel";                  $ip[7] ="";
$port[8] = "80";       $service[8] = "Internet Connection";     $ip[8] ="google.com";
//
// NO NEED TO EDIT BEYOND HERE 
// UNLESS YOU WISH TO CHANGE STYLE OF RESULTS
//
//count arrays
$ports = count($port);
$ports = $ports + 1;
$count = 1;
//Display data in table
echo "<div class=\"nuser\">";
echo "<table width=\"100%\" cellpadding=\"2\" cellsapcing =\"2\">";
echo "<thead>";
echo "<tr>";
echo "<th>Service</th><th>Status</th></tr>";
echo "</thead>";
echo "<tbody>";
        
while($count < $ports){
     if($ip[$count]==""){
       $ip[$count] = "localhost";
     }
        $fp = @fsockopen("$ip[$count]", $port[$count], $errno, $errstr, $timeout);
        if (!$fp) {
            echo "<tr><td>$service[$count]</td><td><span style=\"color:#FF1493;\">Offline</span></td></tr>";
        } else {
            echo "<tr><td>$service[$count]</td><td><span style=\"color:#32CD32;\">Online</span></td></tr>";
            fclose($fp);
        }
    $count++;
} 
                            
echo "</tbody>";
    
echo "</table>";
            
            
            
  echo"</div>";
            
  ?></div></div><div id="Html2"><a href="./admin.php?show=health"><button class="link"><i class="fa fa-thermometer-three-quarters">&nbsp;</i>&nbsp;<?php echo $lang['health']; ?></button></a></div><div id="Html1"><div style="color:#A9A9A9;font-family:Arial;font-size:13px; text-align:center;">Affiliate Me Version <?php echo $version; ?><br></div></div><div id="Html3"><div style="color:#D3D3D3;font-family:Tahoma;font-size:21px;text-align:center;">Application Server Monitor</div></div></div></body></html>