<?php
	if(!empty($_POST["forgot-password"])){
		$conn = mysqli_connect("localhost", "root", "", "recreate");
		
		$condition = "";
		
		if(!empty($_POST["email"])) {
			if(!empty($condition)) {
				$condition = " and ";
			}
			$condition = " member_email = '" . $_POST["user-email"] . "'";
		}
		<div>
		<table>
		<tr>
			<td>Security Question</td>
			<td><select name=security_que>
			<option value="what is your favourite color">what is your favourite color</option>
			<option value="what is your favourite car">what is your favourite car</option>
			<option value="what is your favourite country">what is your favourite country</option>
			</select>
			</td>
		</tr>
		</table>
		<br>
		<>
		<label name="Answer"><input type="text" name="ans"></label>
		
		if(!empty($condition)) {
			$condition = " where " . $condition;
		}

		$sql = "Select * from user " . $condition;
		$result = mysqli_query($conn,$sql);
		$user = mysqli_fetch_array($result);
		
		if(!empty($user)) {
			require_once("forgot-password-recovery-mail.php");
		} else {
			$error_message = 'No User Found';
		}
	}
?>
