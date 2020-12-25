<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$durationid=$_GET['durationid'];
			$sql="delete from duration where durationid='$durationid'";
			$result=mysqli_query($cn,$sql);
			
		?>
		<script>
			alert("duration deleted");
			location = "duration.php";
		</script>
	</body>
</html>