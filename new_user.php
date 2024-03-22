<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <?php include('./header.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}
::selection{
  background: #4158d0;
  color: #fff;
}
.container{
  width: 50%;
  background: #fff;
  border-radius: 15px;
  box-shadow: 0px 15px 20px rgba(0,0,0,0.1);
}
.container .title{
  font-size: 35px;
  font-weight: 600;
  text-align: center;
  line-height: 100px;
  color: #fff;
  user-select: none;
  border-radius: 15px 15px 0 0;
  background: linear-gradient(-135deg, #c850c0, #4158d0);
}
.container form{
  padding: 10px 30px 50px 30px;
}
.container form .field{
  height: 50px;
  width: 100%;
  margin-top: 20px;
  position: relative;
}
.container form .field input[type="text"], 
.container form .field input[type="email"],
.container form .field input[type="password"],
.container form .field input[type="tel"]{
  height: 100%;
  width: 60%;
  outline: none;
  font-size: 17px;
  margin-left: 40%;
  border: 1px solid lightgrey;
  border-radius: 25px;
  transition: all 0.3s ease;
}
.container form .field input[type="submit"]{
  height: 100%;
  width: 60%;
  outline: none;
  font-size: 17px;
  margin-left: 20%;
  border: 1px solid lightgrey;
  border-radius: 25px;
  transition: all 0.3s ease;
}
.container form .field textarea{
  height: 100%;
  width: 60%;
  outline: none;
  font-size: 17px;
  margin-left: 40%;
  transition: all 0.3s ease;
}
.container form .field input[type="file"]{
  height: 100%;
  width: 60%;
  outline: none;
  margin-left: 40%;
  transition: all 0.3s ease;
}
.container form .field input:focus,
form .field input:valid{
  border-color: #4158d0;
}
.container form .field label{
  position: absolute;
  top: 50%;
  left: 20px;
  color: #999999;
  font-weight: 400;
  font-size: 17px;
  pointer-events: none;
  transform: translateY(-50%);
  transition: all 0.3s ease;
}
form .field input:focus ~ label,
form .field input:valid ~ label{
  top: 0%;
  font-size: 16px;
  color: #4158d0;
  background: #fff;
  transform: translateY(-50%);
}
form .content{
  display: flex;
  width: 100%;
  height: 50px;
  font-size: 16px;
  align-items: center;
  justify-content: space-around;
}
form .content input{
  width: 15px;
  height: 15px;
  background: red;
}
form .content label{
  color: #262626;
  user-select: none;
  padding-left: 5px;
}
form .content .pass-link{
  color: "";
}
form .field input[type="submit"]{
  color: #fff;
  border: none;
  padding-left: 0;
  margin-top: -10px;
  font-size: 20px;
  font-weight: 500;
  cursor: pointer;
  background: linear-gradient(-135deg, #c850c0, #4158d0);
  transition: all 0.3s ease;
}
form .field input[type="submit"]:active{
  transform: scale(0.95);
}
form .signup-link{
  color: #262626;
  margin-top: 20px;
  text-align: center;
}
form .pass-link a,
form .signup-link a{
  color: #4158d0;
  text-decoration: none;
}
form .pass-link a:hover,
form .signup-link a:hover{
  text-decoration: underline;
}
        .navbar-nav {
            margin-left: 60%;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #56B4E3;
            width: 100%;
            height: calc(100%);
            top: 0;
            left: 0;
            align-items: center !important;
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
            background: #fff;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .error-msg{
            color: red;
        }
        .form-container{
            margin-top: 1%;
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
<div class="form-container">
    <div class="container">
        <div class="right">
            <div class="row">
            <div data-bs-spy="scroll" data-bs-smooth-scroll="true" class="scrollspy-example-2" tabindex="0">
            <form class="row g-3" action="new_user_process.php" method="POST" id="reg-form" enctype="multipart/form-data">

            <center>
                <h2 class="title">Register</h2>
        </center>
                <div class="field item-1">
                    <label class="control-label text-dark form-label" for="fname">Full Name:</label>
                    <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter your full name">
                    <span class="error-msg"></span>
                </div>

                <div class="field item-2">
                    <label class="control-label text-dark form-label" for="mob">Mobile Number:</label>
                    <input type="tel" class="form-control" id="mob" name="mob" placeholder="Enter your mobile number">
                    <span class="error-msg"></span>
                </div>

                <div class="field item-3">
                    <label class="control-label text-dark form-label" for="email">Email ID:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email id">
                    <span class="error-msg"></span>
                </div>

                <div class="field item-4">
                    <label class="control-label text-dark form-label" for="address">Address:</label>
                    <textarea class="form-control" name="address" id="address" placeholder="Enter your Address"></textarea>
                    <span class="error-msg"></span>
                </div>

                <div class="field item-5">
                    <label class="control-label text-dark form-label" for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username">
                    <span class="error-msg"></span>
                </div>

                <div class="field item-6">
                    <label class="control-label text-dark form-label" for="photo">Upload QR Code:</label>
                    <input type="file" id="photo" name="photo">
                    <span class="error-msg"></span>
                </div>

                <div class="field item-7">
                    <label class="control-label text-dark form-label" for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                    <span class="error-msg"></span>
                </div>

                <div class="field item-8">
                    <label class="control-label text-dark form-label" for="cpassword">Confirm Password:</label>
                    <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm your password">
                    <span class="error-msg"></span>
                </div>

                <div class="signup-link">
                    Already Have an account? <a href="login.php">Login Now</a>
                </div>
                <div class="field">
                    <input type="submit" value="Register">
                </div>

            </form>
        </div>
        </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $("#reg-form").submit(function(event) {
        event.preventDefault();
        
        $(".error-msg").text(""); // Clear previous error messages
        
        var fname = $('#fname').val();
        var mob = $("#mob").val();
        var email = $('#email').val();
        var address = $('#address').val();
        var uname = $('#username').val();
        var photo = $('#photo')[0].files[0];
        var password = $("#password").val();
        var cpassword = $("#cpassword").val();
        
        var valid = true; // Flag to check if validation succeeded
        
        if(fname ==="")
        {
            $("#fname").siblings(".error-msg").text("*Full name is required");
            valid = false;
        }

        if(/\d/.test(fname))
        {
            $("#fname").siblings(".error-msg").text("*Full name should not require number");
            valid = false;
        }

        if(email === "")
        {
            $("#email").siblings(".error-msg").text("*Email ID is required");
            valid = false;
        }

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(!emailRegex.test(email))
        {
            $("#email").siblings(".error-msg").text("*Invalid email address");
            valid = false;
        }

        if(address ==="")
        {
            $("#address").siblings(".error-msg").text("*Address is required");
            valid = false;
        }

        if(uname ==="")
        {
            $("#username").siblings(".error-msg").text("*Username is required");
            valid = false;
        }

        if(!photo)
        {
            $("#photo").siblings(".error-msg").text("*Please upload an image");
            valid = false;
        }

        if (mob.length != 10) {
            $("#mob").siblings(".error-msg").text("*Phone number must be 10 characters");
            valid = false;
        }
        
        if (password.length < 8) {
            $("#password").siblings(".error-msg").text("*Password must have at least 8 characters.");
            valid = false;
        }
        
        if (password !== cpassword) {
            $("#cpassword").siblings(".error-msg").text("*Passwords do not match.");
            valid = false;
        }
        
        if (valid) {
            // Password validation successful, proceed with form submission
            this.submit();
        }
    });
});
</script>
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
