<?php
session_start();
if(isset($_SESSION["netadmin"])){
?>
<!DOCTYPE html PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html>
<head>
<title>"<?php echo php_uname('n'); ?>" - titids</title>
</head>
<?php
//  This script was writen by webmaster@theworldsend.net, Aug.2001
//  http://www.theworldsend.net 
//  This is my first script. Enjoy.
//  
// Put it into whatever directory and call it. That's all.
// Updated to 4.2 code in 2002
// Get Variable from form via register globals on/off
//-------------------------
$unix      =  1; //set this to 1 if you are on a *unix system      
$windows   =  0; //set this to 1 if you are on a windows system
// -------------------------
// nothing more to be done.
// -------------------------
//globals on or off ?
$register_globals = (bool) ini_get('register_gobals');
$system = ini_get('system');
$unix = (bool) $unix;
$win  = (bool)  $windows;
//
If ($register_globals)
{
   $ip = getenv(REMOTE_ADDR);
   $self = $PHP_SELF;
} 
else 
{
   $submit = $_GET['submit'];
   $host   = $_GET['host'];
   $ip     = $_SERVER['REMOTE_ADDR'];
   $self   = $_SERVER['PHP_SELF'];
};
      $host= preg_replace ("/[^A-Za-z0-9.]/","",$host);
      echo '<body bgcolor="#FFFFFF" text="#000000"></body>';
      echo '<pre>';           
      //check target IP or domain
      if ($unix) 
      {
         system("traceroute $host");
         system("killall -q traceroute");// kill all traceroute processes in case there are some stalled ones or use echo 'traceroute' to execute without shell
      }
      else
      {
         system("tracert $host");
      }
      echo '</pre>'; 
}
else{
	header("Location:../");
}
?>
