<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$email=mysqli_real_escape_string($cn,$_POST['email']);
			$pass=mysqli_real_escape_string($cn,$_POST['pass']);
			$sql="select uid from user where email='$email' and pass='$pass'";
			$result=mysqli_query($cn,$sql);
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$count=mysqli_num_rows($result);
			
			if($count==1){
				header("Location:product.php");
			}
			else
			{
				?>
				<script type="text/javascript">alert("Enter Valid Details..........");
				location = "login.php";
				</script>
			<?php
			}
		?>
	</body>
</html>
