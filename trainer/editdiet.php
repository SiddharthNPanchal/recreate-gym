<?php
include_once('inc/header1.php');
?>    
    
<?php
include_once('inc/right.php');
?>
<html>
<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$dietid=$_GET['dietid'];
			$sql="select * from diet where dietid='$dietid'";
			$result=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result);
			$_SESSION['msg']="diet Deleted";
			mysqli_close($cn);
?>

	<body>
		<h2>Edit</h2>
		<form action="editdiet1.php" method="post">
		<input type="hidden" name="dietid" value="<?php echo $rec['dietid'];?>"/>
		<table border="1">
			<!--<tr>
				<td>DietType</td>
				<td><input type="text" required value="
				<?php// echo $rec['diettype'];?>" name="diettype"/> </td>
			</tr>-->
			<tr>
				<td>FoodItems</td>
				<td><input type="text" required value="<?php echo $rec['fooditems'];?>" name="fooditems"/> </td>
			</tr>
			<tr>
				<td><a href="diet.php">back</a></td>
				<td><input type="submit" value="save"></td>
			</tr>
			
		</table>
	</body>
</html>
<?php
include_once('inc/footer1.php');
?>