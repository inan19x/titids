<?php
session_start();
if(isset($_SESSION["netadmin"])){
include "../mysql_connect.php";

$ip=$_REQUEST[ip];

if($ip!=""){
	$sqllog="SELECT Alert,Time FROM INTRUDERS WHERE IP='$ip' ORDER BY Time DESC LIMIT 5";
	$qrylog=mysql_query($sqllog);
	while($rowlog=mysql_fetch_array($qrylog)){
		$string=$rowlog[Alert];
		$pattern="(\[\*\*\]|[[0-9]*:[0-9]*:[0-9]*\])";
		$replace="";
		$tipeserangan=preg_replace($pattern,$replace,$string);
		echo "<strong><big>$tipeserangan</big></strong><br>detected at $rowlog[Time]<br><br>";
	}
}
}
else{
	header("Location:../");
}
?>
