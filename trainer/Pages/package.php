<html>
	<body>
		<form action="package1.php" method="post">
			<table>
			<th>package</th>
				<tr>
					<td>PackageName</td>
					<td><input type="text" name="packagename" required></td>
				</tr>
				<tr>
					<td>Startdate</td>
					<td><input type="text" name="startdate" required></td>
				</tr>
				<tr>
					<td>Enddate</td>
					<td><input type="text" name="enddate" required></td>
				</tr>
				<tr>
					<td>Price</td>
					<td><input type="text" name="price" required></td>
				</tr>
				<tr>
					<td colspan="3"  align="center"><input type="submit" value="submit "name="submit" ></td>
				</tr>
			</table>
		</form>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select * from package";
			$result=mysqli_query($cn,$sql);
			
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>PackageID</th>";
			echo "<th>PackageName</th>";
			echo "<th>Startdate</th>";
			echo "<th>Enddate</th>";
			echo "<th>Price</th>";
			echo "<th>Add new</th>";
			echo "</tr>";
			
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				echo "<td>${row['packageid']}</td>";
				echo "<td>${row['packagename']}</td>";
				echo "<td><${row['startdate']}/td>";
				echo "<td>${row['enddate']}</td>";
				echo "<td>${row['price']}</td>";
				echo "<td><a href='editpackage.php?packageid=${row['packageid']}'>Edit</a>|<a href='deletepackage.php?packageid=${row['packageid']}'>Delete</a></td>";
				echo "</tr>";
			}
			echo "<tr><td colspan='5'>".mysqli_num_rows($result)." records fornd</td></tr>";
			echo "</table>";
			mysqli_close($cn);
		?>
	</body>
	
</html>