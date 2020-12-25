<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$offerdiscount=$_POST['offerdiscount'];
			$sql="insert into producttype (producttypename) values ('$offerdiscount')";
			$result=mysqli_query($cn,$sql);
			//$_SESSION['msg']="Product Offer Inserted";
			header("Location:productoffer.php");
		?>
	</body>
</html>