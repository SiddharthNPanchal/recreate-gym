<?php session_start() ?> 
<html>
	<body>
		<?php 
		$cn=mysqli_connect("localhost","root","","recreate") or die("check connection");

				
					if(!empty($_SESSION["shopping_cart"]))
					{
						$total = 0;
						foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
				
			$item_id=$values["item_id"];
			
			$total = $total + $values["item_price"];
						}
					?>
					<table>
					<tr>
						<td colspan="4" align="right">Total</td>
						<td align="right">Rs <?php echo number_format($total, 2); ?></td>
						
					</tr>
					
					<?php
					}
				
		$uid=$_SESSION['uid'];
		$sql="insert into bookpackage(packageid,uid,pdate)values('$item_id','$uid',now())";
		echo $sql;
		$result=mysqli_query($cn,$sql);
		echo $result;


		
if(!empty($_SESSION["shopping_cart"]))
				{
					$total = 0;
					foreach($_SESSION["shopping_cart"] as $keys => $values)
				{
				
			$item_id=$values["item_id"];

}}
	header("Location:packagepayment.php");
	?>
	</body>
</html>