<?php session_start() ?>
<?php
include_once('inc/header.php');
?>    
    
<?php
include_once('inc/content.php');
?> 
<html>
<h1>SELECTED PACKAGE</h1>
</html>
<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$abc=$_SESSION['uid'];
			//echo "$abc";
			$sql="select p.*,b.*,d.* from package p ,bookpackage b,duration d where p.id=b.packageid and b.uid=$abc and d.durationid=p.durationid ";
			$result=mysqli_query($cn,$sql);
			
			echo "<table border='1'>";
			echo "<tr>";
			
			echo "<th>Package Name </th>";
			echo "<th>Description</th>";
			echo "<th>Duration</th>";
			echo "<th>Package Start Date </th>";
			//echo "<th>Name </th>";
			echo "</tr>";
			
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				echo "<td>${row['packagename']}</td>";
				echo "<td>${row['packagedetails']}</td>";
				echo "<td>${row['peroid']}</td>";
				echo "<td>${row['pdate']}</td>";
				//echo "<td>${row['fname']}</td>";
				echo "</tr>";
			}
			
			echo "<tr><td colspan='5'>".mysqli_num_rows($result)." records found</td></tr>";
			echo "</table>";
			mysqli_close($cn);
?>
<?php
include_once('inc/footer.php');
?>