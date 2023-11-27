<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php


	if(isset($_GET['id'])) {
		$id = $_GET['id'];

		$getTheatres = $conn->query("SELECT * FROM theatres WHERE movie_id='$id'");
		$getTheatres->execute();

		$getAllTheatres = $getTheatres->fetchAll(PDO::FETCH_OBJ);
	}




?>

    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/tre_img.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs mb-2"><span class="mr-2"><a href="index.php">Home <i class="fa fa-chevron-right"></i></a></span> <span>Theatres <i class="fa fa-chevron-right"></i></span></p>
            <h1 class="mb-0 bread">Theatres</h1>
          </div>
        </div>
      </div>
    </section>
   
    <section class="ftco-section bg-light ftco-no-pt ftco-no-pb">
			<div class="container-fluid px-md-0">
				<div class="row no-gutters">
					<?php foreach($getAllTheatres as $theatre) : ?>
					<div class="col-lg-6">
						<div class="room-wrap d-md-flex">
							<a href="#" class="img" style="background-image: url(images/<?php echo $theatre->image; ?>);"></a>
							<div class="half left-arrow d-flex align-items-center">
								<div class="text p-4 p-xl-5 text-center">
									<!-- <p class="star mb-0"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></p> -->
									<p class="mb-0"><span class="price mr-1"><?php echo $theatre->price; ?></span> <span class="per">per ticket</span></p>
									<h3 class="mb-3"><a href="theatres/theatre-single.php?id=<?php echo $theatre->id; ?>"><?php echo $theatre->name; ?></a></h3>
									<ul class="list-accomodation">
										<li><span>Description:</span> <?php echo $theatre->desc; ?></li>
										<li><span>Genre:</span> <?php echo $theatre->genre; ?></li>
										<li><span>View:</span> <?php echo $theatre->view; ?></li>
										<li><span>Language:</span> <?php echo $theatre->lang; ?></li>
										<!-- <li><span>Malls:</span> <?php echo $theatre->mall_id; ?></li>
										<li><span>Movies:</span> <?php echo $theatre->movie_id; ?></li> -->
										<!-- <li><span>Mall:</span> <?php echo $theatre->movie_name; ?></li> -->
									</ul>
									<p class="pt-1"><a href="theatres/theatre-single.php?id=<?php echo $theatre->id; ?>" class="btn-custom px-3 py-2">Book tickets <span class="icon-long-arrow-right"></span></a></p>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
    			
    		</div>
			</div>
		</section>
		
<?php require "includes/footer.php"; ?>
