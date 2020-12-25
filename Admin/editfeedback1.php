<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$fid=$_POST['fid'];
			$fdesc=$_POST['fdesc'];
			$sql="update feedback set fdesc='$fdesc' where fid='$fid'";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="feedback updated";
			header("Location:feedback.php");
		?>
	</body>
</html>