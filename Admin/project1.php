<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$packageofferdiscount=$_POST['packageofferdiscount'];
			$sql="insert into packageoffer (packageofferdiscount) values ($packageofferdiscount)";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="package offer Inserted";
			header("Location:packageoffer.php");
		?>
	</body>
</html>