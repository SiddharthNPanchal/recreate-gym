<?php include_once("inc/header.php");
include_once("inc/content.php");
//echo $_SESSION['fname'];
?>
<?php 

error_reporting(0);
?>
  </head>

  <body>
    <div id="wrapper">


        <div class="container-fluid body-section">
            <div class="row">


<?php 
session_start();
$connect = mysqli_connect("localhost", "root", "", "recreate");
?>
<h3 align =center>Bill</h3>
	<center>
			<div style="width:100%" class="table-responsive" >
				<table width="90%"border=1 class="table table-bordered">
					<tr>
						<!--<th>package Id</th>-->
						<th>package Name</th>

						<th>Price</th>
						<th>Total</th>
						</tr>
					<?php
					if(!empty($_SESSION["shopping_cart"]))
					{
						$total = 0;
						foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
					?>
					<tr>
						<td align=center><?php echo $values["item_name"]; ?></td>

						<td align=center>Rs <?php echo $values["item_price"]; ?></td>
						<td align=center>RS <?php echo $values["item_price"];?></td>
					</tr>
					<?php
							$total = $total + $values["item_price"];
						}
					?>
					<tr>
						<td colspan="2" align="right">Total</td>
						<td align="right">Rs <?php echo number_format($total, 2); ?></td>
						
					</tr>
					<tr>
					<td colspan=5 align=right><a href="packageinsert.php" align=right><h3>Payment</h3></a></td>
					</tr>
					<?php
					}
					?>
						
				</table>
			</div>
		</div>
	</div>
	<br />
	</body>
</html>
	
<?php include_once("inc/footer.php");

?>
