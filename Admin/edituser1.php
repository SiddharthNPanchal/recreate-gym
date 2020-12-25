<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$uid=$_POST['uid'];
			$lname=$_POST['lname'];
			$fname=$_POST['fname'];
			$ucategory=$_POST['ucategory'];
			$phn=$_POST['phn'];
			$email=$_POST['email'];
			$weight=$_POST['weight'];
		//	$gender=$_POST['gender'];
			$address=$_POST['address'];
			$cityid=$_POST['cityid'];
			$Movie_image = $_FILES['file']['name'];
			
			echo $uid;
			echo '<br>';
			echo $address;
			echo '<br>';
			echo $fname;
			echo '<br>';
			echo $lname;
			echo '<br>';
			echo $cityid;
			echo '<br>';
			echo $phn;
			echo '<br>';
			echo $ucategory;
			
			$target="images/".basename($_FILES['file']['name']);
        if ($_FILES['file']['name'] != "") {
            move_uploaded_file($_FILES['file']['tmp_name'], $target) or
                    die("Could not copy file!");
        } else {
            die("No file specified!");
        }

			
			$sql="update user set image='$Movie_image',cityid='$cityid',address='$address',lname='$lname',fname='$fname',ucategory='$ucategory',phn='$phn',email='$email',weight='$weight' where uid='$uid'";
			$result=mysqli_query($cn,$sql);
			//$_SESSION['msg']="city updated";
			//header("Location:user.php");
		?>
		<script type="text/javascript">alert("Gym Member details Updated");
				location = "user.php";
		</script>
	</body>
</html>