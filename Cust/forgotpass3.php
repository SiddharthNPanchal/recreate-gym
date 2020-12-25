<?php session_start() ?>
<?php include_once("inc/header.php");
include_once("inc/content.php");
?>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$email=$_POST['email'];
			$ans=$_POST['ans'];
			$sql="select email from user";
			$result=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result);
			
			if(!$email=mysqli_fetch_array($result))
			{
				header("Location:forgotpass.php");
			}
			else
			{
				?>
				<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$email=$_POST['email'];
			$ans=$_POST['ans'];
			$sql="select * from user where email='$email'";
			$result=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result);
			$count=mysqli_num_rows($result);
			
		//	mysqli_close($cn);
			
			// header("Location:forgot3.php");
		?>
		<?php
		if($count < 2 )
		
			{
				?>
				<form action="forgot3.php" method="post">
				<table>
				<tr>
				<td>
					<label>Enter New Password</label></td><td><input type="text" name="pass1"></td></tr>
					<tr><td>
					<label>Enter confirm Password</label></td><td><input type="text" name="pass2"></td></tr>
					
					<tr><td>
					<input type="submit" value="submit "name="submit" >
					</td>
					</tr>
				</form>
					
				
			<?php
			}
			?>

			<?php
			}
			mysqli_close($cn);
		?>			