<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ste";

// Connect to MySQL without specifying the database
$conn = @new mysqli($servername, $username, $password);

if ($conn->connect_errno) {
    die("<p style='color:red;'>Connection failed: " . $conn->connect_error . "</p>");
}

// Create the database if it doesn't exist
if (!$conn->query("CREATE DATABASE IF NOT EXISTS `$dbname`")) {
    die("<p style='color:red;'>Database creation failed: " . $conn->error . "</p>");
}

// Select the database
if (!$conn->select_db($dbname)) {
    die("<p style='color:red;'>Cannot select database: " . $conn->error . "</p>");
}
?>