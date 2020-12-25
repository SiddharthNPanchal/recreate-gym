<html>
	<?php
include_once('inc/header1.php');
?> 
<?php
include_once('inc/right.php');
?>
<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$productcompanyid=$_GET['productcompanyid'];
			$sql="select * from productcompany where productcompanyid='$productcompanyid'";
			$result=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result);
			$_SESSION['msg']="Product company Deleted";
			mysqli_close($cn);
?>

	<body>
		<h2>Edit</h2>
		<form action="editproductcompany1.php" method="post">
		<input type="hidden" name="productcompanyid" value="<?php echo $rec['productcompanyid'];?>"/>
		<table border="1">
			<tr>
				<td>product company name</td>
				<td><input type="text" required value="<?php echo $rec['productcompanyname'];?>" name="productcompanyname"/> </td>
			</tr>
			
			<tr>
				<td><a href="poductcompany.php">back</a></td>
				<td><input type="submit" value="save"></td>
			</tr>
			
		</table>
	</body>
		<?php
include_once('inc/footer1.php');
?>
</html>