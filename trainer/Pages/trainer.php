<html>
	<body>
	<head>
	<style>
	
	</style>
	</head>
		<form action="trainerInsert.php" method="post">
			<table>
			<th>Trainer</th>
				<tr>
					<td>Trainer Name</td>
					<td><input type="text" name="trainername" required></td>
				</tr>
				<tr>
					<td>Trainer Dob</td>
					<td><input type="text" name="trainerdob" required></td>
				</tr>
				<tr>
					<td>Trainer Phn</td>
					<td><input type="text" name="trainermob" required></td>
				</tr>
				<tr>
					<td>Trainer mail</td>
					<td><input type="text" name="trainermail" required></td>
				</tr>
				<tr>
					<td>Trainer Weight</td>
					<td><input type="text" name="trainerweight" required></td>
				</tr>
				<tr>
					<td>Trainer Height</td>
					<td><input type="text" name="trainerheight" required></td>
				</tr>
				
				<tr>
					<td>Security Question</td>
					<td><input type="text" name="secque" required></td>
				</tr>
				<tr>
					<td colspan="2"  align="center"><input type="submit" value="submit "name="submit" ></td>
				</tr>
			</table>
		</form>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select * from trainer";
			$result=mysqli_query($cn,$sql);
			
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>TrainerName</th>";
			echo "<th>TrainerDob</th>";
			echo "<th>TrainerPhn</th>";
			echo "<th>TrainerMail</th>";
			echo "<th>TrainerWeight</th>";
			echo "<th>TrainerHeight</th>";
			/*echo "<th>SecurityAnswer</th>";*/
			echo "<th>SecurityQuestion</th>";
			echo "<th>Add new</th>";
			echo "</tr>";
			
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				echo "<td>${row['trainername']}</td>";
				echo "<td>${row['trainerdob']}</td>";
				echo "<td>${row['trainermob']}</td>";
				echo "<td>${row['trainermail']}</td>";
				echo "<td>${row['trainerweight']}</td>";
				echo "<td>${row['trainerheight']}</td>";
				/*echo "<td>${row['secans']}</td>";*/	
				echo "<td>${row['secque']}</td>";				
				echo "<td><a href='edittrainer.php?trainerid=${row['trainerid']}'>Edit</a>|<a href='deletetrainer.php?trainerid=${row['trainerid']}'>Delete</a></td>";
				echo "</tr>";
			}
			echo "<tr><td colspan='10'>".mysqli_num_rows($result)." record(s) found</td></tr>";
			echo "</table>";
			mysqli_close($cn);
		?>
	</body>
	
</html>