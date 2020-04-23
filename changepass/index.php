<?php
session_start();
if(isset($_SESSION["netadmin"])){
	$newpass=md5($_POST['newpass']);
	include "../mysql_connect.php";
	$sqlchgpass="update NETADM set passwd='$newpass' limit 1";
	$qrychgpass=mysql_query($sqlchgpass);
}
header("Location:../");
?>