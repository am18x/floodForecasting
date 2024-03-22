<?php
// Connect to the database (replace with your credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flood_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch latitude and distance values
$sql = "SELECT latitude, longitude, distance FROM danger_zone";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>