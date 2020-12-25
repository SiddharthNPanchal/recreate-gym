<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$productname=$_POST['productname'];
			$productcompanyid=$_POST['productcompanyid'];
			//$productofferid=$_POST['productofferid'];
			$quantity=$_POST['quantity'];
			$description=$_POST['description'];
			$price=$_POST['price'];
			$producttypeid=$_POST['producttypeid'];
			$size=$_POST['size'];
			$Movie_image = $_FILES['file']['name'];

$target="images/".basename($_FILES['file']['name']);
        if ($_FILES['file']['name'] != "") {
            move_uploaded_file($_FILES['file']['tmp_name'], $target) or
                    die("Could not copy file!");
        } else {
            die("No file specified!");
        }
			$sql="insert into product(productname,productcompanyid,quantity,description,price,type,image,size) values ('$productname','$productcompanyid','$quantity','$description','$price','$producttypeid','$Movie_image','$size')";
			$result=mysqli_query($cn,$sql);
			
			header("Location:product.php");
		?>
	</body>
</html>