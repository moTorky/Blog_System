<!-- /*
* Template Name: Blogy
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Untree.co">
	<link rel="shortcut icon" href="favicon.png">

	<meta name="description" content="" />
	<meta name="keywords" content="bootstrap, bootstrap5" />

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600;700&display=swap" rel="stylesheet">


	<link rel="stylesheet" href="fonts/icomoon/style.css">
	<link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

	<link rel="stylesheet" href="assets/user/css/tiny-slider.css">
	<link rel="stylesheet" href="assets/user/css/aos.css">
	<link rel="stylesheet" href="assets/user/css/glightbox.min.css">
	<link rel="stylesheet" href="assets/user/css/style.css">

	<link rel="stylesheet" href="assets/user/css/flatpickr.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


	<title>Blogy &mdash;  Blog System</title>
</head>
<body>

	<div class="site-mobile-menu site-navbar-target">
		<div class="site-mobile-menu-header">
			<div class="site-mobile-menu-close">
				<span class="icofont-close js-menu-toggle"></span>
			</div>
		</div>
		<div class="site-mobile-menu-body"></div>
	</div>

	<nav class="site-nav">
		<div class="container">
			<div class="menu-bg-wrap">
				<div class="site-navigation">
					<div class="row g-0 align-items-center">
						<div class="col-1">
							<a href="index.php" class="logo m-0 float-start">Blogy<span class="text-primary">.</span></a>
						</div>
						<div class="col-8 text-center">
							<form action="#" class="search-form d-inline-block d-lg-none">
								<input type="text" class="form-control" placeholder="Search...">
								<span class="bi-search"></span>
							</form>

							<ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu mx-auto">
								<li class="active"><a href="index.php">Home</a></li>

								<li><a href="category.php?name=Culture">Culture</a></li>
								<li><a href="category.php?name=Business">Business</a></li>
								<li><a href="category.php?name=Politics">Politics</a></li>
							</ul>
						</div>
						<div class="col-2">
							<a href="#" class="burger ms-auto float-end site-menu-toggle js-menu-toggle d-inline-block d-lg-none light">
								<span></span>
							</a>
							<form action="category.php" class="search-form d-none d-lg-inline-block">
								<input type="text" class="form-control" placeholder="Search..." name="searchKey">
								<span class="bi-search"></span>
							</form>
						</div>
						<div class="col-1 text-end">

						<?php 
						if (session_status() === PHP_SESSION_NONE) {
							session_start();
						}
						// echo $_SESSION['id'];
						if(!empty($_SESSION['id'])) {
							include('./inc/user_img.php');
						}else{
							echo '<a href="login.php"><button value="login" class="btn btn-primary">login</button></a>';
						}?>
						</div>                                        

					</div>
				</div>
			</div>
		</div>
	</nav>