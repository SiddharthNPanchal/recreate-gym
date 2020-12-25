SSSS<?php session_start() ?>

		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$email1=$_POST['email'];
			$secans=$_POST['ans'];
			$sql="select email from user where email = '$email1'";
			$sql1="select secans from user where secans = '$secans'";
			$result=mysqli_query($cn,$sql);
			$result1=mysqli_query($cn,$sql1);
			$rec=mysqli_fetch_array($result);
			$rec1=mysqli_fetch_array($result1);
			if($email1==$rec['email'] && $secans==$rec1['secans']) 
			{
					echo $rec['email'];
					echo $rec1['secans'];
					
					$sql2="select pass from user where email = '$email1' and secans='$secans'";
					
					$result3=mysqli_query($cn,$sql2);
					$rec3=mysqli_fetch_array($result3);
				?>
					<script type="text/javascript">alert("Your current password is : <?php echo $rec3[0];?>");
				//location = "login.php";
				</script>
		<?php
		}
			else
			{
					echo "world";
			}	
		?>
	
		