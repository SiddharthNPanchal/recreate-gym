
<?php
session_start();
include_once('inc/header1.php');

?>    
    
<?php
include_once('inc/right.php');

?>
<html>
<head>
<title>Login Page</title>
      
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
<body>
<div align = "center">
<div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Change Password</b></div>
	<form action="password1.php" method="post">
		
	
					<table>
					
					<tr>
					<td><label>Email</label></td><td><input type="email" name="email" required></td>
					</tr>
					<br>
					<tr>
					<td><label>Old Password</label></td><td><input type="password" name="old" required></td>
					</tr>
					<br>
					<tr>
					<td><label>New Password</label></td><td><input type="password" name="old1" required></td></tr>
					<br>
					<tr>
					<td><label>Confirm Password</label></td><td><input type="password" name="old2" required></td></tr>
					<br>
					<tr>
					<td colspan="2"><input type="submit" value="submit "name="submit"></td>
					</tr>
					
					
					</table>
					<!--<center><input type="submit" value="submit "name="submit"></center>-->
						</form>
						
				</div>
				</div>
				</div>
         
</body>						
</html>
<?php
include_once('inc/footer1.php');
?>