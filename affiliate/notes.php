<?php
// Powerstone Affiliate Me, Version 1.0.0 https://www.powerstonegh.com.
include "db.php";
$idb = $dbserver;
if (empty($idb)){header("Location:installer.php");}
$link = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbdatabase);
?><?php
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
?><!doctype html><html><head><meta charset="utf-8"><title>Notes</title><meta name="robots" content="noindex, nofollow"><link href="notes.css" rel="stylesheet"></head><body><?php echo "<br>" ;?><?php
//Fetch results from database and display in a table
    $sql = "SELECT * FROM notes WHERE USERNAME = '" . $_SESSION['username'] . "' ORDER BY status DESC, id DESC LIMIT 5";
    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
           
            while($row = mysqli_fetch_array($result)){
            
            echo "<table class=\"notes\">";
                    
                    if($row['STATUS']== "1") echo "<th><img src='images/" . $row['ICON'] . "'></th>" . "<th><a href='" . $row['LINK'] . "'>" . "<strong>Sent by System: " . $row['DATE'] . "</strong><br>" . "<span style=\"color:#FFFFFF;font-family:Tahoma;font-size:12px;\">" . $row['MESSAGE'] . "</span></a></th>"; else echo "<td><img src='images/read_" . $row['ICON'] . "'></td>" . "<td><a href='" . $row['LINK'] . "'>" . "Sent by System: " . $row['DATE'] . "<br>" . "<span style=\"color:#A9A9A9;font-family:Tahoma;font-size:12px;\">" . $row['MESSAGE'] . "</span>" . "</a></td>";
                    
                echo "</table>";
            }

            // Close result set
            mysqli_free_result($result);
        } else{
            echo "<span style=\"color:#4F4F4F;font-family:Arial;font-size:18px;\"><strong><center><br>No Notifications!</center><br></strong></span>";
        }
    }
      echo "<br><a href=\"./user.php?show=notes\"><button class=\"va\">View All Notifications</button></a>";
?><?php
//Mark read messages as read
 $sql2 = "UPDATE notes SET status='0' WHERE USERNAME = '" . $_SESSION['username'] . "' ORDER BY status DESC, id DESC LIMIT 5";
 $result = mysqli_query($link, $sql2);
//Close connection
 mysqli_close($link);
 ?></body></html>