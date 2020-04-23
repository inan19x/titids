<?php
session_start();
if(isset($_SESSION["netadmin"])){
include "../mysql_connect.php";

$ip=$_REQUEST[ip];
list($byte1,$byte2,$byte3,$byte4)=explode(".",$ip);
if($ip!=""){
	if($byte1=="10" OR $byte1=="172" OR $byte1=="192"){
		echo "<div style=\"padding:10px;\">Hostname dan GeoIP tidak ter-<em>resolv</em>. Alamat IP ini mungkin adalah <a href=\"http://www.faqs.org/rfcs/rfc1918.html\" target=\"_blank\" >RFC 1918</a> (Private Internet).";
	}
	else{
	echo "<div style=\"padding:10px;\">";
		$country=file_get_contents("https://api.hostip.info/get_html.php?ip=$ip");
		$hostname=gethostbyaddr($ip);
		echo "<table><tr><td rowspan=\"2\"><img src=\"https://api.hostip.info/flag.php?ip=$ip\" /></td><td style=\"padding-left:10px;\"><font color=\"#0000ff\">$hostname</font></td></tr><tr><td style=\"padding-left:10px;\">$country</td></tr></table>";
	}
	echo "</div>";
}
}
else{
	header("Location:../");
}
?>
