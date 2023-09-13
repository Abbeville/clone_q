<?php
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
include "db.php";
if(empty($dbserver)){header('Location: /index.php'); exit;}
date_default_timezone_set($tzone);
$time = time();
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
$sucm = '';
$link = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbdatabase);
$error_message = '';
//start session and check if capcha should be enabled or not
session_start();
if(isset($_COOKIE['browser']))
{$browid = $_COOKIE['browser'];}
else
{$browid = $time; setcookie('browser', $time, time() + 3600*24*360);}
if(isset($_SESSION['locale']))
{
    $locale = $_SESSION['locale'];
}
else
{
    $locale = $locale;
}
if(file_get_contents("locale/".$locale.".php"))
{
    include "locale/".$locale.".php";
}
else
{
    include "locale/en-us.php";
}
$visibility = "hidden";
if($capcha=='on') {
$visibility = "visible";
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
   if (isset($_POST['captcha_code'],$_SESSION['random_txt']) && md5($_POST['captcha_code']) == $_SESSION['random_txt'])
   {
      unset($_POST['captcha_code'],$_SESSION['random_txt']);
   }
   else
   {
      $error_message = 'Wrong captcha code, retry!';
   }
  }
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
   $city='Not Define';
}if(!$country){
   $country='Please select Country!';
}
$mip = $ip_address;
$cdc = "https://ipapi.co/".$mip."/country_calling_code";
$ccode = file_get_contents($cdc);
//Process form data
mysqli_set_charset($link, 'utf8');
if(empty($_SESSION["token"])){$_SESSION["token"]=rand(11111, 99999);}
$token = $_SESSION["token"];
if(!empty($_POST) && $_POST["token"]==$token && strtolower($_SERVER['HTTP_HOST'])==strtolower(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST))){

   $username = mysqli_real_escape_string($link, $_POST['username']);
   $email = mysqli_real_escape_string($link, $_POST['email']);
   $password = mysqli_real_escape_string($link, $_POST['password']);
   $confirmpassword = mysqli_real_escape_string($link, isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : '');
   $fullname = mysqli_real_escape_string($link, $_POST['fullname']);
   $phone = mysqli_real_escape_string($link, $_POST['phone']);
   $website = mysqli_real_escape_string($link, $_POST['website']);
   $country = $_POST['country'];
   $avatar = $_POST['avatar'];
   $credit = $_POST['credit'];
   $terms = isset($_POST['terms']) ? $_POST['terms'] : '';
//validate submitted data from form
   if ($password != $confirmpassword)
   {
      $error_message = $lang["mispass"];
   }
   else
   if (!preg_match("/^[A-Za-z0-9_!@$]{1,50}$/", $username))
   {
      $error_message = $lang["invuser"];
   }
   else
   if (!preg_match("/^[A-Za-z0-9_&}{!@.#^%*?$]{1,50}$/", $password))
   {
      $error_message = $lang["invpass"];
   }
   else
   if (!preg_match("/^[A-Za-z0-9_!@$.' &]{1,50}$/", $fullname))
   {
      $error_message = $lang["invname"];
   }
   else
   if (!preg_match("/^.+@.+\..+$/", $email))
   {
      $error_message = $lang["invemail"];
   }
   else
   if (strlen($phone) == 0)
   {
      $error_message = $lang["nofon"];
   }
   else
   if (strlen($terms) == 0)
   {
      $error_message = $lang["tc"];
   }
   if ($phone == $ccode)
   {
      $error_message = $lang["vafon"];
   }
//check if the username or email does not exist, else error out
$conn = new mysqli($dbserver,$dbusername,$dbpassword,$dbdatabase);
$counter=0;
$sql3="SELECT * FROM users  WHERE USERNAME = '" . $username . "' ";
$result=mysqli_query($conn, $sql3);
$counter=mysqli_num_rows($result);
if ($counter > 0)
   {
      $error_message = $lang["userdup"];
   }
$comail=0;
$sql3="SELECT * FROM users  WHERE EMAIL = '" . $email . "' ";
$result=mysqli_query($conn, $sql3);
$comail=mysqli_num_rows($result);
if ($comail > 0)
   {
      $error_message = $lang["maildup"];
   }
//insert record to database if no error is detected
if (empty($error_message)){
$cpass = password_hash($password, PASSWORD_BCRYPT);
$mysql_table = "users";

$sql = "INSERT INTO $mysql_table (`USERNAME`, `EMAIL`, `PASSWORD`, `NAME`, `PHONE`, `COUNTRY`, `PAYPAL`, `AVATAR`, `CREDIT`, `ACESS`, `ONLINE`, `DATE`, `LMS`, `WEBSITE`, `MOMO`, `CHEQUE`, `DFA`, `BANK`, `RKEY`) VALUES ('$username', '$email', '$cpass','$fullname','$phone','$country','','$avatar','$credit','user','$time','$time','$time','$website','','','','','')";
$result = mysqli_query($link, $sql);
//define html email message to send to the user
$sql9 = "SELECT * FROM etemplates WHERE NAME = '" . $signupet . "' ";
$result = mysqli_query($link, $sql9);
$rw = mysqli_fetch_array($result);
$dbtmsg = $rw['MESSAGE'] ;

$variables = array();


$variables['sitename'] = $sitename;

$variables['semail'] = $semail;

$variables['fullname'] = $fullname;


$variables['username'] = $username;


$variables['password'] = $password;


$template = stripslashes($dbtmsg);



foreach($variables as $key => $value)

{

$template = str_replace('{{ '.$key.' }}', $value, $template);

}
$message = $template;
//send html email based on admin's settings
if($smtpmail == 'on') {


$subject = "Your New Account";

$body = $message;
$mail->FromName = $sitename;
$mail->addAddress($email);
$mail->Subject = $subject;
$mail->Body    = $body;
$mail->send();
} else {
$subject = "Your New Account";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From:  ' . $sitename . ' <' . $semail .'>' . " \r\n";
mail($email,$subject,$message,$headers);
}

$_SESSION["username"] = $username;
$_SESSION["fullname"] = $fullname;
$_SESSION["email"] = $email;
$_SESSION["right"] = "user";

$sucm = $lang["accset"];

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
 
if(!$city){
   $city='Unknown!';
}if(!$region){
   $region='Unknown!';
}if(!$country){
   $country='Unknown!';
}
$flag = "flags/".strtolower($addrDetailsArr['geoplugin_countryCode']).".png";

//add records to database
$sql2 = "INSERT INTO `login` (`USERNAME`, `CITY`,`COUNTRY`, `IP`, `OS`, `DATE`, `TIME`, `BROWSER`, `FLAG`, `OSLOGO`, `BROLOGO`, `BROWID`) VALUES ('$username','$city','$country','$ip_address','$user_os','$time','$time','$browser','$flag','$oslogo','$brologo','$browid')";
$result = mysqli_query($link, $sql2);

//Update last activity time in database
$sql100 = "UPDATE users SET ONLINE='".$time."' WHERE USERNAME = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($link, $sql100);
}
}
?><!doctype html><html><head><meta charset="utf-8"><title><?php echo $lang["signup"];?></title><meta name="robots" content="noindex, nofollow"><meta name="generator" content="Powerstone"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="signup.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script><script src="transition.min.js"></script><script src="modal.min.js"></script><script src="wwb14.min.js"></script><link href="font-awesome.min.css" rel="stylesheet"><link href="<?php echo $favicon; ?>" rel="shortcut icon" type="image/x-generic"><?php echo urldecode($ganal); ?></head><body><div id="container"><div id="Html5"><script>
function passwordStrength(password)
{var desc=new Array();desc[0]="Very Weak";desc[1]="Weak";desc[2]="Better";desc[3]="Medium";desc[4]="Strong";desc[5]="Strongest";var score=0;if(password.length>4)score++;if((password.match(/[a-z]/))&&(password.match(/[A-Z]/)))score++;if(password.match(/[0-9]/))score++;if(password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))score++;if(password.length>8)score++;document.getElementById("passwordDescription").innerHTML=desc[score];document.getElementById("passwordStrength").className="strength"+score;function addclass(){var element=document.getElementById("confirmpassword");element.classList.add("disabled");}
function removeclass(){var element=document.getElementById("confirmpassword");element.classList.remove("disabled");}
if(document.getElementById("passwordDescription").innerHTML=='Better')signupform.confirmpassword.disabled=false;if(document.getElementById("passwordDescription").innerHTML=='Medium')signupform.confirmpassword.disabled=false;if(document.getElementById("passwordDescription").innerHTML=='Strong')signupform.confirmpassword.disabled=false;if(document.getElementById("passwordDescription").innerHTML=='Strongest')signupform.confirmpassword.disabled=false;if(document.getElementById("passwordDescription").innerHTML=='Weak')signupform.confirmpassword.disabled=true;if(document.getElementById("passwordDescription").innerHTML=='Very Weak')signupform.confirmpassword.disabled=true;if(document.getElementById("passwordDescription").innerHTML=='Better')removeclass()=true;if(document.getElementById("passwordDescription").innerHTML=='Medium')removeclass()=true;if(document.getElementById("passwordDescription").innerHTML=='Strong')removeclass()=true;if(document.getElementById("passwordDescription").innerHTML=='Strongest')removeclass()=true;if(document.getElementById("passwordDescription").innerHTML=='Weak')addclass()=true;if(document.getElementById("passwordDescription").innerHTML=='Very Weak')addclass()=true;}</script></div><div id="Html1"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:16px;\"><center><i class=\"fa fa-check-circle-o\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
echo "<script type=\"text/javascript\">
var wait=setTimeout(\"location.href='user.php';\",7000);</script>";
}
?><?php
if($error_message !='') {
echo "<div class=\"alert2\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:14px;\"><center><i class=\"fa fa-info-circle\">&nbsp;</i><strong>" . $error_message . "</strong></center></div></div>";
}
?></div><div id="Html10"><span style="color:#696969;font-family:Arial;font-size:15px;"><center><?php $cyear = date("Y"); echo "Copyright © " .$cyear ." " .$sitename. ", All Rights Reserved."; ?></center></span></div><div id="wb_Form1"><form name="signupform" method="post" action="./signup.php" id="Form1" onsubmit="ShowObject('Html2', 1);ShowObject('Html11', 0);document.getElementById('Form1').submit();return false;"><input type="hidden" name="avatar" value=""><input type="hidden" name="credit" value="0"><input type="hidden" name="token" value="<?php echo $token; ?>"><input type="text" id="fullname" name="fullname" value="" tabindex="2" spellcheck="false" placeholder="<?php echo $lang['fullname'];?>"><input type="text" id="username" name="username" value="" tabindex="1" autofocus spellcheck="false" placeholder="<?php echo $lang['username'];?>"><input type="password" id="password" name="password" value="" tabindex="3" spellcheck="false" placeholder="<?php echo $lang['password'];?>" onkeyup="passwordStrength(this.value)"><input type="password" id="confirmpassword" name="confirmpassword" value="" tabindex="4" disabled spellcheck="false" placeholder="<?php echo $lang['copass'];?>" class="disabled"><input type="email" id="email" name="email" value="" tabindex="5" spellcheck="false" placeholder="<?php echo $lang['email'];?>"><select name="country" size="1" id="country" tabindex="8"><optgroup label="<?php echo $lang['autodetected'];?>"><option selected value="<?php echo $country; ?>"><?php echo $country; ?></option></optgroup><optgroup label="<?php echo $lang['otherco'];?>"><option value="Afghanistan">Afghanistan</option><option value="Aland Islands">Aland Islands</option><option value="Albania">Albania</option><option value="Algeria">Algeria</option><option value="American Samoa">American Samoa</option><option value="Andorra">Andorra</option><option value="Angola">Angola</option><option value="Anguilla">Anguilla</option><option value="Antarctica">Antarctica</option><option value="Antigua and Barbuda">Antigua and Barbuda</option><option value="Argentina">Argentina</option><option value="Armenia">Armenia</option><option value="Aruba">Aruba</option><option value="Australia">Australia</option><option value="Austria">Austria</option><option value="Azerbaijan">Azerbaijan</option><option value="Bahamas">Bahamas</option><option value="Bahrain">Bahrain</option><option value="Bangladesh">Bangladesh</option><option value="Barbados">Barbados</option><option value="Belarus">Belarus</option><option value="Belgium">Belgium</option><option value="Belize">Belize</option><option value="Benin">Benin</option><option value="Bermuda">Bermuda</option><option value="Bhutan">Bhutan</option><option value="Bolivia">Bolivia</option><option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option><option value="Botswana">Botswana</option><option value="Bouvet Island">Bouvet Island</option><option value="Brazil">Brazil</option><option value="British Indian Ocean Territory">British Indian Ocean Territory</option><option value="Brunei Darussalam">Brunei Darussalam</option><option value="Bulgaria">Bulgaria</option><option value="Burkina Faso">Burkina Faso</option><option value="Burundi">Burundi</option><option value="Cambodia">Cambodia</option><option value="Cameroon">Cameroon</option><option value="Canada">Canada</option><option value="Cape Verde">Cape Verde</option><option value="Cayman Islands">Cayman Islands</option><option value="Central African Republic">Central African Republic</option><option value="Chad">Chad</option><option value="Chile">Chile</option><option value="China">China</option><option value="Christmas Island">Christmas Island</option><option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option><option value="Colombia">Colombia</option><option value="Comoros">Comoros</option><option value="Congo">Congo</option><option value="Cook Islands">Cook Islands</option><option value="Costa Rica">Costa Rica</option><option value="Cote D'Ivoire">Cote D'Ivoire</option><option value="Croatia">Croatia</option><option value="Cuba">Cuba</option><option value="Cyprus">Cyprus</option><option value="Czech Republic">Czech Republic</option><option value="Denmark">Denmark</option><option value="Djibouti">Djibouti</option><option value="Dominica">Dominica</option><option value="Dominican Republic">Dominican Republic</option><option value="Ecuador">Ecuador</option><option value="Egypt">Egypt</option><option value="El Salvador">El Salvador</option><option value="Equatorial Guinea">Equatorial Guinea</option><option value="Eritrea">Eritrea</option><option value="Estonia">Estonia</option><option value="Ethiopia">Ethiopia</option><option value="Falkland Islands">Falkland Islands</option><option value="Faroe Islands">Faroe Islands</option><option value="Fiji">Fiji</option><option value="Finland">Finland</option><option value="France">France</option><option value="French Guiana">French Guiana</option><option value="French Polynesia">French Polynesia</option><option value="French Southern Territories">French Southern Territories</option><option value="Gabon">Gabon</option><option value="Gambia">Gambia</option><option value="Georgia">Georgia</option><option value="Germany">Germany</option><option value="Ghana">Ghana</option><option value="Gibraltar">Gibraltar</option><option value="Greece">Greece</option><option value="Greenland">Greenland</option><option value="Grenada">Grenada</option><option value="Guadeloupe">Guadeloupe</option><option value="Guam">Guam</option><option value="Guatemala">Guatemala</option><option value="Guinea">Guinea</option><option value="Guinea-Bissau">Guinea-Bissau</option><option value="Guyana">Guyana</option><option value="Haiti">Haiti</option><option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option><option value="Vatican City">Vatican City</option><option value="Honduras">Honduras</option><option value="Hong Kong">Hong Kong</option><option value="Hungary">Hungary</option><option value="Iceland">Iceland</option><option value="India">India</option><option value="Indonesia">Indonesia</option><option value="Iran">Iran</option><option value="Iraq">Iraq</option><option value="Ireland">Ireland</option><option value="Israel">Israel</option><option value="Italy">Italy</option><option value="Jamaica">Jamaica</option><option value="Japan">Japan</option><option value="Jordan">Jordan</option><option value="Kazakhstan">Kazakhstan</option><option value="Kenya">Kenya</option><option value="Kiribati">Kiribati</option><option value="South Korea">South Korea</option><option value="North Korea">North Korea</option><option value="Kuwait">Kuwait</option><option value="Kyrgyzstan">Kyrgyzstan</option><option value="Laos">Laos</option><option value="Latvia">Latvia</option><option value="Lebanon">Lebanon</option><option value="Lesotho">Lesotho</option><option value="Liberia">Liberia</option><option value="Libya">Libya</option><option value="Liechtenstein">Liechtenstein</option><option value="Lithuania">Lithuania</option><option value="Luxembourg">Luxembourg</option><option value="Macao">Macao</option><option value="Macedonia">Macedonia</option><option value="Madagascar">Madagascar</option><option value="Malawi">Malawi</option><option value="Malaysia">Malaysia</option><option value="Maldives">Maldives</option><option value="Mali">Mali</option><option value="Malta">Malta</option><option value="Marshall Islands">Marshall Islands</option><option value="Martinique">Martinique</option><option value="Mauritania">Mauritania</option><option value="Mauritius">Mauritius</option><option value="Mayotte">Mayotte</option><option value="Mexico">Mexico</option><option value="Micronesia">Micronesia</option><option value="Moldova">Moldova</option><option value="Monaco">Monaco</option><option value="Mongolia">Mongolia</option><option value="Montserrat">Montserrat</option><option value="Morocco">Morocco</option><option value="Mozambique">Mozambique</option><option value="Myanmar">Myanmar</option><option value="Namibia">Namibia</option><option value="Nauru">Nauru</option><option value="Nepal">Nepal</option><option value="Netherlands">Netherlands</option><option value="Netherlands Antilles">Netherlands Antilles</option><option value="New Caledonia">New Caledonia</option><option value="New Zealand">New Zealand</option><option value="Nicaragua">Nicaragua</option><option value="Niger">Niger</option><option value="Nigeria">Nigeria</option><option value="Niue">Niue</option><option value="Norfolk Island">Norfolk Island</option><option value="Northern Mariana Islands">Northern Mariana Islands</option><option value="Norway">Norway</option><option value="Oman">Oman</option><option value="Pakistan">Pakistan</option><option value="Palau">Palau</option><option value="Palestinian Territory">Palestinian Territory</option><option value="Panama">Panama</option><option value="Papua New Guinea">Papua New Guinea</option><option value="Paraguay">Paraguay</option><option value="Peru">Peru</option><option value="Philippines">Philippines</option><option value="Pitcairn">Pitcairn</option><option value="Poland">Poland</option><option value="Portugal">Portugal</option><option value="Puerto Rico">Puerto Rico</option><option value="Qatar">Qatar</option><option value="Reunion">Reunion</option><option value="Romania">Romania</option><option value="Russian Federation">Russian Federation</option><option value="Rwanda">Rwanda</option><option value="Saint Helena">Saint Helena</option><option value="Saint Kitts And Nevis">Saint Kitts And Nevis</option><option value="Saint Lucia">Saint Lucia</option><option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option><option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option><option value="Samoa">Samoa</option><option value="San Marino">San Marino</option><option value="Sao Tome and Principe">Sao Tome and Principe</option><option value="Saudi Arabia">Saudi Arabia</option><option value="Senegal">Senegal</option><option value="Serbia and Montenegro">Serbia and Montenegro</option><option value="Seychelles">Seychelles</option><option value="Sierra Leone">Sierra Leone</option><option value="Singapore">Singapore</option><option value="Slovakia">Slovakia</option><option value="Slovenia">Slovenia</option><option value="Solomon Islands">Solomon Islands</option><option value="Somalia">Somalia</option><option value="South Africa">South Africa</option><option value="Spain">Spain</option><option value="Spratly Islands">Spratly Islands</option><option value="Sri Lanka">Sri Lanka</option><option value="Sudan">Sudan</option><option value="Suriname">Suriname</option><option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option><option value="Swaziland">Swaziland</option><option value="Sweden">Sweden</option><option value="Switzerland">Switzerland</option><option value="Syrian Arab Republic">Syrian Arab Republic</option><option value="Taiwan">Taiwan</option><option value="Tajikistan">Tajikistan</option><option value="Tanzania">Tanzania</option><option value="Thailand">Thailand</option><option value="Timor-Leste">Timor-Leste</option><option value="Togo">Togo</option><option value="Tokelau">Tokelau</option><option value="Tonga">Tonga</option><option value="Trinidad and Tobago">Trinidad and Tobago</option><option value="Tunisia">Tunisia</option><option value="Turkey">Turkey</option><option value="Turkmenistan">Turkmenistan</option><option value="Turks and Caicos Islands">Turks and Caicos Islands</option><option value="Tuvalu">Tuvalu</option><option value="Uganda">Uganda</option><option value="Ukraine">Ukraine</option><option value="United Arab Emirates">United Arab Emirates</option><option value="United Kingdom">United Kingdom</option><option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option><option value="United States">United States</option><option value="Uruguay">Uruguay</option><option value="Uzbekistan">Uzbekistan</option><option value="Vanuatu">Vanuatu</option><option value="Venezuela">Venezuela</option><option value="Vietnam">Vietnam</option><option value="Virgin Islands">Virgin Islands</option><option value="Wallis and Futuna">Wallis and Futuna</option><option value="Western Sahara">Western Sahara</option><option value="Yemen">Yemen</option><option value="Zambia">Zambia</option><option value="Zimbabwe">Zimbabwe</option></optgroup></select><div id="Html3"><div class="pwb"><div id="passwordStrength" class="strength0"><div id="passwordDescription">No Password Detected</div></div></div></div><input type="text" id="phone" name="phone" value="<?php echo $ccode; ?>" tabindex="7" spellcheck="false" placeholder="<?php echo $lang['phone'];?>"><div id="wb_terms"><input type="checkbox" id="terms" name="terms" value="yes" tabindex="9"><label for="terms"></label></div><input type="text" id="Captcha1" name="captcha_code" value="" tabindex="10" autofocus spellcheck="false" placeholder="<?php echo $lang['captcha'];?>" style="visibility:<?php echo $visibility; ?>;"><div id="Html4"><img src="captcha1.php" alt="Click for new image" title="Click for new image" style="cursor:pointer;float:left;width:100px;height:32px;visibility:<?php echo $visibility; ?>;" onclick="this.src='captcha1.php?'+Math.random()"></div><div id="Html7"><div style="color:#1E90FF;font-family:Arial;font-size:17px;text-align:center;"><strong><?php echo $lang["signup"];?></strong></div></div><label for="terms" id="Label1"><?php echo $lang['termpre'];?><a href="#" onclick="$('#tcs').modal('show');return false;">&nbsp;<?php echo $lang['terms'];?></a></label><input type="url" id="Editbox1" name="website" value="" tabindex="6" spellcheck="false" placeholder="<?php echo $lang['website'];?>"><div id="Html8"><div style="color:#808080;font-family:Arial;font-size:9.3px;text-align:center;"><?php echo $lang['passmeter'];?></div></div><div id="Html9"><div class="logo"><a href="./"><img src="<?php echo $logo; ?>" alt="Logo"></a></div></div><div id="Html2"><but class="button2" disabled><div class="fa fa-spinner fa-pulse"></div>&nbsp;&nbsp;Creating Account...</but></div><div id="Html11"><button type="submit" class="button"><i class="fa fa-user">&nbsp;</i>&nbsp;&nbsp;<?php echo $lang["signup"];?></button></div></form></div><div id="tcs" class="modal fade" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><div id="wb_Text4"><span style="color:#808080;font-family:Arial;font-size:16px;">Our Terms &amp; Conditions of Service</span></div><div id="Html6"><?php echo nl2br(urldecode($tos)); ?></div></div></div></div></div></div></body></html>