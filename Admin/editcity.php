	<?php
include_once('inc/header1.php');
?>    
    
<?php
include_once('inc/right.php');
?>
<html>
<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$cityid=$_GET['cityid'];
			$sql="select * from city where cityid='$cityid'";
			$result=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result);
			$_SESSION['msg']="city Deleted";
			mysqli_close($cn);
?>

	<body>
		<h2>Edit</h2>
		<form action="editcity1.php" method="post">
		<input type="hidden" name="cityid" value="<?php echo $rec['cityid'];?>"/>
		<table border="1">
			<tr>
				<td>city name</td>
				<td><input type="text" required value="<?php echo $rec['cityname'];?>" name="cityname"/> </td>
			</tr>
			
			<tr>
				<td><a href="city.php">back</a></td>
				<td><input type="submit" value="save"></td>
			</tr>
			
		</table>
	</body>
</html>
<?php
include_once('inc/footer1.php');
?>