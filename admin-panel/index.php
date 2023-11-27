<?php require "layouts/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php 


if(!isset($_SESSION['adminname'])) {
  echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php' </script>";
}


//movie count

$movies = $conn->query("SELECT COUNT(*) AS count_movies FROM movies");
$movies->execute();

$allMovies = $movies->fetch(PDO::FETCH_OBJ);


//admin count

$admins = $conn->query("SELECT COUNT(*) AS count_admins FROM admins");
$admins->execute();

$allAdmins = $admins->fetch(PDO::FETCH_OBJ);


//theatres count

$theatres = $conn->query("SELECT COUNT(*) AS count_theatres FROM theatres");
$theatres->execute();

$allTheatres = $theatres->fetch(PDO::FETCH_OBJ);


//bookings count

$bookings = $conn->query("SELECT COUNT(*) AS count_bookings FROM bookings");
$bookings->execute();

$allBookings = $bookings->fetch(PDO::FETCH_OBJ);





?>
      <div class="row">
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Movies</h5>
              <!-- <h6 class="card-subtitle mb-2 text-muted">Bootstrap 4.0.0 Snippet by pradeep330</h6> -->
              <p class="card-text">number of movies: <?php echo $allMovies->count_movies; ?></p>
             
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">theatres</h5>
              
              <p class="card-text">number of theatres: <?php echo $allTheatres->count_theatres; ?></p>
              
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Admins</h5>
              
              <p class="card-text">number of admins: <?php echo $allAdmins->count_admins; ?></p>
              
            </div>
          </div>
        </div>
        

        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Bookings</h5>
              
              <p class="card-text">number of bookings: <?php echo $allBookings->count_bookings; ?></p>
              
            </div>
          </div>
        </div>
      </div>
<?php require "layouts/footer.php"; ?>
   
        
