<?php session_start() ?>
<?php
include_once('inc/header.php');
?>    
    
<?php
include_once('inc/content.php');
?> 
<html>
<h1>ORDER DETAILS</h1>
</html>
<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$abc=$_SESSION['uid'];
			//echo "$abc";
			$sql="select p.*,o.*,P1.* from product p,product_order p1,order1 o where p1.product_id=p.id and o.order_id=p1.order_id and  o.user_id=$abc";
			$result=mysqli_query($cn,$sql);
			
			echo "<table border='1'>";
			echo "<tr>";
			
			echo "<th>Product Name </th>";
			echo "<th>Quantity</th>";
			echo "<th> Total</th>";
			echo "<th>Order Date </th>";
			//echo "<th>Name </th>";
			echo "</tr>";
			
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				echo "<td>${row['productname']}</td>";
				echo "<td>${row['quantity']}</td>";
				echo "<td>${row['total_amount']}</td>";
				echo "<td>${row['order_date']}</td>";
				//echo "<td>${row['fname']}</td>";
				echo "</tr>";
			}
			
			echo "<tr><td colspan='5'>".mysqli_num_rows($result)." records found</td></tr>";
			echo "</table>";
			mysqli_close($cn);
?>
<?php
include_once('inc/footer.php');
?>