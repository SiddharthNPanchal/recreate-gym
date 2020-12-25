<?php
include_once('inc/header1.php');
?>    
    
<?php
include_once('inc/right.php');
?> 
<html>
	<?php
		$cn=mysqli_connect("localhost","root","","recreate");
		$id=$_GET['id'];
		$sql="select * from package where id='$id'";
		$result=mysqli_query($cn,$sql);
			$rec=mysqli_fetch_array($result);
		mysqli_close($cn);
	?>
	<body>
		<h2>Edit</h2>
		<form action="editpackage1.php" method="post">
		<input type="hidden" name="id" value="<?php echo $rec['id'];?>"/>
		<table border="1">
			<tr>
				<td>package name</td>
				<td><input type="text" required value="<?php echo $rec['packagename'];?>" name="packagename"/> </td>
			</tr>
			<tr>
				<td>package details</td>
				<td><input type="text" required value="<?php echo $rec['packagedetails'];?>" name="packagedetails"/> </td>
			</tr>
			<!--<tr>
				<td>startdate</td>
				<td><input type="date" required value="<?php echo $rec['startdate'];?>" name="startdate"/> </td>
			</tr>
			<tr>
				<td>enddate</td>
				<td><input type="date" required value="<?php echo $rec['enddate'];?>" name="enddate"/> </td>
			</tr>-->
			<tr>
				<td>price</td>
				<td><input type="text" required value="<?php echo $rec['price'];?>" name="price"/> </td>
			</tr>
			<tr>
							<td>Duration</td>
			<td>
                            <select name="durationid">
                                <?php
                                $cn=mysqli_connect("localhost","root","","recreate") or die(mysqli_eroor());
                                $sql="select * from duration";
                                $res=mysqli_query($cn,$sql);
                                while($arr=mysqli_fetch_array($res)){
                                    ?>
                                <option value="<?php echo $arr['durationid'] ?>"><?php echo $arr['peroid'] ?></option>
                <?php
                                }
                                mysqli_close($cn);
                                ?>
                                </select>
                                
                                
                        </td>
				</tr>
				
			<tr>
				<td><a href="package.php">back</a></td>
				<td><input type="submit" value="save"></td>
			</tr>
			
		</table>
	</body>
</html>
<?php
include_once('inc/footer1.php');
?>