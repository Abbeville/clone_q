<?php if(empty($link)){header('Location: ./user.php'); exit;} 
//Select banner's data
if(!empty($_GET['bid']) && !preg_match("/^[0-9. ]+$/", $_GET['bid'])) {exit('Error getting image ID');}
$bid = mysqli_real_escape_string($link, isset($_GET['bid']) ? $_GET['bid'] : '');
$sql = "SELECT * FROM banners WHERE id = '".$bid."'";
$result = mysqli_query($link, $sql);
$ro = mysqli_fetch_array($result);
                    $banner = $ro['banner'] ;
                    $altext = $ro['alte'] ;
                    $width = $ro['width'] ;
                    $height = $ro['height'] ;
                    $url = $ro['URL'] ;
if($altext == '') {$altext = $sitename;} else {$altext = $altext;}
if($purl == "on") {$surl = "?url=".$url;} else {$surl = "&url=".$url;}

$bc = '<a href="'.$afflink.$surl.'" target="_blank"><img src="'.$prot . $domain . "/banners/". $banner.'" alt="'.$altext.'" style="width:'.$width.'px;height:'.$height.'px;"></a>';
$bss = $afflink.$surl;
?><!doctype html><html><head><meta charset="utf-8"><title>Banners | <?php echo $_SESSION["username"];?></title><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="font-awesome.min.css" rel="stylesheet"><link href="banners.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script><script src="transition.min.js"></script><script src="modal.min.js"></script><script src="wwb14.min.js"></script></head><body><div id="container"><input type="text" id="link" onclick="copy_to_clipboard('link');return false;" name="link" value="<?php echo $afflink; ?>" readonly spellcheck="false"><div id="wb_FontAwesomeIcon3"><div><a href="<?php echo $afflink; ?>" class="share facebook "><div id="FontAwesomeIcon3"><i class="fa fa-facebook-square"></i></div></a></div></div><div id="wb_FontAwesomeIcon4"><div><a href="<?php echo $afflink; ?>" data-text="" class="share twitter "><div id="FontAwesomeIcon4"><i class="fa fa-twitter-square"></i></div></a></div></div><div id="Html9"><?php
     
     $record_per_page = 12;
$page = '';
if(isset($_GET["page"]))
{
 $page = $_GET["page"];
}
else
{
 $page = 1;
}

$start_from = ($page-1)*$record_per_page;
$query = "SELECT * FROM banners order by id DESC LIMIT $start_from, $record_per_page";
$result = mysqli_query($link, $query);
if(mysqli_num_rows($result)>0){
echo "<div class='nuser'> <span style=\"color:#808080;font-family:Arial;font-size:16px;\">&nbsp;<i class=\"fa fa-link\">&nbsp;</i>".$lang['affban']."</span> <br><br>";
    echo "<table id='myTable' width=\"100%\" cellpadding=\"2\" cellsapcing =\"2\">";
        echo "<thead>";
           echo "<tr>";
                
                    
                    
                    
                    echo "<th>".strtoupper($lang['banners'])."</th>";
                    echo "<th>".strtoupper($lang['imgsiz'])."</td>";
                    
                    echo "<th>".strtoupper($lang['addban'])."</td>";
                    
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
            while($row = mysqli_fetch_array($result)){
           
            $banner = "<a href='banners/".urlencode($row['banner'])."' target=\"_blank\"><img src='banners/".urlencode($row['banner'])."'></a>";
                echo "<tr>";
                    
                    $id = $row['id'];
                    
                    echo "<td><span class='banner'>" . $banner . "</span></td>";
                    echo "<td>" . $row['width'] . " X " . $row['height'] . " Pixels</td>";
                    
                    echo "<td width=\"150px\"><a href='user.php?show=banners&page=".$page."&bid=".$id."'><span class='copy'><div class=\"fa fa-code\">&nbsp;</div>Copy HTML</span></a></td>";
                    
                echo "</tr>";
                
            }
            
            echo "</table></div>";
            
            } else {echo "<br><br><br><div style=\"color:#FF1493;font-family:Arial;font-size:25px; text-align: center;\"><strong>".$lang['noban']."</strong></div><br>";}
    echo "</tbody>";
            
    echo "<div class = 'nav'>";
            
    $page_query = "SELECT * FROM banners ORDER BY id DESC";
    $page_result = mysqli_query($link, $page_query);
    $total_records = mysqli_num_rows($page_result);
    $total_pages = ceil($total_records/$record_per_page);
    $start_loop = $page;
    $difference = $total_pages - $page;
    if($total_pages - 1 < 5){$diff = $total_pages-1;} else {$diff = 5;}
    if($difference <= 5)
    {
     $start_loop = $total_pages - $diff;
    }
    $end_loop = $start_loop + $diff;
    if($total_records>$record_per_page) {
    if($page > 1)
    {
     echo "<a href='user.php?show=banners&page=1' class='pg'>First</a>";
     echo "<a href='user.php?show=banners&page=".($page - 1)."' class='pg'><<</a>";
    }
    for($i=$start_loop; $i<=$end_loop; $i++)
    {   if($i==$page){$cl="pgd";} else {$cl="pg";}    
     echo "<a href='user.php?show=banners&page=$i' class='".$cl."'>".$i."</a>";
    }
    if($page < $end_loop)
    {
     echo "<a href='user.php?show=banners&page=".($page + 1)."' class='pg'>>></a>";
     echo "<a href='user.php?show=banners&page=".$total_pages."' class='pg'>Last</a>";
    }
    }
    echo "</div>";
     ?><br><br><div style="color:#696969;font-family:Arial;font-size:15px; text-align:center;"><?php echo "Copyright © " .$year ." " .$sitename. ", All Rights Reserved."; ?></div></div><div id="banner1" class="modal fade" data-keyboard="false" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><textarea name="bn1" id="ban1" onclick="copy_to_clipboard('ban1');return false;" rows="4" cols="37" readonly spellcheck="false" placeholder="There is no HTML code generated for this banner, please try again!"><?php echo $bc; ?></textarea><input type="button" id="Button1" onclick="copy_to_clipboard('ban1');return false;" name="" value="Copy"><input type="text" id="sharelink" onclick="copy_to_clipboard('sharelink');return false;" name="sharelink" value="<?php echo $bss; ?>" spellcheck="false"><div id="wb_bfbs"><div><a href="<?php echo $bss; ?>" class="share facebook "><div id="bfbs"><i class="fa fa-facebook-square"></i></div></a></div></div><div id="wb_btts"><div><a href="<?php echo $bss; ?>" data-text="" class="share twitter "><div id="btts"><i class="fa fa-twitter-square"></i></div></a></div></div><div id="Html1"><span style="color:#000000;font-family:Arial;font-size:13px;"><?php echo $lang["bannote"]; ?></span></div></div></div></div></div><div id="qr" class="modal fade" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><div id="Html20"><div class="qr"><img src="<?php echo $username; ?>.png"></div></div><div id="wb_Text4"><span style="color:#000000;font-family:Arial;font-size:13px;"><strong>Scan and share the link below with your friends</strong></span></div></div></div></div></div><div id="wb_FontAwesomeIcon1"><a href="#" onclick="$('#qr').modal('show');return false;"><div id="FontAwesomeIcon1"><i class="fa fa-qrcode"></i></div></a></div><div id="urlink"><div style="color:#808080;font-family:Arial;font-size:21px; text-align:left;"><?php echo $lang["urlink"]; ?>:</div></div><div id="urlink2"><div style="color:#808080;font-family:Arial;font-size:16px; text-align:right;"><?php echo $lang["urlink"]; ?>:</div></div></div><script src="share/jquery.shares.js"></script><script>
$(document).ready(function(){$('a.share').shares();});</script></body></html><script>
function copy_to_clipboard(id)
{document.getElementById(id).select();document.execCommand('copy');}</script><script>
function sp(){$('#banner1').modal('show');}</script><?php if(isset($_GET['bid']) ? $_GET['bid'] : '' !='') {
echo "<script>
sp();</script>";
}
?>