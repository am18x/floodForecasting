<!DOCTYPE html>
<html lang="en">
<?php session_start() ?>
<?php 
include 'db_connect.php';
ob_start();
if(!isset($_SESSION['system'])){
$system = $conn->query("SELECT * FROM system_settings")->fetch_array();
foreach($system as $k => $v){
  $_SESSION['system'][$k] = $v;
}
}
ob_end_flush();

?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="index.css">
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=geometry"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
  <title>Shelter Form</title>
  <style>
    body{
      margin: 0; /* Remove default margin */
    padding: 0; /* Remove default padding */
    background-image: url('assets/uploads/bg.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    }
    
    .navbar-nav {
    margin-left: 60%;
    }
    .form{
      margin-left: 10%;
      margin-right: 10%;
    }
    h2{
      color: #fff;
    }
    .form-label{
      color: #fff;
    }
    .card{
      background-color: rgba(255, 255, 255, 0.3);
    }
    .profile-panel {
    position: fixed;
    z-index: 1;
    top: 0;
    right: -25%; /* Start outside the viewport on the right */
    width: 25%;
    height: 50%;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    transition: right 0.3s ease-in-out;
}

/* Show the panel */
.profile-panel.active {
    right: 0; /* Slide in from the right */
}
.close-button{
  margin-left: 3px;
}
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
      <a class="navbar-brand btn btn-info" href="index.php">
          <img src="https://w7.pngwing.com/pngs/326/48/png-transparent-hurricane-katrina-flood-control-manhattan.png" width="60" height="40" alt="">
          Flood Forecasting
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
        <?php
            if(isset($_SESSION['login_id']))
              echo "
                <a class='nav-link btn me-md-2' href='home.php'>Home</a>
                <div class='profile-panel'><button class='btn close-button'><i class='fa-solid fa-xmark'></i></button><ul><li><a class='nav-link btn me-md-2' href='update_user.php'>Profile</a></li><br><li><a class='nav-link btn me-md-2' href='ajax.php?action=logout'>Logout</a></li></ul></div>
                <button class='nav-link btn me-md-2 profile-button' style='width: 35px;'><i class='fa-solid fa-user'></i></button>";
                if(!isset($_SESSION['login_id']))
                echo "<a class='nav-link btn me-md-2' style='width: 90%; margin-left: -40%' href='help.php'>If you want help then click here</a>
                <a class='nav-link btn me-md-2' href='contact_us.php'>Contact Us</a>
                <a href='login.php' class='nav-link btn me-md-2'>Login</a>";
            ?>
        </div>
      </div>

    </div>
  </nav>

    <div  class="form mb-1 mb-sm-0">
      <div class='card'>
        <div class="card-body">
          <form id="shelterform" enctype="multipart/form-data">
            <center><h2>Shelter</h2></center>
            <label class="control-label form-label" for="oname">Owner Name:</label>
            <input type="text" class="form-control" id="oname" name="oname" value="<?php echo getOwnerName(); ?>" required>

            <label class="control-label form-label" for="payment">Payment:</label>
                  <select class="form-select" id="payment" name="payment" required>
                    <option value="Paid">Paid</option>
                    <option value="Free">Free</option>
                  </select>
                  
            <label class="control-label form-label" for="rate">Rate per Room:</label>
            <input type="text" class="form-control" id="rate" name="rate" required>

            <label class="control-label form-label" for="tNumRoom">Number of Rooms:</label>
            <input type="text" class="form-control" id="tNumRoom" name="tNumRoom" required>

            <label class="control-label form-label" for="aNumRoom">Available Rooms:</label>
            <input type="text" class="form-control" id="aNumRoom" name="aNumRoom" required>

            <label class="control-label form-label" for="address">Address:</label>
            <textarea class="form-control" name="address" id="address" required><?php echo getAddress(); ?></textarea>

            <label class="control-label form-label" for="mob">Mobile Number:</label>
            <input type="tel" class="form-control" id="mob" name="mob" value="<?php echo getMobileNumber(); ?>" required><br>

            <center><button type="submit" class="btn btn-bg btn-block btn-wave col-md-2" style='background-color: #E84F62'>Save</button></center>

            <script>
            document.getElementById("shelterform").addEventListener("submit", function (event) {
              event.preventDefault();

              const form = event.target;
              const formData = new FormData(form);

              fetch("shelter.php", {
                method: "POST",
                body: formData
              })
              .then(response => response.text())
              .then(message => {
                alert(message);
                form.reset(); // Optional: Clear the form after successful submission
              })
              .catch(error => console.error("Error:", error));
            });
            </script>
            <?php
              function getOwnerName() {
                if(isset($_SESSION['login_id'])) {
                    global $conn;
                    $userId = $_SESSION['login_id'];
            
                    $stmt = $conn->prepare("SELECT fname FROM users WHERE id = ?");
                    $stmt->bind_param("i", $userId);
            
                    $stmt->execute();
                    $stmt->bind_result($fname);
            
                    if ($stmt->fetch()) {
                        return $fname;
                    }
            
                    $stmt->close();
                }
            
                return "";
              }
              function getAddress() {
                if(isset($_SESSION['login_id'])) {
                    global $conn;
                    $userId = $_SESSION['login_id'];
            
                    $stmt = $conn->prepare("SELECT address FROM users WHERE id = ?");
                    $stmt->bind_param("i", $userId);
            
                    $stmt->execute();
                    $stmt->bind_result($address);
            
                    if ($stmt->fetch()) {
                        return $address;
                    }
            
                    $stmt->close();
                }
            
                return ""; // Return empty string if not found
              }
              function getMobileNumber() {
                if(isset($_SESSION['login_id'])) {
                    global $conn;
                    $userId = $_SESSION['login_id'];
            
                    $stmt = $conn->prepare("SELECT mob FROM users WHERE id = ?");
                    $stmt->bind_param("i", $userId);
            
                    $stmt->execute();
                    $stmt->bind_result($mob);
            
                    if ($stmt->fetch()) {
                        return $mob;
                    }
            
                    $stmt->close();
                }
            
                return ""; // Return empty string if not found
            }
            ?>
          </form>    
        </div>
      </div>
    </div>
    <script>
    // Function to toggle the profile panel
    function toggleProfilePanel() {
        var panel = document.querySelector('.profile-panel');
        panel.classList.toggle('active');
    }

    // Attach click event to the "Profile" button
    var profileButton = document.querySelector('.profile-button');
    profileButton.addEventListener('click', toggleProfilePanel);

    // Attach click event to the close button
    var closeButton = document.querySelector('.close-button');
    closeButton.addEventListener('click', toggleProfilePanel);
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var paymentSelect = document.getElementById("payment");
    var rateInput = document.getElementById("rate");

    // Add event listener to the payment dropdown
    paymentSelect.addEventListener("change", function() {
        if (paymentSelect.value === "Paid") {
            rateInput.disabled = false;
            rateInput.required = true;
        } else if (paymentSelect.value === "Free") {
            rateInput.disabled = true;
            rateInput.required = false;
            rateInput.value = "0"; // Set value to 0 when disabled
        }
    });
});
</script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>