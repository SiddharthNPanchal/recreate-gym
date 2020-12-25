<!DOCTYPE html>
<html lang="en">
<head>
</head>
<?php
include_once('inc/header1.php');

?>    
    
<?php
include_once('inc/right.php');
?> 
		<form action="project2.php" method="post">
		<h1>DURATION</H1>
			<table >
				<tr>
					<td>Peroid</td>
					<td><input type="text" name="peroid" required></td>
				</tr>
				<tr>
					<td colspan="5"  align="center"><input type="submit" value="submit "name="submit" ></td>
				</tr>
			</table>
		</form>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select * from duration";
			$result=mysqli_query($cn,$sql);
		
			echo "<table class=class1 border='1'>";
			echo "<tr>";
			//echo "<th>Duration ID</th>";
			echo "<th>Peroid</th>";
			echo "<th>Add new</th>";
			echo "</tr>";
		
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				//echo "<td>${row['durationid']}</td>";
				echo "<td>${row['peroid']}</td>";
				//echo "<td>${row['fname']}</td>";
				echo "<td><a href='editduration.php?durationid=${row['durationid']}'>Edit</a>|<a href='deleteduration.php?durationid=${row['durationid']}'>Delete</a></td>";
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