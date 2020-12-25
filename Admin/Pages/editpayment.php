<html>
<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$paymentid=$_GET['paymentid'];
			$sql="select * from payment where paymentid='$paymentid'";
			$result=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result);
			//$_SESSION['msg']="city Deleted";
			mysqli_close($cn);
?>

	<body>
		<h2>Edit</h2>
		<form action="editpayment1.php" method="post">
		<input type="hidden" name="paymentid" value="<?php echo $rec['paymentid'];?>"/>
		<table border="1">
			<tr>
				<td>paymenttype</td>
				<td><input type="text" required value="<?php echo $rec['paymenttype'];?>" name="paymenttype"/> </td>
			</tr>
			<tr>
				<td>discount</td>
				<td><input type="text" required value="<?php echo $rec['discount'];?>" name="discount"/> </td>
			</tr>
			<tr>
				<td><a href="payment.php">back</a></td>
				<td><input type="submit" value="save"></td>
			</tr>		
		</table>
	</body>
</html>

