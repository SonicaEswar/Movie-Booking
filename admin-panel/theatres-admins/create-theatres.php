<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php
if (!isset($_SESSION['adminname'])) {
    echo "<script>window.location.href='" . ADMINURL . "/admins/login-admins.php' </script>";
}

$movies = $conn->query("SELECT * FROM movies");
$movies->execute();
$allMovies = $movies->fetchAll(PDO::FETCH_OBJ);

if (isset($_POST['submit'])) {
    if (empty($_POST['name']) || empty($_POST['price']) || empty($_POST['desc']) || empty($_POST['genre']) || empty($_POST['view']) || empty($_POST['lang']) || empty($_POST['movie_name']) || empty($_POST['movie_id'])) {
        echo "<script>alert('one or more inputs are empty')</script>";
    } else {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $desc = $_POST['desc'];
        $genre = $_POST['genre'];
        $view = $_POST['view'];
        $lang = $_POST['lang'];
        $movie_name = $_POST['movie_name'];
        $movie_id = $_POST['movie_id'];
        $image = $_FILES['image']['name'];

        $dir = "theatre_images/" . basename($image);

        $insert = $conn->prepare("INSERT INTO theatres (name, price, `desc`, genre, view, lang, mall_id, movie_id, movie_name, status, created_at, image)
        VALUES (:name, :price, :desc, :genre, :view, :lang, 0, :movie_id, :movie_name, 1, CURRENT_TIMESTAMP(), :image)");

        $insert->execute([
            ":name" => $name,
            ":price" => $price,
            ":desc" => $desc,
            ":genre" => $genre,
            ":view" => $view,
            ":lang" => $lang,
            ":movie_id" => $movie_id,
            ":movie_name" => $movie_name,
            ":image" => $image
        ]);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $dir)) {
            header("location: show-theatres.php");
        }
    }
}
?>




       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Theatres</h5>
          <form method="POST" action="create-theatres.php" enctype="multipart/form-data">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="name" id="form2Example1" class="form-control" placeholder="name" />
                 
                </div>
                <div class="form-outline mb-4 mt-4">
                  <input type="file" name="image" id="form2Example1" class="form-control" />
                 
                </div>  
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="price" id="form2Example1" class="form-control" placeholder="price" />
                 
                </div> 
                 <div class="form-outline mb-4 mt-4">
                  <input type="text" name="desc" id="form2Example1" class="form-control" placeholder="description" />
                 
                </div> 
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="genre" id="form2Example1" class="form-control" placeholder="genre" />
                 
                </div> 
                
               <div class="form-outline mb-4 mt-4">
                <input type="text" name="view" id="form2Example1" class="form-control" placeholder="view" />
               
               </div>
               <div class="form-outline mb-4 mt-4">
                  <input type="text" name="lang" id="form2Example1" class="form-control" placeholder="language" />
                 
                </div>  
                <!-- <select name="mall_id" class="form-control">
                <option>Choose mall Name</option>
                <?php foreach($allMalls as $mall) : ?>
                  <option value="<?php echo $mall->id; ?>" ><?php echo $mall->name; ?></option>
                <?php endforeach; ?>
               </select> -->
               <select name="status" style="margin-top: 15px;" class="form-control">
                    <option>Malls</option>
                    <option value="">Orion Mall</option>
                    <option value="">Mantri Sqaure</option>
                    <option value="">Lulu Mall</option>
                </select>
               
               <!-- <select name="movie_name" class="form-control">
                <option>Choose MOVIE Name</option>
                <?php foreach($allMovies as $movie) : ?>
                  <option value="<?php echo $movie->name; ?>" ><?php echo $movie->name; ?></option>
                <?php endforeach; ?>
               </select>
               <br>
   
               <select name="movie_id" class="form-control">
                <option>Choose Same MOVIE ID</option>
                <?php foreach($allMovies as $movie) : ?>
                  <option value="<?php echo $movie->id; ?>"><?php echo $movie->name; ?></option>
                <?php endforeach; ?>
                
               </select>
               <br> -->
               <div class="form-outline mb-4 mt-4">
                  <input type="text" name="movie_name" id="form2Example1" class="form-control" placeholder="movie_name" />
                 
                </div>  
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="movie_id" id="form2Example1" class="form-control" placeholder="movie_id" />
                 
                </div>  

                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>

          
              </form>

            </div>
          </div>
        </div>
      </div>
<?php require "../layouts/footer.php"; ?>