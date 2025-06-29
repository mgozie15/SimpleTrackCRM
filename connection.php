<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$databasename = "rawrear_ecommerce";
$servername = "localhost";
$username = "rawrear_ecommerce";
$password = "6789Asd@Tiger123!@#Pakistan@1947";

// Create connection
$conn = new mysqli($servername, $username, $password, $databasename);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
?>
