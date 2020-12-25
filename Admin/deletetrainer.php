<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$trainerid=$_GET['trainerid'];
			$sql="delete from trainer where trainerid='$trainerid'";
			$result=mysqli_query($cn,$sql);
			
		?>
		<script>
			alert("Trainer deleted");
			location = "trainer.php";
		</script>
	</body>
</html>