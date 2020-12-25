<html>
	<body>
		<form action="payment1.php" method="post">
			<table>
				<tr>
					<td>paymenttype</td>
					<td><input type="text" name="paymenttype" required></td>
				</tr>
				<tr>
					<td>Discount</td>
					<td><input type="text name="discount" required></td>
				</tr>
				<tr>
					<td colspan="2"  align="center"><input type="submit" value="submit "name="submit" ></td>
				</tr>
			</table>
		</form>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate");
			$sql="select * from payment";
			$result=mysqli_query($cn,$sql);
			echo "<table border=1>";
			echo "<tr>";
			echo "<th>PaymentId</th>";
			echo "<th>Paymenttype</th>";
			echo "<th>Discount</th>";
			echo "<th>Add new</th>";
			echo "</tr>";
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				echo "<td>${row['paymentid']}</td>";
				echo "<td>${row['paymenttype']}</td>";
				echo "<td>${row['discount']}</td>";
				echo "<td><a href='editpayment.php?paymentid=${row['paymentid']}'>Edit</a>|<a href='deletepayment.php?paymentid=${row['paymentid']}'>Delete</a></td>";
				echo "</tr>";
			}
		?>
</html>