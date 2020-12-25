<?php session_start() ?>

<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$productcompanyid=$_POST['productcompanyid'];
			$productcompanyname=$_POST['productcompanyname'];
			$sql="update productcompany set productcompanyname='$productcompanyname' where productcompanyid='$productcompanyid'";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="product company updated";
			//header("Location:poductcompany.php");
		?>
		<script type="text/javascript">alert("Company Updated");
				location = "poductcompany.php";
				</script>

	</body>

</html>