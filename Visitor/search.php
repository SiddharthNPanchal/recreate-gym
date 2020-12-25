<?php session_start() ?>


<?php include_once("inc/header.php");
include_once("inc/content.php");
//echo $_SESSION['fname'];
?>
	<table border="1">
	<form action="search.php" method="post">
			<tr>
			<td>Search By Name</td>
			<td><input type="text" name="name"></td>
        </tr>        
		<tr>
		<td colspan="2" align="center"><input type="submit" value="submit" name="btnsubmit"></td>
		</tr>
	</form>
</table>



      <?php
       if(isset($_POST['name'])) {
		   
	$cn=mysqli_connect("localhost","root","","recreate")or die(mysqli_error());	
	$sql="select id,size,productname,quantity,description,price,type,image from product where productname like '%$_POST[name]%'";
	$result=mysqli_query($cn,$sql);
	echo"<table border='1' cellpadding='10' cellspacing='0' bgcolor='pink'>";
	echo "<caption>Search result</caption>";
	echo"<tr>";
	echo "<th>pname</th>";
	 echo "<th>Size</th>";
        echo "<th>quantity</th>";
        echo "<th>description</th>"; 
        echo "<th>price</th>";
        echo "<th>type</th>";
		echo "<th>image</th>";
		echo "<th>link</th>";
    echo "</tr>";
	while($row=mysqli_fetch_array($result)){
		echo "<tr>";
		echo "<td>${row['productname']}</td>";
		echo "<td>${row['size']}</td>";
		echo "<td>${row['quantity']}</td>";
        echo "<td>${row['description']}</td>";          
		echo "<td>${row['price']}</td>";
        echo "<td>${row['type']}</td>";
        echo "<td><img src=images/$row[image] width=60 height=60 /></td>";
		
		echo"<td><a href='registration.php?id=${row['id']}'>AddtoCart</a> |
		<a href='registration.php?id=${row['id']}'>wishlist</a> </td>";
		echo "</tr>";
	}
	//echo"<tr><td colspan='9'>".mysqli_num_rows($result)."records found</td></tr>";
	echo "</table>";
	mysqli_close($cn);
            }
	?>
	<?php
		if(isset($_SESSION['msg'])){
		   echo $_SESSION['msg'];
		   unset($_SESSION['msg']);
		}
		?>
<?php include_once("inc/footer.php");

?>
