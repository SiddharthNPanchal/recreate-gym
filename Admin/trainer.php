<?php session_start() ?>
<?php include_once("inc/header1.php");
include_once("inc/right.php");
?>
  
        
		

		
		<table border=1 align="center">
		<h1 align="center">TRAINER</h1>
		<form action="" method="post">
		<tr>
			<td>Name</td>
			<td><input type="text" name="name" value="<?php if(isset($_POST['name'])) { echo $_POST['name'];}?>" required></input></td>
		</tr>
		<tr>
			<td>Address</td>
			<td><textarea name="address" required></textarea></td>
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
			<td>dob</td>
			<td><input type="date" name="dob" required></input></td>
		</tr>
		<tr>
			<td>Gender</td>
			<td><input type="radio" name="gen" value="male">male</input>
			<input type="radio" name="gen" value="female">female</input></td>
		</tr>
		<tr>
			<td>Weight</td>
			<td><input type="text" name="weight" value="<?php if(isset($_POST['weight'])) { echo $_POST['weight'];}?>" required></input></td>
		</tr>
		<tr>
			<td>Height</td>
			<td><input type="text" name="height" value="<?php if(isset($_POST['height'])) { echo $_POST['height'];}?>" required></input></td>
		</tr>
		<tr>
			<td>Mobile Number</td>
			<td><input type="text" name="phn" value="<?php if(isset($_POST['phn'])) { echo $_POST['phn'];}?>" required></input></td>
		</tr>
		
		
		
		<tr>
			<td>Security Question</td>
			<td><select name=security_que required>
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
			<td></td>
			<td> <input type="submit" value="submit" name="submit"> </td>
		</tr>	
		</form>
</table>
</div>
            </div>
        </div>

	
</body>
<?php
		$cn=mysqli_connect("localhost","root","","recreate") or die("Check Connection");
			if (isset($_POST['submit'])){
				$email_id=$_POST['email_id'];
				$sql="select email from user where email = '$email_id'";
			$result1=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result1);
		$name=$_POST['name'];
		$address=$_POST['address'];
		$password=$_POST['password'];
		$dob=$_POST['dob'];
		
		$gender=$_POST['gen'];
		$weight=$_POST['weight'];
		$height=$_POST['height'];
		$phn=$_POST['phn'];
		
		$security_que=$_POST['security_que'];	
		$security_ans=$_POST['security_ans'];
			if(!preg_match("/^[a-zA-Z]+$/",$name))
			{
				echo '<script>alert("Name must contain alphabets only!!.")</script>';
			}
		
			else if(!preg_match("/^\d{10}+$/",$phn))
			{
				echo '<script>alert("Enter valid phn no.")</script>';
				
			}
			
			else if(!preg_match("/^\d{0,3}+$/",$weight))
			{
				echo '<script>alert("Enter valid weight")</script>';
			}
			else if(!filter_var($email_id,FILTER_VALIDATE_EMAIL))
			{
				echo '<script>alert("Enter valid Email")</script>';
			}
			else if($email_id==$rec['email'])
			{
				echo '<script>alert("Email already exists")</script>';
			}
			else if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]{6,15}$/',$password))
				{
					echo '<script>alert("Password must contain 6 characters of letters, numbers and at least one special character")</script>';
				}
			else
			{
				//	echo $weight;
			

		
	//echo "$name";
	//echo "$address";
	//echo "$dob";
	//echo "$address";
	//echo "$phn";
	//echo "$email_id";
	//echo "$password";
	//echo "$gender";
	//echo "$security_que";
	//echo "$security_ans";
	//echo "$weight";
	//echo "$height";
	$sql="insert into trainer(tname,address,pass,dob,email,gender,weight,secque,secans,phn,height) values('$name','$address','$password','$dob','$email_id','$gender','$weight','$security_que','$security_ans','$phn','$height')";
	$result=mysqli_query($cn,$sql);
		?>
				<script type="text/javascript">alert("Trainer Inserted");
				//location = "trainer.php";
					
					</script>
			<?php
			}
			}
		?>
</html>
	<?php include_once("inc/footer1.php");
?>