<html>
<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$productcompanyid=$_GET['productcompanyid'];
			$sql="select * from productcompany where productcompanyid='$productcompanyid'";
			$result=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result);
			$_SESSION['msg']="productcompany Deleted";
			mysqli_close($cn);
?>

	<body>
		<h2>Edit</h2>
		<form action="updateproductcompany.php" method="post">
		<input type="hidden" name="productcompanyid" value="<?php echo $rec['productcompanyid'];?>"/>
		<table border="1">
			<tr>
				<td>productcompany name</td>
				<td><input type="text" required value="<?php echo $rec['productcompanyname'];?>" name="productcompanyname"/> </td>
			</tr>
			
			<tr>
				<td><a href="productcompany.php">back</a></td>
				<td><input type="submit" value="save"></td>
			</tr>
			
		</table>
	</body>
</html>
