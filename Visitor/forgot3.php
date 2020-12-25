<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$pass1=$_POST['pass1'];
			$pass2=$_POST['pass2'];
			$uid=$_POST['uid'];
			echo "$pass1";
			echo "$pass2";
			echo "$uid";
			
			$sql="update user set pass='$pass1' where uid='$uid'";
			$result=mysqli_query($cn,$sql);
			//header("location:login.php");
			
			
		?>
	</body>
</html>