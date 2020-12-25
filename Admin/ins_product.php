<html>
	<body>

<?php 
		$cn=mysqli_connect("localhost","root","","flikers") or die("check connection");
		$name=$_POST['name'];
		$p_detail=$_POST['p_detail'];
		$category_id=$_POST['category_id'];
		$price=$_POST['price'];
		$quantity=$_POST['quantity'];
		$brand_id=$_POST['brand_id'];
		$Movie_image = $_FILES['file']['name'];


$target="images/".basename($_FILES['file']['name']);
        if ($_FILES['file']['name'] != "") 
		{
            move_uploaded_file($_FILES['file']['tmp_name'], $target) or
                    die("Could not copy file!");
        } else 
		{
            die("No file specified!");
        }
       

		
       
	print_r($name);
        print_r($Movie_image);
	print_r($category_id);
	print_r($p_detail);
	print_r($price);
	print_r($quantity);
	print_r($brand_id);



		$sql="insert into product (name,p_detail,category_id,price,quantity,brand_id,image)values('$name','$p_detail','$category_id','$price','$quantity','$brand_id','$Movie_image')";
		$result=mysqli_query($cn,$sql);
		$_SESSION['msg']="product inserted";
		header("Location:product.php");
	?>

</body>
</html>