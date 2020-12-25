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
							$total = $total +  $values["item_price"];
						}
					?>
					
						<td>Total: </td>
						<td> Rs <?php echo number_format($total, 2); ?></td>
						
					</tr>
					<tr><td>Card Holder Name</td>
					    <td><input type="text"></tr>
					<tr><td>Card No</td>
					    <td><input type="text"></tr>
					<tr><td>CVV No</td>
					    <td><input type="text"></tr>
					<tr><td>Expiry Date</td>
					    <td><input type="date"></tr>
					<tr><td></td>
					    <td><input type="submit" value=submit></tr>
					
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
