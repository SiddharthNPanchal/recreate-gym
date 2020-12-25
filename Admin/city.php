<html>
	<body>
	<?php
include_once('inc/header1.php');
?>    
    
<?php
include_once('inc/right.php');
?> 
		<form action="insertcity.php" method="post">
		<h1>CITY</h1>
	
			<table>
				<tr>
					<td>City</td>
					<td><input type="text" name="cityname" required></td>
				</tr>
				<tr>
					<td colspan="2"  align="center"><input type="submit" value="submit "name="submit" ></td>
				</tr>
			</table>
		</form>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select * from city";
			$result=mysqli_query($cn,$sql);
			
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>CityID</th>";
			echo "<th>CityName</th>";
			echo "<th>Add new</th>";
			echo "</tr>";
			
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				echo "<td>${row['cityid']}</td>";
				echo "<td>${row['cityname']}</td>";
				echo "<td><a href='editcity.php?cityid=${row['cityid']}'>Edit</a>|<a href='deletecity.php?cityid=${row['cityid']}'>Delete</a></td>";
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