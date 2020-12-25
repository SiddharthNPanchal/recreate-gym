<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$offerdiscount=$_POST['offerdiscount'];
			$sql="insert into productoffer (offerdiscount) values ('$offerdiscount')";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="ProductOffer Inserted";
			//header("Location:productoffer.php");
		?>
	</body>
</html>