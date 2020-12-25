<html>
	<body>
	<head>
	<style>
	
	</style>
	</head>
		<form action="productInsert.php" method="post">
			<table>
			<th>Product</th>
				<tr>
					<td>Product Name</td>
					<td><input type="text" name="productname" required></td>
				</tr>
				<tr>
					<td>Quantity</td>
					<td><input type="text" name="quantity" required></td>
				</tr>
				<tr>
					<td>Description</td>
					<td><input type="text" name="description" required></td>
				</tr>
				<tr>
					<td>Price</td>
					<td><input type="text" name="price" required></td>
				</tr>
				<tr>
					<td>type</td>
					<td><input type="text" name="type" required></td>
				</tr>
				
				<tr>
					<td colspan="2"  align="center"><input type="submit" value="submit "name="submit" ></td>
				</tr>
			</table>
		</form>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select * from product";
			$result=mysqli_query($cn,$sql);
			
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>ProductName</th>";
			echo "<th>Quantity</th>";
			echo "<th>Description</th>";
			echo "<th>Type</th>";
			echo "<th>Price</th>";
			
			
			echo "<th>Add new</th>";
			echo "</tr>";
			
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				echo "<td>${row['productname']}</td>";
				echo "<td>${row['quantity']}</td>";
				echo "<td>${row['description']}</td>";
				echo "<td>${row['type']}</td>";
				echo "<td>${row['price']}</td>";
				echo "<td><a href='editproduct.php?productid=${row['productid']}'>Edit</a>|<a href='deleteproduct.php?productid=${row['productid']}'>Delete</a></td>";
				echo "</tr>";
			}
			echo "<tr><td colspan='10'>".mysqli_num_rows($result)." record(s) found</td></tr>";
			echo "</table>";
			mysqli_close($cn);
		?>
	</body>
	
</html>