<?php if(empty($link)){header('Location: ./user.php'); exit;} ?><!doctype html><html><head><meta charset="utf-8"><title>User | Notifications</title><meta name="robots" content="noindex, nofollow"><meta name="generator" content="Powerstone"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="allnotes.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="Html1"><?php echo "<br>" ;?><?php

    $sql = "SELECT * FROM notes WHERE USERNAME = '" . $_SESSION['username'] . "' ORDER BY status DESC, id DESC ";
//Echo results from database into table
    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
           
            while($row = mysqli_fetch_array($result)){
            
            echo "<table id=\"notes\">";
                    
                    if($row['STATUS']== "1") echo "<th width='50'><img src='images/" . $row['ICON'] . "'></th>" . "<th><a href='" . $row['LINK'] . "'>" . "<strong>Sent by System: " . $row['DATE'] . "</strong><br>" . "<span style=\"color:#1E1E1E;font-family:Tahoma;font-size:12px;\">" . $row['MESSAGE'] . "</span></a></th>"; else echo "<td width='50'><img src='images/read_" . $row['ICON'] . "'></td>" . "<td><a href='" . $row['LINK'] . "'>" . "Sent by System: " . $row['DATE'] . "<br>" . "<span style=\"color:#A9A9A9;font-family:Tahoma;font-size:12px;\">" . $row['MESSAGE'] . "</span>" . "</a></td>";
                    
                echo "</table>";
            }

            // Close result set
            mysqli_free_result($result);
        } else{
            echo "<span style=\"color:#4F4F4F;font-family:Arial;font-size:18px;\"><strong><center><br>No Notifications!</center><br></strong></span>";
        }
    } 
    ?><?php
//Mark read messages as read
 $sql2 = "UPDATE notes SET status='0' WHERE USERNAME = '" . $_SESSION['username'] . "' ORDER BY status DESC";
 $result = mysqli_query($link, $sql2);
 mysqli_close($link);
 ?></div><div id="Html2"><div style="color:#808080;font-family:Arial;font-size:19px;text-align:center;"><strong><?php echo $lang["allnotes"]; ?></strong></div></div></div></body></html>