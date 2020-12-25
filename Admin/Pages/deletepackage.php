<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$packageid=$_GET['packageid'];
			$sql="delete from package where packageid='$packageid'";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="package Deleted";
			//header("Location:package.php");
		?>
	</body>
</html>