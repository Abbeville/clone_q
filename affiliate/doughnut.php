<?php ob_start(); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.1/Chart.min.js"></script>
<script src="pretty-doughtnut.js"></script>
<script src="jquery-1.12.4.min.js"></script>
<?php

include "db.php";
if(empty($dbserver)){header('Location: /index.php'); exit;}
date_default_timezone_set($tzone);
$time = time();
$year = date("Y");
$month = date("m");
$link = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbdatabase);
session_start();
if (!isset($_SESSION['username']))
{
   header('Location: ./index.php');
   exit;
}

//Obtain the total visits and signups and find the percentage

$sql20 = "SELECT * FROM ref WHERE YEAR(date) = $year && MONTH(date) = $month ";
$result=mysqli_query($link, $sql20);
$tr=mysqli_num_rows($result);

if($tr==0){$tr=1;}

$sql21 = "SELECT * FROM ref WHERE YEAR(date) = $year && MONTH(date) = $month && SALE = 'yes'";
$result=mysqli_query($link, $sql21);
$rr=mysqli_num_rows($result);


$pr = $rr/$tr;

?>



<style>

canvas {
  z-index: 100;
}

.labelPercentage {
  font-size: x-large;
}
 
.labelText {
  font-size: small;
  color: #CCCCCC;
}
 
.labelContainer3 {
  display: block;
  text-align: center;
  width: 100px;
  font-family: Tahoma;
}
a {
    color: #1E90FF;
    text-decoration: none;
}
</style>


<script>
//The doughnut meter
$(window).load(function() {
  doughnutWidget.options = {
    container3: $('#container3'),
    width: 10,
    height: 100,
    class: 'myClass',
    cutout: 50
  };

  doughnutWidget.render(data());

  setInterval(init, 2000);
});

function init() {
  doughnutWidget.render(data());
}

function data() {
    var data = {
    Converted: {
      val: Math.round(<?php echo $pr; ?> * 100),
      color: '#1E90FF',
      link: './admin.php?show=map'
    }
  };

  return data;
}


</script>

  <div id="container3"></div>
  
<?php
//Close connection
mysqli_close($link);

ob_end_flush();
?>