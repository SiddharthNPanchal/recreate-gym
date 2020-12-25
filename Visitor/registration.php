<?php session_start() ?>
<?php include_once("inc/header.php");
include_once("inc/content.php");
?>
<html>
<body>
	<table border=1 align="center">
		<h1 align="center">Registration Form for Recreate Gym User</h1>
	<form action="" method="post">
	<tr>
			<td>First Name</td>
			<td><input type="text" name="first_name" value="<?php if(isset($_POST['first_name'])) { echo $_POST['first_name'];}?>" required></input></td>
		</tr>
		<tr>
			<td>Last Name</td>
			<td><input type="text" name="last_name" value="<?php if(isset($_POST['last_name'])) { echo $_POST['last_name'];}?>" required></input></td>
		</tr>
		<tr>
			<td>dob</td>
			<td><input type="date" name="dob" value="<?php if(isset($_POST['dob'])) { echo $_POST['dob'];}?>" required></input></td>
		</tr><tr>
			<td>Address</td>
			<td><textarea name="address" value="<?php if(isset($_POST['address'])) { echo $_POST['address'];}?>" required></textarea></td>
		</tr>
		<tr>
			<td>City</td>
			<td>
                            <select name="cityid">
                                <?php
                                $cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_eroor());
                                $sql="select * from city";
                                $res=mysqli_query($cn,$sql);
                                while($arr=mysqli_fetch_array($res)){
                                    ?>
                                <option value="<?php echo $arr['cityid'] ?>"><?php echo $arr['cityname'] ?></option>
                <?php
                                }
                                mysqli_close($cn);
                                ?>
                                </select>
                                
                                
                        </td>
		</tr>
		<tr>
			<td>Mobile Number</td>
			<td><input type="text" name="phn" value="<?php if(isset($_POST['phn'])) { echo $_POST['phn'];}?>" required></input></td>
		</tr>
		<tr>
			<td>Weight</td>
			<td><input type="text" name="weight" value="<?php if(isset($_POST['weight'])) { echo $_POST['weight'];}?>" required></input></td>
		</tr>

		<tr>
			<td>Email id</td>
			<td><input type="email" name="email_id" value="<?php if(isset($_POST['email_id'])) { echo $_POST['email_id'];}?>" required></input></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type="password" name="password" required></input></td>
		</tr>
		<tr>
			<td>Gender</td>
			<td><input type="radio" name="gen" value="male" checked="true">male</input>
			<input type="radio" name="gen" value="female">female</input></td>
		</tr>
		<tr>
			<td>Security Question</td>
			<td><select name="security_que" >
			<option value="what is your favourite color">what is your favourite color</option>
			<option value="what is your favourite car">what is your favourite car</option>
			<option value="what is your favourite country">what is your favourite country</option>
			</select>
			</td>
		</tr>
		<tr>
			<td>Security Answer</td>
			<td><input type="text" name="security_ans" value="<?php if(isset($_POST['security_ans'])) { echo $_POST['security_ans'];}?>" required></input></td></br>
		</tr>
		<tr>
			
			<td colspan = "2" align="center"> <input type="submit" value="submit" name="submit"> </td>
		</tr>
	</form>
	</table>
	<table align="center">
<tr><td>Already a Member? <a href="login.php">Login</a></td></tr>
</table>

	<?php
		$cn=mysqli_connect("localhost","root","","recreate") or die("Check Connection");
		if(isset($_POST['submit']))
		{
			$email_id=$_POST['email_id'];
			$phn=$_POST['phn'];
			$sql="select email from user where email = '$email_id'";
			$result1=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result1);
			$first_name = $_POST['first_name'];
			$last_name = $_POST['last_name'];
			$dob = $_POST['dob'];
			$address = $_POST['address'];
			$security_ans=$_POST['security_ans'];
			$password=$_POST['password'];
			$gender=$_POST['gen'];
			$security_que=$_POST['security_que'];
			//echo "$first_name";
			//echo "$dob";
			//echo "$address";
			//echo "$last_name";
			$cityid=$_POST['cityid'];
			
			$weight=$_POST['weight'];
			//$email_id=$_POST['email_id'];
	?>
	<?php
		if(!preg_match("/^[a-zA-Z]+$/",$first_name	))
		{
	?>
		<script type="text/javascript">alert("Name must contain alphabets only!!");
		//location = "registration1.php";
		</script>
	<?php
		}
		else if(!preg_match("/^[a-zA-Z]+$/",$last_name))
			{
				?>
				<script type="text/javascript">alert("Last Name must contain alphabets only!!");
				//location = "registration1.php";
					</script>
					<?php
			}
			else if(!preg_match("/^\d{10}+$/",$phn))
			{
			?>
	<script type="text/javascript">alert("Enter valid contact number");
				//location = "registration1.php";
					</script>
			<?php
			}
			else if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]{6,15}$/',$password))
				{
				?>
					<script type="text/javascript">alert("Password must contain 6 characters of letters, numbers and at least one special character.");
						//location = "registration1.php";
					</script>
				<?php
			}			
			else if(!filter_var($email_id,FILTER_VALIDATE_EMAIL))
				{
					
					
					?>
					<script type="text/javascript">alert("Enter valid email");
				//location = "registration.php";
					
					</script>
					<?php
				}
				else if($email_id==$rec['email'])
				{
					?>
					<script type="text/javascript">alert("Email already exists");
				//location = "registration.php";
					
					</script>
					<?php
				}
		else
		{
			echo "$first_name";
			echo "$dob";
			echo "$address";
			echo "$last_name";
			echo "$email_id";
			echo "$weight";
			echo "$phn";
			echo "$security_ans";
			echo "$security_que";
			
	
		$sql = "insert into user (ucategory,fname,lname,address,dob,cityid,phn,weight,email,secque,secans,gender,pass) values ('member','$first_name','$last_name','$address','$dob','$cityid','$phn','$weight','$email_id','$security_que','$security_ans','$gender','$password')";
		$result=mysqli_query($cn,$sql);
		$_SESSION['msg']="regestration is complete...";
		header("Location:get_product.php");
		?>	
		<script type="text/javascript">
				location = "get_product.php";
					</script>
<?php		}
		}
		?>
		
</body>
</html>
<?php include_once("inc/footer.php");
			?>