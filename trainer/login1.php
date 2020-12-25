<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$email=mysqli_real_escape_string($cn,$_POST['email']);
			$pass=mysqli_real_escape_string($cn,$_POST['pass']);
			$sql1="select tid from trainer where email='$email' and pass='$pass'";
			$result1=mysqli_query($cn,$sql1);
			$row1 = mysqli_fetch_array($result1);
			$count=mysqli_num_rows($result1);
			$uid=$row1[0];
			echo $count;
			$sql="select tname from trainer where email='$email' and pass='$pass'";
			$result=mysqli_query($cn,$sql);
			$row = mysqli_fetch_array($result);
			$tname=$row[0];
			
			
			if($count==1){
			 $_SESSION['tname']=$tname;
			 $_SESSION['tid']=$tid;
			 //echo $_SESSION['uid'];
			 //echo $_SESSION['fname'];
			header("Location:diet.php");
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
