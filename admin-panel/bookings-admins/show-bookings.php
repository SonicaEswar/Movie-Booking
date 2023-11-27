<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php 


if(!isset($_SESSION['adminname'])) {
  echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php' </script>";
}

$bookings =$conn->query("SELECT * FROM bookings");
$bookings->execute();

$allBookings =$bookings->fetchAll(PDO::FETCH_OBJ);


?>

          <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Bookings</h5>
            
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">show date</th>
                    <th scope="col">show time</th>
                    <th scope="col">email</th>
                    <th scope="col">phone number</th>
                    <th scope="col">full name</th>
                    <th scope="col">Number of people</th>
                    <th scope="col">status</th>
                    <th scope="col">payment</th>
                    <th scope="col">Movie name</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($allBookings as $booking) : ?>
                  <tr>
                    <td><?php echo $booking->showdate; ?></td>
                    <td><?php echo $booking->st; ?></td>
                    <td><?php echo $booking->email; ?></td>
                    <td><?php echo $booking->phone_number; ?></td>
                    <td><?php echo $booking->full_name; ?></td>
                    <td><?php echo $booking->nop; ?></td>
                    <td><?php echo $booking->status; ?></td>
                    <td>$<?php echo $booking->payment; ?></td>
                    <td>$<?php echo $booking->theatre_name; ?></td>
                    
                     <td><a href="status-bookings.php?id=<?php echo $booking->id; ?>" class="btn btn-warning text-white  text-center ">status</a></td>
                  </tr>
                  <?php endforeach; ?>
                 
                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>



<?php require "../layouts/footer.php"; ?>