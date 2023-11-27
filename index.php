<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php


	//movies
	$movies = $conn->query("SELECT * FROM movies WHERE status = 1");
	$movies->execute();

	$allMovies = $movies->fetchAll(PDO::FETCH_OBJ);


	//theatres
	$theatres = $conn->query("SELECT * FROM theatres WHERE status = 1");
	$theatres->execute();

	$allTheatres = $theatres->fetchAll(PDO::FETCH_OBJ);


?>

    <div class="hero-wrap js-fullheight" style="background-image: url('images/tre_img.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-7 ftco-animate">
          	<h2 class="subheading">Welcome to Movie Sprint</h2>
          	<h1 class="mb-4">Don't miss a single frame.</h1>
            <!--<p><a href="#" class="btn btn-primary">Learn more</a> <a href="<?php echo APPURL;?>/contact.php" class="btn btn-white">Contact us</a></p>-->
          </div>
        </div>
      </div>
    </div>

  
    <section class="ftco-section ftco-services">
    	<div class="container">
    		<div class="row">
				<?php foreach($allMovies as $movie) : ?>
					<div class="col-md-4 d-flex services align-self-stretch px-4 ftco-animate">
						<div class="d-block services-wrap text-center">
						<div class="img" style="background-image: url(<?php echO MOVIEIMAGES; ?>/<?php echo $movie->image; ?>);"></div>
						<div class="media-body py-4 px-3">
							<h3 class="heading"><?php echo $movie->name; ?></h3>
							<p><?php echo $movie->description; ?></p>
							<p>Genre: <?php echo $movie->genre; ?>.</p>
							<p><a href="theatres.php?id=<?php echo $movie->id; ?>" class="btn btn-primary">View Theatres</a></p>
						</div>
						</div>      
					</div>
				<?php endforeach; ?>
        
        	</div>
    	</div>
    </section>

    <section class="ftco-section bg-light">
			<div class="container-fluid px-md-0">
				<div class="row no-gutters justify-content-center pb-5 mb-3">
          <div class="col-md-7 heading-section text-center ftco-animate">
            <h2>Now Showing</h2>
          </div>
        </div>
				<div class="row no-gutters">
				<?php foreach($allTheatres as $theatre) : ?>
    				<div class="col-lg-6">
    					<div class="room-wrap d-md-flex">
    						<a href="#" class="img" style="background-image: url(<?php echO THEATRESIMAGES; ?>/<?php echo $theatre->image; ?>);"></a>
    						<div class="half left-arrow d-flex align-items-center">
    							<div class="text p-4 p-xl-5 text-center">
    								<p class="star mb-0"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></p>
    								<!-- <p class="mb-0"><span class="price mr-1">$120.00</span> <span class="per">per night</span></p> -->
	    							<h3 class="mb-3"><a href="<?php echo APPURL; ?>/theatres/theatre-single.php?id=<?php echo $theatre->id; ?>"><?php echo $theatre->name; ?></a></h3>
	    							<ul class="list-accomodation">
	    								<li><span>Description:</span> <?php echo $theatre->desc; ?></li>
	    								<li><span>Genre:</span><?php echo $theatre->genre; ?></li>
	    								<li><span>View:</span> <?php echo $theatre->view; ?></li>
	    								<li><span>Language:</span> <?php echo $theatre->lang; ?></li>
										<li><span>Price Per Ticket:</span> $<?php echo $theatre->price; ?></li>
	    							</ul>
	    							<p class="pt-1"><a href="<?php echo APPURL; ?>/theatres/theatre-single.php?id=<?php echo $theatre->id; ?>" class="btn-custom px-3 py-2">Book tickets<span class="icon-long-arrow-right"></span></a></p>
    							</div>
    						</div>
    					</div>
    				</div>
				<?php endforeach; ?>
    		</div>
			</div>
		</section>



    <section class="ftco-section bg-light">
			<div class="container">
				<div class="row no-gutters">
					<div class="col-md-6 wrap-about">
						<div class="img img-2 mb-4" style="background-image: url(images/tre_img.jpg);">
						</div>
						<h2>The most recommended Online Movie Ticket Booking</h2>
						<p>MovieSprint is widely regarded as the most recommended movie booking app for a multitude of compelling reasons, its user-friendly interface and seamless navigation make it incredibly convenient for users to browse and select from a vast array of movie options, showtimes, and theaters. This app also offers a host of exclusive features, such as seat selection, real-time ticket availability, and secure payment options, ensuring a hassle-free booking experience, provides users with valuable insights into upcoming movies, allowing them to stay informed about the latest releases and book tickets in advance.</p>
					</div>
					<div class="col-md-6 wrap-about ftco-animate">
	          <div class="heading-section">
	          	<div class="pl-md-5">
		            <h2 class="mb-2">What we offer</h2>
	            </div>
	          </div>
	          <div class="pl-md-5">
							<p>Offers a host of exclusive features, such as seat selection, real-time ticket availability, and secure payment options, ensuring a hassle-free booking experience</p>
							<div class="row">
		            <div class="services-2 col-lg-6 d-flex w-100">
		              <div class="icon d-flex justify-content-center align-items-center">
		            		<span class="flaticon-diet"></span>
		              </div>
		              <div class="media-body pl-3">
		                <h3 class="heading">Beverages</h3>
		                <p>Offers a host of exclusive features like seat selection, real-time ticket availability, secure payment options</p>
		              </div>
		            </div> 
		            <div class="services-2 col-lg-6 d-flex w-100">
		              <div class="icon d-flex justify-content-center align-items-center">
		            		<span class="flaticon-workout"></span>
		              </div>
		              <div class="media-body pl-3">
		                <h3 class="heading">Food & Snacks</h3>
		                <p>Offers a host of exclusive features like seat selection, real-time ticket availability, secure payment options</p>
		              </div>
		            </div>
		            <div class="services-2 col-lg-6 d-flex w-100">
		              <div class="icon d-flex justify-content-center align-items-center">
		            		<span class="flaticon-diet-1"></span>
		              </div>
		              <div class="media-body pl-3">
		                <h3 class="heading">Hassle Free Booking</h3>
		                <p>Offers a host of exclusive features like seat selection, real-time ticket availability, secure payment options</p>
		              </div>
		            </div>      
		            <div class="services-2 col-lg-6 d-flex w-100">
		              <div class="icon d-flex justify-content-center align-items-center">
		            		<span class="flaticon-first"></span>
		              </div>
		              <div class="media-body pl-3">
		                <h3 class="heading">Air Conditioning</h3>
		                <p>Offers a host of exclusive features like seat selection, real-time ticket availability, secure payment options</p>
		              </div>
		            </div>
		            <div class="services-2 col-lg-6 d-flex w-100">
		              <div class="icon d-flex justify-content-center align-items-center">
		            		<span class="flaticon-first"></span>
		              </div>
		              <div class="media-body pl-3">
		                <h3 class="heading">Free Wifi</h3>
		                <p>Offers a host of exclusive features like seat selection, real-time ticket availability, secure payment options</p>
		              </div>
		            </div> 
		            <div class="services-2 col-lg-6 d-flex w-100">
		              <div class="icon d-flex justify-content-center align-items-center">
		            		<span class="flaticon-first"></span>
		              </div>
		              <div class="media-body pl-3">
		                <h3 class="heading">Best deals & vouchers</h3>
		                <p>Offers a host of exclusive features like seat selection, real-time ticket availability, secure payment options</p>
		              </div>
		            </div> 
		            <div class="services-2 col-lg-6 d-flex w-100">
		              <div class="icon d-flex justify-content-center align-items-center">
		            		<span class="flaticon-first"></span>
		              </div>
		              <div class="media-body pl-3">
		                <h3 class="heading">Best Experience</h3>
		                <p>Offers a host of exclusive features like seat selection, real-time ticket availability, secure payment options</p>
		              </div>
		            </div> 
		            <div class="services-2 col-lg-6 d-flex w-100">
		              <div class="icon d-flex justify-content-center align-items-center">
		            		<span class="flaticon-first"></span>
		              </div>
		              <div class="media-body pl-3">
		                <h3 class="heading">Secure Payment</h3>
		                <p>Offers a host of exclusive features like seat selection, real-time ticket availability, secure payment options</p>
		              </div>
		            </div>
		          </div>  
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<section class="ftco-intro" style="background-image: url(images/tre_img.jpg);" data-stellar-background-ratio="0.5">
			<div class="overlay"></div>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-9 text-center">
						<h2>Ready to get started</h2>
						<p class="mb-4">It’s safe to book online with us! Enjoy your movie experience.</p>
						<!--<p class="mb-0"><a href="<?php echo APPURL;?>/about.php" class="btn btn-primary px-4 py-3">Learn More</a> <a href="<?php echo APPURL;?>/contact.php" class="btn btn-white px-4 py-3">Contact us</a></p> -->
					</div>
				</div>
			</div>
		</section>


<?php require "includes/footer.php"; ?>