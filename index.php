<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Hotel Website | Home</title>
		<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="css/responsiveslides.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script src="js/responsiveslides.min.js"></script>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css"/>
		  <script>
			    $(function () {
			
			      $("#slider1").responsiveSlides({
			        maxwidth: 1600,
			        speed: 600
			      });
			});
		  </script>
		  <style>
			.contact-info a {
				text-decoration: none;
				color: white;
				padding: 10px 20px;
				border-radius: 5px;
				display: inline-flex;
				align-items: center;
				margin: 5px;
				transition: background-color 0.3s ease;
				font-family: 'PT Sans Narrow', sans-serif;
			}

			.btn-talk {
				background-color: #007BFF;
				border: none;
			}

			.btn-dashboard {
				background-color: #28a745;
				border: none;
			}

			.btn-talk:hover, .btn-dashboard:hover {
				background-color: #0056b3;
				color: white;
			}

			.contact-info i {
				margin-right: 8px;
				font-size: 16px;
			}

			.logo{
				height: 150px;
				width: 150px;
			}

		  </style>
	</head>
	<body>
		<!---start-Wrap--->
			<!---start-header--->
			<div class="header">
				<div class="wrap">
					<div class="header-top">
						<div class="logo">
							<a href="index.php"><img src="images/logo.png " title="logo" /></a>
						</div>
						<div class="contact-info">
							<p class="phone">Call us : <a href="#">980XXXXXXX</a></p>
							<p class="gpa">Gpa : <a href="#">View map</a></p>
							<p class="code">BROUGHT TO YOU BY: <a href="https:www.code-projects.org">CODE-PROJECTS</a></p>
							<?php if (isset($_SESSION['user'])): ?>
								<a href="logout.php" class="btn-talk">
									<i class="fas fa-sign-out-alt"></i> Log out
								</a>
							<?php else: ?>
								<a href="auth.php" class="btn-talk">
									<i class="fas fa-sign-in-alt"></i> Log in
								</a>
							<?php endif; ?>
							<?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
								<a href="dashboard.php" class="btn-dashboard">
									<i class="fas fa-tachometer-alt"></i> Dashboard
								</a>
							<?php endif; ?>
						</div>

						<div class="clear"> </div>
					</div>
				</div>
				<div class="header-top-nav">
					<div class="wrap">
						<ul>
							<li class="active"><a href="index.php">Home</a></li>
							<li><a href="about.html">About</a></li>
							<li><a href="services.html">Services</a></li>
							<li><a href="gallery.html">Gallery</a></li>
							<li><a href="contact.html">Contact</a></li>
							<div class="clear"> </div>
						</ul>
					</div>
				</div>
			</div>
			<!---End-header--->
			<div class="clear"> </div>
			<!--start-image-slider---->
					<div class="image-slider">
						<!-- Slideshow 1 -->
						    <ul class="rslides" id="slider1">
						      <li><img src="images/slider3.jpg" alt=""></li>
						      <li><img src="images/slider1.jpg" alt=""></li>
						      <li><img src="images/slider3.jpg" alt=""></li>
						    </ul>
						 <!-- Slideshow 2 -->
					</div>
					<!--End-image-slider---->
			<!---start-content----->
			<div class="content">
				<div class="quit">
					<p><span class="start">Your </span> hotel's <span class="end">Motto .</span></p>
				</div>
					<div class="content-grids">
						<div class="wrap">
						<div class="content-grid">
							<div class="content-grid-pic">
								<a href="#"><img src="images/icon1.png" title="image-name" /></a>
							</div>
							<div class="content-grid-info">
								<h3>Best food Ever</h3>
								<p>"DESCRIPTION"</p>
								<a href="#">Read More</a>
							</div>
							<div class="clear"> </div>
						</div>
						<div class="content-grid">
							<div class="content-grid-pic">
								<a href="#"><img src="images/icon2.png" title="image-name" /></a>
							</div>
							<div class="content-grid-info">
								<h3>24x7 phone support</h3>
								<p>"DESCRIPTION"</p>
								<a href="#">Read More</a>
							</div>
							<div class="clear"> </div>
						</div>
						<div class="content-grid">
							<div class="content-grid-pic">
								<a href="#"><img src="images/iocn3.png" title="image-name" /></a>
							</div>
							<div class="content-grid-info">
								<h3>Best Room Services</h3>
								<p>"DESCRIPTION"</p>
								<a href="#">Read More</a>
							</div>
							<div class="clear"> </div>
						</div>
						
						<div class="clear"> </div>
					</div>
				</div>
				<div class="clear"> </div>
				<div class="content-box">
					<div class="wrap">
					<div class="content-box-left">
						<div class="content-box-left-topgrid">
							<h3>welcome to our Hotel</h3>
							<p> ' Feel Like Home :)</p>
							<p> Hotel's Description</p>
							<span>For more information about our Hotel, Call 980XXXXXXX</span>
						</div>
						<div class="content-box-left-bootomgrids">
							<div class="content-box-left-bootomgrid">
								<h3>Deluxe Rooms</h3>
								<p> Your description about deluxe rooms</p>
								<a href="#"><img src="images/slider1.jpg" title="image-name" /></a>
							</div>
							<div class="content-box-left-bootomgrid">
								<h3>Luxury Rooms</h3>
								<p>Your description about Luxury rooms</p>
								<a href="#"><img src="images/slider2.jpg" title="image-name" /></a>
							</div>
							<div class="content-box-left-bootomgrid lastgrid">
								<h3>Executive Rooms</h3>
								<p>Your description about Executive rooms</p>
								<a href="#"><img src="images/slider3.jpg" title="image-name" /></a>
							</div>
							<div class="clear"> </div>
						</div>
						<div class="clear"> </div>
					</div>
					<div class="content-box-right">
						<div class="content-box-right-topgrid">
							<h3>To days Specials</h3>
							<a href="#"><img src="images/slider1.jpg" title="imnage-name" /></a>
							<h4>Super Discount Offer</h4>
							<p>"DESCRIPTION"</p>
							<a href="#">Read More</a>
						</div>
						<div class="content-box-right-bottomgrid">
							
						</div>
					</div>
					<div class="clear"> </div>
				</div>
				<div class="clear"> </div>
				<div class="boxs">
				<div class="wrap">
				<div class="box">
			
				</div>
				<div class="box center-box">
					<ul>
						<li><a href="https:www.code-projects.org">Leave a Feedback</a></li>
						<li><a href="https:www.code-projects.org">Reviews and Ratings</a></li>
						<li><a href="https:www.code-projects.org">FAQs</a></li>
						<li><a href="https:www.code-projects.org">Packages</a></li>
						<li><a href="https:www.code-projects.org">Know about Moutaineering and trekking here</a></li>
						<li><a href="https:www.code-projects.org">www.code-projects.org</a></li>
					</ul>
				</div>
		
				<div class="clear"> </div>
			</div>
			<!---start-box---->
		</div>
		<!---start-copy-Right----->
		<div class="copy-tight">
			<p>&copy HOTEL,Nepal 2017 "THIS PROJECT IS BROUGHT TO YOU BY <a href="http://www.code-projects.org/">CODE-PROJECTS"</a></p>
		</div>
		<!---End-copy-Right----->
			</div>
			<!---End-content----->
		</div>
		<!---End-Wrap--->
	</body>
</html>

