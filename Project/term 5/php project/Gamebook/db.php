<?php
// it will help me to connect to the db everytime needed
$servername = "localhost";
$username = "cng352user";
$password = "1234";
$dbname = "gamebook";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: please check if Xampp is working first" . $conn->connect_error);
}
?>
