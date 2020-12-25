<?php
include_once('inc/header1.php');
?>    
    
<?php
include_once('inc/right.php');
?> 	
<h1>DIET PLANS</h1>
	<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select d.*,u.fname from diet d, user u where d.uid = u.uid";
			$result=mysqli_query($cn,$sql);
			
			echo "<table border='1'>";
			echo "<tr>";
			//echo "<th>DietID</th>";
			echo "<th>Name</th>";
			echo "<th>DietType</th>";
			echo "<th>FoodItems</th>";
			//echo "<th>Add new</th>";
			echo "</tr>";
			
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				echo "<td>${row['fname']}</td>";
				echo "<td>${row['diettype']}</td>";
				echo "<td>${row['fooditems']}</td>";
				//echo "<td><a href='editdiet.php?dietid=${row['dietid']}'>Edit</a>|<a href='deletediet.php?dietid=${row['dietid']}'>Delete</a></td>";
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