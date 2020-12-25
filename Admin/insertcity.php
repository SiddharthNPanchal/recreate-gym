<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$cityname=$_POST['cityname'];
			$sql="insert into city (cityname) values ('$cityname')";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="city Inserted";
			header("Location:city.php");
		?>
	</body>
</html>