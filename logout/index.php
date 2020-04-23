<?php
session_start();
unset($_SESSION["netadmin"]);
session_destroy();
header("Location:../");
?>
