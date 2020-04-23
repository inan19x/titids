<?php
//
// titids - Tiny Thick IDS v0.0.1 by Ade Ismail Isnan
// Copyleft 2010
//
// Execute this script from root every minute/hour/day via cronjob to process Suricata's fast.log to Database
// eg.: # crontab -e
//

// Suricata fast.log location:
$fastlog = "/var/log/suricata/fast.log";

include "mysql_connect.php";
$file = fopen($fastlog,"r+");

while (!feof($file)) {
	$content = fgets($file);
	$re = "/^\d+\/\d+\/\d+-\d+:\d+:\d+.\d+\s.\[\*\*\]\s+\[\d+:\d+:\d+\]\s+(?P<alert>\w.+)\s+\[\**]\s+\[Classification:\s+\S.+\]\s+\[Priority:\s+\d+\]\s+\{(?P<proto>\S+)\}\s+(?P<intruder>\d+.\d+.\d+.\d+):\d+\s+\-\>\s+\d+.\d+.\d+.\d+:(?P<port>\d+)/";
	preg_match_all($re, $content, $my_array, PREG_SET_ORDER,0);
	$alert=$my_array[0][1];
	$proto=$my_array[0][2];
	$ip=$my_array[0][3];
	$port=$my_array[0][4];
	if(!empty($ip)){
		$sql="insert into INTRUDERS(Alert,IP,Protocol,Port) values ('$alert','$ip','$proto','$port');";
		mysql_query($sql);
	}
}
ftruncate($file,0);
fclose($file)
?>
