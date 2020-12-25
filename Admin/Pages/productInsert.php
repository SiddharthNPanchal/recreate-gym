<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$productname=$_POST['productname'];
			$quantity=$_POST['quantity'];
			$description=$_POST['description'];
			$price=$_POST['price'];
			$type=$_POST['type'];
			
			$sql="insert into product (productname,quantity,description,price,type) values ('$productname','$quantity','$description','$price','$type')";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="product Inserted";
			//header("Location:Product.php");
		?>
	</body>
</html>