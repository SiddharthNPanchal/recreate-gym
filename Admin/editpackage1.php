<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$id=$_POST['id'];
			$packagename=$_POST['packagename'];
			$packagedetails=$_POST['packagedetails'];
			$startdate=$_POST['startdate'];
			$enddate=$_POST['enddate'];
			$price=$_POST['price'];
			$durationid=$_POST['durationid'];
			$sql="update package set packagename='$packagename',startdate='$startdate',enddate='$enddate',price='$price',durationid='$durationid',packagedetails='$packagedetails' where id='$id'";
			$result=mysqli_query($cn,$sql);
			//$_SESSION['msg']="package updated";
			//header("Location:package.php");
		?>
		<script type="text/javascript">alert("Package Updated");
				location = "package.php";
				</script>

	</body>
</html>