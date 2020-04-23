<?php
session_start();
?>
<html>
<head>
	<meta http-equiv="refresh" content="60;." />
	<title>"<?php echo php_uname('n'); ?>" - titids</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<style type="text/css">
		a{font-size:12px;text-decoration:none;}
		a:link{color:#777;}
		a:visited{color:#777;}
		a:hover{text-decoration:underline;}
		#ket{font-size:11px;}
		td{font-size:12px;}
		#entity{padding:5px;}
	</style>
	<script src="facebox/jquery.js" type="text/javascript"></script>
	<link href="facebox/facebox.css" media="screen" rel="stylesheet" type="text/css" />
	<script src="facebox/facebox.js" type="text/javascript"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$('a[rel*=facebox]').facebox({
				loading_image:'facebox/loading.gif',
				close_image:'facebox/closelabel.gif'
			})
		});
		function popup(){
			window.open("chart_view.php","mywindow","width=700,height=400");
		}
	</script>
</head>
<body style="background: url(image/background.jpg) repeat-x;">
<?php

if(isset($_SESSION["netadmin"])){

include "mysql_connect.php";

$sqlrecent="SELECT IP,Alert,Time FROM INTRUDERS ORDER BY Time DESC Limit 5";
$qryrecent=mysql_query($sqlrecent);
$totalrecent=mysql_num_rows($qryrecent);

$sqlmalicious="SELECT IP,COUNT(IP) AS TOTAL_ATTACK,Alert,Time FROM INTRUDERS GROUP BY IP ORDER BY TOTAL_ATTACK DESC Limit 5";
$qrymalicious=mysql_query($sqlmalicious);
$totalmal=mysql_num_rows($qrymalicious);

$sqlattack="SELECT COUNT(Alert) AS Total FROM INTRUDERS";
$qryattack=mysql_query($sqlattack);
$rowattack=mysql_fetch_array($qryattack);

$sqlstats="select Protocol, COUNT(*) as Jml from INTRUDERS group by Protocol order by Jml DESC Limit 10";
$qrystats=mysql_query($sqlstats);

$sqlstatsp="select Port, COUNT(*) as Jmlport from INTRUDERS group by Port order by Jmlport DESC Limit 10";
$qrystatsp=mysql_query($sqlstatsp);

?>
<table align="center" style="border:outset;width:1156px;">
	<tr>
		<td bgcolor="#ffffff" valign="top" style="padding:10px;">
		<div align="center" style="margin-bottom:10px;">
			<div align="right" valign="top">
				<img src="image/logout.png" /><a href="logout" style="color:#999999;">LOGOUT</a>
				&nbsp;&nbsp;&nbsp;
				<img src="image/account.png" /><a href="account" rel="facebox">ACCOUNT</a>				
				&nbsp;&nbsp;&nbsp;
				<img src="image/about.png" /><a href="about" rel="facebox">ABOUT</a>
			</div>
			<div align="center" style="font-size:25px;">
			titids - Tiny Thick IDS
			</div>
		<?php
		$snortstat=shell_exec("ls /var/run/suricata/ | grep suricata.pid");
		echo "Suricata: ";
		if($snortstat!=""){
			echo "<img src=\"image/running.gif\" /> RUNNING...";
		}
		else{
			echo "<img src=\"image/down.gif\" /> DOWN";
		}
		?>
		</div><hr/>		
		<table style="border:0px;width:1148px;"><tr>
		<td valign="top">
		<div id="entity">
		<big><strong>Most recent attacking host</strong></big> <a href="."><img src="image/refresh.png" /></a><br>
		<div id="ket">Host reported doing malicious activity recently</div>
		<table style="border:solid 1px;width:615px;"><tr style="background-color:#aaaaaa;"><th>Time</th><th>Intruder IP</th><th>Attack Type</th><th>WHOIS?</th><th>Traceback</th></tr>
		<?php
		if($totalrecent==0){
			echo "<tr style=\"background-color:#e5e5e5;\"><td colspan=\"5\"><font style=\"font-size:11px;color:#ff0000;\">Horray, no intruders detected!</td></tr>";
		}
		else{
			while($rowrecent=mysql_fetch_array($qryrecent)){
				echo "<tr style=\"background-color:#e5e5e5;\"><td align=\"leftt\">".$rowrecent[Time]."</td><td>".$rowrecent[IP]."</td><td align=\"left\">".$rowrecent[Alert]."</td><td align=\"center\"><a href=\"detail?ip=$rowrecent[IP]\" rel=\"facebox\" ><img src=\"image/whois.png\" /></a></td><td align=\"center\"><a href=\"traceroute?host=$rowrecent[IP]\" rel=\"facebox\" ><img src=\"image/traceroute.gif\" /></a></td></tr>";
			}
		}
		?>
		</table>
		<br/>
		</div>
		</td>		
		<td valign="top">
		<div id="entity">
		<big><strong>Top malicious host</strong></big>
		<div id="ket">Top intruders/agressive hosts</div>
		<table style="border:solid 1px;width:500px;"><tr style="background-color:#aaaaaa;"><th>Intruder IP</th><th>Hit</th><th>WHOIS?</th><th>Traceback</th></tr>
		<?php
		if($totalmal==0){
			echo "<tr style=\"background-color:#e5e5e5;\"><td colspan=\"5\"><font style=\"font-size:11px;color:#ff0000;\">Horray, no intruders detected!</td></tr>";
		}
		else{
			while($rowmalicious=mysql_fetch_array($qrymalicious)){
				echo "<tr style=\"background-color:#FFC1B4;\"><td>".$rowmalicious[IP]."</td><td align=\"center\"><a href=\"detection/?ip=$rowmalicious[IP]\" rel=\"facebox\" >".$rowmalicious[TOTAL_ATTACK]."x</a></td><td align=\"center\"><a href=\"detail?ip=$rowmalicious[IP]\" rel=\"facebox\" ><img src=\"image/whois.png\" /></a></td><td align=\"center\"><a href=\"traceroute?host=$rowmalicious[IP]\" rel=\"facebox\" ><img src=\"image/traceroute.gif\" /></a></td></tr>";
			}
		}
		?>
		</td></tr></table>
		<br/>
		</div>
		</table>
		<div id="entity">
		<big><strong>Total intruders to date:
		<?php
		if($rowattack[Total]==0){
			echo "0";
		}
		else{
			echo "$rowattack[Total] times.";
		}
		?>
		</strong></big><br/>
		<div id="ket">Attack statistics</div>
		<table style="border:solid 1px;width:1148px;">
		<tr style="background-color:#aaaaaa;">
			<th>Attack Chart</th>
			<th>Protocol Stats</th>
		</tr>
		<tr>
		<td style="width:1000px;border:1px;">
			<img src="image/pie_chart.php" />
		</td>
		<td bgcolor="#eee" style="width:148px;border:1px;padding-left:5px;">
			<strong>By Protocol:</strong><br/>
			<?php
			while($rowstats=mysql_fetch_array($qrystats)){
				if($rowstats==0){
					echo "<pre>No protocol data.</pre>";
				}
				else{
					echo "$rowstats[Protocol] : $rowstats[Jml]<br/>";
				}
			}
			?><br/>
			<strong>By Port:</strong><br/>
			<?php
			while($rowstatsp=mysql_fetch_array($qrystatsp)){
				if($rowstatsp==0){
					echo "<pre>No port data.</pre>";
				}
				else{
					echo "#$rowstatsp[Port] : $rowstatsp[Jmlport]<br/>";
				}
			}
			?><br/>
		</td>
		</tr>
		</table>
		</div>
		</td>
	</tr>
</table>
<?php
}
else{
?>
<center>
<div style="margin-top:100px;">
	<form method="post" action="login/" style="background-color:#ffffff;width:300px;padding:10px;border:outset;">
		USERNAME&nbsp;&nbsp;<input type="text" name="username"><br><br>
		PASSWORD&nbsp;&nbsp;<input type="password" name="password"><br><br>
		<input type="submit" value="L O G I N">
	</form>
</div>
</center>
<?php
}
?>
<center>
<font size="2">titids v0.0.1 <em>coffee-left</em> 2010 Ade Ismail Isnan<br></font>
</center>
</body>
</html>
