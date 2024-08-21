<?php
$servername = "localhost";
$username = "autoship_test";
$password = "Fq+#0kET;q=6";
$dbname = "autoship_virtualrep";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
