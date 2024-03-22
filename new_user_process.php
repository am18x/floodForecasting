<?php
// Replace these values with your actual database credentials
include 'db_connect.php';
// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user data from the form
$fname = $_POST['fname'];
$phoneNumber = $_POST["mob"];
$email = $_POST["email"];
$address = $_POST["address"];
$username = $_POST['username'];
$password = md5($_POST['password']);
$type = 1;

$photoName = $_FILES['photo']['name'];
$photoTmpName = $_FILES['photo']['tmp_name'];
$photoError = $_FILES['photo']['error'];

$targetDirectory = 'assets/uploads/';

if ($photoError === UPLOAD_ERR_OK) {
    $photoUniqueName = uniqid() . '_' . $photoName;
    $targetPath = $targetDirectory . $photoUniqueName;

    if (move_uploaded_file($photoTmpName, $targetPath)) {
        // File uploaded successfully, proceed with database insertion
        $sql = "INSERT INTO users (fname, mob, email, address, username, photo, password, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $fname, $phoneNumber, $email, $address, $username, $photoUniqueName, $password, $type);
        
        if ($stmt->execute()) {
            // Data inserted successfully
            header("location: login.php?registration=success");
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error moving the uploaded file.";
    }
} else {
    echo "File upload error: " . $photoError;
}

// Close the database connection
$conn->close();
?>