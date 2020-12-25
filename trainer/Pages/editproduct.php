<html>
	<?php
		$cn=mysqli_connect("localhost","root","","recreate");
		$productid=$_GET['productid'];
		$sql="select * from product where productid='$productid'";
		$result=mysqli_query($cn,$sql);
		$rec=mysqli_fetch_array($result);
		mysqli_close($cn);
	?>
	<body>
		<h2>Edit</h2>
		<form action="editproduct1.php" method="post">
		<input type="hidden" name="productid" value="<?php echo $rec['productid'];?>"/>
		<table border="1">
			<tr>
				<td>Product name</td>
				<td><input type="text" required value="<?php echo $rec['productname'];?>" name="productname"/> </td>
			</tr>
			<tr>
				<td>Quantity</td>
				<td><input type="text" required value="<?php echo $rec['quantity'];?>" name="quantity"/> </td>
			</tr>
			<tr>
				<td>Description</td>
				<td><input type="text" required value="<?php echo $rec['description'];?>" name="description"/> </td>
			</tr>
			<tr>
				<td>Price</td>
				<td><input type="text" required value="<?php echo $rec['price'];?>" name="price"/> </td>
			</tr>
			<tr>
				<td>type</td>
				<td><input type="text" required value="<?php echo $rec['type'];?>" name="type"/> </td>
			</tr>
			<tr>
				<td><a href="product.php">back</a></td>
				<td><input type="submit" value="save"></td>
			</tr>
			
		</table>
	</body>
</html>