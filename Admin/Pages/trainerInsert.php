<?php session_start() ?>
<html>
	<body>
		<?php
			$cn=mysqli_connect("localhost","root","","recreate") or die("Check connection");
			$trainername=$_POST['trainername'];
			$trainerdob=$_POST['trainerdob'];
			$trainermob=$_POST['trainermob'];
			$trainermail=$_POST['trainermail'];
			$trainerweight=$_POST['trainerweight'];
			$trainerheight=$_POST['trainerheight'];
			$secque=$_POST['secque'];
			echo "$trainername";
			echo "$trainerdob";
			echo "$trainermob";
			echo "$trainermail";
			echo "$trainerweight";
			echo "$trainerheight";
			echo "$secque";
			$sql="insert into trainer (trainername,trainerdob,trainermob,trainermail,trainerweight,trainerheight) values ('$trainername','$trainerdob','$trainermob','$trainermail','$trainerweight','$trainerheight')";
			$result=mysqli_query($cn,$sql);
			$_SESSION['msg']="Trainer Inserted";
			//header("Location:trainer.php");
		?>
	</body>
</html>