<html>
<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$productofferid=$_GET['productofferid'];
			$sql="select * from productoffer where productofferid='$productofferid'";
			$result=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result);
			mysqli_close($cn);
?>

	<body>
		<h2>Edit</h2>
		<form action="editproductoffer1.php" method="post">
		<input type="hidden" name="productofferid" value="<?php echo $rec['productofferid'];?>"/>
		<table border="1">
			<tr>
				<td>OfferDiscount</td>
				<td><input type="text" required value="<?php echo $rec['offerdiscount'];?>" name="offerdiscount"/> </td>
			</tr>
			
			<tr>
				<td><a href="productoffer.php">back</a></td>
				<td><input type="submit" value="save"></td>
			</tr>
			
		</table>
	</body>
</html>
