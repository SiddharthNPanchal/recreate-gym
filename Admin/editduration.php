
<?php
include_once('inc/header1.php');

?>    
    
<?php
include_once('inc/right.php');
?>
<html>
<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$durationid=$_GET['durationid'];
			$sql="select d.peroid from duration d  where d.durationid='$durationid'";
			$result=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result);
			$_SESSION['msg']="duration ";
			mysqli_close($cn);
			$var1 = $durationid;
?>


	<body>
	
		<h2>Edit Duration</h2>
		<form action="editduration1.php" method="post">
		<input type="hidden" name="durationid1" value="<?php echo "$var1";?>"/>
		<table border="1">
			<tr>
				<td>peroid</td>
				<td><input type="text" required value="<?php echo $rec['peroid'];?>" name="peroid"/> </td>
			</tr>
			<tr>
				<td><a href="duration.php">back</a></td>
				<td><input type="submit" value="save"></td>
			</tr>
			
		</table>
	</body>
	<?php
		include_once('inc/footer1.php');
?>
</html>
