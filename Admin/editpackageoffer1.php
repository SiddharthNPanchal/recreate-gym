<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$packageofferid=$_POST['packageofferid'];
			$packageofferdiscount=$_POST['packageofferdiscount'];
			$sql="update packageoffer set packageofferdiscount='$packageofferdiscount' where packageofferid='$packageofferid'";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="offer updated";
			header("Location:packageoffer.php");
		?>
	</body>
</html>