<?php session_start() ?>
<?php
		if(isset($_SESSION['msg'])){
		   echo $_SESSION['msg'];
		   unset($_SESSION['msg']);
		}
		?>
<?php include_once("inc/header.php"); 
include_once("inc/content.php"); 
?>
	<table border="1">
	<form action="search_category.php" method="post">
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
                                <option value="<?php echo $arr['producttypeid'] ?>"><?php echo $arr['producttypename'] ?></option>
                <?php
                                }
                                mysqli_close($cn);
                                ?>
                                </select>
                                
                                
                        </td>
				</tr>
                
		<tr>
		<td colspan="2" align="center"><input type="submit" value="submit" name="btnsubmit"></td>
		</tr>
	</form>
	</table>
            <?php
            if(isset ($_POST['producttypeid'])) {
	$cn=mysqli_connect("localhost","root","","recreate")or die(mysqli_error());
	$sql="select p.*,t.* from product p,producttype t where type like '%$_POST[producttypeid]%' and p.type=t.producttypeid";
	$result=mysqli_query($cn,$sql);

	echo"<table border='1' cellpadding='10' cellspacing='0' bgcolor='pink'>";
	echo"<tr>";
	echo "<th>pname</th>";
	echo "<th>Size</th>";
        echo "<th>quantity</th>";
        echo "<th>description</th>"; 
        echo "<th>price</th>";
        echo "<th>type</th>";
		echo "<th>image</th>";
		echo "<th></th>";
    echo "</tr>";
	while($row=mysqli_fetch_array($result)){
		echo "<tr>";
		echo "<td>${row['productname']}</td>";
		echo "<td>${row['size']}</td>";
		echo "<td>${row['quantity']}</td>";
        echo "<td>${row['description']}</td>";          
		echo "<td>${row['price']}</td>";
        echo "<td>${row['producttypename']}</td>";
        echo "<td><img src=images/$row[image] width=60 height=60 /></td>";	
	echo"<td><a href='registration.php?id=${row['id']}'>AddtoCart</a> | <a href='registration.php?id=${row['id']}'>wishlist</a> </td></td>";		
		echo "</tr>";
	}
	echo"<tr><td colspan='9'>".mysqli_num_rows($result)."records found</td></tr>";
	echo "</table>";
	mysqli_close($cn);
			}            
	?>
</div>
            </div>
        </div>

	<?php include_once("inc/footer.php");
?>