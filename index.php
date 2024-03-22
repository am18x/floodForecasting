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
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
  <style>
    body {
    width: 100%;
    height: calc(100%);
    top: 0;
    left: 0;
    align-items: center !important;
    margin: 0; /* Remove default margin */
    padding: 0; /* Remove default padding */
    background-repeat: no-repeat;
    background-attachment: fixed;
  }
    .navbar-nav {
    margin-left: 60%;
    }
    #map{ 
      width:100%; 
      height: 500px;
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
                <div class='profile-panel'><button class='btn close-button' ><i class='fa-solid fa-xmark'></i></button><ul><li><a class='nav-link btn me-md-2'  href='update_user.php'>Profile</a></li><br><li><a class='nav-link btn me-md-2' style='background-color: #ABD07E' href='ajax.php?action=logout'>Logout</a></li></ul></div>
                <button class='nav-link btn me-md-2 profile-button' style='width: 35px;'><i class='fa-solid fa-user'></i></button>";
            if(!isset($_SESSION['login_id']))
              echo "<a class='nav-link btn me-md-2' style='width: 90%; margin-left: -40%' href='help.php'>If you want help then click here</a>
              <a class='nav-link btn me-md-2'  href='contact_us.php'>Contact Us</a>
              <a href='login.php' class='nav-link btn me-md-2' >Login</a>";
          ?>
        </div>
      </div>

    </div>
  </nav>

  <br>
        <h5>Select Location to check you are in the safe zone or not: </h5>
        <center>
        <div id="map"></div>
        </center>
  
  <script src="test.js"></script>

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
        // Your JavaScript code here...

        var latitudeValues = [];
        var longitudeValues = [];
        var distanceValues = [];

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);

                    data.forEach(function (item) {
                        latitudeValues.push(parseFloat(item.latitude));
                        longitudeValues.push(parseFloat(item.longitude));
                        distanceValues.push(parseFloat(item.distance));
                    });

                    initMap();
                } else {
                    console.error('Failed to fetch data');
                }
            }
        };

        xhr.open('GET', 'get_data.php', true);
        xhr.send();

        function initMap() {
          var centerOfMap = new google.maps.LatLng(16.665903, 74.475852);

//Map options.
var options = {
  center: centerOfMap, //Set center.
  zoom: 15 //The zoom value.
};

//Create the map object.
map = new google.maps.Map(document.getElementById('map'), options);

for (var i = 0; i < latitudeValues.length; i++) {
    var redCircle = new google.maps.Circle({
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#FF0000',
        fillOpacity: 0.35,
        map: map,
        center: new google.maps.LatLng(latitudeValues[i], longitudeValues[i]),
        radius: distanceValues[i]
    });
}

//Listen for any clicks on the map.
redCircle.addListener('click', function(event) {
    var clickedLocation = event.latLng;
    if (marker === false) {
        marker = new google.maps.Marker({
            position: clickedLocation,
            map: map,
            draggable: true // make it draggable
        });
        google.maps.event.addListener(marker, 'dragend', function(event){
            markerLocation();
        });
    } else {
        marker.setPosition(clickedLocation);
    }
    markerLocation();
});
google.maps.event.addListener(map, 'click', function(event) {                
    //Get the location that the user clicked.
    var clickedLocation = event.latLng;
    //If the marker hasn't been added.
    if(marker === false){
        //Create the marker.
        marker = new google.maps.Marker({
            position: clickedLocation,
            map: map,
            draggable: true //make it draggable
        });
        //Listen for drag events!
        google.maps.event.addListener(marker, 'dragend', function(event){
            markerLocation();
        });
    } else{
        //Marker has already been added, so just change its location.
        marker.setPosition(clickedLocation);
    }
    //Get the marker's location.
    markerLocation();
});
        }
    </script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>