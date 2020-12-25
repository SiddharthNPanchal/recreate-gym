<?php
include_once('inc/header1.php');

?>    
    
<?php
include_once('inc/right.php');

?> 
<html>
	<?php
		$cn=mysqli_connect("localhost","root","","recreate");
		$id=$_GET['id'];
		$sql="select * from product where id='$id'";
		$result=mysqli_query($cn,$sql);
		$rec=mysqli_fetch_array($result);
		mysqli_close($cn);
	?>
	<body>
		<h2>Edit</h2>
		<form action="editproduct1.php" method="post">
		<input type="hidden" name="id" value="<?php echo $rec['id'];?>"/>
		<table border="1">
			<tr>
				<td>Product name</td>
				<td><input type="text" required value= "<?php echo $rec['productname'];?>" name="productname"/> </td>
			</tr>
			<tr>
					<td>Size</td>
					<td><input type="text" name="size" value="<?php echo $rec['size'];?>" required></td>
				</tr>

			<tr>
							<td>ProductCompany</td>
			<td>
                            <select name="productcompanyid">
                                <?php
                                $cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_eroor());
                                $sql="select * from productcompany";
                                $res=mysqli_query($cn,$sql);
                                while($arr=mysqli_fetch_array($res)){
                                    ?>
                                <option value="<?php echo $arr['productcompanyid'];?>"><?php echo $arr['productcompanyname'];?></option>
                <?php
                                }
                                mysqli_close($cn);
                                ?>
                                </select>
                                
                                
                        </td>
				</tr>
				
			<tr>
				<td>Quantity</td>
				<td><input type="text" required value="<?php echo $rec['quantity'];?>" name="quantity"/> </td>
			</tr>
			<tr>
				<td>Description</td>
				<td><input type="text" required value="<?php echo $rec['description'];?>" name="description"/> </td>
			</tr>
			<tr>
				<td>Price</td>
				<td><input type="text" required value="<?php echo $rec['price'];?>" name="price"/> </td>
			</tr>
			<tr>
							<td>Product Type</td>
			<td>
                            <select name="producttypeid">
                                <?php
                                $cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_eroor());
                                $sql="select * from producttype";
                                $res=mysqli_query($cn,$sql);
                                while($arr=mysqli_fetch_array($res)){
                                    ?>
                                <option value="<?php echo $arr['producttypeid']?>"><?php echo $arr['producttypename']?></option>
                <?php
                                }
                                mysqli_close($cn);
                                ?>
                                </select>
                                
                                
                        </td>
				</tr>		<tr>
				<td><a href="product.php">back</a></td>
				<td><input type="submit" value="save"></td>
			</tr>
			
		</table>
	</body>
</html>
<?php
include_once('inc/footer1.php');
?>