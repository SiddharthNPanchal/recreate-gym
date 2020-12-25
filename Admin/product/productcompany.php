<html>
	<body>
		<form action="insertproductcompany.php" method="post">
			<table>
				<tr>
					<td>Product Company</td>
					<td><input type="text" name="productcompanyname" required></td>
				</tr>
				<tr>
					<td colspan="2"  align="center"><input type="submit" value="submit "name="submit" ></td>
				</tr>
			</table>
		</form>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select * from productcompany";
			$result=mysqli_query($cn,$sql);
			
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>ProductCompanyID</th>";
			echo "<th>ProductCompanyName</th>";
			echo "<th>Add new</th>";
			echo "</tr>";
			
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				echo "<td>${row['productcompanyid']}</td>";
				echo "<td>${row['productcompanyname']}</td>";
				echo "<td><a href='editproductcompany.php?productcompanyid=${row['productcompanyid']}'>Edit</a>|<a href='deleteproductcompany.php?productcompanyid=${row['productcompanyid']}'>Delete</a></td>";
				echo "</tr>";
			}
			echo "<tr><td colspan='5'>".mysqli_num_rows($result)." records found</td></tr>";
			echo "</table>";
			mysqli_close($cn);
		?>
	</body>
	
</html>