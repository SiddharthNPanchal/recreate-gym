<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$productid=$_GET['productid'];
			$sql="delete from product where productid='$productid'";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="productid Deleted";
			header("Location:product.php");
		?>
	</body>
</html>