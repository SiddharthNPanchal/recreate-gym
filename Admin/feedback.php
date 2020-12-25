<?php
include_once('inc/header1.php');
?>    
<?php
include_once('inc/right.php');

?> 
<h1>FEEDBACK</h1>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select f.*,u.fname from feedback f,user u where u.uid=f.uid";
			$result=mysqli_query($cn,$sql);
		
			echo "<table border='1'>";
			echo "<tr>";
			//echo "<th>Feedback ID</th>";
			echo "<th>Feedback Description</th>";
			echo "<th>Feedback Date</th>";
			echo "<th>Name</th>";
			echo "<th></th>";
			//echo "<th>Add new</th>";
			echo "</tr>";
		
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				//echo "<td>${row['fid']}</td>";
				echo "<td>${row['fdesc']}</td>";
				echo "<td>${row['fdate']}</td>";
				echo "<td>${row['fname']}</td>";
				echo "<td><a href='deletefeedback.php?fid=${row['fid']}'>Delete</a></td>";
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