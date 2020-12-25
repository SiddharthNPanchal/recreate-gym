	<?php
include_once('inc/header1.php');
?>    
    
<?php
include_once('inc/right.php');
?> 
<html>
	<body>
		<form action="insertdiet.php" method="post">
			<table>
				<tr>
				<td><label>Gym Member name</label></td>
				<td>
                            <select name="uid">
                                <?php
                                $cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_eroor());
                                $sql="select * from user";
                                $res=mysqli_query($cn,$sql);
                                while($arr=mysqli_fetch_array($res)){
                                    ?>
                                <option value="<?php echo $arr['uid'] ?>"><?php echo $arr['fname'] ?></option>
                <?php
                                }
                                mysqli_close($cn);
                                ?>
                                </select>
                                
                                
                        </td>
				</tr>
				<tr>
					<td><label>Diettype</label></td>
					<td>
					<select name="diettype" >
                    <option value="Weight gain">Weight Gain</option>
					<option value="Weight lose">Weight Loss</option>
					<option value="Bodybuilding">Body Building</option>
					</select>
					</td>
				</tr>
				<tr>
					<td><label>Food items</label></td><td><textarea name="fooditems" rows=10 cols="20" required></textarea></td>
				</tr>
				<tr>
				<td colspan="2"  align="center"><input type="submit" value="submit "name="submit" ></td></tr>
			</table>
		</form>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select d.*,u.fname from diet d, user u where d.uid = u.uid";
			$result=mysqli_query($cn,$sql);
			
			echo "<table border='1'>";
			echo "<tr>";
			//echo "<th>DietID</th>";
			echo "<th>Name</th>";
			echo "<th>Diettype</th>";
			echo "<th>FoodItems</th>";
			echo "<th>Add new</th>";
			echo "</tr>";
			
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				echo "<td>${row['fname']}</td>";
				echo "<td>${row['diettype']}</td>";
				echo "<td>${row['fooditems']}</td>";
				echo "<td><a href='editdiet.php?dietid=${row['dietid']}'>Edit</a>|<a href='deletediet.php?dietid=${row['dietid']}'>Delete</a></td>";
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