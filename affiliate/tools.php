<?php if(empty($link)){header('Location: ./admin.php'); exit;} ?><?php
//Define tracke API link
$tracker = $prot . $domain."/refc.php";
$converter = '
<script type=&#34;text/javascript&#34;>
var amt=document.querySelector(\'[name="amount"]\').value;

var id = document.querySelector(\'[name="item_number"]\').value;

var x = new XMLHttpRequest();

   x.open("GET","'.$prot.$domain.'/converter.php?amt="+amt+"&id="+id,true);

   x.withCredentials = true

   x.send();

</script>
';
//Process uploaded images and upload them to server
$pf = rand(1111, 9999);
$sucm = '';
if(!empty($_POST)){
$image_info = getimagesize($_FILES["banner"]["tmp_name"]);
$image_width = $image_info[0];
$image_height = $image_info[1];
$alt = mysqli_real_escape_string($link, $_POST['alt']);
$url = mysqli_real_escape_string($link, $_POST['url']);
$ban = $_FILES['banner']['name'];
if($ban !='') {
$banner = urlencode($pf.$ban);
$target = "banners/".basename($banner);
move_uploaded_file($_FILES['banner']['tmp_name'], $target); }
//Add the banner and it's properties to the database
$sql2 = "INSERT INTO `banners` (`alte`, `banner`,`width`, `height`, `URL`) VALUES ('$alt','$banner','$image_width','$image_height','$url')";
$result = mysqli_query($link, $sql2);
}
//Delete banners
$did = mysqli_real_escape_string($link, isset($_GET["del"]) ? $_GET["del"] : '');
if($did != '')
{
$sql = "SELECT * FROM banners WHERE id = '" . $did . "' ";
$result = mysqli_query($link, $sql);
$rd = mysqli_fetch_array($result);
$dimg = $rd['banner'] ;
$oldimg = '/banners/'.$dimg;
unlink($_SERVER['DOCUMENT_ROOT'] .$oldimg);
$sql67 = "DELETE FROM banners WHERE id = '" . $did . "' ";
$result = mysqli_query($link, $sql67);
$sql68 = "ALTER TABLE banners ENGINE=MyISAM";
$result3 = mysqli_query($link, $sql68);
$sucm = "Requested image successfully removed from server!";
}
?><!doctype html><html><head><meta charset="utf-8"><title>Marketing Tools | Affiliate Me - <?php echo $version; ?></title><meta name="robots" content="noindex, nofollow"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="tools.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script><script src="transition.min.js"></script><script src="modal.min.js"></script></head><body><div id="container"><div id="Html4"><?php
if($sucm !='') {
echo "<div class=\"alert\"> <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> <div style=\"font-size:12px;\"><center><i class=\"fa fa-check-circle-o\">&nbsp;</i><strong>" . $sucm . "</strong></center></div></div>";
}
?></div><div id="Html9"><?php
     
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
echo "<div class='nuser'> <span style=\"color:#C0C0C0;font-family:Arial;font-size:16px;\">&nbsp;<i class=\"fa fa-link\">&nbsp;</i> ".$lang['affban']."</span> <br><br>";
    echo "<table id='myTable' width=\"100%\" cellpadding=\"2\" cellsapcing =\"2\">";
        echo "<thead>";
           echo "<tr>";
                
                    
                    
                    
                    echo "<th>".strtoupper($lang['banners'])."</th>";
                    
                    echo "<th class='nomob'>".strtoupper($lang['altext'])."</th>";
                    echo "<th>".strtoupper($lang['imgsiz'])."</td>";
                    
                    echo "<th>".strtoupper($lang['delete'])."</td>";
                    
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
            while($row = mysqli_fetch_array($result)){
           
            $banner = "<a href='banners/".urlencode($row['banner'])."' target=\"_blank\"><img src='banners/".urlencode($row['banner'])."'></a>";
                echo "<tr>";
                
                    if($row['alte'] == ''){$altext = "---";} else {$altext = $row['alte'];}
                    
                    $id = $row['id'];
                    
                    echo "<td><span class='banner'>" . $banner . "</span></td>";
                    
                    echo "<td class='nomob'>" . $altext . "</span></td>";
                    echo "<td>" . $row['width'] . " X " . $row['height'] . " Pixels</td>";
                    
                    echo "<td><span onclick=\"if(confirm('You are about to delete this banner entirely from your server, this cannot be undone, are you sure you want to continue?')){window.location.href='./admin.php?show=tools&del=$id';}else{return false;}\" class=\"del\"><div class=\"fa fa-trash\">&nbsp;</div></span></td>";
                    
                echo "</tr>";
            }
            
            echo "</table></div>";
            
            } else {echo "<br><br><br><div style=\"color:#FF1493;font-family:Arial;font-size:25px; text-align: center;\"><strong>".$lang['nobanner']."</strong></div><br>";}
    echo "</tbody>";
            
            echo "&nbsp;";
            
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
     echo "<a href='admin.php?show=tools&page=1' class='pg'>First</a>";
     echo "<a href='admin.php?show=tools&page=".($page - 1)."' class='pg'><<</a>";
    }
    for($i=$start_loop; $i<=$end_loop; $i++)
    {   if($i==$page){$cl="pgd";} else {$cl="pg";}    
     echo "<a href='admin.php?show=tools&page=$i' class='".$cl."'>".$i."</a>";
    }
    if($page < $end_loop)
    {
     echo "<a href='admin.php?show=tools&page=".($page + 1)."' class='pg'>>></a>";
     echo "<a href='admin.php?show=tools&page=".$total_pages."' class='pg'>Last</a>";
    }
    }
     ?><br><br><div style="color:#A9A9A9;font-family:Arial;font-size:13px; text-align:center;">Affiliate Me Version <?php echo $version; ?></div><br></div><div id="Html13"><a href="#" onclick="$('#Layer1').modal('show');return false;"><button class="upld"><i class="fa fa-upload">&nbsp;</i>&nbsp;<?php echo $lang['addnewban']; ?></button></a></div><div id="Html2"><a href="#" onclick="$('#api').modal('show');return false;"><button class="vapi"><i class="fa fa-code">&nbsp;</i>&nbsp;<?php echo $lang['api']; ?></button></a></div><form name="Layer1" method="post" action="./admin.php?show=tools" enctype="multipart/form-data" id="Layer1" class="modal fade" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><div id="Html5"><div class="progress"><div class="bar"></div><div style="color:#FFFFFF; font-size:13px;" class="percent">0%</div></div></div><div id="Html6"><center><span style="color:#32CD32;font-family:Arial;font-size:16px;"><strong><div id="status"></div></strong></span></center></div><input type="submit" id="Button1" name="" value="<?php echo $lang['upban']; ?>"><input type="text" id="alttext" name="alt" value="" spellcheck="false" placeholder="<?php echo $lang['alttext']; ?>"><div id="Html11"><div class="drop-zone"><span class="drop-zone__prompt"><?php echo $lang["banph"]; ?></span><input type="file" accept=".bmp,.gif,.jpg,.png" name="banner" class="drop-zone__input"></div></div><input type="url" id="url" name="url" value="" spellcheck="false" placeholder="<?php echo $lang['hosturl']; ?>"><div id="Html3"><div style="color:#D3D3D3;font-family:Arial;font-size:13px;text-align:center;"><?php echo $lang["newban"]; ?></div></div></div></div></div></form><script src="form.js"></script><script>
(function(){var bar=$('.bar');var percent=$('.percent');var status=$('#status');$('form').ajaxForm({beforeSend:function(){status.empty();var percentVal='0%';bar.width(percentVal)
percent.html(percentVal);},uploadProgress:function(event,position,total,percentComplete){var percentVal=percentComplete+'%';bar.width(percentVal)
percent.html(percentVal);},complete:function(xhr){bar.width("100%");percent.html("100%");status.html("Upload Completed, Please Wait!");window.setTimeout(function(){window.location.href="./admin.php?show=tools&upl=done";},2000);}});})();</script><div id="api" class="modal fade" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><textarea name="code" id="link1" onclick="copy_to_clipboard('link1');return false;" rows="9" cols="58" readonly spellcheck="false"><?php echo $converter; ?></textarea><input type="text" id="link2" onclick="copy_to_clipboard('link2');return false;" name="api" value="<iframe src=&#34;<?php echo $tracker; ?>&#34; style=&#34;display: none;&#34;></iframe>" readonly spellcheck="false"><div id="Html7"><div style="color:#F5F5F5;font-family:Arial;font-size:13px;text-align:center;"><strong>Tracker API:</strong><br><?php echo $lang['apid']; ?>:</div></div><div id="Html8"><div style="color:#F5F5F5;font-family:Arial;font-size:13px;text-align:center;"><?php echo $lang['apiv']; ?>:</div></div><div id="Html10"><div style="color:#FFD700;font-family:Arial;font-size:13px;text-align:center;"><?php echo $lang['docr']; ?></div></div></div></div></div></div><div id="Html1"><div style="color:#A9A9A9;font-family:Arial;font-size:21px;text-align:center;"><?php echo $lang['creaunban']; ?></div></div></div></body></html><script>
function copy_to_clipboard(id)
{document.getElementById(id).select();document.execCommand('copy');}</script><script>
document.querySelectorAll(".drop-zone__input").forEach((inputElement)=>{const dropZoneElement=inputElement.closest(".drop-zone");dropZoneElement.addEventListener("click",(e)=>{inputElement.click();});inputElement.addEventListener("change",(e)=>{if(inputElement.files.length){updateThumbnail(dropZoneElement,inputElement.files[0]);}});dropZoneElement.addEventListener("dragover",(e)=>{e.preventDefault();dropZoneElement.classList.add("drop-zone--over");});["dragleave","dragend"].forEach((type)=>{dropZoneElement.addEventListener(type,(e)=>{dropZoneElement.classList.remove("drop-zone--over");});});dropZoneElement.addEventListener("drop",(e)=>{e.preventDefault();if(e.dataTransfer.files.length){inputElement.files=e.dataTransfer.files;updateThumbnail(dropZoneElement,e.dataTransfer.files[0]);}
dropZoneElement.classList.remove("drop-zone--over");});});function updateThumbnail(dropZoneElement,file){let thumbnailElement=dropZoneElement.querySelector(".drop-zone__thumb");if(dropZoneElement.querySelector(".drop-zone__prompt")){dropZoneElement.querySelector(".drop-zone__prompt").remove();}
if(!thumbnailElement){thumbnailElement=document.createElement("div");thumbnailElement.classList.add("drop-zone__thumb");dropZoneElement.appendChild(thumbnailElement);}
thumbnailElement.dataset.label=file.name;if(file.type.startsWith("image/")){const reader=new FileReader();reader.readAsDataURL(file);reader.onload=()=>{thumbnailElement.style.backgroundImage=`url('${reader.result}')`;};}else{thumbnailElement.style.backgroundImage=null;}}</script>