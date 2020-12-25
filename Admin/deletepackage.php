<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$id=$_GET['id'];
			$sql="delete from package where id='$id'";
			$result=mysqli_query($cn,$sql);
			
			header("Location:package.php");
		?>
		<script>
			alert("package deleted");
			location = "package deleted";
		</script>
	</body>
</html>