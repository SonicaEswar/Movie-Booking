<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>
<?php


if(isset($_GET['id'])){

  $id = $_GET['id'];

  $movie = $conn->query("SELECT * FROM movies WHERE id='$id'");
  $movie->execute();

  $movieSingle =$movie->fetch(PDO::FETCH_OBJ);


  if(isset($_POST['submit'])){
    if(empty($_POST['name']) OR empty($_POST['description'])OR empty($_POST['genre'])) {
      echo "<script>alert('one or more inputs are empty')</script>";
    } else {

      $name = $_POST['name'];
      $description = $_POST['description'];
      $genre = $_POST['genre'];

      $update = $conn->prepare("UPDATE movies SET name = :name, description = :description, genre = :genre WHERE id='$id'");

      $update->execute([
      ":name" => $name,
      ":description" => $description,
      ":genre" => $genre,
    ]);

    header("location: show-movies.php");
  } 
}



}



?>
       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Update MOVIE</h5>
          <form method="POST" action="update-movies.php?id=<?php echo $id; ?>" >
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <input type="text" value="<?php echo $movieSingle->name; ?>"  name="name" id="form2Example1" class="form-control" placeholder="name" />
                 
                </div>
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Description</label>
                  <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3">
                  <?php echo $movieSingle->description; ?>
                  </textarea>
                </div>

                <div class="form-outline mb-4 mt-4">
                  <label for="exampleFormControlTextarea1">Genre</label>

                  <input type="text" value="<?php echo $movieSingle->genre; ?>" name="genre" id="form2Example1" class="form-control"/>
                 
                </div>

      
                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">update</button>

          
              </form>

            </div>
          </div>
        </div>
      </div>
<?php require "../layouts/footer.php"; ?>