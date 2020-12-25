<html>
	<?php
		$cn=mysqli_connect("localhost","root","","recreate");
		$packageid=$_GET['packageid'];
		$sql="select * from package where packageid='$packageid'";
		$result=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result);
		mysqli_close($cn);
	?>
	<body>
		<h2>Edit</h2>
		<form action="editpackage1.php" method="post">
		<input type="hidden" name="packageid" value="<?php echo $rec['packageid'];?>"/>
		<table border="1">
			<tr>
				<td>package name</td>
				<td><input type="text" required value="<?php echo $rec['packagename'];?>" name="packagename"/> </td>
			</tr>
			<tr>
				<td>startdate</td>
				<td><input type="text" required value="<?php echo $rec['startdate'];?>" name="startdate"/> </td>
			</tr>
			<tr>
				<td>enddate</td>
				<td><input type="text" required value="<?php echo $rec['enddate'];?>" name="enddate"/> </td>
			</tr>
			<tr>
				<td>price</td>
				<td><input type="text" required value="<?php echo $rec['price'];?>" name="price"/> </td>
			</tr>
			<tr>
				<td><a href="package.php">back</a></td>
				<td><input type="submit" value="save"></td>
			</tr>
			
		</table>
	</body>
</html>