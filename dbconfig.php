<?php
// Database configuration
$dbHost     = "localhost";
$dbUsername = "111";
$dbPassword = "2222";
$dbName     = "nessus_db";
 
// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
