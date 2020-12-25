<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$diettype=$_POST['diettype'];
			$duration=$_POST['duration'];
			$sql="insert into diet1 (diettype,duration) values ('$diettype','$duration')";
			$result=mysqli_query($cn,$sql);
			//echo $diettype;
			//echo $duration;
			//echo '$duration';
			$_SESSION['msg']="diet Inserted";
		    header("Location:diet.php");
		?>
	</body>
</html>