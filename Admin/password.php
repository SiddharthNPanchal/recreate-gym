<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$email1=$_POST['email'];
			$old=$_POST['old'];
			$old1=$_POST['old1'];
			$old2=$_POST['old2'];
			//echo "$email";
			$sql="select uid,pass,email from user where email='$email1'";
			//echo "$pass1";
			$result=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result);
			
			$count=mysqli_num_rows($result);	
		//	mysqli_close($cn);
		// header("Location:forgot3.php");
		?>
		<?php
		if($email1!=$rec['email'])
		{
		?>
				<script type="text/javascript">alert("Enter correct email");
				location = "changepass.php";
				</script>
				
		<?php
		}	
		else if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]{6,15}$/',$old1))
				{?>
					<script>alert("Password must contain 6 characters of letters, numbers and at least one special character");
					location = "changepass.php";
					</script>;
			
		<?php
				}
		else if($old1!=$old2)
		{
		?>
				<script type="text/javascript">alert("Enter same password in both the fields");
				location = "changepass.php";
				</script>
		<?php	
		}
		
		else if($old!=$rec['pass'])
		{
		?>
				<script type="text/javascript">alert("Enter correct existing password");
				location = "changepass.php";
				</script>	
		<?php
		}
		
		else
		{
			?>
			<?php
			
				$sql="update user set pass='$old1' where email='$email1'";
				$result=mysqli_query($cn,$sql);
		?>
			
				<script type="text/javascript">alert("Congratulations!Your Password has been successfully changed.");
				location = "login.php";
				</script>
		<?php
		}
		?>
	</body>
</html>