<html>
	<body>
	</head>
<?php
include_once('inc/header1.php');
?>    
    
<?php
include_once('inc/right.php');
?> 

		<form action="insertproductoffer.php" method="POST">
			<table>
				<tr>
					<td>ProductDiscount</td>
					<td><input type="text" name="offerdiscount" required></td>
				</tr>
				<tr>
					<td colspan="2"  align="center"><input type="submit" value="submit "name="submit" ></td>
				</tr>
			</table>
		</form>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select * from productoffer";
			$result=mysqli_query($cn,$sql);
			
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>ProductID</th>";
			echo "<th>ProductDiscount</th>";
			echo "<th>Add new</th>";
			echo "</tr>";
			
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				echo "<td>${row['productofferid']}</td>";
				echo "<td>${row['offerdiscount']}</td>";
				echo "<td><a href='editproductoffer.php?productofferid=${row['productofferid']}'>Edit</a>|<a href='deleteproductoffer.php?productofferid=${row['productofferid']}'>Delete</a></td>";
				echo "</tr>";
			}
			echo "<tr><td colspan='5'>".mysqli_num_rows($result)." records fornd</td></tr>";
			echo "</table>";
			mysqli_close($cn);
		?>
	</body>
	
</html>
<?php
include_once('inc/footer1.php');
?>