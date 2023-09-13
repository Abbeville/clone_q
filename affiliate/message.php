<?php if(empty($link)){header('Location: ./user.php'); exit;} 
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
$tid = '';
$subj = '';
$class = '';
$diss = '';
//If form is submited, define the posted variables and store them into a database
if(!empty($_POST) && $_POST["token"]==$token && strtolower($_SERVER['HTTP_HOST'])==strtolower(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST))){
if(empty($_POST["tid"])) { $tid = rand(111111, 999999);} else { $tid = $_POST["tid"];}
$search = array(':(',':D',':)',';)','<3',' B)',':yup',':bye',':pray','<','>');
$replace = array('😠','😃','😊','😉','💙','😎','👍','👋','🙏','&lt;','&gt;');
$subj = mysqli_real_escape_string($link, str_replace($search, $replace, $_POST['subject']));
$status = mysqli_real_escape_string($link, $_POST["status"]);
$status1 = mysqli_real_escape_string($link, $_POST["status1"]);
$message = mysqli_real_escape_string($link, str_replace($search, $replace, $_POST['message']));
$divs = mysqli_real_escape_string($link, $_POST["divs"]);
$class = "";
$times = mysqli_real_escape_string($link, $_POST["times"]);
if(!isset($_POST["subject"])){
$sql11 = "SELECT * FROM tickets WHERE tid = '" . $tid . "' ";
$result = mysqli_query($link, $sql11);
$row = mysqli_fetch_array($result);
$subj = mysqli_real_escape_string($link, $row['subject']) ;
}

$sql2 = "INSERT INTO `tickets` (`username`, `name`, `userid`, `email`, `tid`, `subject`, `status`, `status1`, `message`, `time`, `divs`, `class`, `times`, `file`, `trash`) VALUES ('$username','$name','$username','$email','$tid','$subj','$status','$status1','$message','$time','$divs','$class','$times','','0')";
$result = mysqli_query($link, $sql2);
$class = 'readonly';
$diss = 'disabled';

//Send an email message to admin to alert them of a new ticket update
$subject = "A new message";
$message = "Hello admin, please you just received a new message on the ticket with the subject ". $subj .", kindly log into your affiliate dashboard to reply this ticket, thanks.";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From:  ' . $sitename . ' <noreply@powerstonegh.com>' . " \r\n";
mail($semail,$subject,$message,$headers);
//If Ticket alert by SMS is ON but there is no admin online, then send them an SMS alert
if($smsticket == 'on') {
$sonline=0;
$sql7="SELECT * FROM users WHERE acess = 'admin' AND $time - online > '406'";
$result=mysqli_query($link, $sql7);
$sonline=mysqli_num_rows($result);

if($sonline > 0) {
$msg = "You just received a new message from your affiliate " . $name . " under the subject " . $subj . " kindly log in to check and reply!";
$sender_id = "New+Msg";
$date_time = "";

$msg1 = urlencode($msg);
$url = "https://apps.mnotify.net/smsapi?"
            . "key=$mnotifykey"
            . "&to=$phone"
            . "&msg=$msg1"
            . "&sender_id=$sender_id"
            . "&date_time=$date_time";
$response = file_get_contents($url) ;
      }
   }
}
//Define user header notification variables
$ticketid = $_GET['id'];
//Load message from database using a ticket ID if the user tried to reply to it
if(!empty($ticketid) && preg_match("/^[0-9. ]+$/", $ticketid)){
$mid = mysqli_real_escape_string($link, $ticketid);
$sql10 = "SELECT * FROM tickets WHERE tid = '" . $mid . "' ";
$result = mysqli_query($link, $sql10);
$row = mysqli_fetch_array($result);

$subj = mysqli_real_escape_string($link, $row['subject']) ;
$tid = $ticketid;
$class = 'readonly';
$diss = 'disabled';
}

if(!empty($_GET['subj'])){
$subj = $_GET['subj'] ;
}

?><!doctype html><html><head><meta charset="utf-8"><title>User | Conversation of Ticket ID# <?php if(empty($tid)) { echo 'Unknown';} else { echo $tid ;} ?></title><meta name="robots" content="noindex, nofollow"><meta name="generator" content="Powerstone"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="message.css" rel="stylesheet"><script>
function Validateticket()
{var regexp;var message=document.getElementById('message');if(!(message.disabled||message.style.display==='none'||message.style.visibility==='hidden'))
{if(message.value=="")
{alert("Message field is empty!");message.focus();return false;}}
var Editbox1=document.getElementById('Editbox1');if(!(Editbox1.disabled||Editbox1.style.display==='none'||Editbox1.style.visibility==='hidden'))
{if(Editbox1.value=="")
{alert("Please add subject");Editbox1.focus();return false;}}
return true;}</script><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="wb_Form2"><form name="ticket" method="post" action="./user.php?show=message" enctype="multipart/form-data" id="Form2" onsubmit="return Validateticket()"><input type="hidden" name="divs" value="&lt;div class=\&quot;container\&quot;&gt;"><input type="hidden" name="times" value="&lt;span class=\&quot;time-left\&quot;&gt;"><input type="hidden" name="status1" value="<cr>New!</cr>"><input type="hidden" name="status" value=""><input type="hidden" name="tid" value="<?php echo $tid; ?>"><input type="hidden" name="token" value="<?php echo $token; ?>"><textarea name="message" id="message" rows="4" cols="132" tabindex="1" autofocus spellcheck="true" placeholder="<?php echo $lang['message'];?>"></textarea><div id="Html2"><button type="submit" class="send"><i class="fa fa-paper-plane">&nbsp;</i>&nbsp;<?php echo $lang['send'];?></button></div><input type="text" id="Editbox1" name="subject" value="<?php echo nl2br($subj); ?>" tabindex="2" spellcheck="false" placeholder="<?php echo $lang['subject'];?>" <?php echo $class; ?> class="<?php echo $class; ?>" <?php echo $diss; ?>><div id="Html3"><?php
 
    // Attempt select query execution
    
    $sql = "SELECT * FROM tickets WHERE username = '" . $_SESSION["username"] . "' AND tid = '" . $tid . "' ORDER BY id DESC";
//Fetch chat results from database into table
    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
           
            while($row = mysqli_fetch_array($result)){
            
                             
                 $sql71 = "SELECT * FROM users WHERE USERNAME = '" . $row['userid'] . "' ";
                 $res = mysqli_query($link, $sql71);
                 $ro = mysqli_fetch_array($res);

                  $profile = $ro['AVATAR'] ;
                  
                 echo htmlspecialchars_decode(stripslashes($row['divs']));               
                  echo "<img src='avatars/". $profile ."' class='".$row['class']."' onerror=\"this.src='images/defavat.png';\" />"; echo "<td>" . $row['status'] . "</td>";
                  
                    echo htmlspecialchars_decode(stripslashes($row['times'])) . "<i><span style=\"font-size:12px;\">" . "From "; if ($row['userid'] == $username) echo "You" ; else echo $row['name']; echo " <i class=\"fa fa-clock-o\">&nbsp;</i>: " . date('y-m-d', $row['time']) . "</span></i>" . "</span>";
                    
                    echo "<span style=\"color:#FF0000;\" class=\"time-left\" ></span><br>";
                    echo "<p>" . "<span style=\"color:#696969;font-family:Tahoma;font-size:16px;\">" . nl2br($row['message']) . "</span>" . "</p>";
                    
                echo "</div>";
            }

            // Close result set
            mysqli_free_result($result);
        } else{
            echo "<br><br><span style=\"color:#FF1493;font-family:Arial;font-size:18px;\"><strong><br><br><br><br><center>".$lang['noconv']."</center></strong></span>";
        }
    }
    ?></div><div id="Html1"><center><span style="color:#1E90FF;font-family:Arial;font-size:21px;"><strong><?php echo $lang['tickconv'];?><?php if(empty($tid)) { echo 'Unknown';} else { echo $tid ;} ?></strong></span></center></div><div id="Html4"><span style="color:#1E90FF;font-family:Arial;font-size:16px;"><strong><?php echo $lang['subject'];?>:</strong></span></div></form></div><div id="copyright"><div style="color:#696969;font-family:Arial;font-size:15px; text-align:center;"><?php echo "Copyright © " .$year ." " .$sitename. ", All Rights Reserved."; ?></div></div></div></body></html><?php
    $sql23 = "UPDATE tickets SET status='' WHERE tid = '" . $tid . "' ";
    if(mysqli_query($link, $sql23)){
        echo "";
    }     
    // Close connection
    mysqli_close($link);
    ?>