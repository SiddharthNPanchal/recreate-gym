<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$dietid=$_GET['dietid'];
			$sql="delete from diet where dietid='$dietid'";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="diet Deleted";
			header("Location:diet.php");
		?>
	</body>
</html>