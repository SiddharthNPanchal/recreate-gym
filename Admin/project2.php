<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$peroid=$_POST['peroid'];
			echo "$peroid";
			//$uid=$_POST['uid'];
			$sql="insert into duration (peroid) values ('$peroid')";
			$result=mysqli_query($cn,$sql);
			
			$_SESSION['msg']="duration Inserted";
			
			header("Location:duration.php");
			
		?>
	</body>
</html>