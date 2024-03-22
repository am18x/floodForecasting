<?php
// Assuming you have already set up the database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flood_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user input
$owner_name = $_POST['oname'];
$type = $_POST['type'];
$address = $_POST['address'];
$mob = $_POST['mob'];
$inRate = $_POST['payment'];

if($inRate == 'Free')
{
    $rate = 0;
}
else
{
    $rate = $_POST['rate'];
}

// Prepare and execute the SQL query to insert data into the "services" table
$sql = "INSERT INTO food (oname, rate, type, address, mob) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $owner_name, $rate, $type, $address, $mob);
$stmt->execute();

// Check if the data was successfully inserted
if ($stmt->affected_rows > 0) {
    echo "Thank you for donating this things, it will help many people.";
} else {
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();
?>