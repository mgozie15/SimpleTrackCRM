<?php

require '/home/rawrear/public_html/connection.php';

error_reporting(E_ALL); // Report all types of errors
ini_set('display_errors', 1);

// Value to insert (you can set this dynamically or randomly)
$number = rand(1, 100); // Insert a random number between 1 and 100

// Prepare and execute the insert query
$sql = "INSERT INTO test_cron (no) VALUES ($number)";

if ($conn->query($sql) === TRUE) {
    echo "Number inserted successfully: $number";
} else {
    echo "Error inserting number: " . $conn->error;
}

// Close the connection
$conn->close();
?>
