<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$productcompanyid=$_GET['productcompanyid'];
			$sql="delete from productcompany where productcompanyid='$productcompanyid'";
			$result=mysqli_query($cn,$sql);
		
		?>
		<script>
			alert("Productcompany deleted");
			location = "poductcompany.php";
		</script>
	</body>
</html>