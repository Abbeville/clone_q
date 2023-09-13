<?php

//Function convert number

function numbConv($ru)
{

    $mu1 = number_format($ru);
    $mu2 = number_format($ru / 1000, 1) . 'K';
    $mu3 = number_format($ru / 1000000, 1) . 'M';
    $mu4 = number_format($ru / 1000000000, 1) . 'B';
    
    // Anything less than a ten thousand
if ($ru < 10000) {
return "$mu1";
}

// Anything less than a million
else if ($ru < 1000000) {
return "$mu2";
}

// Anything less than a billion
else if ($ru < 1000000000) {
return "$mu3";
}

else {
    // At least a billion
return "$mu4";
   }

}

//Function convert money

function moneyConv($mo)
{

    $mo1 = number_format($mo, 2);
    $mo2 = number_format($mo / 1000, 2) . 'K';
    $mo3 = number_format($mo / 1000000, 2) . 'M';
    $mo4 = number_format($mo / 1000000000, 2) . 'B';
    
    // Anything less than a ten thousand
if ($mo < 10000) {
return "$mo1";
}

// Anything less than a million
else if ($mo < 1000000) {
return "$mo2";
}

// Anything less than a billion
else if ($mo < 1000000000) {
return "$mo3";
}

else {
    // At least a billion
return "$mo4";
   }

}


//Function timeAgo

function timeAgo($etime)
{
    $time_ago = $etime;
    $cur_time   = time();
    $time_rem   = $cur_time - $time_ago;
    $seconds    = $time_rem ;
    $minutes    = round($time_rem / 60 );
    $hours      = round($time_rem / 3600);
    $days       = round($time_rem / 86400 );
    $weeks      = round($time_rem / 604800);
    $months     = round($time_rem / 2600640 );
    $years      = round($time_rem / 31207680 );
    // Seconds
    if($seconds <= 60){
        return "Just Now";
    }
    //Minutes
    else if($minutes <=60){
        if($minutes==1){
            return "one minute ago";
        }
        else{
            return "$minutes minutes ago";
        }
    }
    //Hours
    else if($hours <=24){
        if($hours==1){
            return "an hour ago";
        }else{
            return "$hours hrs ago";
        }
    }
    //Days
    else if($days <= 15){
        if($days==1){
            return "yesterday";
        }else{
            return "$days days ago";
        }
    }
    //Weeks
    else if($weeks <= 3.9){
        if($weeks==1){
            return "one week ago";
        }else{
            return "$weeks weeks ago";
        }
    }
    //Months
    else if($months <=12){
        if($months==1){
            return "one month ago";
        }else{
            return "$months months ago";
        }
    }
    //Years
    else{
        if($years==1){
            return "one year ago";
        }else{
            return "$years years ago";
        }
    }
}


//Function timeLeft
function timeLeft($etime)
{
    $time_ago = strtotime($etime);
    $cur_time   = time();
    $time_rem   = $time_ago - $cur_time;
    $seconds    = $time_rem ;
    $minutes    = round($time_rem / 60 );
    $hours      = round($time_rem / 3600);
    $days       = round($time_rem / 86400 );
    $weeks      = round($time_rem / 604800);
    $months     = round($time_rem / 2600640 );
    $years      = round($time_rem / 31207680 );
    // Seconds
    if($seconds <= 60){
        return "Complete";
    }
    //Minutes
    else if($minutes <=60){
        if($minutes==1){
            return "one minute";
        }
        else{
            return "$minutes minutes";
        }
    }
    //Hours
    else if($hours <=24){
        if($hours==1){
            return "an hour";
        }else{
            return "$hours hrs";
        }
    }
    //Days
    else if($days <= 15){
        if($days==1){
            return "a day";
        }else{
            return "$days days";
        }
    }
    //Weeks
    else if($weeks <= 3.9){
        if($weeks==1){
            return "one week";
        }else{
            return "$weeks weeks";
        }
    }
    //Months
    else if($months <=12){
        if($months==1){
            return "one month";
        }else{
            return "$months months";
        }
    }
    //Years
    else{
        if($years==1){
            return "one year";
        }else{
            return "$years years";
        }
    }
}

//Size converter

 function format_size($size) {
        $mod = 1024;
        $units = explode(' ','B KB MB GB TB PB');
        for ($i = 0; $size > $mod; $i++) {
            $size /= $mod;
        }
        return round($size, 2) . ' ' . $units[$i];
    }
    
    
    
//Folder size calculator

 function foldersize($path) {
  $total_size = 0;
  $files = scandir($path);

  foreach($files as $t) {
    if (is_dir(rtrim($path, '/') . '/' . $t)) {
      if ($t<>"." && $t<>"..") {
          $size = foldersize(rtrim($path, '/') . '/' . $t);

          $total_size += $size;
      }
    } else {
      $size = filesize(rtrim($path, '/') . '/' . $t);
      $total_size += $size;
    }
  }
  return $total_size;
}

// Get domain from url
function get_domain($url)
{
  $pieces = parse_url($url);
  $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
    return $regs['domain'];
  }
  return false;
}

// Get page title

	function getTitle($url) {
		$data = file_get_contents($url);
    $title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $data, $matches) ? $matches[1] : null;
    return $title;
	}
	
	
// Calculate domain age
class DomainAge
{
    private $WHOIS_SERVERS = array(
        "com" => array("whois.verisign-grs.com", "/Creation Date:(.*)/"), 
        "net" => array("whois.verisign-grs.com", "/Creation Date:(.*)/"), 
        "org" => array("whois.pir.org", "/Creation Date:(.*)/"), 
        "info" => array("whois.afilias.info", "/Created On:(.*)/"), 
        "biz" => array("whois.neulevel.biz", "/Domain Registration Date:(.*)/"), 
        "us" => array("whois.nic.us", "/Domain Registration Date:(.*)/"), 
        "uk" => array("whois.nic.uk", "/Registered on:(.*)/"), 
        "ca" => array("whois.cira.ca", "/Creation date:(.*)/"), 
        "tel" => array("whois.nic.tel", "/Domain Registration Date:(.*)/"), 
        "ie" => array("whois.iedr.ie", "/registration:(.*)/"), 
        "it" => array("whois.nic.it", "/Created:(.*)/"), 
        "cc" => array("whois.nic.cc", "/Creation Date:(.*)/"), 
        "ws" => array("whois.nic.ws", "/Domain Created:(.*)/"), 
        "sc" => array("whois2.afilias-grs.net", "/Created On:(.*)/"), 
        "mobi" => array("whois.dotmobiregistry.net", "/Created On:(.*)/"), 
        "pro" => array("whois.registrypro.pro", "/Created On:(.*)/"), 
        "edu" => array("whois.educause.net", "/Domain record activated:(.*)/"), 
        "tv" => array("whois.nic.tv", "/Creation Date:(.*)/"), 
        "travel" => array("whois.nic.travel", "/Domain Registration Date:(.*)/"), 
        "in" => array("whois.inregistry.net", "/Created On:(.*)/"), 
        "me" => array("whois.nic.me", "/Domain Create Date:(.*)/"), 
        "cn" => array("whois.cnnic.cn", "/Registration Date:(.*)/"), 
        "asia" => array("whois.nic.asia", "/Domain Create Date:(.*)/"), 
        "ro" => array("whois.rotld.ro", "/Registered On:(.*)/"), 
        "aero" => array("whois.aero", "/Created On:(.*)/"), 
        "nu" => array("whois.nic.nu", "/created:(.*)/")
    );
    public function age($domain)
    {
        
        $domain = trim($domain); //remove space from start and end of domain
        if (substr(strtolower($domain), 0, 7) == "http://")
            $domain = substr($domain, 7); // remove http:// if included
        if (substr(strtolower($domain), 0, 4) == "www.")
            $domain = substr($domain, 4); //remove www from domain
        if (preg_match("/^([-a-z0-9]{2,100}).([a-z.]{2,8})$/i", $domain)) {
            $domain_parts = explode(".", $domain);
            $tld          = strtolower(array_pop($domain_parts));
            if (!$server = $this->WHOIS_SERVERS[$tld][0]) {
                return false;
            }
            $res = $this->QueryWhoisServer($server, $domain);
            if (preg_match($this->WHOIS_SERVERS[$tld][1], $res, $match)) {
                date_default_timezone_set('UTC');
                $time  = time() - strtotime($match[1]);
                $years = floor($time / 31556926);
                $days  = floor(($time % 31556926) / 86400);
                if ($years == "1") {
                    $y = "1 year";
                } else {
                    $y = $years . " years";
                }
                if ($days == "1") {
                    $d = "1 day";
                } else {
                    $d = $days . " days";
                }
                return "$y, $d";
            } else
                return false;
        } else
            return false;
    }
    
    private function QueryWhoisServer($whoisserver, $domain)
    {
        $port    = 43;
        $timeout = 10;
        $fp = @fsockopen($whoisserver, $port, $errno, $errstr, $timeout) or die("Socket Error " . $errno . " - " . $errstr);
        //if($whoisserver == "whois.verisign-grs.com") $domain = "=".$domain; // whois.verisign-grs.com requires the equals sign ("=") or it returns any result containing the searched string.
        fputs($fp, $domain . "\r\n");
        $out = "";
        while (!feof($fp)) {
            $out .= fgets($fp);
        }
        fclose($fp);
        
        $res = "";
        if ((strpos(strtolower($out), "error") === FALSE) && (strpos(strtolower($out), "not allocated") === FALSE)) {
            $rows = explode("\n", $out);
            foreach ($rows as $row) {
                $row = trim($row);
                if (($row != '') && ($row[0] != '#') && ($row[0] != '%')) {
                    $res .= $row . "\n";
                }
            }
        }
        return $res;
    }
}

// Get alexa rank
function AlexaRank($domain) {
    $url = "https://www.alexa.com/minisiteinfo/".$domain;
    $string = file_get_contents($url);
    
    $temp_s = substr($string, strpos($string, "Global") + 38);
    return(substr($temp_s, 0, strpos($temp_s, "</a></div>")));

}


//Function get maximum allowed upload size

function _GetMaxAllowedUploadSize(){
    $Sizes = array();
    $Sizes[] = ini_get('upload_max_filesize');

    for($x=0;$x<count($Sizes);$x++){
        $Last = strtolower($Sizes[$x][strlen($Sizes[$x])-1]);
        if($Last == 'k'){
            $Sizes[$x] *= 1024;
        } elseif($Last == 'm'){
            $Sizes[$x] *= 1024;
            $Sizes[$x] *= 1024;
        } elseif($Last == 'g'){
            $Sizes[$x] *= 1024;
            $Sizes[$x] *= 1024;
            $Sizes[$x] *= 1024;
        } elseif($Last == 't'){
            $Sizes[$x] *= 1024;
            $Sizes[$x] *= 1024;
            $Sizes[$x] *= 1024;
            $Sizes[$x] *= 1024;
        }
    }
    return min($Sizes);
}

function _Byte2Size($bytes,$RoundLength=1) {
    $kb = 1024;         // Kilobyte
    $mb = 1024 * $kb;   // Megabyte
    $gb = 1024 * $mb;   // Gigabyte
    $tb = 1024 * $gb;   // Terabyte

    if($bytes < $kb) {
        if(!$bytes){
            $bytes = '0';
        }
        return (($bytes + 1)-1).' B';
    } else if($bytes < $mb) {
        return round($bytes/$kb,$RoundLength).' KB';
    } else if($bytes < $gb) {
        return round($bytes/$mb,$RoundLength).' MB';
    } else if($bytes < $tb) {
        return round($bytes/$gb,$RoundLength).' GB';
    } else {
        return round($bytes/$tb,$RoundLength).' TB';
    }
}


//Fuction detect mime type
function mime_type($file_path)
{
    $mime_type = null;

    if (function_exists('finfo_open')) {
        $finfo = new finfo(FILEINFO_MIME_TYPE, null);
        $mime_type = $finfo->file($file_path);
    }
    if (empty($mime_type) && function_exists('passthru') && function_exists('escapeshellarg')) {
        ob_start();
        passthru(sprintf('file -b --mime %s 2>/dev/null', escapeshellarg($file_path)), $return);
        if ($return > 0) {
            ob_end_clean();
            $mime_type = null;
        }
        $type = trim(ob_get_clean());
        if (!preg_match('#^([a-z0-9\-]+/[a-z0-9\-\.]+)#i', $type, $match)) {
            $mime_type = null;
        }
        $mime_type = $match[1];
    }
    return $mime_type;
}