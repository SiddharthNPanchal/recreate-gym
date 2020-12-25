<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$productofferid=$_POST['productofferid'];
			$offerdiscount=$_POST['offerdiscount'];
			$sql="update productoffer set offerdiscount='$offerdiscount' where productofferid='$productofferid'";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="ProductOffer updated";
			header("Location:productoffer.php");
		?>
	</body>
</html>