<?php

$dbhost = "localhost";
$dbname = "CRUD";
$dbusername = "root";
$dbpassword = "";

// Database connection
$conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname);

// Check connection
if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}
else{
    // Database Connected Successfully
}

?>