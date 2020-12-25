<html>
	<body>
			<?php
include_once('inc/header1.php');
?>    
    
<?php
include_once('inc/right.php');
?>
		<form action="insertproductoffer.php" method="POST">
			<table>
			<h1>Product Type</h1>
			
				<tr>
					<td>Product Type</td>
					<td><input type="text" name="offerdiscount" required></td>
				</tr>
				<tr>
					<td colspan="2"  align="center"><input type="submit" value="submit "name="submit" ></td>
				</tr>
			</table>
		</form>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select * from producttype";
			$result=mysqli_query($cn,$sql);
			
			echo "<table border='1'>";
			echo "<tr>";
			//echo "<th>ProductID</th>";
			echo "<th>Product Type name</th>";
			echo "<th>Add new</th>";
			echo "</tr>";
			
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				//echo "<td>${row['productofferid']}</td>";
				echo "<td>${row['producttypename']}</td>";
				echo "<td><a href='editproductoffer.php?producttypeid=${row['producttypeid']}'>Edit</a>|<a href='deleteproductoffer.php?producttypeid=${row['producttypeid']}'>Delete</a></td>";
				echo "</tr>";
			}
			echo "<tr><td colspan='5'>".mysqli_num_rows($result)." records found</td></tr>";
			echo "</table>";
			mysqli_close($cn);
		?>
	</body>
	
</html>
<?php
include_once('inc/footer1.php');
?>