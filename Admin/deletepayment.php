<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$paymentid=$_GET['paymentid'];
			$sql="delete from payment where paymentid='$paymentid'";
			$result=mysqli_query($cn,$sql);
			
		?>
		<script>
			alert("Payment deleted");
			location = "payment.php";
		</script>
	</body>
</html>