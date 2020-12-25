<?php session_start() ?>
<?php
include_once('inc/header.php');
?>    
    
<?php
include_once('inc/content.php');
?>
<html>
<table border=0 align="center" >
	<tr>
	<td>Welcome <?php echo $_SESSION['fname'];?></td>
	</tr>
	
	<tr>
	<td><a href="orderdetails.php">ORDER HISTORY</a></td>
	</tr>
	<tr>
	<td><a href="mypackage.php">SELECTED PACKAGE</a></td>
	</tr>

	<tr>
	<td><a href="custdiet.php">MY DIET PLAN</a></td>
	</tr>
	<tr>
	<td><a href="changepass.php">CHANGE PASSWORD</a></td>
	</tr>
	<tr>
	<td><a href="logout.php">LOGOUT</a></td>
	</tr>
</table>
</html>
<?php
include_once('inc/footer.php');
?>