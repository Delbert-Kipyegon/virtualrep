<?php
$servername = "109.70.148.40";
$username = "autoship";
$password = "0Ub73i4]PnoBA@";
$dbname = "autoship_virtualrep";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";