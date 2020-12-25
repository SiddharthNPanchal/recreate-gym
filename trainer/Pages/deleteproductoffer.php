<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$productofferid=$_GET['productofferid'];
			$sql="delete from productoffer where productofferid='$productofferid'";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="productoffer Deleted";
			//header("Location:productofferid.php");
		?>
	</body>
</html>