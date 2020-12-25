<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$id=$_GET['id'];
			$sql="delete from product where id='$id'";
			$result=mysqli_query($cn,$sql);
			
		?>
		<script>
			alert("product deleted");
			location = "product.php";
		</script>
	</body>
</html>