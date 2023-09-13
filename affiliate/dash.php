<?php if(empty($link)){header('Location: ./user.php'); exit;} ?><!doctype html><html><head><meta charset="utf-8"><title>User | <?php echo $_SESSION["username"];?></title><link href="font-awesome.min.css" rel="stylesheet"><link href="dash.css" rel="stylesheet"><script src="jquery-1.12.4.min.js"></script><script src="transition.min.js"></script><script src="modal.min.js"></script><script src="wwb14.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script></head><body><div id="container"><div id="Layer2" onclick="window.location.href='./user.php?show=clicks';return false;" class="enable"><div id="wb_FontAwesomeIcon3"><div id="FontAwesomeIcon3"><i class="fa fa-users"></i></div></div><div id="Html18"><span style="color:#808080;font-family:Arial;font-size:45px;"><?php echo numbConv($sa); ?></span></div><div id="Html2"><span style="color:#808080;font-family:Arial;font-size:20px;"><?php echo $lang["clicks"]; ?> (<?php echo numbConv($ru); ?>)</span></div><div id="Html5"><span style="color:#808080;font-family:Arial;font-size:16px;"><?php echo $lang["signups"]; ?></span></div><hr id="Line1"></div><div id="Layer3" onclick="window.location.href='./user.php?show=com';return false;" class="enable"><div id="wb_FontAwesomeIcon4"><div id="FontAwesomeIcon4"><i class="fa fa-money"></i></div></div><div id="Html19"><span style="color:#808080;font-family:Arial;font-size:45px;"><?php echo $currsym.moneyConv($balance);?></span></div><hr id="Line2"><div id="Html1"><span style="color:#808080;font-family:Arial;font-size:20px;"><?php echo $lang["earned"]; ?> (<?php echo $currsym.moneyConv($income);?>)</span></div><div id="Html6"><span style="color:#808080;font-family:Arial;font-size:16px;"><?php echo $lang["funds"]; ?></span></div></div><input type="text" id="link" onclick="copy_to_clipboard('address');return false;" name="link" value="<?php echo $afflink; ?>" readonly spellcheck="false"><script>
function copy_to_clipboard(id)
{document.getElementById('link').select();document.execCommand('copy');}</script><div id="qr" class="modal fade" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><div id="Html20"><div class="qr"><img src="<?php echo $username; ?>.png"></div></div><div id="wb_Text4"><span style="color:#000000;font-family:Arial;font-size:13px;"><strong>Scan and share the link below with your friends</strong></span></div></div></div></div></div><div id="wb_FontAwesomeIcon6"><div><a href="<?php echo $afflink; ?>" class="share facebook "><div id="FontAwesomeIcon6"><i class="fa fa-facebook-square"></i></div></a></div></div><div id="wb_FontAwesomeIcon13"><div><a href="<?php echo $afflink; ?>" data-text="" class="share twitter "><div id="FontAwesomeIcon13"><i class="fa fa-twitter-square"></i></div></a></div></div><div id="wb_FontAwesomeIcon1"><a href="#" onclick="$('#qr').modal('show');return false;"><div id="FontAwesomeIcon1"><i class="fa fa-qrcode"></i></div></a></div><div id="urlink"><div style="color:#808080;font-family:Arial;font-size:21px; text-align:left;"><?php echo $lang["urlink"]; ?>:</div></div><div id="Layer1"><div id="Html29"><?php
     
    // Define month variables

     
    $m1 = '0';
    $m2 = '0';
    $m3 = '0';
    $m4 = '0';
    $m5 = '0';
    $m6 = '0';
    $m7 = '0';
    $m8 = '0';
    $m9 = '0';
    $m10 = '0';
    $m11 = '0';
    $m12 = '0';
    
    // Attempt select query execution
    $year = date("Y");
    
    $sql = "SELECT YEAR(date) AS y,
       MONTH(date) AS m,
       COUNT(*) AS tally
FROM   ref
WHERE  YEAR(date) = $year AND USERNAME = '$username'
GROUP BY
       YEAR(date),
       MONTH(date)";
    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
//Select month values from database into an array
            while($row = mysqli_fetch_array($result)){

                    if($row['m']== "1") $m1 = "". $row['tally'] ."";
                    elseif($row['m']== "2") $m2 = "". $row['tally'] ."";
                    elseif($row['m']== "3") $m3 = "". $row['tally'] ."";
                    elseif($row['m']== "4") $m4 = "". $row['tally'] ."";
                    elseif($row['m']== "5") $m5 = "". $row['tally'] ."";
                    elseif($row['m']== "6") $m6 = "". $row['tally'] ."";
                    elseif($row['m']== "7") $m7 = "". $row['tally'] ."";
                    elseif($row['m']== "8") $m8 = "". $row['tally'] ."";
                    elseif($row['m']== "9") $m9 = "". $row['tally'] ."";
                    elseif($row['m']== "10") $m10 = "". $row['tally'] ."";
                    elseif($row['m']== "11") $m11 = "". $row['tally'] ."";
                    elseif($row['m']== "12") $m12 = "". $row['tally'] ."";
                    
                    
                    
                        
            }

        }
    }
    
    
    

    $c1 = '0';
    $c2 = '0';
    $c3 = '0';
    $c4 = '0';
    $c5 = '0';
    $c6 = '0';
    $c7 = '0';
    $c8 = '0';
    $c9 = '0';
    $c10 = '0';
    $c11 = '0';
    $c12 = '0';
    
    // Attempt select query execution
    
    $sqls = "SELECT YEAR(date) AS y,
       MONTH(date) AS c,
       COUNT(*) AS tally
FROM   ref
WHERE  YEAR(date) = $year AND USERNAME = '$username' AND SALE = 'yes'
GROUP BY
       YEAR(date),
       MONTH(date)";
    if($results = mysqli_query($link, $sqls)){
        if(mysqli_num_rows($results) > 0){
//Select month values from database into an array
            while($rows = mysqli_fetch_array($results)){

                    if($rows['c']== "1") $c1 = "". $rows['tally'] ."";
                    elseif($rows['c']== "2") $c2 = "". $rows['tally'] ."";
                    elseif($rows['c']== "3") $c3 = "". $rows['tally'] ."";
                    elseif($rows['c']== "4") $c4 = "". $rows['tally'] ."";
                    elseif($rows['c']== "5") $c5 = "". $rows['tally'] ."";
                    elseif($rows['c']== "6") $c6 = "". $rows['tally'] ."";
                    elseif($rows['c']== "7") $c7 = "". $rows['tally'] ."";
                    elseif($rows['c']== "8") $c8 = "". $rows['tally'] ."";
                    elseif($rows['c']== "9") $c9 = "". $rows['tally'] ."";
                    elseif($rows['c']== "10") $c10 = "". $rows['tally'] ."";
                    elseif($rows['c']== "11") $c11 = "". $rows['tally'] ."";
                    elseif($rows['c']== "12") $c12 = "". $rows['tally'] ."";
                    
                    
                    
                        
            }
            
            mysqli_free_result($result);
        }
    }
    
    ?><canvas id="myChart"></canvas><script>
var xValues=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];new Chart("myChart",{type:"line",data:{labels:xValues,datasets:[{label:'Clicks',data:[<?php echo $m1;?>,<?php echo $m2;?>,<?php echo $m3;?>,<?php echo $m4;?>,<?php echo $m5;?>,<?php echo $m6;?>,<?php echo $m7;?>,<?php echo $m8;?>,<?php echo $m9;?>,<?php echo $m10;?>,<?php echo $m11;?>,<?php echo $m12;?>],backgroundColor:"rgba(30,144,255,0.3)",borderColor:"#48a4fd",fill:true},{label:'Sales',data:[<?php echo $c1;?>,<?php echo $c2;?>,<?php echo $c3;?>,<?php echo $c4;?>,<?php echo $c5;?>,<?php echo $c6;?>,<?php echo $c7;?>,<?php echo $c8;?>,<?php echo $c9;?>,<?php echo $c10;?>,<?php echo $c11;?>,<?php echo $c12;?>],backgroundColor:"rgba(50,205,50,0.3)",borderColor:"limegreen",fill:true}]},options:{legend:{display:false},responsive:true,maintainAspectRatio:false,scales:{xAxes:[{display:true,gridLines:{display:true,color:"#D3D3D3"},scaleLabel:{display:true,}}],yAxes:[{display:true,gridLines:{display:true,color:"#D3D3D3"},scaleLabel:{display:true,}}]}}});Chart.defaults.global.defaultFontColor="#808080";</script></div><div id="Html3"><div style="color:#808080;font-family:Arial;font-size:16px;text-align:center;"><?php echo $lang['monclick'].$year; ?></div></div></div><div id="Layer4"><div id="Html4"><div style="color:#808080;font-family:Arial;font-size:16px;text-align:center;"><?php echo $lang['geoclicks'].$year; ?></div></div><div id="Html15"><?php
//Define variables for each country of the world     
 $c1 = '';
 $c2 = '';
 $c3 = '';
 $c4 = '';
 $c5 = '';
 $c6 = '';
 $c7 = '';
 $c8 = '';
 $c9 = '';
 $c10 = '';
 $c11 = '';
 $c12 = '';
 $c13 = '';
 $c14 = '';
 $c15 = '';
 $c16 = '';
 $c17 = '';
 $c18 = '';
 $c19 = '';
 $c20 = '';
 $c21 = '';
 $c22 = '';
 $c23 = '';
 $c24 = '';
 $c25 = '';
 $c26 = '';
 $c27 = '';
 $c28 = '';
 $c29 = '';
 $c30 = '';
 $c31 = '';
 $c32 = '';
 $c33 = '';
 $c34 = '';
 $c35 = '';
 $c36 = '';
 $c37 = '';
 $c38 = '';
 $c39 = '';
 $c40 = '';
 $c41 = '';
 $c42 = '';
 $c43 = '';
 $c44 = '';
 $c45 = '';
 $c46 = '';
 $c47 = '';
 $c48 = '';
 $c49 = '';
 $c50 = '';
 $c51 = '';
 $c52 = '';
 $c53 = '';
 $c54 = '';
 $c55 = '';
 $c56 = '';
 $c57 = '';
 $c58 = '';
 $c59 = '';
 $c60 = '';
 $c61 = '';
 $c62 = '';
 $c63 = '';
 $c64 = '';
 $c65 = '';
 $c66 = '';
 $c67 = '';
 $c68 = '';
 $c69 = '';
 $c70 = '';
 $c71 = '';
 $c72 = '';
 $c73 = '';
 $c74 = '';
 $c75 = '';
 $c76 = '';
 $c77 = '';
 $c78 = '';
 $c79 = '';
 $c80 = '';
 $c81 = '';
 $c82 = '';
 $c83 = '';
 $c84 = '';
 $c85 = '';
 $c86 = '';
 $c87 = '';
 $c88 = '';
 $c89 = '';
 $c90 = '';
 $c91 = '';
 $c92 = '';
 $c93 = '';
 $c94 = '';
 $c95 = '';
 $c96 = '';
 $c97 = '';
 $c98 = '';
 $c99 = '';
 $c100 = '';
 $c101 = '';
 $c102 = '';
 $c103 = '';
 $c104 = '';
 $c105 = '';
 $c106 = '';
 $c107 = '';
 $c108 = '';
 $c109 = '';
 $c110 = '';
 $c111 = '';
 $c112 = '';
 $c113 = '';
 $c114 = '';
 $c115 = '';
 $c116 = '';
 $c117 = '';
 $c118 = '';
 $c119 = '';
 $c120 = '';
 $c121 = '';
 $c122 = '';
 $c123 = '';
 $c124 = '';
 $c125 = '';
 $c126 = '';
 $c127 = '';
 $c128 = '';
 $c129 = '';
 $c130 = '';
 $c131 = '';
 $c132 = '';
 $c133 = '';
 $c134 = '';
 $c135 = '';
 $c136 = '';
 $c137 = '';
 $c138 = '';
 $c139 = '';
 $c140 = '';
 $c141 = '';
 $c142 = '';
 $c143 = '';
 $c144 = '';
 $c145 = '';
 $c146 = '';
 $c147 = '';
 $c148 = '';
 $c149 = '';
 $c150 = '';
 $c151 = '';
 $c152 = '';
 $c153 = '';
 $c154 = '';
 $c155 = '';
 $c156 = '';
 $c157 = '';
 $c158 = '';
 $c159 = '';
 $c160 = '';
 $c161 = '';
 $c162 = '';
 $c163 = '';
 $c164 = '';
 $c165 = '';
 $c166 = '';
 $c167 = '';
 $c168 = '';
 $c169 = '';
 $c170 = '';
 $c171 = '';
 $c172 = '';
 $c173 = '';
 $c174 = '';
 $c175 = '';
 $c176 = '';
 $c177 = '';
 $c178 = '';
 $c179 = '';
 $c180 = '';
 $c181 = '';
 $c182 = '';
 $c183 = '';
 $c184 = '';
 $c185 = '';
 $c186 = '';
 $c187 = '';
 $c188 = '';
 $c189 = '';
 $c190 = '';
 $c191 = '';
 $c192 = '';
 $c193 = '';
 $c194 = '';
 $c195 = '';
 $c196 = '';
 $c197 = '';
 $c198 = '';
 $c199 = '';
 $c200 = '';
 $c201 = '';
 $c202 = '';
 $c203 = '';
 $c204 = '';
 $c205 = '';
 $c206 = '';
 $c207 = '';
 $c208 = '';
 $c209 = '';
 $c210 = '';
 $c211 = '';
 $c212 = '';
 $c213 = '';
    // Attempt select query execution

    $sql = "SELECT COUNTRY AS c,
       COUNT(*) AS tally
FROM   ref WHERE USERNAME = '" . $_SESSION['username'] . "'
GROUP BY
       COUNTRY";
    if($result = mysqli_query($link, $sql)){
        if(mysqli_num_rows($result) > 0){
//Fetch the results of the countries into an array
            while($row = mysqli_fetch_array($result)){

                                        if($row['c']== "Faroe Islands") $c1 = "". $row['tally'] ."";
                    elseif($row['c']== "United States Minor Outlying Islands") $c2 = "". $row['tally'] ."";
                    elseif($row['c']== "United States") $c3 = "". $row['tally'] ."";
                    elseif($row['c']== "Japan") $c4 = "". $row['tally'] ."";
                    elseif($row['c']== "Seychelles") $c5 = "". $row['tally'] ."";
                    elseif($row['c']== "India") $c6 = "". $row['tally'] ."";
                    elseif($row['c']== "France") $c7 = "". $row['tally'] ."";
                    elseif($row['c']== "Micronesia") $c8 = "". $row['tally'] ."";
                    elseif($row['c']== "China") $c9 = "". $row['tally'] ."";
                    elseif($row['c']== "Portugal") $c10 = "". $row['tally'] ."";
                    elseif($row['c']== "Serranilla Bank") $c11 = "". $row['tally'] ."";
                    elseif($row['c']== "Saint Helena") $c12 = "". $row['tally'] ."";
                    elseif($row['c']== "Brazil") $c13 = "". $row['tally'] ."";
                    elseif($row['c']== "Kiribati") $c14 = "". $row['tally'] ."";
                    elseif($row['c']== "Philippines") $c15 = "". $row['tally'] ."";
                    elseif($row['c']== "Mexico") $c16 = "". $row['tally'] ."";
                    elseif($row['c']== "Spain") $c17 = "". $row['tally'] ."";
                    elseif($row['c']== "Bajo Nuevo Bank") $c18 = "". $row['tally'] ."";
                    elseif($row['c']== "Maldives") $c19 = "". $row['tally'] ."";
                    elseif($row['c']== "Spratly Islands") $c20 = "". $row['tally'] ."";
                    elseif($row['c']== "United Kingdom") $c21 = "". $row['tally'] ."";
                    elseif($row['c']== "Greece") $c22 = "". $row['tally'] ."";
                    elseif($row['c']== "American Samoa") $c23 = "". $row['tally'] ."";
                    elseif($row['c']== "Denmark") $c24 = "". $row['tally'] ."";
                    elseif($row['c']== "Greenland") $c25 = "". $row['tally'] ."";
                    elseif($row['c']== "Guam") $c26 = "". $row['tally'] ."";
                    elseif($row['c']== "Northern Mariana Islands") $c27 = "". $row['tally'] ."";
                    elseif($row['c']== "Puerto Rico") $c28 = "". $row['tally'] ."";
                    elseif($row['c']== "Virgin Islands") $c29 = "". $row['tally'] ."";
                    elseif($row['c']== "Canada") $c30 = "". $row['tally'] ."";
                    elseif($row['c']== "Sao Tome and Principe") $c31 = "". $row['tally'] ."";
                    elseif($row['c']== "Cape Verde") $c32 = "". $row['tally'] ."";
                    elseif($row['c']== "Dominica") $c33 = "". $row['tally'] ."";
                    elseif($row['c']== "Netherlands") $c34 = "". $row['tally'] ."";
                    elseif($row['c']== "Jamaica") $c35 = "". $row['tally'] ."";
                    elseif($row['c']== "Samoa") $c36 = "". $row['tally'] ."";
                    elseif($row['c']== "Oman") $c37 = "". $row['tally'] ."";
                    elseif($row['c']== "Saint Vincent and The Grenadines") $c38 = "". $row['tally'] ."";
                    elseif($row['c']== "Turkey") $c39 = "". $row['tally'] ."";
                    elseif($row['c']== "Bangladesh") $c40 = "". $row['tally'] ."";
                    elseif($row['c']== "Saint Lucia") $c41 = "". $row['tally'] ."";
                    elseif($row['c']== "Nauru") $c42 = "". $row['tally'] ."";
                    elseif($row['c']== "Norway") $c43 = "". $row['tally'] ."";
                    elseif($row['c']== "Saint Kitts And Nevis") $c44 = "". $row['tally'] ."";
                    elseif($row['c']== "Bahrain") $c45 = "". $row['tally'] ."";
                    elseif($row['c']== "Tonga") $c46 = "". $row['tally'] ."";
                    elseif($row['c']== "Finland") $c47 = "". $row['tally'] ."";
                    elseif($row['c']== "Indonesia") $c48 = "". $row['tally'] ."";
                    elseif($row['c']== "Mauritius") $c49 = "". $row['tally'] ."";
                    elseif($row['c']== "Sweden") $c50 = "". $row['tally'] ."";
                    elseif($row['c']== "Trinidad and Tobago") $c51 = "". $row['tally'] ."";
                    elseif($row['c']== "Malaysia") $c52 = "". $row['tally'] ."";
                    elseif($row['c']== "Panama") $c53 = "". $row['tally'] ."";
                    elseif($row['c']== "Palau") $c54 = "". $row['tally'] ."";
                    elseif($row['c']== "Tuvalu") $c55 = "". $row['tally'] ."";
                    elseif($row['c']== "Marshall Islands") $c56 = "". $row['tally'] ."";
                    elseif($row['c']== "Chile") $c57 = "". $row['tally'] ."";
                    elseif($row['c']== "Thailand") $c58 = "". $row['tally'] ."";
                    elseif($row['c']== "Grenada") $c59 = "". $row['tally'] ."";
                    elseif($row['c']== "Estonia") $c60 = "". $row['tally'] ."";
                    elseif($row['c']== "Antigua and Barbuda") $c61 = "". $row['tally'] ."";
                    elseif($row['c']== "Taiwan") $c62 = "". $row['tally'] ."";
                    elseif($row['c']== "Barbados") $c63 = "". $row['tally'] ."";
                    elseif($row['c']== "Italy") $c64 = "". $row['tally'] ."";
                    elseif($row['c']== "Malta") $c65 = "". $row['tally'] ."";
                    elseif($row['c']== "Vanuatu") $c66 = "". $row['tally'] ."";
                    elseif($row['c']== "Singapore") $c67 = "". $row['tally'] ."";
                    elseif($row['c']== "Cyprus") $c68 = "". $row['tally'] ."";
                    elseif($row['c']== "Sri Lanka") $c69 = "". $row['tally'] ."";
                    elseif($row['c']== "Comoros") $c70 = "". $row['tally'] ."";
                    elseif($row['c']== "Fiji") $c71 = "". $row['tally'] ."";
                    elseif($row['c']== "Russia") $c72 = "". $row['tally'] ."";
                    elseif($row['c']== "Vatican City") $c73 = "". $row['tally'] ."";
                    elseif($row['c']== "San Marino") $c74 = "". $row['tally'] ."";
                    elseif($row['c']== "Kazakhstan") $c75 = "". $row['tally'] ."";
                    elseif($row['c']== "Azerbaijan") $c76 = "". $row['tally'] ."";
                    elseif($row['c']== "Tajikistan") $c77 = "". $row['tally'] ."";
                    elseif($row['c']== "Lesotho") $c78 = "". $row['tally'] ."";
                    elseif($row['c']== "Uzbekistan") $c79 = "". $row['tally'] ."";
                    elseif($row['c']== "Morocco") $c80 = "". $row['tally'] ."";
                    elseif($row['c']== "Colombia") $c81 = "". $row['tally'] ."";
                    elseif($row['c']== "Timor-Leste") $c82 = "". $row['tally'] ."";
                    elseif($row['c']== "Tanzania") $c83 = "". $row['tally'] ."";
                    elseif($row['c']== "Argentina") $c84 = "". $row['tally'] ."";
                    elseif($row['c']== "Saudi Arabia") $c85 = "". $row['tally'] ."";
                    elseif($row['c']== "Pakistan") $c86 = "". $row['tally'] ."";
                    elseif($row['c']== "Yemen") $c87 = "". $row['tally'] ."";
                    elseif($row['c']== "United Arab Emirates") $c88 = "". $row['tally'] ."";
                    elseif($row['c']== "Kenya") $c89 = "". $row['tally'] ."";
                    elseif($row['c']== "Peru") $c90 = "". $row['tally'] ."";
                    elseif($row['c']== "Dominican Republic") $c91 = "". $row['tally'] ."";
                    elseif($row['c']== "Haiti") $c92 = "". $row['tally'] ."";
                    elseif($row['c']== "Papua New Guinea") $c93 = "". $row['tally'] ."";
                    elseif($row['c']== "Angola") $c94 = "". $row['tally'] ."";
                    elseif($row['c']== "Cambodia") $c95 = "". $row['tally'] ."";
                    elseif($row['c']== "Vietnam") $c96 = "". $row['tally'] ."";
                    elseif($row['c']== "Mozambique") $c97 = "". $row['tally'] ."";
                    elseif($row['c']== "Costa Rica") $c98 = "". $row['tally'] ."";
                    elseif($row['c']== "Benin") $c99 = "". $row['tally'] ."";
                    elseif($row['c']== "Nigeria") $c100 = "". $row['tally'] ."";
                    elseif($row['c']== "Iran") $c101 = "". $row['tally'] ."";
                    elseif($row['c']== "El Salvador") $c102 = "". $row['tally'] ."";
                    elseif($row['c']== "Sierra Leone") $c103 = "". $row['tally'] ."";
                    elseif($row['c']== "Guinea-Bissau") $c104 = "". $row['tally'] ."";
                    elseif($row['c']== "Croatia") $c105 = "". $row['tally'] ."";
                    elseif($row['c']== "Belize") $c106 = "". $row['tally'] ."";
                    elseif($row['c']== "South Africa") $c107 = "". $row['tally'] ."";
                    elseif($row['c']== "Central African Republic") $c108 = "". $row['tally'] ."";
                    elseif($row['c']== "Sudan") $c109 = "". $row['tally'] ."";
                    elseif($row['c']== "Congo") $c110 = "". $row['tally'] ."";
                    elseif($row['c']== "Kuwait") $c111 = "". $row['tally'] ."";
                    elseif($row['c']== "Germany") $c112 = "". $row['tally'] ."";
                    elseif($row['c']== "Belgium") $c113 = "". $row['tally'] ."";
                    elseif($row['c']== "Ireland") $c114 = "". $row['tally'] ."";
                    elseif($row['c']== "North Korea") $c115 = "". $row['tally'] ."";
                    elseif($row['c']== "South Korea") $c116 = "". $row['tally'] ."";
                    elseif($row['c']== "Guyana") $c117 = "". $row['tally'] ."";
                    elseif($row['c']== "Honduras") $c118 = "". $row['tally'] ."";
                    elseif($row['c']== "Myanmar") $c119 = "". $row['tally'] ."";
                    elseif($row['c']== "Gabon") $c120 = "". $row['tally'] ."";
                    elseif($row['c']== "Equatorial Guinea") $c121 = "". $row['tally'] ."";
                    elseif($row['c']== "Nicaragua") $c122 = "". $row['tally'] ."";
                    elseif($row['c']== "Latvia") $c123 = "". $row['tally'] ."";
                    elseif($row['c']== "Uganda") $c124 = "". $row['tally'] ."";
                    elseif($row['c']== "Malawi") $c125 = "". $row['tally'] ."";
                    elseif($row['c']== "Armenia") $c126 = "". $row['tally'] ."";
                    elseif($row['c']== "Somaliland") $c127 = "". $row['tally'] ."";
                    elseif($row['c']== "Turkmenistan") $c128 = "". $row['tally'] ."";
                    elseif($row['c']== "Zambia") $c129 = "". $row['tally'] ."";
                    elseif($row['c']== "New Caledonia") $c130 = "". $row['tally'] ."";
                    elseif($row['c']== "Mauritania") $c131 = "". $row['tally'] ."";
                    elseif($row['c']== "Algeria") $c132 = "". $row['tally'] ."";
                    elseif($row['c']== "Lithuania") $c133 = "". $row['tally'] ."";
                    elseif($row['c']== "Ethiopia") $c134 = "". $row['tally'] ."";
                    elseif($row['c']== "Eritrea") $c135 = "". $row['tally'] ."";
                    elseif($row['c']== "Ghana") $c136 = "". $row['tally'] ."";
                    elseif($row['c']== "Slovenia") $c137 = "". $row['tally'] ."";
                    elseif($row['c']== "Guatemala") $c138 = "". $row['tally'] ."";
                    elseif($row['c']== "Bosnia and Herzegovina") $c139 = "". $row['tally'] ."";
                    elseif($row['c']== "Jordan") $c140 = "". $row['tally'] ."";
                    elseif($row['c']== "Syrian Arab Republic") $c141 = "". $row['tally'] ."";
                    elseif($row['c']== "Monaco") $c142 = "". $row['tally'] ."";
                    elseif($row['c']== "Albania") $c143 = "". $row['tally'] ."";
                    elseif($row['c']== "Uruguay") $c144 = "". $row['tally'] ."";
                    elseif($row['c']== "Cyprus No Mans Area") $c145 = "". $row['tally'] ."";
                    elseif($row['c']== "Mongolia") $c146 = "". $row['tally'] ."";
                    elseif($row['c']== "Rwanda") $c147 = "". $row['tally'] ."";
                    elseif($row['c']== "Somalia") $c148 = "". $row['tally'] ."";
                    elseif($row['c']== "Bolivia") $c149 = "". $row['tally'] ."";
                    elseif($row['c']== "Cameroon") $c150 = "". $row['tally'] ."";
                    elseif($row['c']== "Republic of Congo") $c151 = "". $row['tally'] ."";
                    elseif($row['c']== "Western Sahara") $c152 = "". $row['tally'] ."";
                    elseif($row['c']== "Serbia") $c153 = "". $row['tally'] ."";
                    elseif($row['c']== "Montenegro") $c154 = "". $row['tally'] ."";
                    elseif($row['c']== "Togo") $c155 = "". $row['tally'] ."";
                    elseif($row['c']== "Laos") $c156 = "". $row['tally'] ."";
                    elseif($row['c']== "Afghanistan") $c157 = "". $row['tally'] ."";
                    elseif($row['c']== "Ukraine") $c158 = "". $row['tally'] ."";
                    elseif($row['c']== "Slovakia") $c159 = "". $row['tally'] ."";
                    elseif($row['c']== "Siachen Glacier") $c160 = "". $row['tally'] ."";
                    elseif($row['c']== "Bulgaria") $c161 = "". $row['tally'] ."";
                    elseif($row['c']== "Qatar") $c162 = "". $row['tally'] ."";
                    elseif($row['c']== "Liechtenstein") $c163 = "". $row['tally'] ."";
                    elseif($row['c']== "Austria") $c164 = "". $row['tally'] ."";
                    elseif($row['c']== "Swaziland") $c165 = "". $row['tally'] ."";
                    elseif($row['c']== "Hungary") $c166 = "". $row['tally'] ."";
                    elseif($row['c']== "Romania") $c167 = "". $row['tally'] ."";
                    elseif($row['c']== "Niger") $c168 = "". $row['tally'] ."";
                    elseif($row['c']== "Luxembourg") $c169 = "". $row['tally'] ."";
                    elseif($row['c']== "Andorra") $c170 = "". $row['tally'] ."";
                    elseif($row['c']== "Cote D'Ivoire") $c171 = "". $row['tally'] ."";
                    elseif($row['c']== "Liberia") $c172 = "". $row['tally'] ."";
                    elseif($row['c']== "Brunei Darussalam") $c173 = "". $row['tally'] ."";
                    elseif($row['c']== "Iraq") $c174 = "". $row['tally'] ."";
                    elseif($row['c']== "Georgia") $c175 = "". $row['tally'] ."";
                    elseif($row['c']== "Gambia") $c176 = "". $row['tally'] ."";
                    elseif($row['c']== "Switzerland") $c177 = "". $row['tally'] ."";
                    elseif($row['c']== "Chad") $c178 = "". $row['tally'] ."";
                    elseif($row['c']== "Kosovo") $c179 = "". $row['tally'] ."";
                    elseif($row['c']== "Lebanon") $c180 = "". $row['tally'] ."";
                    elseif($row['c']== "Djibouti") $c181 = "". $row['tally'] ."";
                    elseif($row['c']== "Burundi") $c182 = "". $row['tally'] ."";
                    elseif($row['c']== "Suriname") $c183 = "". $row['tally'] ."";
                    elseif($row['c']== "Israel") $c184 = "". $row['tally'] ."";
                    elseif($row['c']== "Mali") $c185 = "". $row['tally'] ."";
                    elseif($row['c']== "Senegal") $c186 = "". $row['tally'] ."";
                    elseif($row['c']== "Guinea") $c187 = "". $row['tally'] ."";
                    elseif($row['c']== "Zimbabwe") $c188 = "". $row['tally'] ."";
                    elseif($row['c']== "Poland") $c189 = "". $row['tally'] ."";
                    elseif($row['c']== "Macedonia") $c190 = "". $row['tally'] ."";
                    elseif($row['c']== "Paraguay") $c191 = "". $row['tally'] ."";
                    elseif($row['c']== "Belarus") $c192 = "". $row['tally'] ."";
                    elseif($row['c']== "Czech Republic") $c193 = "". $row['tally'] ."";
                    elseif($row['c']== "Burkina Faso") $c194 = "". $row['tally'] ."";
                    elseif($row['c']== "Namibia") $c195 = "". $row['tally'] ."";
                    elseif($row['c']== "Libya") $c196 = "". $row['tally'] ."";
                    elseif($row['c']== "Tunisia") $c197 = "". $row['tally'] ."";
                    elseif($row['c']== "Bhutan") $c198 = "". $row['tally'] ."";
                    elseif($row['c']== "Moldova") $c199 = "". $row['tally'] ."";
                    elseif($row['c']== "South Sudan") $c200 = "". $row['tally'] ."";
                    elseif($row['c']== "Botswana") $c201 = "". $row['tally'] ."";
                    elseif($row['c']== "Bahamas") $c202 = "". $row['tally'] ."";
                    elseif($row['c']== "New Zealand") $c203 = "". $row['tally'] ."";
                    elseif($row['c']== "Cuba") $c204 = "". $row['tally'] ."";
                    elseif($row['c']== "Ecuador") $c205 = "". $row['tally'] ."";
                    elseif($row['c']== "Australia") $c206 = "". $row['tally'] ."";
                    elseif($row['c']== "Venezuela") $c207 = "". $row['tally'] ."";
                    elseif($row['c']== "Solomon Islands") $c208 = "". $row['tally'] ."";
                    elseif($row['c']== "Madagascar") $c209 = "". $row['tally'] ."";
                    elseif($row['c']== "Iceland") $c210 = "". $row['tally'] ."";
                    elseif($row['c']== "Egypt") $c211 = "". $row['tally'] ."";
                    elseif($row['c']== "Kyrgyzstan") $c212 = "". $row['tally'] ."";
                    elseif($row['c']== "Nepal") $c213 = "". $row['tally'] ."";

                                        
                                           
            }
            
            mysqli_free_result($result);
        } 
    }
     
   
    ?><script src="https://code.highcharts.com/maps/highmaps.js"></script><script src="https://code.highcharts.com/maps/modules/exporting.js"></script><script src="https://code.highcharts.com/mapdata/custom/world.js"></script><div id="container1"></div><script>
var data=[['fo',<?php echo $c1;?>],['um',<?php echo $c2;?>],['us',<?php echo $c3;?>],['jp',<?php echo $c4;?>],['sc',<?php echo $c5;?>],['in',<?php echo $c6;?>],['fr',<?php echo $c7;?>],['fm',<?php echo $c8;?>],['cn',<?php echo $c9;?>],['pt',<?php echo $c10;?>],['sw',<?php echo $c11;?>],['sh',<?php echo $c12;?>],['br',<?php echo $c13;?>],['ki',<?php echo $c14;?>],['ph',<?php echo $c15;?>],['mx',<?php echo $c16;?>],['es',<?php echo $c17;?>],['bu',<?php echo $c18;?>],['mv',<?php echo $c19;?>],['sp',<?php echo $c20;?>],['gb',<?php echo $c21;?>],['gr',<?php echo $c22;?>],['as',<?php echo $c23;?>],['dk',<?php echo $c24;?>],['gl',<?php echo $c25;?>],['gu',<?php echo $c26;?>],['mp',<?php echo $c27;?>],['pr',<?php echo $c28;?>],['vi',<?php echo $c29;?>],['ca',<?php echo $c30;?>],['st',<?php echo $c31;?>],['cv',<?php echo $c32;?>],['dm',<?php echo $c33;?>],['nl',<?php echo $c34;?>],['jm',<?php echo $c35;?>],['ws',<?php echo $c36;?>],['om',<?php echo $c37;?>],['vc',<?php echo $c38;?>],['tr',<?php echo $c39;?>],['bd',<?php echo $c40;?>],['lc',<?php echo $c41;?>],['nr',<?php echo $c42;?>],['no',<?php echo $c43;?>],['kn',<?php echo $c44;?>],['bh',<?php echo $c45;?>],['to',<?php echo $c46;?>],['fi',<?php echo $c47;?>],['id',<?php echo $c48;?>],['mu',<?php echo $c49;?>],['se',<?php echo $c50;?>],['tt',<?php echo $c51;?>],['my',<?php echo $c52;?>],['pa',<?php echo $c53;?>],['pw',<?php echo $c54;?>],['tv',<?php echo $c55;?>],['mh',<?php echo $c56;?>],['cl',<?php echo $c57;?>],['th',<?php echo $c58;?>],['gd',<?php echo $c59;?>],['ee',<?php echo $c60;?>],['ag',<?php echo $c61;?>],['tw',<?php echo $c62;?>],['bb',<?php echo $c63;?>],['it',<?php echo $c64;?>],['mt',<?php echo $c65;?>],['vu',<?php echo $c66;?>],['sg',<?php echo $c67;?>],['cy',<?php echo $c68;?>],['lk',<?php echo $c69;?>],['km',<?php echo $c70;?>],['fj',<?php echo $c71;?>],['ru',<?php echo $c72;?>],['va',<?php echo $c73;?>],['sm',<?php echo $c74;?>],['kz',<?php echo $c75;?>],['az',<?php echo $c76;?>],['tj',<?php echo $c77;?>],['ls',<?php echo $c78;?>],['uz',<?php echo $c79;?>],['ma',<?php echo $c80;?>],['co',<?php echo $c81;?>],['tl',<?php echo $c82;?>],['tz',<?php echo $c83;?>],['ar',<?php echo $c84;?>],['sa',<?php echo $c85;?>],['pk',<?php echo $c86;?>],['ye',<?php echo $c87;?>],['ae',<?php echo $c88;?>],['ke',<?php echo $c89;?>],['pe',<?php echo $c90;?>],['do',<?php echo $c91;?>],['ht',<?php echo $c92;?>],['pg',<?php echo $c93;?>],['ao',<?php echo $c94;?>],['kh',<?php echo $c95;?>],['vn',<?php echo $c96;?>],['mz',<?php echo $c97;?>],['cr',<?php echo $c98;?>],['bj',<?php echo $c99;?>],['ng',<?php echo $c100;?>],['ir',<?php echo $c101;?>],['sv',<?php echo $c102;?>],['sl',<?php echo $c103;?>],['gw',<?php echo $c104;?>],['hr',<?php echo $c105;?>],['bz',<?php echo $c106;?>],['za',<?php echo $c107;?>],['cf',<?php echo $c108;?>],['sd',<?php echo $c109;?>],['cd',<?php echo $c110;?>],['kw',<?php echo $c111;?>],['de',<?php echo $c112;?>],['be',<?php echo $c113;?>],['ie',<?php echo $c114;?>],['kp',<?php echo $c115;?>],['kr',<?php echo $c116;?>],['gy',<?php echo $c117;?>],['hn',<?php echo $c118;?>],['mm',<?php echo $c119;?>],['ga',<?php echo $c120;?>],['gq',<?php echo $c121;?>],['ni',<?php echo $c122;?>],['lv',<?php echo $c123;?>],['ug',<?php echo $c124;?>],['mw',<?php echo $c125;?>],['am',<?php echo $c126;?>],['sx',<?php echo $c127;?>],['tm',<?php echo $c128;?>],['zm',<?php echo $c129;?>],['nc',<?php echo $c130;?>],['mr',<?php echo $c131;?>],['dz',<?php echo $c132;?>],['lt',<?php echo $c133;?>],['et',<?php echo $c134;?>],['er',<?php echo $c135;?>],['gh',<?php echo $c136;?>],['si',<?php echo $c137;?>],['gt',<?php echo $c138;?>],['ba',<?php echo $c139;?>],['jo',<?php echo $c140;?>],['sy',<?php echo $c141;?>],['mc',<?php echo $c142;?>],['al',<?php echo $c143;?>],['uy',<?php echo $c144;?>],['cnm',<?php echo $c145;?>],['mn',<?php echo $c146;?>],['rw',<?php echo $c147;?>],['so',<?php echo $c148;?>],['bo',<?php echo $c149;?>],['cm',<?php echo $c150;?>],['cg',<?php echo $c151;?>],['eh',<?php echo $c152;?>],['rs',<?php echo $c153;?>],['me',<?php echo $c154;?>],['tg',<?php echo $c155;?>],['la',<?php echo $c156;?>],['af',<?php echo $c157;?>],['ua',<?php echo $c158;?>],['sk',<?php echo $c159;?>],['jk',<?php echo $c160;?>],['bg',<?php echo $c161;?>],['qa',<?php echo $c162;?>],['li',<?php echo $c163;?>],['at',<?php echo $c164;?>],['sz',<?php echo $c165;?>],['hu',<?php echo $c166;?>],['ro',<?php echo $c167;?>],['ne',<?php echo $c168;?>],['lu',<?php echo $c169;?>],['ad',<?php echo $c170;?>],['ci',<?php echo $c171;?>],['lr',<?php echo $c172;?>],['bn',<?php echo $c173;?>],['iq',<?php echo $c174;?>],['ge',<?php echo $c175;?>],['gm',<?php echo $c176;?>],['ch',<?php echo $c177;?>],['td',<?php echo $c178;?>],['kv',<?php echo $c179;?>],['lb',<?php echo $c180;?>],['dj',<?php echo $c181;?>],['bi',<?php echo $c182;?>],['sr',<?php echo $c183;?>],['il',<?php echo $c184;?>],['ml',<?php echo $c185;?>],['sn',<?php echo $c186;?>],['gn',<?php echo $c187;?>],['zw',<?php echo $c188;?>],['pl',<?php echo $c189;?>],['mk',<?php echo $c190;?>],['py',<?php echo $c191;?>],['by',<?php echo $c192;?>],['cz',<?php echo $c193;?>],['bf',<?php echo $c194;?>],['na',<?php echo $c195;?>],['ly',<?php echo $c196;?>],['tn',<?php echo $c197;?>],['bt',<?php echo $c198;?>],['md',<?php echo $c199;?>],['ss',<?php echo $c200;?>],['bw',<?php echo $c201;?>],['bs',<?php echo $c202;?>],['nz',<?php echo $c203;?>],['cu',<?php echo $c204;?>],['ec',<?php echo $c205;?>],['au',<?php echo $c206;?>],['ve',<?php echo $c207;?>],['sb',<?php echo $c208;?>],['mg',<?php echo $c209;?>],['is',<?php echo $c210;?>],['eg',<?php echo $c211;?>],['kg',<?php echo $c212;?>],['np',<?php echo $c213;?>]];Highcharts.mapChart('container1',{chart:{map:'custom/world',backgroundColor:'rgba(255, 255, 255, 0.0)'},title:{text:''},mapNavigation:{enabled:true,buttonOptions:{verticalAlign:'bottom'}},colorAxis:{min:0},series:[{data:data,name:'Visitor',states:{hover:{color:'#BADA55'}},dataLabels:{enabled:false,format:'{point.name}'}}]});</script></div></div><div id="copyright"><div style="color:#696969;font-family:Arial;font-size:15px; text-align:center;"><?php echo "Copyright © " .$year ." " .$sitename. ", All Rights Reserved."; ?></div></div><div id="urlink2"><div style="color:#808080;font-family:Arial;font-size:16px; text-align:right;"><?php echo $lang["urlink"]; ?>:</div></div></div><script src="share/jquery.shares.js"></script><script>
$(document).ready(function(){$('a.share').shares();});</script></body></html>