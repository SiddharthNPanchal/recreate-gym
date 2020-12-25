<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php error_reporting(0);?>
<?php session_start()?>
<!DOCTYPE HTML>
<html>
<head>
<title>RE CREATE GYM</title>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />-->
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(".scroll").click(function(event){		
				event.preventDefault();
				$('html,body').animate({scrollTop:$(this.hash).offset().top},1200);
			});
		});
	</script>
<!-- grid-slider -->
<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="js/jquery.contentcarousel.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<!-- //grid-slider -->
</head>
<body>
 <!-- start header_top -->
	<div class="header">
	   <div class="container">
		  <div class="header-text">
			<h1>Perfect Fitness</h1>
			<h2>RE CREATE PROMISE TO:</h2>
			<p>
HELP YOU FIND YOUR STARTING POINT
BUILD YOUR PATH TO SUCCESS
SHOW YOU THE ROPES
BE WITH YOU EVERY STEP OF THE WAY
GUARANTEE SATISFACTION</p>
			
		  </div>
		  <div class="header-arrow">
		     <a href="#menu" class="class scroll"><span> </span </a>
		  </div>
	    </div>
	  </div>
	<!-- end header_top -->
	<!-- start header_bottom -->
	  <div class="header-bottom">
		 <div class="container">
			<div class="header-bottom_left">
				<i class="phone"> </i><span>(079)2665 2825</span>
			</div>
			<div class="social">	
			   <ul>	
				  <li class="facebook"><a href="https://www.facebook.com/recreategympaldi/"><span> </span></a></li>
				  <li class="twitter"><a href="#"><span> </span></a></li>
				  <li class="pinterest"><a href="#"><span> </span></a></li>	
				  <li class="google"><a href="#"><span> </span></a></li>
				  <li class="tumblr"><a href="#"><span> </span></a></li>
				  <li class="instagram"><a href="#"><span> </span></a></li>	
				  <li class="rss"><a href="#"><span> </span></a></li>							
			   </ul>
		   </div>
		   <div class="clear"></div>
		</div>
	  </div>
	<!-- end header_bottom -->
	<!-- start menu -->
	<? php $a= echo $_SESSION['fname'];?>
    <div class="menu" id="menu">
	  <div class="container">
		 <div class="logo">
			<a href="get_product.php"><img src="images/logo.png" alt=""/></a>
		 </div>
		 <div class="h_menu4"><!-- start h_menu4 -->
		   <a class="toggleMenu" href="#">Menu</a>
			 <ul class="nav">
			   <li ><a href="search.php">Search</a></li>
			   <!--<li><a href="search_category.php">Search Category</a></li>-->
			   <li><a href="package.php">Buy Gym Package</a></li>
			   <li><a href="trainers.php">Our Trainers</a></li>
			   <li><a href="batch.php">Batch Details</a></li>
			   <li><a href="feedback.php">Feedback</a></li>
			   <li><a href="wishlist.php">WishList</a></li>
			   <li><a href="demo.php">Cart</a></li>
			   <li><a href="account.php"><?php  echo $_SESSION['fname'];?>'s Account</a></li>			   
			 </ul>
			  <script type="text/javascript" src="js/nav.js"></script>
		  </div><!-- end h_menu4 -->
		 <div class="clear"></div>
	  </div>
	</div>
	<!-- end menu -->
