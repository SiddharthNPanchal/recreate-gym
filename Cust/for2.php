<?php session_start() ?>
<html>
<body>
<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$email=$_POST['email'];
			$ans=$_POST['ans'];

			
			$sql="select uid from user where email='$email'";
			$result=mysqli_query($cn,$sql);
			echo "$uid";
				
			echo "siddharth";

			mysqli_close($cn);
?>
</body>
</html>
