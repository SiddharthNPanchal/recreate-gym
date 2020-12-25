<?php 
error_reporting(0);
?>
<?php include_once("inc/header.php");
include_once("inc/content.php");
?>
  </head>

  <body>
    <div id="wrapper">


        <div class="container-fluid body-section">
            <div class="row">


<?php 
session_start();
$connect = mysqli_connect("localhost", "root", "", "flikers");
?>

<table align=center>
	<h3 align=center>Payment Detail</h3>
<form>
					<?php
					if(!empty($_SESSION["shopping_cart"]))
					{
						$total = 0;
						foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
					?>
					<tr>
					<?php
							$total = $total + ($values["item_quantity"] * $values["item_price"]);
						}
					?>
					
						<td>Total: </td>
						<td> Rs <?php echo number_format($total, 2); ?></td>
						
					</tr>
					<tr>
						<label for="total">Your Order has been placed Succesfully</label>
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
