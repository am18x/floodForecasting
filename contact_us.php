<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="index.css">
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=geometry"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
    <title>Contact Us</title>
    <style>
      body {
    margin: 0; /* Remove default margin */
    padding: 0; /* Remove default padding */
  }
        .navbar-nav {
        margin-left: 60%;
        }
        .cnt{
            width: 50%;
            height: 50%;
            display: block;
            margin-left: auto;
            margin-top: 5%;
            margin-right: auto;
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
    <center>
        <br><h3>Emergency Contact Numbers</h3>
    </center>
    <div class="cnt">
    <table class="table table-light table-hover">
        <tr>
            <th>Name</th>
            <th>Contact Number</th>
        </tr>
        <tr>
            <td>Polic</td>
            <td>100</td>
        </tr>
        <tr>
            <td>Fire</td>
            <td>101</td>
        </tr>
        <tr>
            <td>Ambulance</td>
            <td>102</td>
        </tr>
        <tr>
            <td>State Level Helpline for Health</td>
            <td>104</td>
        </tr>
        <tr>
            <td>Disaster Management / Medical Helpline</td>
            <td>108</td>
        </tr>
    </table>
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


  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>