
<?php
include_once('inc/header1.php');

?>    
    
<?php
include_once('inc/right.php');

?><html>
<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$fid=$_GET['fid'];
			$sql="select * from feedback where fid='$fid'";
			$result=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result);
			$_SESSION['msg']="feedback ";
			mysqli_close($cn);
?>

	<body>
		<h2>Edit</h2>
		<form action="editfeedback1.php" method="post">
		<input type="hidden" name="fid" value="<?php echo $rec['fid'];?>"/>
		<table border="1">
			<tr>
				<td>feedback desc</td>
				<td><input type="text" required value="<?php echo $rec['fdesc'];?>" name="fdesc"/> </td>
			</tr>
			<tr>
				<td><a href="feedback.php">back</a></td>
				<td><input type="submit" value="save"></td>
			</tr>
			
		</table>
	</body>
</html>
	
<?php
include_once('inc/footer1.php');
?>