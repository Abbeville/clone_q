<?php
$tid = '';
$class = '';
$diss = '';
//Fetch ticket details using the ticket id from database
if(!empty($_GET['id'])){
$_SESSION['meid'] = $_GET["id"];
$tid = $_GET['id'];
$_SESSION['cuser'] = $_GET["uid"];
}
//Fetch ticket details
$sql10 = "SELECT * FROM tickets WHERE tid = '" . $_SESSION['meid'] . "' ";
$result = mysqli_query($link, $sql10);
$row = mysqli_fetch_array($result);
$subj = mysqli_real_escape_string($link, $row['subject']) ;
$subjr = $row['subject'] ;

//Fetch customer detils using the ticket username
$sql34 = "SELECT * FROM users WHERE USERNAME = '" . $_SESSION['cuser'] . "' ";
$result = mysqli_query($link, $sql34);
$row = mysqli_fetch_array($result);

                    $uphone = $row['PHONE'] ;
                    $user = $row['USERNAME'] ;
                    $email = $row['EMAIL'] ;
                    $name = $row['NAME'] ;

//Select user's data from database
$sql = "SELECT * FROM users WHERE USERNAME = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result);

                    $balance = $row['CREDIT'] ;
                    $avatar = $row['AVATAR'] ;
                    $online = $row['ONLINE'] ;
                    $phone = $row['PHONE'] ;
                    $username = $row['USERNAME'] ;
                    $myname = $row['NAME'] ;
                    
//Insert message detils into database when admin posts the form
if(!empty($_POST)){
$search = array(':(',':D',':)',';)','<3',' B)',':yup',':bye',':pray','<','>');
$replace = array('😠','😃','😊','😉','💙','😎','👍','👋','🙏','&lt;','&gt;');
$status = $_POST["status"];
$status1 = $_POST["status1"];
$message = mysqli_real_escape_string($link, str_replace($search, $replace, $_POST['message']));
$divs = $_POST["divs"];
$class = "right";
$times = $_POST["times"];
$tid = $_POST["tid"];

$sql2 = "INSERT INTO `tickets` (`username`, `name`, `userid`, `email`, `tid`, `subject`, `status`, `status1`, `message`, `time`, `divs`, `class`, `times`, `file`, `trash`) VALUES ('$user','Support','$username','$email','$tid','$subj','$status','$status1','$message','$time','$divs','$class','$times','','0')";
$result = mysqli_query($link, $sql2);

//HTML Message to send to user
$sql9 = "SELECT * FROM etemplates WHERE NAME = '" . $titemp . "' ";
$result = mysqli_query($link, $sql9);
$rw = mysqli_fetch_array($result);
$dbtmsg = $rw['MESSAGE'] ;

$variables = array();


$variables['sitename'] = $sitename;

$variables['ticket'] = $tid;

$variables['fullname'] = $name;


$variables['message'] = $message;


$variables['subject'] = $subj;


$template = stripslashes($dbtmsg);



foreach($variables as $key => $value)

{

$template = str_replace('{{ '.$key.' }}', $value, $template);

}
$mesg = $template;
//Proccess the message using admin's email settings
if($smtpmail == 'on') {

$subject = "Ticket ID #".$tid." Updated by Support";

$body = $mesg;
$mail->FromName = $sitename;
$mail->addAddress($email);
$mail->Subject = $subject;
$mail->Body    = $body;
$mail->send();
} else {
$subject = "Ticket ID #".$tid." Updated by Support";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From:  ' . $sitename . ' <' . $semail .'>' . " \r\n";
mail($email,$subject,$mesg,$headers);
   }
}
?><!doctype html><html><head><meta charset="utf-8"><title>Conversation of Ticket ID# <?php if(empty($tid)) { echo 'Unknown';} else { echo $tid ;} ?></title><meta name="robots" content="noindex, nofollow"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="reply.css" rel="stylesheet"><script>
function Validateticket()
{var regexp;var message=document.getElementById('message');if(!(message.disabled||message.style.display==='none'||message.style.visibility==='hidden'))
{if(message.value=="")
{alert("Message field is empty!");message.focus();return false;}}
var Editbox1=document.getElementById('Editbox1');if(!(Editbox1.disabled||Editbox1.style.display==='none'||Editbox1.style.visibility==='hidden'))
{if(Editbox1.value=="")
{alert("Please add subject");Editbox1.focus();return false;}}
return true;}</script><script src="jquery-1.12.4.min.js"></script></head><body><div id="container"><div id="wb_Form2"><form name="ticket" method="post" action="./admin.php?show=reply" enctype="multipart/form-data" id="Form2" onsubmit="return Validateticket()"><input type="hidden" name="divs" value="&lt;div class=\&quot;container darker\&quot;&gt;"><input type="hidden" name="times" value="&lt;span class=\&quot;time-right\&quot;&gt;"><input type="hidden" name="status1" value=""><input type="hidden" name="status" value="<cr>New!</cr>"><input type="hidden" name="tid" value="<?php echo $tid; ?>"><textarea name="message" id="message" rows="4" cols="131" tabindex="1" autofocus spellcheck="true" placeholder="<?php echo $lang['message'];?>"></textarea><input type="text" id="Editbox1" name="subject" value="<?php echo nl2br($subjr); ?>" tabindex="2" readonly disabled autocomplete="off" spellcheck="false" placeholder="<?php echo $lang['subject'];?>" <?php echo $class; ?> class="<?php echo $class; ?>" <?php echo $diss; ?>><div id="Html4"><center><span style="color:#1E90FF;font-family:Arial;font-size:21px;"><strong><?php echo $lang['tickconv'];?><?php if(empty($tid)) { echo 'Unknown';} else { echo $tid ;} ?></strong></span></center></div><div id="Html8"><?php
 
    // Attempt select query execution
    
    $sql = "SELECT * FROM tickets WHERE tid = '" . $tid . "' ORDER BY id DESC";
    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
           
//Fetch and display data from database
            while($row = mysqli_fetch_array($result)){
            
                             
                 $sql71 = "SELECT * FROM users WHERE USERNAME = '" . $row['userid'] . "' ";
                 $res = mysqli_query($link, $sql71);
                 $ro = mysqli_fetch_array($res);

                  $profile = $ro['AVATAR'] ;
                  
                 echo htmlspecialchars_decode(stripslashes($row['divs']));               
                  echo "<img src='avatars/". $profile ."' class='".$row['class']."' onerror=\"this.src='images/defavat.png';\" />"; echo "<td>" . $row['status1'] . "</td>";
                  
                    echo htmlspecialchars_decode(stripslashes($row['times'])) . "<i>" . "From "; if ($row['userid'] == $username) echo "You" ; else echo $row['userid']; echo " <i class=\"fa fa-clock-o\">&nbsp;</i>: " . date('y-m-d', $row['time']) . "</i>" . "</span>";
                    
                    echo "<span style=\"color:#FF0000;\" class=\"time-left\" ></span><br>";
                    echo "<p>" . "<span style=\"color:#DCDCDC;font-family:Tahoma;font-size:16px;\">" . nl2br($row['message']) . "</span>" . "</p>";
                    
                echo "</div>";
            }

            // Close result set
            mysqli_free_result($result);
        } else{
            echo "<br><br><span style=\"color:#FF1493;font-family:Arial;font-size:18px;\"><strong><br><br><br><br><center>No conversations in this ticket,<br>use the text box below to start one!</center></strong></span>";
        }
    } 
$sql23 = "UPDATE tickets SET status1='' WHERE tid = '" . $tid . "' ";
$updt = mysqli_query($link, $sql23);
?></div><div id="Html3"><button type="submit" class="send"><i class="fa fa-reply">&nbsp;</i>&nbsp;REPLY</button></div><div id="Html1"><span style="color:#1E90FF;font-family:Arial;font-size:16px;"><strong><?php echo $lang['subject'];?>:</strong></span></div></form></div><div id="Html23"><div style="color:#A9A9A9;font-family:Arial;font-size:13px; text-align:center;">Affiliate Me Version <?php echo $version; ?><br></div></div></div></body></html>