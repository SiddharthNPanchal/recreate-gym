<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$productcompanyname=$_POST['productcompanyname'];
			$pro1 = strtolower("$productcompanyname");
			//echo "$pro1";
			$sql1 = "select (productcompanyname) from productcompany where productcompanyname = '$pro1'";
			$result1=mysqli_query($cn,$sql1);
			$rec=mysqli_fetch_array($result1);
			echo strtolower("$rec[productcompanyname]");
			echo $pro1;

			if($pro1==strtolower("$rec[productcompanyname]"))
			{
				//echo "Hello";
			?>
				<script type="text/javascript">alert("Company already exists");
				location = "poductcompany.php";
					
					</script>
			<?php
			}
			else
			{
			
			$pro1 = strtolower("$productcompanyname");
			
			$sql="insert into productcompany (productcompanyname) values ('$pro1')";
			$result=mysqli_query($cn,$sql);
			//$rec=mysqli_fetch_array($result);
			
			$_SESSION['msg']="product company Inserted";
			//echo "World";
			header("Location:poductcompany.php");
			}
		?>
	</body>
</html>