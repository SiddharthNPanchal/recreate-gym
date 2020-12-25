<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$uid=$_POST['uid'];
			$diettype=$_POST['diettype'];
			$fooditems=$_POST['fooditems'];
			$sql="insert into diet (diettype,fooditems,uid) values ('$diettype','$fooditems','$uid')";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="Diet Inserted";
			header("Location:diet.php");
		?>
	</body>
</html