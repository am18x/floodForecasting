<?php
// server.php

// Connect to the database
$connection = mysqli_connect("localhost", "root", "", "flood_db");

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query the database
$query = "SELECT distance FROM danger_zone";
$result = mysqli_query($connection, $query);

// Fetch data and send as JSON
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);

// Close the connection
mysqli_close($connection);
?>
