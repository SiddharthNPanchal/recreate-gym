<?php session_start() ?>
<html>
	<body>
		
		<?php
		$cn=mysqli_connect("localhost","root","","recreate") or die("Check Connection");
			if (isset($_POST['submit'])){
		$name=$_POST['name'];
		$address=$_POST['address'];
		$password=$_POST['password'];
		$dob=$_POST['dob'];
		$email_id=$_POST['email_id'];
		$gender=$_POST['gen'];
		$weight=$_POST['weight'];
		$height=$_POST['height'];
		$phn=$_POST['phn'];
		
		$security_que=$_POST['security_que'];	
		$security_ans=$_POST['security_ans'];
		
		if(!preg_match("/^\d{10}+$/",$phn))
			{
				echo '<script>alert("Enter valid phn no.")</script>';
				
			}
			
			else if(!preg_match("/^\d{0,3}+$/",$weight))
			{
				echo '<script>alert("Enter valid weight")</script>';
			}
			else
			{
				//	echo $weight;
			

		
	echo "$name";
	echo "$address";
	echo "$dob";
	echo "$address";
	echo "$phn";
	echo "$email_id";
	echo "$password";
	echo "$gender";
	echo "$security_que";
	echo "$security_ans";
	echo "$weight";
	echo "$height";
	$sql="insert into trainer(tname,address,pass,dob,email,gender,weight,secque,secans,phn,height) values('$name','$address','$password','$dob','$email_id','$gender','$weight','$security_que','$security_ans','$phn','$height')";
	$result=mysqli_query($cn,$sql);
		?>
				<script type="text/javascript">alert("Trainer Inserted");
				location = "trainer.php";
					
					</script>
			<?php
			}
			}
		?>
	</body>
</html>