<?php
session_start();
if(isset($_SESSION["netadmin"])){
?>
<div style="margin-top:5px;text-align:right;">
	<form method="post" action="changepass/" style="background-color:#ffffff;width:300px;padding:10px;">
		NEW PASSWORD&nbsp;&nbsp;<input type="password" name="newpass"><br><br>
		<input type="submit" value="U P D A T E">
	</form>
</div>
<?php
}
else{
	header("Location:../");
}
?>