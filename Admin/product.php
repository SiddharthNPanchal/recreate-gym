<?php
include_once('inc/header1.php');
?>    
<?php
include_once('inc/right.php');
?>	

<html>
	<body>

	<head>
	<style>
	
	</style>
	</head>
		<form action="productInsert.php" method="post" enctype="multipart/form-data">
		<h1>PRODUCT</h1>
			<table>
				<tr>
					<td>Product Name</td>
					<td><input type="text" name="productname" required></td>
				</tr>
				<tr>
					<td>Size</td>
					<td><input type="text" name="size" required></td>
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
					<td><input type="text" name="quantity" required></td>
				</tr>
				<tr>
					<td>Description</td>
					<td><input type="text" name="description" required></td>
				</tr>
				<tr>
					<td>Price</td>
					<td><input type="text" name="price" required></td>
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
				</tr>		
				   <tr><td>
                        product image</td>
                    <td><input type="file" name="file" value="" size="35"></td></tr>

				<tr>
					<td colspan="2"  align="center"><input type="submit" value="submit "name="submit" ></td>
				</tr>
				
			</table>
		</form>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select p.*,c.productcompanyname,t.producttypename from product p,productcompany c,producttype t where p.productcompanyid=c.productcompanyid and p.type=t.producttypeid";
			$result=mysqli_query($cn,$sql);			
			echo "<table border='1'>";
			echo "<tr>";
			//echo "<th>ProductId</th>";
			echo "<th>ProductName</th>";
			echo "<th>Size</th>";
			echo "<th>Product Company</th>";
			//echo "<th>Product Offer</th>";
			echo "<th>Quantity</th>";
			echo "<th>Description</th>";
			echo "<th>Type</th>";
			echo "<th>Price</th>";
			echo "<th>image</th>";
			
			echo "<th>Add new</th>";
			echo "</tr>";
			
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				//echo "<td>${row['id']}</td>";
				echo "<td>${row['productname']}</td>";
				echo "<td>${row['size']}</td>";
				echo "<td>${row['productcompanyname']}</td>";
				//echo "<td>${row['productofferdiscount']}</td>";
				echo "<td>${row['quantity']}</td>";
				echo "<td>${row['description']}</td>";
				echo "<td>${row['producttypename']}</td>";
				echo "<td>${row['price']}</td>";
				echo "<td><img src=images/$row[image] width=60 height=60 /></td>";
				echo "<td><a href='editproduct.php?id=${row['id']}'>Edit</a>|<a href='deleteproduct.php?id=${row['id']}'>Delete</a></td>";
				echo "</tr>";
			}
			echo "<tr><td colspan='10'>".mysqli_num_rows($result)." record(s) found</td></tr>";
			echo "</table>";
			mysqli_close($cn);
		?>
	</body>
	
</html>
<?php
include_once('inc/footer1.php');
?>