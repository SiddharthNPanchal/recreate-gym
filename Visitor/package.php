<?php session_start() ?>
<?php include_once("inc/header.php");
include_once("inc/content.php");
?>
<body>
<?php
		if(isset($_SESSION['msg'])){
		   echo $_SESSION['msg'];
		   unset($_SESSION['msg']);
		}
		?>

	<table border="1">
	<form action="package.php" method="post">
		                <tr>
			<td>Package</td>
			<td>
                            <select name="name">
                                <option value="Golden">Golden</option>
								<option value="Silver">Silver</option>
								<option value="Platinum">Platinum</option>
                                </select>
                                
                                
                        </td>
		</tr>

		<tr>
		<td colspan="2" align="center"><input type="submit" value="submit" name="btnsubmit"></td>
		</tr>
	</form>
</table>
      <?php
       if(isset($_POST['name'])) {
	$cn=mysqli_connect("localhost","root","","recreate")or die(mysqli_error());	
	$sql="select p.*,d.peroid from package p,duration d where packagename like '%$_POST[name]%' and p.durationid=d.durationid ";
	
	$result=mysqli_query($cn,$sql);
	echo"<table border='1' cellpadding='10' cellspacing='0' bgcolor='pink'>";
	echo"<tr>";
	echo "<th>package</th>";
      echo "<th>price</th>";
		echo"<th>Details</th>";
		echo "<th>Duration</th>";
	
    echo "</tr>";
	while($row=mysqli_fetch_array($result)){
		echo "<tr>";
		echo "<td>${row['packagename']}</td>";
		echo "<td>${row['price']}</td>";
		echo "<td>${row['packagedetails']}</td>";
   //     echo "<td>${row['startdate']}</td>";          
	//	echo "<td>${row['enddate']}</td>";
		echo "<td>${row['peroid']}</td>";

        
		echo"<td><a href='registration.php?id=${row['id']}'>Select</a> 
		 </td>";
		echo "</tr>";
	}
	//echo"<tr><td colspan='9'>".mysqli_num_rows($result)."records found</td></tr>";
	echo "</table>";
	mysqli_close($cn);
            }
	?>
</div>
            </div>
        </div>	
</body>
</html>
<?php include_once("inc/footer.php");

?>