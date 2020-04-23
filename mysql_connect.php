<?php
$host = "dbhost";
$username = "dbuser";
$password = "dbpass";
$dbname = "titids";

@mysql_connect($host,$username,$password);

@mysql_query("use $dbname");
?>
