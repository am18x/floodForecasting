<?php
include('db_connect.php');

if(isset($_POST['password']) && isset($_FILES['photo'])) {
    session_start();
    
    $password = md5($_POST['password']);
    $photoName = $_FILES['photo']['name'];
    $photoTmpName = $_FILES['photo']['tmp_name'];
    $photoError = $_FILES['photo']['error'];
    
    $targetDirectory = 'assets/uploads/';
    
    if ($photoError === UPLOAD_ERR_OK) {
        $photoUniqueName = uniqid() . '_' . $photoName;
        $targetPath = $targetDirectory . $photoUniqueName;
        
        if (move_uploaded_file($photoTmpName, $targetPath)) {
            // Update the photo column in the database
            $user_id = $_SESSION['login_id'];
            $updatePhotoQuery = "UPDATE users SET photo = '$photoUniqueName' WHERE id = '$user_id'";
            $conn->query($updatePhotoQuery);
        }
    }
    
    // Update the password column in the database
    $user_id = $_SESSION['login_id'];
    $updatePasswordQuery = "UPDATE users SET password = '$password' WHERE id = '$user_id'";
    $conn->query($updatePasswordQuery);
    
    header("location: home.php?update=success");// Return a success indicator
} else {
    echo 0; // Return an error indicator
}
?>
