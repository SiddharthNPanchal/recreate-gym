<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$producttypeid=$_GET['producttypeid'];
			$sql="delete from producttype where producttypeid='$producttypeid'";
			$result=mysqli_query($cn,$sql);
			
		?>
		<script>
			alert("Productoffer deleted");
			location = "productoffer.php";
		</script>
	</body>
</html>