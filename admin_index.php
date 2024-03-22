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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="index.css">
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=geometry"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
  <style>
    body{
      margin: 0; /* Remove default margin */
    padding: 0; /* Remove default padding */
    }
    .navbar-nav {
    margin-left: 70%;
    }
    .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #fff;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group input[type="file"] {
            padding: 10px;
        }

        .form-group button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  
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
                <div class='profile-panel'><button class='btn close-button' ><i class='fa-solid fa-xmark'></i></button><ul><li><a class='nav-link btn me-md-2'  href='update_admin.php'>Profile</a></li><br><li><a class='nav-link btn me-md-2' s href='ajax.php?action=logout'>Logout</a></li></ul></div>
                <button class='nav-link btn me-md-2 profile-button' style='width: 35px; '><i class='fa-solid fa-user'></i></button>";
                if(!isset($_SESSION['login_id']))
                echo "<a class='nav-link btn me-md-2' style=' width: 90%; margin-left: -40%' href='help.php'>If you want help then click here</a>
                <a class='nav-link btn me-md-2'  href='contact_us.php'>Contact Us</a>
                <a href='login.php' class='nav-link btn me-md-2' >Login</a>";
            ?>
        </div>
      </div>

    </div>
  </nav>
  <hr>

  <center><h4 class="navbar-brand btn btn-info">Welcome Admin</h4></center>
<br>
<?php
    // Check if registration success parameter is set
    if (isset($_GET['registration']) && $_GET['registration'] === "success") {
        echo '<script>alert("Password updated successful!");</script>';
    }
    ?>
  <div class="row">
    <div  class="col-sm-6">
        <div class='card' style="width: 30rem; margin-left: 3rem; background: gray;">
          <div class="card-body">
            <div class="form-container">
            <div class="container">
            <h2>Notify danger</h2>
            <form action="danger_zone_process.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                    <label for="area">Area Name: </label>
                    <input type="text" id="area" name="area" placeholder="Enter name of area..." required>
                </div>

                <div class="form-group">
                    <label for="lat">Point Latitude: </label>
                    <input type="text" id="lat" name="lat" placeholder="Enter name of area..." required>
                </div>

                <div class="form-group">
                    <label for="lng">Point Longitude: </label>
                    <input type="text" id="lng" name="lng" placeholder="Enter name of area..." required>
                </div>
                
                <div class="form-group">
                    <label for="distance">Distance from Point: </label>
                    <input type="text" id="distance" name="distance" placeholder="Enter distance in meters.." required>
                </div>

                <div class="form-group">
                    <center><button type="submit" style="background-color: #E84F62">Store</button></center>
                </div>
            </form>
            </div>
            </div>
          </div>
        </div>
      </div>
      <div  class="col-sm-6">
        <div class='card' style="width: 38rem; ">
          <div class="card-body">
            <!-- Update Data -->
            <div class="table-responsive">
                <table class="table">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Area</th>
                          <th>Latitude</th>
                          <th>Longitude</th>
                          <th>Distance</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                      $danger_zones = $conn->query("SELECT * FROM danger_zone");
                      if($danger_zones->num_rows > 0)
                      {
                        while ($row = $danger_zones->fetch_assoc()) {
                          echo "<tr>
                                  <td>{$row['id']}</td>
                                  <td>{$row['area']}</td>
                                  <td>{$row['latitude']}</td>
                                  <td>{$row['longitude']}</td>
                                  <td>{$row['distance']}</td>
                                  <td>
                                      <button class='btn btn-danger remove-button' data-id='{$row['id']}'>Remove</button>
                                  </td>
                              </tr>";
                        }
                      }
                      else
                      {
                        echo "<tr><td></td> <td> No Data Available!!!</td></tr>";
                      }
                      ?>
                  </tbody>
                </table>
            </div>
          </div>
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
  // Attach click event to the "Remove" buttons
var removeButtons = document.querySelectorAll('.remove-button');
removeButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var id = this.getAttribute('data-id');
        if (confirm("Are you sure you want to remove this entry?")) {
            // Make an AJAX request to remove the data
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Reload the page after successful removal
                        window.location.reload();
                    } else {
                        console.error('Failed to remove data');
                    }
                }
            };
            xhr.open('GET', 'remove_data.php?id=' + id, true);
            xhr.send();
        }
    });
});
</script>

  <script src="map.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>