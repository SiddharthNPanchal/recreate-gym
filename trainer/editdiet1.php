<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$dietid=$_POST['dietid'];
			$diettype=$_POST['diettype'];
			$fooditems=$_POST['fooditems'];
			$sql="update diet set fooditems='$fooditems' where dietid='$dietid'";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="city updated";
			header("Location:diet.php");
		?>
	</body>
</html>