<?php session_start() ?>


<?php include_once("inc/header.php");
include_once("inc/content.php");
//echo $_SESSION['fname'];
?>
<?php
?>
			<h1>Products</h1>
			<?php 
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select * from product";
			$result=mysqli_query($cn,$sql);			
			echo "<table border='1'>";
			echo "<tr>";
			//echo "<th>ProductId</th>";
			echo "<th>ProductName</th>";
			echo "<th>Product Company</th>";
			echo "<th>Product Offer</th>";
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
				echo "<td>${row['productcompanyid']}</td>";
				echo "<td>${row['productofferid']}</td>";
				echo "<td>${row['quantity']}</td>";
				echo "<td>${row['description']}</td>";
				echo "<td>${row['type']}</td>";
				echo "<td>${row['price']}</td>";
				echo "<td><img src=images/$row[image] width=60 height=60 /></td>";
				echo"<td><a href='demo.php?id=${row['id']}'>AddtoCart</a> | <a href='inwishlist.php?id=${row['id']}'>wishlist</a> </td>";	
				echo "</tr>";
			}
			echo "<tr><td colspan='10'>".mysqli_num_rows($result)." record(s) found</td></tr>";
			echo "</table>";
			mysqli_close($cn);
		?>
<?php include_once("inc/footer.php");

?>