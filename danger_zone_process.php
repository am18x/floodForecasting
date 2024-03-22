
<?php
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
        $area = $_POST['area'];
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        $distance = $_POST['distance'];

        // Prepare and execute the SQL query to insert data into the "services" table
        $sql = "INSERT INTO danger_zone (area, latitude, longitude, distance) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $area, $lat, $lng, $distance);
        $stmt->execute();

        // Check if the data was successfully inserted
        if ($stmt->affected_rows > 0) {
            header("location:admin_index.php");
        } else {
            echo "Error: " . $conn->error;
        }
?>