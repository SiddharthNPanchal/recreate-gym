<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$cityid=$_GET['cityid'];
			$sql="delete from city where cityid='$cityid'";
			$result=mysqli_query($cn,$sql);

		?>
		<script>
			alert("city deleted");
			location = "city.php";
		</script>
	</body>
</html>