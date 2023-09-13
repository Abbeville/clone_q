<?php if(empty($link)){header('Location: /index.php'); exit;} 
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
$error_message = '';
$rememberme = '';
$right = '';
//SMTP Email Config
require_once("mailer/autoload.php"); 
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = $mailhost;
$mail->SMTPAuth = true;
$mail->Username = $musername;
$mail->Password = $mpassword;
$mail->SMTPSecure = 'ssl';
$mail->Port = $mport;
$mail->From = $semail;
$mail->addReplyTo($semail);
$mail->isHTML(true);
mysqli_set_charset($link,"utf8");
if(empty($_SESSION["token"])){$_SESSION["token"]=rand(11111, 99999);}
$token = $_SESSION["token"];
if(!empty($_POST) && strtolower($_SERVER['HTTP_HOST'])==strtolower(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST))){
$uid = mysqli_real_escape_string($link, $_POST['username']);
$password = mysqli_real_escape_string($link, $_POST['password']);
$rememberme = isset($_POST['remember']) ? $_POST['remember'] : '';
//Validate token
if($_POST["token"]!=$token) {$error_message = "Sorry session token has expired, kindly try again";}
//Detect if input password and username match else echo error
$counter=0;
$pcounter=0;
$sql3="SELECT * FROM users  WHERE USERNAME = '" . $uid . "' ";
$result=mysqli_query($link, $sql3);
$counter=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
$dpass = $row['PASSWORD'] ;
if (password_verify($password, $dpass)) { $pcounter=1; }
$tcounter = $counter * $pcounter;
if ($tcounter == 0)
   {
      $sql2="SELECT * FROM users  WHERE EMAIL = '" . $uid . "' ";
$result=mysqli_query($link, $sql2);
$counter=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
$dpass = $row['PASSWORD'] ;
if (password_verify($password, $dpass)) { $pcounter=1; }
$tcounter = $counter * $pcounter;
if ($tcounter == 0)
   {
      $error_message = $lang["loginerror"];
   }
else {
$sql = "SELECT * FROM users WHERE EMAIL = '" . $uid . "' ";
    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){

            while($row = mysqli_fetch_array($result)){

                    $username = $row['USERNAME'] ;
                    $email = $row['EMAIL'] ;
                    $fullname = $row['NAME'] ;
                    $right = $row['ACESS'] ;
            }

            mysqli_free_result($result);
        } else{
            $error_message = $lang["techerror"];
        }
    }
   }
 } else {
$sql = "SELECT * FROM users WHERE USERNAME = '" . $uid . "' ";
    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){

            while($row = mysqli_fetch_array($result)){

                    $username = $row['USERNAME'] ;
                    $email = $row['EMAIL'] ;
                    $fullname = $row['NAME'] ;
                    $right = $row['ACESS'] ;
                    
            }

            mysqli_free_result($result);
        } else{
            $error_message = $lang["techerror"];
        }
    } 
}
//Check if the user have been blocked and dipaly notice
if ($right == 'zblocked')
   {
      $error_message = $lang["acblock"];
   }
//If all credentials match, start session and send user to log.php for login tracking
if (empty($error_message)){
$_SESSION["username"] = $username;
$_SESSION["fullname"] = $fullname;
$_SESSION["email"] = $email;
$_SESSION["right"] = $right;
//Check and record login details
$user_agent     =   $_SERVER['HTTP_USER_AGENT'];
function getOS() { 
    global $user_agent;
    $os_platform    =   "Unknown OS Platform";
    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );
    foreach ($os_array as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }
    }   
    return $os_platform;
}

$user_os        =   getOS();
if($user_os=='Windows 10' || $user_os=='Windows 8.1' || $user_os=='Windows 8' || $user_os=='Windows 7' || $user_os=='Windows Vista' || $user_os=='Windows Server 2003/XP x64' || $user_os=='Windows XP' || $user_os=='Windows 2000' || $user_os=='Windows ME' || $user_os=='Windows 98' || $user_os=='Windows 95' || $user_os=='Windows 3.11'){$oslogo='os/windows.png';} else if($user_os=='Mac OS X' || $user_os=='Mac OS 9' || $user_os=='iPhone' || $user_os=='iPod' || $user_os=='iPad'){$oslogo='os/mac.png';} else if($user_os=='Linux'){$oslogo='os/linux.png';} else if($user_os=='Ubuntu'){$oslogo='os/ubuntu.png';} else if($user_os=='Android'){$oslogo='os/android.png';} else if($user_os=='BlackBerry'){$oslogo='os/blackberry.png';} else if($user_os=='Mobile'){$oslogo='os/mobile.png';} else {$oslogo='os/unknown.png';}
//Obtaining the browser of user
$browser="";
if(strrpos(strtolower($_SERVER["HTTP_USER_AGENT"]),strtolower("MSIE")))
{
$browser="Internet Explorer"; $brologo="browsers/ie.png";
}
else if(strrpos(strtolower($_SERVER["HTTP_USER_AGENT"]),strtolower("Presto")))
{
$browser="Opera"; $brologo="browsers/opera.png";
}
else if(strrpos(strtolower($_SERVER["HTTP_USER_AGENT"]),strtolower("CHROME")))
{
$browser="Google Chrome"; $brologo="browsers/chrome.png";
}
else if(strrpos(strtolower($_SERVER["HTTP_USER_AGENT"]),strtolower("SAFARI")))
{
$browser="Safari"; $brologo="browsers/safari.png";
}
else if(strrpos(strtolower($_SERVER["HTTP_USER_AGENT"]),strtolower("FIREFOX")))
{
$browser="Mozilla Firefox"; $brologo="browsers/firefox.png";
}
else
{
$browser=" Unknown Browser"; $brologo="browsers/unknown.png";
}

/*Get user ip address*/
$ip_address=$_SERVER['REMOTE_ADDR'];
 
/*Get user ip address details with geoplugin.net*/
$geopluginURL='http://www.geoplugin.net/php.gp?ip='.$ip_address;
$addrDetailsArr = unserialize(file_get_contents($geopluginURL));
 
/*Get City name by return array*/
$city = $addrDetailsArr['geoplugin_city'];
 
/*Get Country name by return array*/
$country = $addrDetailsArr['geoplugin_countryName'];
/*Get Region name by return array*/
$region = $addrDetailsArr['geoplugin_region'];
 
if(!$city){
   $city='Unknown!';
}if(!$region){
   $region='Unknown!';
}if(!$country){
   $country='Unknown!';
}
$flag = "flags/".strtolower($addrDetailsArr['geoplugin_countryCode']).".png";
//Detect if it is a new device
$sql7="SELECT * FROM login  WHERE USERNAME = '" . $_SESSION['username'] . "' && BROWID = '".$browid."' ";
$resulte=mysqli_query($link, $sql7);
$kbrw=mysqli_num_rows($resulte);

//add records to database
$sql2 = "INSERT INTO `login` (`USERNAME`, `CITY`,`COUNTRY`, `IP`, `OS`, `DATE`, `TIME`, `BROWSER`, `FLAG`, `OSLOGO`, `BROLOGO`, `BROWID`) VALUES ('$username','$city','$country','$ip_address','$user_os','$time','$time','$browser','$flag','$oslogo','$brologo','$browid')";
$result = mysqli_query($link, $sql2);

//Update last activity time in database
$sql100 = "UPDATE users SET ONLINE='".$time."' WHERE USERNAME = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($link, $sql100);

//2Factor authentication processor
$sql = "SELECT * FROM users WHERE USERNAME = '" . $_SESSION['username'] . "' ";
$result1 = mysqli_query($link, $sql);
$row = mysqli_fetch_array($result1);
                    $dfa = $row['DFA'] ;
                    $uemail = $row['EMAIL'] ;
                    $rname = $row['NAME'] ;
                    
if($dfa == "" && $kbrw < 1){
//Send email
$message = '<meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Vibaze Charts</title>
      
  
    <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">New Browser.</span>
    <table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;" cellspacing="0" cellpadding="0" border="0">
      <tbody><tr>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
        <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
          <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">
            <!-- START CENTERED WHITE CONTAINER -->
            <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">
              <!-- START MAIN CONTENT AREA -->
              <tbody><tr>
                <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                  <table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" cellspacing="0" cellpadding="0" border="0">
                    <tbody><tr>
                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                        <div>
                        <div style="text-align:center;"><b><font color="#000000"><img alt="Logo" src="'.$prot.$domain.'/'.$logo.'" style="max-width:150px; max-height:150px;" align="middle"></font></b></div><br>
                        <div style="text-align:center;"><div style="text-align:center;"><b></div><b><font size="4" color="#000000">LOGIN FROM A NEW BROWSER/DEVICE</font></b><br></div>
                        <br>
                        <font color="#000000">Hello '.$rname.',</font></div><font color="#000000"> we just noticed that a new browser just logged into your account, please quickly contact support and login to change your password and enable the 2-factor authentication if this login was was not by you.<br>
                        Details of the new browser are below;<br>
                        <strong>
                        Browser: <img src="'.$prot.$domain.'/'.$brologo.'" style="vertical-align: middle;" width="17" height="17"> '.$browser.'<br>
                        Operating System: <img src="'.$prot.$domain.'/'.$oslogo.'" style="vertical-align: middle;" width="17" height="17"> '.$user_os.'<br>
                        Country: <img src="'.$prot.$domain.'/'.$flag.'" style="vertical-align: middle;" width="17" height="17"> '.$country.'<br>
                        </strong>
                        <br></font><div><font color="#000000">Regards.</font></div>
                        <br>
                        <div style="text-align:center;"><a href="'.$prot.$domain.'" target="_blank" style="display: inline-block; color: #ffffff; background-color: #1E90FF; border: solid 1px #1E90FF; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #1E90FF;">Login</a><table width="200" cellspacing="0" cellpadding="0" border="0" align="center"></div>
                      </td>
                    </tr>
                  </tbody></table>
                </td>
              </tr>
            <!-- END MAIN CONTENT AREA -->
            </tbody></table>
          <!-- END CENTERED WHITE CONTAINER -->
          </div>
          
          <!-- START FOOTER -->
      <div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;">
       <table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" cellspacing="0" cellpadding="0" border="0">
        <tbody><tr>
        <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">&nbsp;You are receiving this message because you are a member of '.$domain.'.<br>Copyright © '.date("Y").'.<span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;"></span>
        </td>
       </tr>
      </tbody></table>
   </div>
   <!-- END FOOTER -->
          
        </td>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
      </tr>
    </tbody></table>
';
if($smtpmail == 'on') {


$subject = "New Browser Detected";

$body = $message;
$mail->FromName = $sitename;
$mail->addAddress($uemail);
$mail->Subject = $subject;
$mail->Body    = $body;
$mail->send();
} else {
$subject = "New Browser Detected";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From:  ' . $sitename . ' <' . $semail .'>' . " \r\n";
mail($uemail,$subject,$message,$headers);
   }

} else
if($dfa == "yes" && $kbrw < 1){
    
$otp = rand(1111, 9999);
$_SESSION["otp"] = $otp;
$_SESSION["browid"] = $browid;
setcookie("browser", "", time()-3600);
//Send Email
$message = '<meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Vibaze Charts</title>
      
  
    <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">Authentication.</span>
    <table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;" cellspacing="0" cellpadding="0" border="0">
      <tbody><tr>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
        <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
          <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">
            <!-- START CENTERED WHITE CONTAINER -->
            <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">
              <!-- START MAIN CONTENT AREA -->
              <tbody><tr>
                <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                  <table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" cellspacing="0" cellpadding="0" border="0">
                    <tbody><tr>
                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                        <div>
                        <div style="text-align:center;"><b><font color="#000000"><img alt="Logo" src="'.$prot.$domain.'/'.$logo.'" style="max-width:150px; max-height:150px;" align="middle"></font></b></div><br>
                        <div style="text-align:center;"><div style="text-align:center;"><b></div><b><font size="4" color="#000000">LOGIN FROM A NEW BROWSER/DEVICE</font></b><br></div>
                        <br>
                        <font color="#000000">Hello '.$rname.',</font></div><font color="#000000"> we just noticed that a new browser tried gaining access to your account on our website but because you enabled 2-factor authentication we decided to send you the authentication code, please login to change your password if the login attempt was not by you.<br>
                        Details of the new browser are below;<br>
                        <strong>
                        Browser: <img src="'.$prot.$domain.'/'.$brologo.'" style="vertical-align: middle;" width="17" height="17"> '.$browser.'<br>
                        Operating System: <img src="'.$prot.$domain.'/'.$oslogo.'" style="vertical-align: middle;" width="17" height="17"> '.$user_os.'<br>
                        Country: <img src="'.$prot.$domain.'/'.$flag.'" style="vertical-align: middle;" width="17" height="17"> '.$country.'<br>
                        </strong>
                        Your authentication code is: <strong>'.$otp.'</strong> and you can equally use the button below to authenticate without having to copy and paste!<br><br></font><div><font color="#000000">Regards.</font></div>
                        <br>
                        <div style="text-align:center;"><a href="'.$prot.$domain.'/checkpoint.php?auth='.$otp.'" target="_blank" style="display: inline-block; color: #ffffff; background-color: #1E90FF; border: solid 1px #1E90FF; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #1E90FF;">Confirm</a><table width="200" cellspacing="0" cellpadding="0" border="0" align="center"></div>
                      </td>
                    </tr>
                  </tbody></table>
                </td>
              </tr>
            <!-- END MAIN CONTENT AREA -->
            </tbody></table>
          <!-- END CENTERED WHITE CONTAINER -->
          </div>
          
          <!-- START FOOTER -->
      <div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;">
       <table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" cellspacing="0" cellpadding="0" border="0">
        <tbody><tr>
        <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">&nbsp;You are receiving this message because you are a member of '.$domain.'.<br>Copyright © '.date("Y").'.<span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;"></span>
        </td>
       </tr>
      </tbody></table>
   </div>
   <!-- END FOOTER -->
          
        </td>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
      </tr>
    </tbody></table>
';

if($smtpmail == 'on') {


$subject = "New Browser Detected";

$body = $message;
$mail->FromName = $sitename;
$mail->addAddress($uemail);
$mail->Subject = $subject;
$mail->Body    = $body;
$mail->send();
} else {
$subject = "New Browser Detected";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From:  ' . $sitename . ' <' . $semail .'>' . " \r\n";
mail($uemail,$subject,$message,$headers);
   }
}

//Redirect User to appropriate page
if ($_SESSION['right'] == 'superadmin') {header("Location: ./admin.php");}
else
if($_SESSION['right'] == 'admin') {header("Location: ./admin.php");} else {header("Location: ./user.php");}
   }
}
if ($rememberme == 'on')
      {
         setcookie('username', $uid, time() + 3600*24*30);
         setcookie('password', $password, time() + 3600*24*30);
      }
if(isset($_COOKIE['username'])){$user = $_COOKIE['username'];} else {$user = "";}
if(isset($_COOKIE['password'])){$pass = $_COOKIE['password'];} else {$pass = "";}
?><!doctype html><html><head><meta charset="utf-8"><title><?php echo $lang["login"];?> | <?php echo $sitename; ?></title><meta name="robots" content="index, follow"><meta name="generator" content="Powerstone"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="font-awesome.min.css" rel="stylesheet"><link href="login.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script><script src="wwb14.min.js"></script></head><body><div id="container"><div id="Html4"><?php
if($error_message !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:14px;\"><center><i class=\"fa fa-info-circle\">&nbsp;</i><strong>" . $error_message . "</strong></center></div></div>";
}
?></div><div id="wb_Form1"><form name="login" method="post" action="./index.php" id="Form1" onsubmit="ShowObject('Html1', 0);ShowObject('Html2', 1);document.getElementById('Form1').submit();return false;"><input type="hidden" name="token" value="<?php echo $token; ?>"><div id="Html2"><but class="button2" disabled><div class="fa fa-spinner fa-pulse"></div>&nbsp;&nbsp;<?php echo $lang["validating"];?></but></div><input type="text" id="username" name="username" value="<?php echo $user; ?>" autofocus spellcheck="false" placeholder="<?php echo $lang['useremail'];?>"><input type="password" id="password" name="password" value="<?php echo $pass; ?>" spellcheck="false" placeholder="<?php echo $lang['password'];?>"><div id="wb_FontAwesomeIcon1"><div id="FontAwesomeIcon1"><i class="fa fa-user"></i></div></div><div id="wb_FontAwesomeIcon2"><div id="FontAwesomeIcon2"><i class="fa fa-key"></i></div></div><div id="Html1"><button type="submit" class="button"><i class="fa fa-sign-in">&nbsp;</i>&nbsp;&nbsp;<?php echo $lang["login"];?></button></div><div id="wb_remember"><input type="checkbox" id="remember" name="remember" value="on"><label for="remember"></label></div><div id="Html7"><div style="color:#1E90FF;font-family:Arial;font-size:17px;text-align:center;"><strong><?php echo $lang["login"];?></strong></div></div><label for="remember" id="Label1"><?php echo $lang['remme'];?></label><div id="Html3"><div style="color:#696969;font-family:Arial;font-size:15px; text-align:center;"><?php echo $lang["forgpass"];?>&nbsp;<strong><a href="./passrecover.php"><?php echo $lang["getnew"];?></a></strong><br><br><?php echo $lang["newmember"];?>&nbsp;<strong><a href="./signup.php"><?php echo $lang["signup"];?></a></strong></div></div><div id="Html9"><div class="logo"><a href="./"><img src="<?php echo $logo; ?>" alt="Logo"></a></div></div></form></div><div id="Html24"><?php
$dir = "locale";
/* Hide this */
$hideName = array('.','..','.DS_Store');    
// Sort in ascending order - this is default
$files = scandir($dir);
/* While this to there no more files are */
  $ldet=explode("-",$locale);
  $cfile = $ldet[0];
  $clflag = $ldet[1];
 echo "<div style='text-align:center;' class='dropup'><span class='language coflag'>Language: <img src='flags/".$clflag.".png'></a>".ucwords($cfile)."</span><div class='dropup-content'>";
foreach($files as $filename) {
    if(!in_array($filename, $hideName)){
       /* echo the name of the files */
       
  $str_explode=explode(".",$filename);
  $ffile = $str_explode[0];
  
  $str_explode=explode("-",$ffile);
  $file = $str_explode[0];
  $lflag = $str_explode[1];
  
  echo "<a href='?locale=".$ffile."' class='coflag'> <img src='flags/".$lflag.".png'> ".ucwords($file)."</a>";
    
    }
}
 
 echo "</div></div>";
 
 ?></div></div></body></html>