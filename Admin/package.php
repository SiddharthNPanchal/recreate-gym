<?php
include_once('inc/header1.php');
?>    
    
<?php
include_once('inc/right.php');
?> 
<html>
	<body>
		<form action="package1.php" method="post">
			<table>
			<h1>PACKAGE</h1>
				<tr>
					<td>PackageName</td>
					<td><input type="text" name="packagename" required></td>
				</tr>
				<tr>
					<td>PackageDetails</td>
					<td><input type="text" name="packagedetails" required></td>
				</tr>
				<!--<tr>
					<td>Startdate</td>
					<td><input type="date" name="startdate" required></td>
				</tr>
				<tr>
					<td>Enddate</td>
					<td><input type="date" name="enddate" required></td>
				</tr>
				<tr>-->
					<td>Price</td>
					<td><input type="text" name="price" required></td>
				</tr>
				<tr>
							<td>Duration</td>
			<td>
                            <select name="durationid">
                                <?php
                                $cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_eroor());
                                $sql="select * from duration";
                                $res=mysqli_query($cn,$sql);
                                while($arr=mysqli_fetch_array($res)){
                                    ?>
                                <option value="<?php echo $arr['durationid'] ?>"><?php echo $arr['peroid'] ?></option>
                <?php
                                }
                                mysqli_close($cn);
                                ?>
                                </select>
                                
                                
                        </td>
				</tr>
				<tr>
					<td colspan="3"  align="center"><input type="submit" value="submit "name="submit" ></td>
				</tr>
			</table>
		</form>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select p.*,d.peroid from package p, duration d where p.durationid=d.durationid";
			$result=mysqli_query($cn,$sql);
			
			echo "<table border='1'>";
			echo "<tr>";
			//echo "<th>PackageID</th>";
			echo "<th>PackageName</th>";
			//echo "<th>Startdate</th>";
			//echo "<th>Enddate</th>";
			echo "<th>Description</th>";
			echo "<th>Price</th>";
			echo "<th>Duration</th>";
			echo "<th>Add new</th>";
			echo "</tr>";
			
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				//echo "<td>${row['id']}</td>";
				echo "<td>${row['packagename']}</td>";
				
				echo "<td>${row['packagedetails']}</td>";
				//echo "<td>${row['enddate']}</td>";
				echo "<td>${row['price']}</td>";
				echo "<td>${row['peroid']}</td>";
				echo "<td><a href='editpackage.php?id=${row['id']}'>Edit</a>|<a href='deletepackage.php?id=${row['id']}'>Delete</a></td>";
				echo "</tr>";
			}
			echo "<tr><td colspan='6'>".mysqli_num_rows($result)." records found</td></tr>";
			echo "</table>";
			mysqli_close($cn);
		?>
	</body>
</html>
<?php
include_once('inc/footer1.php');
?>