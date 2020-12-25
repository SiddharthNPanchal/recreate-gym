<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$cityid=$_POST['cityid'];
			$cityname=$_POST['cityname'];
			$sql="update city set cityname='$cityname' where cityid='$cityid'";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="city updated";
			header("Location:city.php");
		?>
	</body>
</html>