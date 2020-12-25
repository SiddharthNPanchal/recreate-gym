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
			$sql="select tid,pass,email from trainer where email='$email1'";
			//echo "$pass1";
			$result=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result);
			
			$count=mysqli_num_rows($result);	
		//	mysqli_close($cn);
		// header("Location:forgot3.php");
		?>
		<br>
		
		<?php
		if(!$email1==$rec['email'])
		{
		?>
				<script type="text/javascript">alert("Enter correct email");
				location = "changepass.php";
				</script>
				
		<?php
		}	
		?>
		<?php
		if($old1!=$old2)
		{
		?>
				<script type="text/javascript">alert("Enter same password in both the fields");
				location = "changepass.php";
				</script>
		<?php	
		}
		?>
		<?php
		if($old!=$rec['pass'])
		{
		?>
				<script type="text/javascript">alert("Enter current existing password");
				location = "changepass.php";
				</script>	
		<?php
		}
		
		else
		{
			?>
			<?php
			
				$sql="update trainer set pass='$old1' where email='$email1'";
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