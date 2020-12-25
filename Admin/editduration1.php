<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$durationid=$_POST['durationid1'];
			$peroid=$_POST['peroid'];
			echo "$durationid";
			$sql="update duration set peroid='$peroid' where durationid='$durationid'";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="duration updated";
			//header("Location:duration.php");
		?>
		<script type="text/javascript">alert("Duration Updated");
				location = "duration.php";
				</script>
	</body>
</html>