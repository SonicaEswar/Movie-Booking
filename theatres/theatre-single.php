<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch theatre details
    $theatre = $conn->query("SELECT * FROM theatres WHERE status = 1 AND id='$id'");
    $theatre->execute();
    $singleTheatre = $theatre->fetch(PDO::FETCH_OBJ);

    // Grabbing utilities
    $utilities = $conn->query("SELECT * FROM utilities WHERE theatre_id='$id'");
    $utilities->execute();
    $allUtilities = $utilities->fetchAll(PDO::FETCH_OBJ);

    // Fetch show times for the selected mall
    $selectedMallId = $singleTheatre->mall_id;
    // $showTimesQuery = $conn->query("SELECT * FROM show_times WHERE status = 1 AND mall_id='$selectedMallId'");
    // $showTimes = $showTimesQuery->fetchAll(PDO::FETCH_OBJ);
	$showTimesQuery = $conn->query("SELECT show_times.*, theatres.name AS theatre_name
			FROM show_times
			INNER JOIN theatres ON show_times.theatre_id = theatres.id
			WHERE show_times.status = 1 AND show_times.mall_id='$selectedMallId'");
	$showTimes = $showTimesQuery->fetchAll(PDO::FETCH_OBJ);

    if (isset($_POST['submit'])) {
        if (empty($_POST['email']) || empty($_POST['phone_number']) || empty($_POST['full_name'])
            || empty($_POST['showdate']) || empty
		($_POST['ttre']) || empty($_POST['st']) || empty($_POST['nop'])) {
            echo "<script>alert('One or more inputs are empty')</script>";
        } else {
            $showdate = date('Y-m-d', strtotime($_POST['showdate']));

            $ttre = $_POST['ttre'];
            $st = $_POST['st'];
            $nop = $_POST['nop'];
            $email = $_POST['email'];
            $phone_number = $_POST['phone_number'];
            $full_name = $_POST['full_name'];
            $movie_name = $singleTheatre->movie_name;
            $theatre_name = $singleTheatre->name;
            $user_id = $_SESSION['id'];
            $status = "Pending";
            $payment = $singleTheatre->price;
            $_SESSION['price'] = $singleTheatre->price * $nop;
            $today = date("Y-m-d");
			$current_time = date('H:i:s');


            // Check if the selected show date is in the past
            if (strtotime($showdate) < strtotime($today)) {
                echo "<script>alert('Pick a date that is not in the past, starting from today')</script>";
            } else {
				if ($showdate == $today && $st < $current_time) {
					echo "<script>alert('Show time cannot be in the past. Please select a valid show time.')</script>";
				} else {
                // Check if the number of selected seats matches the number of persons
                $selectedSeats = isset($_POST['selected_seats']) ? $_POST['selected_seats'] : [];
                if (count($selectedSeats) != $nop) {
                    echo "<script>alert('Please select exactly $nop seats for booking.')</script>";
                } else {
						// Check if the selected seats are available for the chosen show time
						$selectedSeatsQuery = $conn->prepare("SELECT * FROM bookings 
							WHERE showdate=:showdate AND ttre=:ttre AND st=:st AND status='Successful'");
						$selectedSeatsQuery->execute([
							':showdate' => $showdate,
							':ttre' => $ttre,
							':st' => $st,
						]);
						$selectedSeatsResult = $selectedSeatsQuery->fetchAll(PDO::FETCH_OBJ);

						$selectedSeatsArray = [];
						foreach ($selectedSeatsResult as $row) {
							$rowSeats = explode(',', $row->selected_seats);
							$selectedSeatsArray = array_merge($selectedSeatsArray, $rowSeats);
						}

						$intersect = array_intersect($selectedSeatsArray, $selectedSeats);

						if (!empty($intersect)) {
							echo "<script>alert('Some selected seats are already booked. Please choose different seats.')</script>";
						} else {
							// Insert booking details into the database
							$stmt = $conn->prepare("CALL InsertBooking(:showdate, :ttre, :st, :nop, :email, :phone_number, :full_name, :movie_name, :theatre_name, :status, :payment, :user_id, :selected_seats, :payment_status)");

							$stmt->bindParam(':showdate', $showdate, PDO::PARAM_STR);
							$stmt->bindParam(':ttre', $ttre, PDO::PARAM_INT);
							$stmt->bindParam(':st', $st, PDO::PARAM_INT);
							$stmt->bindParam(':nop', $nop, PDO::PARAM_INT);
							$stmt->bindParam(':email', $email, PDO::PARAM_STR);
							$stmt->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
							$stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
							$stmt->bindParam(':movie_name', $movie_name, PDO::PARAM_STR);
							$stmt->bindParam(':theatre_name', $theatre_name, PDO::PARAM_STR);
							$stmt->bindValue(':status', 'Successful', PDO::PARAM_STR);
							$paymentValue = $_SESSION['price'];
							$stmt->bindParam(':payment', $paymentValue, PDO::PARAM_INT);

							$userIDValue = $user_id;
							$stmt->bindParam(':user_id', $userIDValue, PDO::PARAM_INT);

							$selectedSeatsValue = implode(',', $selectedSeats);
							$stmt->bindParam(':selected_seats', $selectedSeatsValue, PDO::PARAM_STR);

							$stmt->bindParam(':payment_status', $status, PDO::PARAM_STR);
							$status = 'Successful';

							$stmt->execute();
							foreach ($selectedSeats as $selectedSeat) {
								$seatStatus = 'Booked'; // Assuming newly booked seats have 'Booked' status
								$seatInsertQuery = $conn->prepare("INSERT INTO seats (seat_number, status) VALUES (:seat_number, :status)");
								$seatInsertQuery->bindParam(':seat_number', $selectedSeat, PDO::PARAM_STR);
								$seatInsertQuery->bindParam(':status', $seatStatus, PDO::PARAM_STR);
								$seatInsertQuery->execute();
							}

							echo "<script>window.location.href='" . APPURL . "/theatres/pay.php'</script>";

						}
					}
				}
			}

        }
    }
} else {
    echo "<script>window.location.href='" . APPURL . "/404.php' </script>";
}


// Assuming you are fetching these values from the form submission or database
$showdate = isset($_POST['showdate']) ? $_POST['showdate'] : ''; // Change accordingly
$ttre = isset($_POST['ttre']) ? $_POST['ttre'] : ''; // Change accordingly
$st = isset($_POST['st']) ? $_POST['st'] : ''; // Change accordingly

// Function to get available seats based on show date, theatre, and show time

function getAvailableSeats($showdate, $ttre, $st)
{
    global $conn;

    // Fetch booked seats for the given show date, theatre, and show time with successful payment
    $selectedSeatsQuery = $conn->prepare("SELECT * FROM bookings 
        WHERE showdate=:showdate AND ttre=:ttre AND st=:st AND payment_status='Successful'");
    $selectedSeatsQuery->execute([
        ':showdate' => $showdate,
        ':ttre' => $ttre,
        ':st' => $st,
    ]);

    $selectedSeatsResult = $selectedSeatsQuery->fetchAll(PDO::FETCH_OBJ);

    // Extract booked seats from the result
    $bookedSeats = [];
    foreach ($selectedSeatsResult as $row) {
        $bookedSeats = array_merge($bookedSeats, explode(',', $row->selected_seats));
    }

    // Assuming A1 to A20 are the available seats
    $allSeats = array_map(function ($num) {
        return "A$num";
    }, range(1, 20));

    // Calculate available seats by finding the difference between all seats and booked seats
    $availableSeats = array_diff($allSeats, $bookedSeats);

    return $availableSeats;
}

// Function to get booked seats based on show date, theatre, and show time
function getBookedSeats($showdate, $ttre, $st)
{
    global $conn;

    // Fetch booked seats for the given show date, theatre, and show time
    $selectedSeatsQuery = $conn->prepare("SELECT selected_seats FROM bookings 
        WHERE showdate=:showdate AND ttre=:ttre AND st=:st AND status='Successful'");
    $selectedSeatsQuery->execute([
        ':showdate' => $showdate,
        ':ttre' => $ttre,
        ':st' => $st,
    ]);
    $selectedSeatsResult = $selectedSeatsQuery->fetchAll(PDO::FETCH_OBJ);

    // Extract booked seats from the result
    $bookedSeats = [];
    foreach ($selectedSeatsResult as $row) {
        $bookedSeats = array_merge($bookedSeats, explode(',', $row->selected_seats));
    }

    return $bookedSeats;
}




?>














<div class="hero-wrap js-fullheight" style="background-image: url('<?php echo APPURL; ?>/images/<?php echo $singleTheatre->image; ?>');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-7 ftco-animate">
          	<h2 class="subheading">Welcome to Movie Sprint</h2>
          	<h1 class="mb-4"><?php echo $singleTheatre->name; ?></h1>
            <!-- <p><a href="#" class="btn btn-primary">Learn more</a> <a href="#" class="btn btn-white">Contact us</a></p> -->
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section ftco-book ftco-no-pt ftco-no-pb">
    	<div class="container">
	    	<div class="row justify-content-end">
	    		<div class="col-lg-7">
					<form action="theatre-single.php?id=<?php echo $id; ?>" method="POST" class="appointment-form" style="margin-top: -568px;">
						<h3 class="mb-3">Book Tickets</h3>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<input type="text" name="email" class="form-control" placeholder="Email">
								</div>
							</div>
						   
							<div class="col-md-12">
								<div class="form-group">
									<input type="text" name="full_name" class="form-control" placeholder="Full Name">
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<input type="text" name="phone_number" class="form-control" placeholder="Phone Number">
								</div>
							</div>

							<!-- <div class="col-md-6">
								<div class="form-group">
								<div class="input-wrap">
									<div class="icon"><span class="ion-md-calendar"></span></div>
										<input type="text" name="check_in" class="form-control appointment_date-check-in" placeholder="Check-In">
									</div>
								</div>
							</div> -->

							<div class="col-md-6">
								<div class="form-group">
									<div class="input-wrap">
										<div class="icon"><span class="ion-md-calendar"></span></div>
										<input type="text" name="showdate" class="form-control appointment_date-check-in" placeholder="Date">
									</div>
								</div>
							</div>
						
							<!-- <div class="col-md-6">
									<div class="form-group">
										<div class="icon"><span class="ion-md-calendar"></span></div>
										<input type="text" name="check_out" class="form-control appointment_date-check-out" placeholder="Check-Out">
									</div>
							</div> -->
							<!--<div class="col-md-6">
								<div class="form-group">
									<div class="input-wrap">
										<div class="icon"><span class="ion-md-clock"></span></div>
										<input type="text" name="ttre" class="form-control" placeholder="Select Theatre">
								</div>
							</div> -->

							<div class="col-md-6">
								<div class="form-group">
									<label for="ttre">Select Mall</label>
									<select name="ttre" class="form-control">
										<?php
										// Fetch theatres from the database
										$mallsQuery = $conn->query("SELECT * FROM malls WHERE status = 1");
										$malls = $mallsQuery->fetchAll(PDO::FETCH_OBJ);

										// Display theatres in the dropdown
										foreach ($malls as $mall) {
											echo "<option value='" . $mall->id . "'>" . $mall->name . "</option>";
										}
										?>
									</select>
								</div>
							</div>


							<div class="col-md-6">
								<div class="form-group">
									<label for="st">Select Show Time</label>
									<select name="st" class="form-control">
										<?php
										// Fetch theatres from the database
										$show_timesQuery = $conn->query("SELECT * FROM show_times WHERE status = 1");
										$show_times = $show_timesQuery->fetchAll(PDO::FETCH_OBJ);

										// Display theatres in the dropdown
										foreach ($show_times as $show_time) {
											echo "<option value='" . $show_time->id . "'>" . $show_time->show_time . "</option>";
										}
										?>
									</select>
								</div>
							</div>






							






							<div class="col-md-10">
								<div class="form-group">
									<div class="input-wrap">
										<div class="icon"><span class="ion-md-clock"></span></div>
										<input type="text" name="nop" class="form-control" placeholder="Number of persons">
								</div>
							</div>
						</div>

						<<div class="col-md-12">
							<div class="form-group text-center">
								<h3>Seat Selection</h3>
								<div id="seatMap" class="d-flex justify-content-center align-items-center flex-wrap">
									<?php
									// Get available and booked seats
									$availableSeats = getAvailableSeats($showdate, $ttre, $st);
									$bookedSeats = getBookedSeats($showdate, $ttre, $st);

									// Display seat checkboxes dynamically
									for ($row = 1; $row <= 5; $row++) :
									?>
										<div class="row mb-2">
											<?php for ($seat = 1; $seat <= 4; $seat++) :
												$seatNumber = ($row - 1) * 4 + $seat;
												$seatStatus = in_array("A$seatNumber", $bookedSeats) ? 'booked' : (in_array("A$seatNumber", $availableSeats) ? 'available' : 'unavailable');
											?>
												<div class="custom-control custom-checkbox mx-3 my-1">
													<input type="checkbox" class="custom-control-input" id="seat<?php echo $seatNumber; ?>" name="selected_seats[]" value="A<?php echo $seatNumber; ?>" <?php echo $seatStatus === 'booked' ? 'disabled' : ''; ?>>
													<label class="custom-control-label <?php echo $seatStatus; ?>" for="seat<?php echo $seatNumber; ?>">A<?php echo $seatNumber; ?></label>
												</div>
											<?php endfor; ?>
										</div>
									<?php endfor; ?>

									<!-- Screen -->
									<div class="screen text-center w-100 mt-3 mb-2">
										<p>Screen</p>
									</div>
								</div>
							</div>
						</div>






						
							<div class="col-md-12">
								<div class="form-group">
									<input type="submit" name="submit" value="Book and Pay Now" class="btn btn-primary py-3 px-5">
								</div>
							</div>
						</div>
				</form>
	    		</div>
	    	</div>
	    </div>
    </section>
   


  


    <section class="ftco-section bg-light">
			<div class="container">
				<div class="row no-gutters">
					<div class="col-md-6 wrap-about">
						<div class="img img-2 mb-4" style="background-image: url(<?php echo APPURL; ?>/images/tre_img.jpg);">
						</div>
						<h2>The most recommended Online Movie ticket booking website</h2>
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
						<?php foreach($allUtilities as $utility) : ?>
		            		<div class="services-2 col-lg-6 d-flex w-100">
		              		<div class="icon d-flex justify-content-center align-items-center">
		            				<span class="<?php echo $utility->icon; ?>"></span>
		              		</div>
		              		<div class="media-body pl-3">
		                		<h3 class="heading"><?php echo $utility->name; ?></h3>
		                		<p>
								<?php echo $utility->description; ?>
								</p>
		              		</div>
		            		</div> 
						<?php endforeach; ?>	
		          </div>  
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<section class="ftco-intro" style="background-image: url(<?php echo APPURL; ?>/images/tre_img.jpg);" data-stellar-background-ratio="0.5">
			<div class="overlay"></div>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-9 text-center">
						<h2>Ready to get started</h2>
						<p class="mb-4">It’s safe to book online with us! Enjoy your movie experience.</p>
						<!--<p class="mb-0"><a href="#" class="btn btn-primary px-4 py-3">Learn More</a> <a href="#" class="btn btn-white px-4 py-3">Contact us</a></p> -->
					</div>
				</div>
			</div>
		</section>



<?php require "../includes/footer.php";?>
