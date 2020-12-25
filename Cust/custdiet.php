	
<?php session_start() ?>

	  <?php include_once("inc/header.php");
include_once("inc/content.php");
?>
<h1>Diet Plan</h1>
<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$uid1=$_SESSION['uid'];
			//echo $uid1;
			$sql="select d.*,u.fname from diet d, user u where d.uid = $uid1 and u.uid = $uid1";
			$result=mysqli_query($cn,$sql);
			
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>Name</th>";
			echo "<th>Diettype</th>";
			echo "<th>FoodItems</th>";
			//echo "<th>Name</th>";
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
		//	echo "<tr><td colspan='5'>".mysqli_num_rows($result)." records found</td></tr>";
			echo "</table>";
			mysqli_close($cn);
		?>
<?php include_once("inc/footer.php");

?>