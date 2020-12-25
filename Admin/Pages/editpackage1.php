<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$cityid=$_POST['packageid'];
			$packagename=$_POST['packagename'];
			$startdate=$_POST['startdate'];
			$enddate=$_POST['enddate'];
			$price=$_POST['price'];
			$sql="update package set packagename='$packagename',startdate='$startdate',enddate='$enddate',price='$price' where packageid='$packageid'";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="package updated";
			header("Location:package.php");
		?>
	</body>
</html>