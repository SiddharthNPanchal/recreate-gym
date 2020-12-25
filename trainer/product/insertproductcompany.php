<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$productcompanyname=$_POST['productcompanyname'];
			$sql="insert into productcompany (productcompanyname) values ($productcompanyname)";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="product company Inserted";
			header("Location:productcompany.php");
		?>
	</body>
</html>