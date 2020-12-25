<form action="forgot3.php" method="post">
					<label>Enter New Password</label><input type="text" name="pass1">
					<label>Enter confirm Password</label><input type="text" name="pass2">
					<input type="text" name="uid" value="<?php echo $rec['uid'];?>">
					<input type="submit" value="submit "name="submit" >
				</form>