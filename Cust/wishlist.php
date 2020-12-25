	<?php session_start()?>
<?php include_once("inc/header.php");
include_once("inc/content.php");
?>
<?php

			$userid=$_SESSION['uid'];
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select p.*,c.productcompanyname,t.producttypename,w.*,u.fname from product p,productcompany c,producttype t,wishlist w,user u where p.productcompanyid=c.productcompanyid and p.type=t.producttypeid and p.id=w.productid and u.uid=w.userid and u.uid=$userid";
			$result=mysqli_query($cn,$sql);	
			echo $_SESSION['fname'];
			echo "'s wishlist";
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>Gym member name</th>";
			echo "<th>ProductName</th>";
			echo "<th>Product Company</th>";
			echo "<th>Quantity</th>";
			echo "<th>Description</th>";
			echo "<th>Type</th>";
			echo "<th>Price</th>";
			echo "<th>image</th>";
			echo "<th>Links</th>";
			echo "</tr>";
			
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				echo "<td>${row['fname']}</td>";
				echo "<td>${row['productname']}</td>";
				echo "<td>${row['productcompanyname']}</td>";
				echo "<td>${row['quantity']}</td>";
				echo "<td>${row['description']}</td>";
				echo "<td>${row['producttypename']}</td>";
				echo "<td>${row['price']}</td>";
				echo "<td><img src=images/$row[image] width=150 height=150 /></td>";
				echo"<td><a href='demo.php?id=${row['id']}'>AddtoCart</a>  </td>";

				echo "</tr>";
			}
			echo "<tr><td colspan='10'>".mysqli_num_rows($result)." record(s) found</td></tr>";
			echo "</table>";
			mysqli_close($cn);
		?>
	</body>
	<?php include_once("inc/footer.php");

?>