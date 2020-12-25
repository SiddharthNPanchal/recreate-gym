<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$packageofferid=$_GET['packageofferid'];
			$sql="delete from packageoffer where packageofferid='$packageofferid'";
			$result=mysqli_query($cn,$sql);
			
		?>
		<script>
			alert("packageoffer deleted");
			location = "packageoffer.php";
		</script>
	</body>
</html>


