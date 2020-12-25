<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$email=$_POST['email'];
			$ans=$_POST['ans'];
			$sql="select * from user where email='$email'";
			$result=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result);
			$count=mysqli_num_rows($result);
			
		//	mysqli_close($cn);
			
			// header("Location:forgot3.php");
		?>
		<?php
		if($count < 2 )
		
			{
				?>
				<form action="forgot3.php" method="post">
					<label>Enter New Password</label><input type="text" name="pass1">
					<label>Enter confirm Password</label><input type="text" name="pass2">
					<input type="text" name="uid" value="<?php echo $rec['uid'];?>">
					<input type="submit" value="submit "name="submit" >
				</form>
					
				
			<?php
			}
			?>
			
	</body>
</html>