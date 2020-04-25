# titids
Tiny Thick IDS - a Simple Web GUI for Suricata NIDS

System requirement:
- Suricata IDS installed
- php-5.4 or below
- mysql-server
- httpd or equivalent server

Scripto Kiddo - 2009

# FAQ
1. Seriously?<br/>
No<br/>

2. Wtf your php code?<br/>
Nah, this project part of my first PHP code back in college. What do you expect?<br/>

3. How to install?<br/>
Wtf? Seriously? Don't. Mmm kay....<br/>
-Setup the LAMP stack in your server<br/>
-Setup Snort/Suricata in your server<br/>
-git clone https://github.com/inan19x/titids.git<br/>
-edit DB config in titids/mysql_connect.php<br/>
-dump DB schema in titids/titids-db-schema.sql<br/>
-edit some changes in titids/cron/process-alert.php<br/>
-add cron job to execute titids/cron/process-alert.php<br/>
-go to https://your-server/titids/ - user:admin pass:admin<br/>
