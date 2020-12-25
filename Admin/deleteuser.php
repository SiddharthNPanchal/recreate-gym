<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$uid=$_GET['uid'];
			$sql="delete from user where uid='$uid'";
			$result=mysqli_query($cn,$sql);
			?>
			<script>
			alert("User deleted");
			location = "user.php";
			</script>
		
	</body>
</html>