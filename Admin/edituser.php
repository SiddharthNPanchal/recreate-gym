	<?php
include_once('inc/header1.php');
?>    
    
<?php
include_once('inc/right.php');
?> 
<html>
<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$uid=$_GET['uid'];
			$sql="select * from user where uid='$uid'";
			$result=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result);
			//$_SESSION['msg']="city Deleted";
			mysqli_close($cn);
	?>

	<body>
		<h2>Edit</h2>
		<form action="edituser1.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="uid" value="<?php echo $rec['uid'];?>"/>
		<table border="1">
			<!--<tr>
				<td>Category</td>
				<td><input type="text" required value="<?php echo $rec['ucategory'];?>" name="ucategory"/> </td>
			</tr>
			<tr>
				<td>Address</td>
				<td><input type="text" required value="<?php echo $rec['address'];?>" name="address"/> </td>
			</tr>
			<tr>
				<td>email</td>
				<td><input type="text" required value="<?php echo $rec['email'];?>" name="email"/> </td>
			</tr>
			<tr>
				<td>phn</td>
				<td><input type="text" required value="<?php echo $rec['phn'];?>" name="phn"/> </td>
			</tr>
			<tr>
				<td>First name</td>
				<td><input type="text" required value="<?php echo $rec['fname'];?>" name="fname"/> </td>
			</tr>
			<tr>
				<td>Last name</td>
				<td><input type="text" required value="<?php echo $rec['lname'];?>" name="lname"/> </td>
			</tr>
			<tr>
				<td>dob</td>
				<td><input type="text" required value="<?php echo $rec['dob'];?>" name="dob"/> </td>
			</tr>
			<tr>
				<td>weight</td>
				<td><input type="text" required value="<?php echo $rec['weight'];?>" name="weight"/> </td>
			</tr>
			<!--<tr>
				<td>gender</td>
				<td><input type="radio" name="gender" value="male">Male</input>
				<input type="radio" name="gender" value="female">Female</input>
				</td>
			</tr>-->
			<!--<td>City</td>
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
			</td>-->
			<tr><td>
                        product image</td>
                    <td><input type="file" name="file" value="" size="35"></td></tr>

			<tr>
				<td><a href="user.php">back</a></td>
				<td><input type="submit" value="save"></td>
			</tr>
			
		</table>
	</body>
</html>
<?php
include_once('inc/footer1.php');
?>