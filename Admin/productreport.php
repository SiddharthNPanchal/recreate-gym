	<?php
include_once('inc/header1.php');
?>    
    
<?php
include_once('inc/right.php');
?> 
<html>
<h1>SALES DETAILS</h1>
</html>
<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select p.*,o.*,p1.productname,u.fname from product_order p,product p1 ,order1 o,user u where p.product_id=p1.id and o.user_id=u.uid and p.order_id=o.order_id";
			$result=mysqli_query($cn,$sql);
			
			echo "<table border='1'>";
			echo "<tr>";
			
			echo "<th>Product Name </th>";
			echo "<th>Quantity</th>";
			echo "<th> Total</th>";
			echo "<th>Order Date </th>";
			echo "<th>Name </th>";
			echo "</tr>";
			
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				echo "<td>${row['productname']}</td>";
				echo "<td>${row['quantity']}</td>";
				echo "<td>${row['total_amount']}</td>";
				echo "<td>${row['order_date']}</td>";
				echo "<td>${row['fname']}</td>";
				echo "</tr>";
			}
			echo "<tr><td colspan='5'>".mysqli_num_rows($result)." records found</td></tr>";
			echo "</table>";
			mysqli_close($cn);
?>
<?php
include_once('inc/footer1.php');
?>