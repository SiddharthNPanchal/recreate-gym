<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$paymentid=$_POST['paymentid'];
			$paymenttype=$_POST['paymenttype'];
			$discount=$_POST['discount'];
			$sql="update payment set paymenttype='$paymenttype',discount='$dsicount' where paymentid='$paymentid'";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="payment updated";
			header("Location:payment.php");
		?>
	</body>
</html>