<?php
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
include "db.php";
$idb = $dbserver;
if (empty($idb)){header("Location:index.php");}

$con = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbdatabase);
date_default_timezone_set($tzone);
$date = date("Y-m-d");
$time = date("G:i:s");
$ts = time();
if (session_id() == "")
{
   session_start();
}
if (!isset($_SESSION['username']))
{
   header('Location: ./index.php');
   exit;
}
if (isset($_SESSION['expires_by']))
{
   $expires_by = intval($_SESSION['expires_by']);
   if (time() < $expires_by)
   {
      $_SESSION['expires_by'] = time() + intval($_SESSION['expires_timeout']);
   }
   else
   {
      unset($_SESSION['username']);
      unset($_SESSION['expires_by']);
      unset($_SESSION['expires_timeout']);
      header('Location: ./index.php');
      exit;
   }
}
//Restrict page access to only admin and super admin
if ($_SESSION['right'] != 'admin' && $_SESSION['right'] != 'superadmin') header("Location: /user.php");
$return = "";
//Create table array for backup and start backup
$tables = array();
$result = mysqli_query($con,"SHOW TABLES");
while ($row = mysqli_fetch_row($result)) {
	$tables[] = $row[0];
}
$return .= "-- Powerstone Database Backup Wizard
-- Version 1.3
-- https://www.powerstonegh.com/
-- Backup Generated for Database `".$dbdatabase."` 
-- Backup Generated Time: ".$date.", ".$time."--";
foreach ($tables as $table) {
	$result = mysqli_query($con, "SELECT * FROM ".$table);
	$num_fields = mysqli_num_fields($result);

	$row2 = mysqli_fetch_row(mysqli_query($con, 'SHOW CREATE TABLE '.$table));
	$return .= "\n\n".$row2[1].";\n\n";
	for ($i=0; $i < $num_fields; $i++) { 
		while ($row = mysqli_fetch_row($result)) {
			$return .= 'INSERT INTO `'.$table.'` VALUES (';
			for ($j=0; $j < $num_fields; $j++) { 
				$row[$j] = addslashes($row[$j]);
				if (isset($row[$j])) {
					$return .= "'$row[$j]'";} else { $return .= '""';}
					if($j<$num_fields-1){ $return .= ','; }
				}
				$return .= ");\n";
			}
		}
		$return .= "\n\n\n";
	
}
//Create and save backup as backup.sql in the backup folder
$handle = fopen('backup/backup.sql', 'w+');
fwrite($handle, $return);
fclose($handle);

$config = 'backup/backup.php';
$file = fopen($config, 'w');
      fwrite($file, '<?php');
      fwrite($file, "\r\n");
      fwrite($file, '$btime');
      fwrite($file, ' = ');
      fwrite($file, '"');
      fwrite($file, $ts);
      fwrite($file, '";');
      fclose($file);
//Now download the backup to your local hard drive
header('Content-type: text/x-sql');
header('Content-Disposition: attachment; filename="dbbackup.sql"');
readfile('backup/backup.sql');
exit;
?><!doctype html><html><head><meta charset="utf-8"><title>Backup</title><meta name="robots" content="noindex, nofollow"><link href="backup.css" rel="stylesheet"></head><body></body></html>