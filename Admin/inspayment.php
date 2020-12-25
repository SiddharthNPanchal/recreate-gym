<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$paymenttype=$_POST['paymenttype'];
			//$discount=$_POST['discount'];			
			$sql="insert into payment (paymenttype) values ('$paymenttype') ";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="Package Inserted";
			header("Location:package.php");
		?>
	</body>
</html>