<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$packagename=$_POST['packagename'];
			$packagedetails=$_POST['packagedetails'];
			$startdate=$_POST['startdate'];
			$enddate=$_POST['enddate'];
			$price=$_POST['price'];
			$durationid=$_POST['durationid'];
			$sql="insert into package (packagename,startdate,enddate,price,durationid,packagedetails) values ('$packagename','$startdate','$enddate','$price','$durationid','$packagedetails')";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="Package Inserted";
			header("Location:package.php");
		?>
	</body>
</html>