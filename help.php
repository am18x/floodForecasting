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
    body {
      width: 100%;
      height: calc(100%);
      top: 0;
      left: 0;
      align-items: center !important;
      margin: 0; /* Remove default margin */
      padding: 0; /* Remove default padding */
      background-image: url('assets/uploads/helpbg.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed
    }
    .navbar-nav {
    margin-left: 60%;
    }
    .form-select{
      width: 20%
    }
    .row{
      margin-left: 5%;
      margin-right: 5%;
    }
    .form-btn{
      width: 100%;
      height: 44px;
    }
    .form-btn[value="food"] {
    background-color: green;
    color: white;
}

.form-btn[value="shelter"] {
    background-color: blue;
    color: white;
}

.form-btn[value="cloth"] {
    background-color: red;
    color: white;
}

.form-btn[value="medicine"] {
    background-color: gray;
    color: white;
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

  <br>
  <div class="row">
    <div class="col-3">
        <form method="post">
            <button type="submit" class="btn btn-primary form-btn" name="select" value="shelter">Shelter</button>
        </form>
    </div>
    <div class="col-3">
        <form method="post">
            <button type="submit" class="btn btn-success form-btn" name="select" value="food">Food</button>
        </form>
    </div>
    <div class="col-3">
        <form method="post">
            <button type="submit" class="btn btn-warning form-btn" name="select" value="cloth">Cloth</button>
        </form>
    </div>
    <div class="col-3">
        <form method="post">
            <button type="submit" class="btn btn-secondary form-btn" name="select" value="medicine">Medicine</button>
        </form>
    </div>
</div><br><br>

  <?php
    $selected="";
    if (isset($_POST['select'])) 
    {
      $selected = $_POST['select'];
    
        if($selected == "selectop")
        {
          echo "<p> Please select option!!!</p>";
        }else if($selected == "shelter")
        {
          $sql = "SELECT s.oname, s.rate, s.tNumRoom, s.aNumRoom, s.address, s.mob, u.photo FROM shelter s JOIN users u ON s.oname = u.fname";
          $result = mysqli_query($conn, $sql);
          if ($result->num_rows > 0) 
          {
            // Output data of each row
            $cardsInRow = 0;
            while ($row = $result->fetch_assoc()) 
            {
              if($cardsInRow == 0)
              {
                echo "<div class='row'>";
              }
              echo "<div class='col-md-4'>";
              echo "<div class='card border-dark mx-auto p-2' style='width: 20rem;'>";
              echo "<p class='card-title'><b>Owner Name: </b>" . $row["oname"] . "</p>";
              echo "<p class='card-title'><b>Rate per room: </b>" . $row["rate"] . "</p>";
              echo "<p class='card-text'><b>Total Rooms: </b>" . $row["tNumRoom"] . "</p>";
              echo "<p class='card-text'><b>Available Rooms: </b>" . $row["aNumRoom"] . "</p>";
              echo "<p class='card-text'><b>Address: </b>" . $row["address"] . "</p>";
              echo "<p class='card-text'><b>Mobile Number: </b>" . $row["mob"] . "</p>";
              echo "<p class='card-text'><b>QR Code: </b></p><img src='assets/uploads/"  . $row["photo"] . "' width='100' height='230' class='card-img-top rounded-top'>";
              echo "<div class='card-body'><a href='tel:". $row["mob"] . "' class='card-link'><i class='fa-solid fa-phone'></i></a>
                  <a href='http://maps.google.com/maps?q=". $row["address"] . "' class='card-link'><i class='fa-solid fa-location-dot'></i></a>
              </div></div></div>";
              
              $cardsInRow++;

              if($cardsInRow == 3)
              {
                echo "</div><br>";
                $cardsInRow = 0;
              }
            }
            if($cardsInRow>0)
            {
              echo "</div>";
            }
          }
          else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
          }
        }else if($selected == "food")
        {
          $sql = "SELECT s.oname, s.rate, s.type, s.address, s.mob, u.photo FROM food s JOIN users u ON s.oname = u.fname";
          $result = mysqli_query($conn, $sql);
          if ($result->num_rows > 0) 
          {
            // Output data of each row
            $cardsInRow = 0;
            while ($row = $result->fetch_assoc()) 
            {
              if($cardsInRow == 0)
              {
                echo "<div class='row'>";
              }
              echo "<div class='col-md-4'>";
              echo "<div class='card border-dark mx-auto p-2' style='width: 20rem;'>";
              echo "<p class='card-title'><b>Owner Name: </b>" . $row["oname"] . "</p>";
              echo "<p class='card-title'><b>Rate per Plate: </b>" . $row["rate"] . "</p>";
              echo "<p class='card-text'><b>Type of Food: </b>" . $row["type"] . "</p>";
              echo "<p class='card-text'><b>Address: </b>" . $row["address"] . "</p>";
              echo "<p class='card-text'><b>Mobile Number: </b>" . $row["mob"] . "</p>";
              echo "<p class='card-text'><b>QR Code: </b></p><img src='assets/uploads/"  . $row["photo"] . "' width='100' height='230' class='card-img-top rounded-top'>";
              echo "<div class='card-body'><a href='tel:". $row["mob"] . "' class='card-link'><i class='fa-solid fa-phone'></i></a>
                  <a href='http://maps.google.com/maps?q=". $row["address"] . "' class='card-link'><i class='fa-solid fa-location-dot'></i></a>
              </div></div></div>";
              
              $cardsInRow++;

              if($cardsInRow == 3)
              {
                echo "</div><br>";
                $cardsInRow = 0;
              }
            }
            if($cardsInRow>0)
            {
              echo "</div>";
            }
          }
          else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
          }
        }else if($selected == "cloth")
        {
          $sql = "SELECT s.oname, s.rate, s.size, s.address, s.mob, u.photo FROM cloth s JOIN users u ON s.oname = u.fname";
          $result = mysqli_query($conn, $sql);
          if ($result->num_rows > 0) 
          {
            // Output data of each row
            $cardsInRow = 0;
            while ($row = $result->fetch_assoc()) 
            {
              if($cardsInRow == 0)
              {
                echo "<div class='row'>";
              }
              echo "<div class='col-md-4'>";
              echo "<div class='card border-dark mx-auto p-2' style='width: 20rem;'>";
              echo "<p class='card-title'><b>Owner Name: </b>" . $row["oname"] . "</p>";
              echo "<p class='card-title'><b>Price: </b>" . $row["rate"] . "</p>";
              echo "<p class='card-text'><b>Size: </b>" . $row["size"] . "</p>";
              echo "<p class='card-text'><b>Address: </b>" . $row["address"] . "</p>";
              echo "<p class='card-text'><b>Mobile Number: </b>" . $row["mob"] . "</p>";
              echo "<p class='card-text'><b>QR Code: </b></p><img src='assets/uploads/"  . $row["photo"] . "' width='100' height='230' class='card-img-top rounded-top'>";
              echo "<div class='card-body'><a href='tel:". $row["mob"] . "' class='card-link'><i class='fa-solid fa-phone'></i></a>
                  <a href='http://maps.google.com/maps?q=". $row["address"] . "' class='card-link'><i class='fa-solid fa-location-dot'></i></a>
              </div></div></div>";
              
              $cardsInRow++;

              if($cardsInRow == 3)
              {
                echo "</div><br>";
                $cardsInRow = 0;
              }
            }
            if($cardsInRow>0)
            {
              echo "</div>";
            }
          }
          else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
          }
        }else if($selected == "medicine")
        {
          $sql = "SELECT s.oname, s.rate, s.medName, s.address, s.mob, u.photo FROM medicine s JOIN users u ON s.oname = u.fname";
          $result = mysqli_query($conn, $sql);
          if ($result->num_rows > 0) 
          {
            // Output data of each row
            $cardsInRow = 0;
            while ($row = $result->fetch_assoc()) 
            {
              if($cardsInRow == 0)
              {
                echo "<div class='row'>";
              }
              echo "<div class='col-md-4'>";
              echo "<div class='card border-dark mx-auto p-2' style='width: 20rem;'>";
              echo "<p class='card-title'><b>Owner Name: </b>" . $row["oname"] . "</p>";
              echo "<p class='card-title'><b>Rate per Medicine: </b>" . $row["rate"] . "</p>";
              echo "<p class='card-text'><b>Medicine Name: </b>" . $row["medName"] . "</p>";
              echo "<p class='card-text'><b>Address: </b>" . $row["address"] . "</p>";
              echo "<p class='card-text'><b>Mobile Number: </b>" . $row["mob"] . "</p>";
              echo "<p class='card-text'><b>QR Code: </b></p><img src='assets/uploads/"  . $row["photo"] . "' width='100' height='230' class='card-img-top rounded-top'>";
              echo "<div class='card-body'><a href='tel:". $row["mob"] . "' class='card-link'><i class='fa-solid fa-phone'></i></a>
                  <a href='http://maps.google.com/maps?q=". $row["address"] . "' class='card-link'><i class='fa-solid fa-location-dot'></i></a>
              </div></div></div>";
              
              $cardsInRow++;

              if($cardsInRow == 3)
              {
                echo "</div><br>";
                $cardsInRow = 0;
              }
            }
            if($cardsInRow>0)
            {
              echo "</div>";
            }
          }
          else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
          }
        }
    }
    $conn->close();
  ?>

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