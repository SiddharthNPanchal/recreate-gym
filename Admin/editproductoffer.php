<html>
		<?php
include_once('inc/header1.php');
?>    
    
<?php
include_once('inc/right.php');
?>
<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$producttypeid=$_GET['producttypeid'];
			$sql="select * from producttype where producttypeid='$producttypeid'";
			$result=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result);
			mysqli_close($cn);
?>

	<body>
		<h2>Edit</h2>
		<form action="editproductoffer1.php" method="post">
		<input type="hidden" name="producttypeid" value="<?php echo $rec['producttypeid'];?>"/>
		<table border="1">
			<tr>
				<td>Product type name</td>
				<td><input type="text" required value="<?php echo $rec['producttypename'];?>" name="producttypename"/> </td>
			</tr>
			<tr>
				<td><a href="productoffer.php">back</a></td>
				<td><input type="submit" value="save"></td>
			</tr>
		</table>
	</body>
</html>
<?php
include_once('inc/footer1.php');
?>
