<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$email=mysqli_real_escape_string($cn,$_POST['email']);
			$pass=mysqli_real_escape_string($cn,$_POST['pass']);
			$sql1="select uid from user where email='$email' and pass='$pass'";
			$result1=mysqli_query($cn,$sql1);
			$row1 = mysqli_fetch_array($result1);
			$count=mysqli_num_rows($result1);
			$uid=$row1[0];
			
			$sql="select fname from user where email='$email' and pass='$pass'";
			$result=mysqli_query($cn,$sql);
			$row = mysqli_fetch_array($result);
			$fname=$row[0];
			
			
			if($count==1){
			 $_SESSION['fname']=$fname;
			 $_SESSION['uid']=$uid;
			 //echo $_SESSION['uid'];
			 //echo $_SESSION['fname'];
			header("Location:../cust/get_product.php");
			}
			else
			{
				echo '<script>alert("Invalid Password")</script>';
				header("Location:login.php");
				//$errror="Loginname or password is invalid";
			}
		?>
	</body>
</html>
