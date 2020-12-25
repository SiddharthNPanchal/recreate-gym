<html>
	<?php
		$cn=mysqli_connect("localhost","root","","recreate");
		$trainerid=$_GET['trainerid'];
		$sql="select * from trainer where trainerid='$trainerid'";
		$result=mysqli_query($cn,$sql);
		$rec=mysqli_fetch_array($result);
		mysqli_close($cn);
	?>
	<body>
		<h2>Edit</h2>
		<form action="edittrainer1.php" method="post">
		<input type="hidden" name="trainerid" value="<?php echo $rec['trainerid'];?>"/>
		<table border="1">
			<tr>
				<td>Trainer name</td>
				<td><input type="text" required value="<?php echo $rec['trainername'];?>" name="trainername"/> </td>
			</tr>
			<tr>
				<td>Trainer Dob</td>
				<td><input type="text" required value="<?php echo $rec['trainerdob'];?>" name="trainerdob"/> </td>
			</tr>
			<tr>
				<td>Trainer Mob</td>
				<td><input type="text" required value="<?php echo $rec['trainermob'];?>" name="trainermob"/> </td>
			</tr>
			<tr>
				<td>Trainer weight</td>
				<td><input type="text" required value="<?php echo $rec['trainerweight'];?>" name="trainerweight"/> </td>
			</tr>
			<tr>
				<td>Trainer height</td>
				<td><input type="text" required value="<?php echo $rec['trainerheight'];?>" name="trainerheight"/> </td>
			</tr>
			<tr>
				<td>Trainer mail</td>
				<td><input type="text" required value="<?php echo $rec['trainermail'];?>" name="trainermail"/> </td>
			</tr>
			<tr>
				<td><a href="trainer.php">back</a></td>
				<td><input type="submit" value="save"></td>
			</tr>
			
		</table>
	</body>
</html>