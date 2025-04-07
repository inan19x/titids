<?php
Header("Content-Type:image/jpeg");

include "../mysql_connect.php";

$sqldetection = "SELECT COUNT(Alert) AS Total, Alert FROM INTRUDERS GROUP BY Alert ORDER BY Total DESC Limit 10";
$qrydetection = mysql_query($sqldetection);
$sqlsum = "SELECT COUNT(Alert) AS SUM FROM INTRUDERS";
$qrysum = mysql_query($sqlsum);
$rowsum = mysql_fetch_array($qrysum);
$numsum = mysql_num_rows($qrysum);

$i=0;
while ($rowdetection=mysql_fetch_array($qrydetection)) {
	$data[$i] = $rowdetection["Total"];
	$string="$rowdetection[Alert]";
	$pattern="(\[\*\*\]|[[0-9]*:[0-9]*:[0-9]*\])";
	$replace="";
	$alert=preg_replace($pattern,$replace,$string);
	if($numsum!=0){
		$percentage=$rowdetection[Total]/$rowsum[SUM]*100;
		$percentage=number_format($percentage,2);
	}
	$str[$i] = "$alert ($rowdetection[Total]x, $percentage%)";
	$i++;
}

$total = 0;
$d = array();
$kor_x = array();
$kor_y = array();
$t_x = array();
$t_y = array();

for($j=0;$j<=$i-1;$j++) {
    $total += $data[$j];
}
$d[0] = 0;
for($x=1;$x<=$i;$x++) {
    $d[$x] = ($data[$x-1]/$total) * 360;
    $d[$x] += $d[$x-1];
}

$img = ImageCreate(1000,300);
$warna[0] = ImageColorAllocate($img,0,255,0);
$warna[1] = ImageColorAllocate($img,255,0,0);
$warna[2] = ImageColorAllocate($img,0,0,255);
$warna[3] = ImageColorAllocate($img,255,0,255);
$warna[4] = ImageColorAllocate($img,255,255,0);
$warna[5] = ImageColorAllocate($img,128,128,128);
$warna[6] = ImageColorAllocate($img,255,128,0);
$warna[7] = ImageColorAllocate($img,0,150,255);
$warna[8] = ImageColorAllocate($img,112,0,255);
$warna[9] = ImageColorAllocate($img,128,255,0);
$hitam = ImageColorAllocate($img,0,0,0);
$putih = ImageColorAllocate($img,255,255,255);
ImageFill($img,0,0,$putih);

for($k=1;$k<=$i;$k++) {

ImageArc($img,150,150,250,250,$d[$k-1],$d[$k],$hitam);
    // --- mencari koordinat batas --- //
    $kor_x[$k] = round(150+(125*cos(deg2rad($d[$k-1]))));
    $kor_y[$k] = round(150+(125*sin(deg2rad($d[$k-1]))));
    // --- mencari titik tengah --- //
    $t = round(($d[$k-1]+$d[$k])/2);
    $t_x[$k] = round(150+(62.5*cos(deg2rad($t))));
    $t_y[$k] = round(150+(62.5*sin(deg2rad($t))));
    ImageLine($img,150,150,$kor_x[$k],$kor_y[$k],$hitam);
}

for($k=1;$k<=$i;$k++) {
    ImageFillToBorder($img,$t_x[$k],$t_y[$k],$hitam,$warna[$k-1]);
    ImageFilledRectangle($img,310,20*$k+50,320,20*$k+60,$warna[$k-1]);
    ImageString($img,2,330,20*$k+50,$str[$k-1],$hitam);
}

ImageJPEG($img);
?> 
