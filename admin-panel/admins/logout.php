<?php


    session_start();
    session_unset();
    session_destroy();
    header("location: http://localhost/movie-booking/admin-panel/admins/login-admins.php");
