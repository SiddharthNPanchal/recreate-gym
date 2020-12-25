<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$id=$_POST['id'];
			$productname=$_POST['productname'];
			$quantity=$_POST['quantity'];
			$description=$_POST['description'];
			$price=$_POST['price'];
			$producttypeid=$_POST['producttypeid'];
			$productcompanyid=$_POST['productcompanyid'];
			echo "$producttypeid";
			$size=$_POST['size'];

			$sql="update product set productname='$productname',productcompanyid='$productcompanyid',quantity='$quantity',description='$description',price='$price',type='$producttypeid',size='$size' where id='$id'";
			//echo $sql;
			$result=mysqli_query($cn,$sql); 
			//$_SESSION['msg']="product updated";
			//header("Location:product.php");
		?>
		<script type="text/javascript">alert("Product Updated");
				location = "Product.php";
				</script>

	</body>
</html>