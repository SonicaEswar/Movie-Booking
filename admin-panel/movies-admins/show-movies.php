<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php 


if(!isset($_SESSION['adminname'])) {
  echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php' </script>";
}

$movies =$conn->query("SELECT * FROM movies");
$movies->execute();

$allMovies =$movies->fetchAll(PDO::FETCH_OBJ);


?>

      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Movies</h5>
             <a  href="create-movies.php" class="btn btn-primary mb-4 text-center float-right">Create MOVIES</a>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">name</th>
                    <th scope="col">genre</th>
                    <th scope="col">status value</th>
                    <th scope="col">change status</th>
                    <th scope="col">update</th>
                    <th scope="col">delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($allMovies as $movie) : ?>
                    <tr>
                      <th scope="row"><?php echo $movie->id; ?></th>
                      <td><?php echo $movie->name; ?></td>
                      <td><?php echo $movie->genre; ?></td>
                      <td><?php echo $movie->status; ?></td>

                      <td><a  href="status-movies.php?id=<?php echo $movie->id; ?> " class="btn btn-warning text-white text-center ">status</a></td>
                      <td><a  href="update-movies.php?id=<?php echo $movie->id; ?>" class="btn btn-warning text-white text-center ">Update </a></td>
                      <td><a href="delete-movies.php?id=<?php echo $movie->id; ?>" class="btn btn-danger  text-center ">Delete </a></td>
                    </tr>
                  <?php endforeach; ?>
                  
                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>


<?php require "../layouts/footer.php"; ?>