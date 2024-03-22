<?php
session_start();
include 'db_connect.php'; // Include your database connection code

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepare and execute the DELETE query
    $delete_query = "DELETE FROM danger_zone WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param('i', $id);
    
    if ($stmt->execute()) {
        // Data removed successfully
        echo "Data removed successfully!";
    } else {
        // Error occurred while removing data
        echo "Error: Unable to remove data.";
    }

    $stmt->close();
} else {
    // Invalid or missing ID parameter
    echo "Error: Invalid request.";
}

$conn->close();
?>
