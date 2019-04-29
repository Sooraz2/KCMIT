<!DOCTYPE html>
<html lang="zxx">
    <head>
        <!-- meta tag -->
        <meta charset="utf-8">
        <title>Edulearn | Responsive Education HTML5 Template</title>
        <meta name="description" content="">
        <!-- responsive tag -->
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- favicon -->
        <link rel="apple-touch-icon" href="apple-touch-icon_png.html">
        <link rel="shortcut icon" type="image/x-icon" href="images\fav.png">
        <!-- bootstrap v4 css -->
        <link rel="stylesheet" type="text/css" href="css\bootstrap.min.css">
        <!-- font-awesome css -->
        <link rel="stylesheet" type="text/css" href="css\font-awesome.min.css">
        <!-- animate css -->
        <link rel="stylesheet" type="text/css" href="css\animate.css">
        <!-- owl.carousel css -->
        <link rel="stylesheet" type="text/css" href="css\owl.carousel.css">
		<!-- slick css -->
        <link rel="stylesheet" type="text/css" href="css\slick.css">
        <!-- rsmenu CSS -->
        <link rel="stylesheet" type="text/css" href="css\rsmenu-main.css">
        <!-- rsmenu transitions CSS -->
        <link rel="stylesheet" type="text/css" href="css\rsmenu-transitions.css">
        <!-- magnific popup css -->
        <link rel="stylesheet" type="text/css" href="css\magnific-popup.css">
		<!-- flaticon css  -->
        <link rel="stylesheet" type="text/css" href="fonts\flaticon.css">
        <!-- timeline css -->
        <link rel="stylesheet" type="text/css" href="css\timeline.css">
        <!-- style css -->
        <link rel="stylesheet" type="text/css" href="style.css">
        <!-- responsive css -->
        <link rel="stylesheet" type="text/css" href="css\responsive.css">
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="inner-page">
        <!--Preloader area start here-->
        <div class="book_preload">
            <div class="book">
                <div class="book__page"></div>
                <div class="book__page"></div>
                <div class="book__page"></div>
            </div>
        </div>
		<!--Preloader area end here-->
		
        <!--Full width header Start-->
		<div class="full-width-header">
			<!-- Toolbar Start -->
        <?php include "includes/applybar.php"; ?>
			<!-- Toolbar End -->

			<!--Header Start-->
        <?php include "includes/headerSecondary.php"; ?>
			<!--Header End-->

		</div>
        <!--Full width header End-->
		
		<!-- Breadcrumbs Start -->
		<div class="rs-breadcrumbs bg7 breadcrumbs-overlay">
		    <div class="breadcrumbs-inner">
		        <div class="container">
		            <div class="row">
		                <div class="col-md-12 text-center">
		                    <h1 class="page-title">Contact</h1>
		                    <ul>
		                        <li>
		                            <a class="active" href="MS_22.html">Home</a>
		                        </li>
		                        <li>Cantact</li>
		                    </ul>
		                </div>
		            </div>
		        </div>
		    </div><!-- .breadcrumbs-inner end -->
		</div>
		<!-- Breadcrumbs End -->
		
		<!-- Contact Section Start -->
		<div class="contact-page-section sec-spacer">
        	<div class="container">
        		<div id="googleMap"></div>
        		<div class="row contact-address-section">
    				<div class="col-md-4 pl-0">
    					<div class="contact-info contact-address">
    						<i class="fa fa-map-marker"></i>
    						<h4>Address</h4>
    						<p>503  Old Buffalo Street</p>
    						<p>Northwest #205, New York-3087</p>
    					</div>
    				</div>
    				<div class="col-md-4">
    					<div class="contact-info contact-phone">
    						<i class="fa fa-phone"></i>
    						<h4>Phone Number</h4>
    						<a href="tel\MS_66.html">+3453-909-6565</a>
    						<a href="tel\MS_67.html">+2390-875-2235</a>
    					</div>
    				</div>
    				<div class="col-md-4 pr-0">
    					<div class="contact-info contact-email">
    						<i class="fa fa-envelope"></i>
    						<h4>Email Address</h4>
    						<a href="mailto:infoname@gmail.com"><p>infoname@gmail.com</p></a>
    						<a href="#"><p>www.yourname.com</p></a>
        				</div>
        			</div>
        		</div>

        		<div class="contact-comment-section">
        			<h3>Leave Comment</h3>
                    <div id="form-messages"></div>
					<form id="contact-form" method="post" action="mailer.php">
						<fieldset>
							<div class="row">                                      
								<div class="col-md-6 col-sm-12">
									<div class="form-group">
										<label>First Name*</label>
										<input name="fname" id="fname" class="form-control" type="text">
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<div class="form-group">
										<label>Last Name*</label>
										<input name="lname" id="lname" class="form-control" type="text">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<div class="form-group">
										<label>Email*</label>
										<input name="email" id="email" class="form-control" type="email">
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<div class="form-group">
										<label>Subject *</label>
										<input name="subject" id="subject" class="form-control" type="text">
									</div>
								</div>
							</div>
							<div class="row"> 
								<div class="col-md-12 col-sm-12">    
									<div class="form-group">
										<label>Message *</label>
										<textarea cols="40" rows="10" id="message" name="message" class="textarea form-control"></textarea>
									</div>
								</div>
							</div>							        
							<div class="form-group mb-0">
								<input class="btn-send" type="submit" value="Submit Now">
							</div>
							   
						</fieldset>
					</form>						
        		</div>
        	</div>
        </div>
        <!-- Contact Section End -->     
       
        <!-- Partner Start -->
        <?php include 'includes/footer.php'; ?>

        <script>
            $('.rs-course').find('.current-menu-item').removeClass('current-menu-item current_page_item');
            $('.menu-course').addClass('current-menu-item current_page_item');
        </script>
    </body>
</html>