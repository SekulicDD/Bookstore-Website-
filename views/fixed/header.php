<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_GET["page"])&&$_GET["page"]=="cart"&&!isset($_SESSION["user"])){
	$_SESSION["success"]="You need to login to use cart!";
		header('Location:'.BASE_URL."/?page=login"); 
}

if(isset($_GET["page"])&&($_GET["page"]=="admin")){
	if(!isset($_SESSION["user"])){
		$_SESSION["success"]="You dont have access to that page!";
		header('Location:'.BASE_URL."/?page=login"); 
	}

	else if($_SESSION["user"]->role!="Admin"){
		$_SESSION["success"]="You need to login with account that has admin privilages";
		header('Location:'.BASE_URL."/?page=login"); 
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Book Store</title>
	
	<link href="assets/css/minCss.css" rel="stylesheet">
     
    <link rel="shortcut icon" href="assets/images/home/favicon.ico">

	<script src="https://kit.fontawesome.com/71de788cbb.js" crossorigin="anonymous"></script>
</head>

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row" id="headerTop">
					<div class="col-sm-4">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +2346 17 38 93</a></li>				
							</ul>
						</div>
					</div>
					<div class="col-sm-4" id="welcomeUser">
						<?php if(isset($_SESSION["user"])):?>
						<p>Welcome <?=$_SESSION["user"]->firstName?></p>
						<?php endif;?>						
					</div>					
					<div class="col-sm-4">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="https://www.facebook.com"><i class="fa fa-facebook"></i></a></li>
								<li><a href="https://twitter.com"><i class="fa fa-twitter"></i></a></li>																
							</ul>
						</div>
					</div>
					
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="index.php"><img src="assets/images/home/logo.png" alt="logo" /></a>
						</div>					
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">											
	
									<?php if(isset($_SESSION["user"])) {
																			
									?>
									<li><a href="<?=BASE_URL."/index.php?page=cart"?>"><i class="fa fa-shopping-cart"></i> Cart</a></li>
									<li><a href=<?=BASE_URL."/models/users/logout.php"?>><i class="fa fa-lock"></i>Logout</a></li>
										
									<?php 
									}
									else{				
										?>								
										<li><a href="<?=BASE_URL."/index.php?page=login"?>"><i class="fa fa-shopping-cart"></i> Cart</a></li>
										<li><a href=<?=BASE_URL."/index.php?page=login"?>><i class="fa fa-lock"></i>Login</a></li>
									<?php } ?>
																												
								
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" id="smallMenu">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>

						<div id="smallMenuList">
							<ul >
								<li><a href="index.php" >Home</a></li>
                                  
								<li><a href=<?=BASE_URL."/index.php?page=shop&pg=1&order=1"?>>Products</a></li>								
				                   
                                </li> 
								<li><a href="<?=BASE_URL."/index.php?page=contact"?>">Contact</a></li>
								<?php if(!isset($_SESSION["user"])):?>																									
									<li><a href="<?=BASE_URL."/index.php?page=login"?>"> Login</a></li> 
								<?php else:?>
									<li><a href="<?=BASE_URL."/index.php?page=cart"?>"> Cart</a></li> 
								<?php endif;?>  

								<?php if(isset($_SESSION["user"])) {
									if($_SESSION["user"]->role=="Admin"){
										echo "<li><a href='".BASE_URL."/index.php?page=admin'>Admin Panel</a></li>";
									}
								}?>
								
								
							</ul>
						</div>

						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="index.php" >Home</a></li>
								<li class="dropdown"><a href="#">Shop<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href=<?=BASE_URL."/index.php?page=shop&pg=1&order=1"?>>Products</a></li>								
									
										<?php if(!isset($_SESSION["user"])):?>																									
											<li><a href="<?=BASE_URL."/index.php?page=login"?>"> Login</a></li> 
										<?php else:?>
											<li><a href="<?=BASE_URL."/index.php?page=cart"?>"> Cart</a></li> 
										<?php endif;?>
                                    </ul>
                                </li> 
								<li><a href="<?=BASE_URL."/index.php?page=contact"?>">Contact</a></li>

								<?php if(isset($_SESSION["user"])) {
									if($_SESSION["user"]->role=="Admin"){
										echo "<li><a href='".BASE_URL."/index.php?page=admin'>Admin Panel</a></li>";
									}
								}?>
								
								
							</ul>
						</div>
					</div>
				
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->