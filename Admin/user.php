	<?php
include_once('inc/header1.php');
?>    
    
<?php
include_once('inc/right.php');
?> 
<html>
	<h1 align="center">GYM MEMBERS</h1>
	<body>
	<head>
	<style>
	
	</style>
	</head>
		
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select u.*,c.cityname from user u,city c where c.cityid=u.cityid";
			$result=mysqli_query($cn,$sql);
			
			echo "<table border='1'>";
			echo "<tr>";
			//echo "<th>uid</th>";
			//echo "<th>Category</th>";
			echo "<th>First name</th>";
			echo "<th>Last name</th>";
			echo "<th>Dob</th>";
			echo "<th>Phn</th>";
			echo "<th>Email</th>";
			echo "<th>Weight</th>";
			echo "<th>Gender</th>";
			echo "<th>Address</th>";
			echo "<th>SecurityQuestion</th>";
			echo "<th>SecurityAnswer</th>";
			//echo "<th>Pass</th>";
			echo "<th>image</th>";
			echo "<th>city</th>";
			
			echo "<th>Add new</th>";
			echo "</tr>";
			
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				//echo "<td>${row['uid']}</td>";
				//echo "<td>${row['ucategory']}</td>";
				echo "<td>${row['fname']}</td>";
				echo "<td>${row['lname']}</td>";
				echo "<td>${row['dob']}</td>";
				echo "<td>${row['phn']}</td>";
				echo "<td>${row['email']}</td>";
				echo "<td>${row['weight']}</td>";
				echo "<td>${row['gender']}</td>";
				echo "<td>${row['address']}</td>";
				echo "<td>${row['secque']}</td>";
				echo "<td>${row['secans']}</td>";	
				//echo "<td>${row['pass']}</td>";
				echo "<td><img src=images/$row[image] width=60 height=60 /></td>";
				echo "<td>${row['cityname']}</td>";
				echo "<td><a href='edituser.php?uid=${row['uid']}'>Edit</a>|<a href='deleteuser.php?uid=${row['uid']}'>Delete</a></td>";
				echo "</tr>";
			}
			echo "<tr><td colspan='14'>".mysqli_num_rows($result)." record(s) found</td></tr>";
			echo "</table>";
			mysqli_close($cn);
		?>
	</body>
	
</html>
<?php
include_once('inc/footer1.php');
?>