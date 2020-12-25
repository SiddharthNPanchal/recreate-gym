<?php session_start() ?>
<head>
      <title>Forgot Password</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>

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
				<body bgcolor = "#FFFFFF">
   
	
      <div align = "center">
         <div style = "width:400px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Forgot Password</b></div>
				
            <div style = "margin:30px">

				<form action="forgot3.php" method="post">
				<table>
				<tr>
				<td>
					<label>Enter New Password</label></td><td><input type="text" name="pass1"></td></tr>
					<tr><td>
					<label>Enter confirm Password</label></td><td><input type="text" name="pass2"></td></tr>
					<input type="hidden" name="uid" value=<?php echo $rec['uid'];?>>
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