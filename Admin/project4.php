<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$fdesc=$_POST['fdesc'];
			$uid=$_POST['uid'];
			$sql="INSERT INTO `feedback` ( `fdesc`, `fdate`, `uid`) VALUES ( '$fdesc', now(), '$uid');";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="feedback  Inserted";
			header("Location:feedback.php");
		?>
	</body>
</html>