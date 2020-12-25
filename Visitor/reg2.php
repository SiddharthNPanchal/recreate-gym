<?php session_start() ?>
<html>
	<body>
		
		<?php
		$cn=mysqli_connect("localhost","root","","recreate") or die("Check Connection");
		if (isset($_POST['submit']))
		{
		$first_name=$_POST['first_name'];
		$last_name=$_POST['last_name'];
		$dob=$_POST['dob'];
		$phn=$_POST['phn'];
		$address=$_POST['address'];
		$weight=$_POST['weight'];
		$email_id=$_POST['email_id'];
		$password=$_POST['password'];
		$gender=$_POST['gen'];
		$security_que=$_POST['security_que'];	
		$security_ans=$_POST['security_ans'];
		//$user_name=$_POST['user_name'];
		$cityid=$_POST['cityid'];
		?>
		<?php
			if(!preg_match("/^[A-Z][a-zA-Z]+$/",$first_name))
			{
		?>
				<script type="text/javascript">alert("Name must start with capital letter only!!");
				location = "registration.php";
					</script>
			<?php
			}	
			if(!preg_match("/^[A-Z][a-zA-Z -]+$/",$last_name))
			{
			?>
			<script type="text/javascript">alert("Last name must start with capital letter only!!");
				location = "registration.php";
					</script>
			<?php
			}
			else if(!preg_match("/^\d{10}+$/",$phn))
			{
			?>
				<script type="text/javascript">alert("Enter valid phn");
				location = "registration.php";
					</script>
			<?php
			}
			else if(preg_match("/^[a-zA-Z]w+(.w+)*@w+(.[0-9a-zA-Z]+)*.[a-zA-Z]{2,4}$/",$email)
				{	
			?>
				<script type="text/javascript">alert("Enter valid email");
				location = "registration.php";
					</script>
			<?php
			}
			else if(!preg_match("/^\d{0,3}+$/",$weight))
			{
			?>
			
			<script type="text/javascript">alert("Enter valid weight");
				location = "registration.php";
				</script>
				<?php
			
			}
			else
			{
				
					echo "$weight";
					echo "$phn";
					echo "$first_name";
					echo "$last_name";
	echo "$dob";
	echo "$address";
	//echo "$pincode";
	echo "$email_id";
	echo "$password";
	echo "$gender";
	echo "$security_que";
	echo "$security_ans";
	$sql="insert into user(ucategory,fname,lname,address,pass,dob,email,gender,weight,secque,secans,phn,cityid) values('member','$first_name','$last_name','$address','$password','$dob','$email_id','$gender','$weight','$security_que','$security_ans','$phn','$cityid')";
	$result=mysqli_query($cn,$sql);
		$_SESSION['msg']="regestration is complete...";
	header("Location:get_product.php");
			}
		}
	?>
	
		
	</body>
</html>