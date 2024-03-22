<?php
include('db_connect.php');

if(isset($_POST['password'])) {
    session_start();
    
    $password = md5($_POST['password']);
    
    // Update the password column in the database
    $user_id = $_SESSION['login_id'];
    $updatePasswordQuery = "UPDATE admin SET password = '$password' WHERE id = '$user_id'";
    $conn->query($updatePasswordQuery);
    
    header("location: admin_index.php?registration=success");// Return a success indicator
} else {
    echo 0; // Return an error indicator
}
?>
