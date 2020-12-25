
<?php
include_once('inc/header1.php');

?>    
    
<?php
include_once('inc/right.php');

?> 
<html>
	<body>
		<form action="project1.php" method="post">
		<h1>PACKAGE OFFER</H1>
			<table>
				<tr>
					<td>packageoffer</td>
					<td><input type="text" name="packageofferdiscount" required></td>
				</tr>
				<tr>
					<td colspan="2"  align="center"><input type="submit" value="submit "name="submit" ></td>
				</tr>
			</table>
		</form>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select * from packageoffer";
			$result=mysqli_query($cn,$sql);
		
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>Package offerID</th>";
			echo "<th>Package offer discount</th>";
			echo "<th>Add new</th>";
			echo "</tr>";
		
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				echo "<td>${row['packageofferid']}</td>";
				echo "<td>${row['packageofferdiscount']}</td>";
				echo "<td><a href='editpackageoffer.php?packageofferid=${row['packageofferid']}'>Edit</a>|<a href='deletepackageoffer.php?packageofferid=${row['packageofferid']}'>Delete</a></td>";
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