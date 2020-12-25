<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$producttypeid=$_POST['producttypeid'];
			$producttypename=$_POST['producttypename'];
			$sql="update producttype set producttypename='$producttypename' where producttypeid='$producttypeid'";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="ProductOffer updated";
			//header("Location:productoffer.php");
			
		?>
		<script type="text/javascript">alert("Product Type Updated");
				location = "productoffer.php";
				</script>

	</body>
</html>