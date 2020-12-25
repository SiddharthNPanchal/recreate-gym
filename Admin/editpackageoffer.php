<?php
include_once('inc/header1.php');

?>    
    
<?php
include_once('inc/right.php');

?> 
<html>
<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$packageofferid=$_GET['packageofferid'];
			$sql="select * from packageoffer where packageofferid='$packageofferid'";
			$result=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result);
			$_SESSION['msg']="city Deleted";
			mysqli_close($cn);
?>

	<body>
		<h2>Edit</h2>
		<form action="editpackageoffer1.php" method="post">
		<input type="hidden" name="packageofferid" value="<?php echo $rec['packageofferid'];?>"/>
		<table border="1">
			<tr>
				<td>packageoffer discount</td>
				<td><input type="text" required value="<?php echo $rec['packageofferdiscount'];?>" name="packageofferdiscount"/> </td>
			</tr>
			
			<tr>
				<td><a href="packageoffer.php">back</a></td>
				<td><input type="submit" value="save"></td>
			</tr>
			
		</table>
	</body>
</html>
<?php
include_once('inc/footer1.php');
?>