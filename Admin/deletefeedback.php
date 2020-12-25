<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$fid=$_GET['fid'];
			$sql="delete from feedback where fid='$fid'";
			$result=mysqli_query($cn,$sql);
			
		?>
		<script>
			alert("feedback deleted");
			location = "feedback.php";
		</script>
	</body>
</html>