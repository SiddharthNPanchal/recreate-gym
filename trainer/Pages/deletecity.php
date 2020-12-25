<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$cityid=$_GET['cityid'];
			$sql="delete from city where cityid='$cityid'";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="city Deleted";
			//header("Location:city.php");
		?>
	</body>
</html>