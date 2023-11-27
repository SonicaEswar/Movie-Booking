<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php 
if(!isset($_SESSION['adminname'])) {
    echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php' </script>";
}

$theatres = $conn->query("SELECT * FROM theatres");
$theatres->execute();
$allTheatres = $theatres->fetchAll(PDO::FETCH_OBJ);
?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4 d-inline">Theatres</h5>
                <a href="create-theatres.php" class="btn btn-primary mb-4 text-center float-right">Add Movie</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">name</th>
                            <th scope="col">image</th>
                            <th scope="col">price</th>
                            <th scope="col">desc</th>
                            <th scope="col">genre</th>
                            <th scope="col">view</th>
                            <th scope="col">lang</th>
                            <th scope="col">mall_id</th>
                            <th scope="col">movie_id</th>
                            <th scope="col">movie_name</th>
                            <th scope="col">status value</th>
                            <th scope="col">change status</th>
                            <th scope="col">delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($allTheatres as $theatre) : ?>
                            <tr>
                                <th scope="row"><?php echo $theatre->id; ?></th>
                                <td><?php echo $theatre->name; ?></td>
                                <td><?php echo $theatre->image; ?></td>
                                <td>$<?php echo $theatre->price; ?></td>
                                <td><?php echo $theatre->desc; ?></td>
                                <td><?php echo $theatre->genre; ?></td>
                                <td><?php echo $theatre->view; ?></td>
                                <td><?php echo $theatre->lang; ?></td>
                                <td><?php echo $theatre->mall_id; ?></td>
                                <td><?php echo $theatre->movie_id; ?></td>
                                <td><?php echo $theatre->movie_name; ?></td>
                                <td><?php echo $theatre->status; ?></td>
                                <td><a href="status-theatres.php?id=<?php echo $theatre->id; ?>" class="btn btn-warning text-white text-center">status</a></td>
                                <td><a href="delete-theatres.php?id=<?php echo $theatre->id; ?>" class="btn btn-danger text-center" onclick="return confirm('Are you sure you want to delete this theatre?')">Delete</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</div>

<?php require "../layouts/footer.php"; ?>
