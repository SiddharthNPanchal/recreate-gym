<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$diettype=$_POST['diettype'];
			$duration=$_POST['duration'];
			$sql="insert into diet (diettype) values ($diettype)";
			$result=mysqli_query($cn,$sql);
			//$_SESSION['msg']="diet Inserted";
		    //header("Location:diet.php");
		?>
	</body>
</html>