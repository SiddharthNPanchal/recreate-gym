	<?php
include_once('inc/header1.php');
?>    
    
<?php
include_once('inc/right.php');
?>
<h1>PACKAGE DETAILS</h1>
<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select b.*,p.packagename,u.fname from bookpackage b,package p,user u where b.uid=u.uid and b.packageid=p.id";
			$result=mysqli_query($cn,$sql);
			
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>Package Name</th>";
			echo "<th>Gym Member</th>";
			echo "<th>Package date</th>";
			echo "</tr>";
			
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				echo "<td>${row['packagename']}</td>";
				echo "<td>${row['fname']}</td>";
				echo "<td>${row['pdate']}</td>";
				echo "</tr>";
			}
			echo "<tr><td colspan='4'>".mysqli_num_rows($result)." records found</td></tr>";
			echo "</table>";
			mysqli_close($cn);
		?>
		<?php
include_once('inc/footer1.php');
?>