<?php
// ==========================================================================================================
// titids - Tiny Thick IDS v0.0.1 by Ade Ismail Isnan
// Snort/Suricata alert log parser - Copyleft 2010
//
// Execute this script from root every minute/hour/day via cronjob to process Suricata's fast.log to Database
// eg.: # crontab -e
// and run cron job every minute: * * * * * /usr/bin/php -q /path/to/titids/cron/process-alert.php
// ==========================================================================================================

// ===================================================
//
// Suricata fast.log location:
$fastlog = "/var/log/suricata/fast.log";
// MySQL database connection config:
$filedbcon = "/path/to/titids/mysql_connect.php";
//
// ===================================================

include "$filedbcon";
$file = fopen($fastlog,"r+");

while (!feof($file)) {
        $content = fgets($file);
        $re = "/^(?P<month>\d+)\/(?P<day>\d+)\/(?P<year>\d+)-(?P<times>\d+:\d+:\d+).\d+\s.\[\*\*\]\s+\[\d+:\d+:\d+\]\s+(?P<alert>\w.+)\s+\[\**]\s+\[Classification:\s+\S.+\]\s+\[Priority:\s+\d+\]\s+\{(?P<proto>\S+)\}\s+(?P<intruder>\d+.\d+.\d+.\d+):\d+\s+\-\>\s+\d+.\d+.\d+.\d+:(?P<port>\d+)/";
        preg_match_all($re, $content, $my_array, PREG_SET_ORDER,0);
        $m=$my_array[0][1];
        $d=$my_array[0][2];
        $Y=$my_array[0][3];
        $t=$my_array[0][4];
        $alerttime="$Y-$m-$d $t";
        $alert=$my_array[0][5];
        $proto=$my_array[0][6];
        $ip=$my_array[0][7];
        $port=$my_array[0][8];
        if(!empty($ip)){
                $sql="insert into INTRUDERS(Time,Alert,IP,Protocol,Port) values ('$alerttime','$alert','$ip','$proto','$port');";
                mysql_query($sql);
        }
        
// ====================================================================================
//  Custom action, eg. redirect to honeypot for offensive Intruders on port 22 and 2222
// ====================================================================================
//
//        if($port==22 or $port==2222){
//                $honeypot_redir=shell_exec("/sbin/iptables -t nat -L PREROUTING -n | grep -i $ip | wc -l");
//                if($honeypot_redir!=1){
//                        shell_exec("/sbin/iptables -t nat -A PREROUTING -i eth0 -s $ip -p tcp --dport 22 -j REDIRECT --to-port 2222");
//                }
//        }
        
}
ftruncate($file,0);
fclose($file)
?>
