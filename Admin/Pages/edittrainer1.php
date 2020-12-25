<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$trainerid=$_POST['trainerid'];
			$trainername=$_POST['trainername'];
			$trainerdob=$_POST['trainerdob'];
			$trainermob=$_POST['trainermob'];
			$trainerweight=$_POST['trainerweight'];
			$trainerheight=$_POST['trainerheight'];
			$trainermail=$_POST['trainermail'];
			
			
			echo "$trainerid<br>";
			echo "$trainername<br>";
			echo "$trainerdob<br>";
			echo "$trainermob<br>";
			echo "$trainerweight<br>";
			echo "$trainerheight<br>";
			echo "$trainermail<br>";
			$sql="update trainer set trainername='$trainername',trainerdob='$trainerdob',trainermob='$trainermob',trainerweight='$trainerweight',trainerheight='$trainerheight',trainermail='$trainermail' where trainerid='$trainerid'";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="trainer updated";
			header("Location:trainer.php");
		?>
	</body>
</html>