<?php

try{
    //host , server name 
    define("HOST","localhost");

    //dbname
    define("DBNAME","movie-booking");

    //user name for db
    define("USER","root");

    //password no password for php my admin 
    define("PASS","");

    //creating an obj from pdo class  pdo is tool inside php to connect to db securely
    $conn = new PDO("mysql:host=".HOST.";dbname=".DBNAME."",USER,PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // for error msgs
    // if($conn == true) {
    //     echo "db connection is a success";
    // }else {
    //     echo "error";
    // }
} catch(PDOException $e)

{
    echo $e->getMessage();
}


//xampp is a server run (for backend development)
//sever - apache server   
// this file helps to connect to our own database