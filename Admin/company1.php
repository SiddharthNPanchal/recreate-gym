<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$companyname=$_POST['companyname'];
			$companyaddress=$_POST['companyaddress'];
			$phn=$_POST['phn'];
			$mailid=$_POST['mailid'];
			$sql="insert into company1 (companyname,companyaddress,phn,mailid) values ('$companyname','$companyaddress','$phn','$mailid')";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="city Inserted";
			//header("Location:company.php");
		?>
	</body>
</html>