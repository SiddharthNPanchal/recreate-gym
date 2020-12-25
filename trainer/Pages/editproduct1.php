<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$productid=$_POST['productid'];
			$productname=$_POST['productname'];
			$quantity=$_POST['quantity'];
			$description=$_POST['description'];
			$price=$_POST['price'];
			$type=$_POST['type'];
		
			
			
			$sql="update product set productname='$productname',quantity='$quantity',descriptiom='$description',price='$price',type='$type' where productid='$productid'";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="product updated";
			header("Location:product.php");
		?>
	</body>
</html>