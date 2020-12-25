<html>
	<body>
	<?php
include_once('inc/header1.php');
?>    
    
<?php
include_once('inc/right.php');
?> 
		<form action="company1.php" method="post">
		<h1>COMPANY<h1>
			<table>
				<tr>
					<td>CompanyName</td>
					<td><input type="text" name="companyname" required></td>
				</tr>
				<tr>
					<td>CompanyAddress</td>
					<td><input type="text" name="companyaddress" required></td>
				</tr>
				<tr>
					<td>Phn</td>
					<td><input type="text" name="phn" required></td>
				</tr>
				<tr>
					<td>MailId</td>
					<td><input type="text" name="mailid" required></td>
				</tr>
				<tr>
					<td colspan="4"  align="center"><input type="submit" value="submit "name="submit" ></td>
				</tr>
			</table>
		</form>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_error());
			$sql="select * from company1";
			$result=mysqli_query($cn,$sql);
			
			echo "<table border='1'>";
			echo "<tr>";
			echo "<th>CompanyID</th>";
			echo "<th>CompanyName</th>";
			echo "<th>CompanyAddress</th>";
			echo "<th>Phn</th>";
			echo "<th>Mailid</th>";
			echo "<th>Add new</th>";
			echo "</tr>";
			
			while($row=mysqli_fetch_array($result))
			{
				echo "<tr>";
				echo "<td>${row['companyid']}</td>";
				echo "<td>${row['companyname']}</td>";
				echo "<td>${row['companyaddress']}</td>";
				echo "<td>${row['phn']}</td>";
				echo "<td>${row['mailid']}</td>";
				echo "<td><a href='editcompany.php?companyid=${row['companyid']}'>Edit</a>|<a href='deletecompany.php?companyid=${row['companyid']}'>Delete</a></td>";
				echo "</tr>";
			}
			echo "<tr><td colspan='6'>".mysqli_num_rows($result)." records found</td></tr>";
			echo "</table>";
			mysqli_close($cn);
		?>
	</body>
	
</html>
<?php
include_once('inc/footer1.php');
?>