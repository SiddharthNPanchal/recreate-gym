<?php session_start();
error_reporting(0); 
?>
<?php
include_once('inc/header.php');
?>    
<?php
include_once('inc/content.php');
//echo $_SESSION['fname'];
?>
<head>
<style>
<link href="mycss.css" rel="stylesheet">
</style>
</head>
<body>
<?php
		if(isset($_SESSION['msg'])){
		   echo $_SESSION['msg'];
		   unset($_SESSION['msg']);
		}
		?>

	<div id="right_data_bar">
	<center><h2>Product</h2></center>
	<br/>
	<?php
		$con=mysqli_connect("localhost","root","","recreate") or die("check connection");
		$get_products="select p.*,c.productcompanyname from product p,productcompany c where p.productcompanyid=c.productcompanyid order by rand() limit 0,5";		
		$row=mysqli_query($con,$get_products);
		
		while($result=mysqli_fetch_array($row))
		{
			$id=$result[id];
			$product_title=$result[productname];
			$productcompanyname=$result[productcompanyname];
			//$productofferid=$result[productofferdiscount];
			$product_price=$result[price];
			$size=$result[size];
			$product_image=$result[image];
			echo
			"<div style='width:200px;height:200px;float:left;margin-left:10px;margin-right:10px;text-align:center;'>
			<b><h3 style='background:green'>$product_title</h3></b>
			<br>
			<img src='images/$product_image' width='80%' height='80%'>
			<br>
			<b><h3 style='background:red'>$productcompanyname</h3></b>
			<b><h3 style='background:grey'>Rs $product_price</h3></b>
			<b><h3 style='background:grey'> size $size</h3></b>
			<b><a href='demo.php?id=$id'>Add to cart</a>
</div>";
		}
	?>	
    </div>
     </div>
        </div>
		
</body>
</html>
<?php
include_once('inc/footer.php');
?>