<?php
ob_start();
?><?php 
// Powerstone Affiliate Me, Version 2.1.4 https://www.powerstonegh.com.
include "../db.php";
include "../functions.php";
$idb = $dbserver;
if (empty($idb)){header("Location:installer.php");}
$link = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbdatabase);
date_default_timezone_set($tzone);
$time = time();
$year = date("Y");
$date = date("Y-m-d");
$search = array('<','>');
$replace = array('&lt;','&gt;');

//Start session and store vistitor's referrer and redirect them to the store url
ini_set('session.cookie_lifetime', $sessdur);
session_start();
$seg = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$ref = mysqli_real_escape_string($link, str_replace($search, $replace, end($seg)));
$url = isset($_GET['url']) ? $_GET['url'] : '';
if($url == ""){$red =$red;} else {$red = $url;}
if(isset($_SESSION['ref'])){header("Location:$red"); exit();}
else
{
$_SESSION['ref'] = $ref;
$_SESSION['trn'] = $time;
}
$user = $ref;
//Validate to be sure the user exists
$sql1="SELECT * FROM users WHERE USERNAME = '" . $user . "' ";
$result=mysqli_query($link, $sql1);
if(mysqli_num_rows($result)== 0)
{header("Location:$red"); exit();}

//Function to get OS of user
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
$trn = $time;
$mysql_table = "ref";
$vdate = "0000-00-00";
$refer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
if($refer == '') {$refer = "direct";} else {$refer = mysqli_real_escape_string($link, $_SERVER['HTTP_REFERER']);}
$redi = get_domain($red);
$sql = "INSERT INTO $mysql_table (`USERNAME`, `TRN`, `COMM`, `VCOMM`, `DATE`, `VDATE`, `CITY`, `REGION`, `COUNTRY`, `IP`, `OS`, `TIME`, `BROWSER`, `FLAG`, `OSLOGO`, `BROLOGO`, `REFER`, `SALE`, `CPC`, `URL`, `OID`) VALUES ('$user','$trn','0','0','$date','$vdate','$city','$region','$country','$ip_address','$user_os','$time','$browser','$flag','$oslogo','$brologo','$refer','no','$cpcv','$redi','')";
$result = mysqli_query($link, $sql);
//Select user's data from database and update their commission if CPC is enabled
if($cpc == "on"){
$sql9 = "SELECT * FROM users WHERE USERNAME = '" . $user . "' ";
$result = mysqli_query($link, $sql9);
$ro = mysqli_fetch_array($result);
$combal = $ro['CREDIT'];
if($combal==''){$combal=0;}
$ncombal = sprintf('%f', floatval($combal + $cpcv));
$sql67 = "UPDATE users SET CREDIT='" . $ncombal . "' WHERE USERNAME = '" . $user . "' ";
$result = mysqli_query($link, $sql67);
}
header("Location:$red");
mysqli_close($link);
?><!doctype html><html><head><meta charset="utf-8"><title><?php echo $sitename; ?></title><meta name="keywords" content="<?php echo $sitename; ?>"><meta name="author" content="Powerstone"><meta name="robots" content="noindex, nofollow"><link href="index.css" rel="stylesheet"></head><body></body></html><?php
ob_end_flush();
?>