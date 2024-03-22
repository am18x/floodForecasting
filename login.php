<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include('./db_connect.php');
ob_start();

$system = $conn->query("SELECT * FROM system_settings")->fetch_array();
foreach ($system as $k => $v) {
  $_SESSION['system'][$k] = $v;
}
ob_end_flush();
?>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Login | <?php echo $_SESSION['system']['name'] ?></title>
  <link rel="stylesheet" href="index.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <?php include('./header.php'); ?>
  <?php
  if (isset($_SESSION['login_id']))
    header("location:home.php");
  ?>

</head>
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
width: 380px;
background: #fff;
border-radius: 15px;
box-shadow: 0px 15px 20px rgba(0,0,0,0.1);
margin-top:3%;
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
.container form .field input{
height: 100%;
width: 100%;
outline: none;
font-size: 17px;
padding-left: 20px;
border: 1px solid lightgrey;
border-radius: 25px;
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
form .content .checkbox{
display: flex;
align-items: center;
justify-content: center;
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
body {
width: 100%;
height: calc(100%);
position: fixed;
top: 0;
left: 0;
align-items: center !important;
margin: 0; /* Remove default margin */
padding: 0; /* Remove default padding */
background: #fff;
background-repeat: no-repeat;
background-attachment: fixed;
}

.navbar-nav {
margin-left: 60%;
}

main#main {
width: 100%;
height: calc(100%);
display: flex;
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

  <div class="container">
  <?php
    // Check if registration success parameter is set
    if (isset($_GET['registration']) && $_GET['registration'] === "success") {
        echo '<script>alert("Registration successful! You can now log in.");</script>';
    }
    ?>
  <div class="title">
     Login Form
  </div>
  <form id="login-form" action="#">
     <div class="field">
         <input type="text" id="username" name="username" placeholder="Enter username" class="form-control form-control-sm">
     </div>
     <div class="field">
         <input type="password" id="password" name="password" placeholder="Enter password" class="form-control form-control-sm">
     </div>
     <div class="field">
        <input type="submit" value="Login">
     </div>
     <div class="signup-link">
        Not a member? <a href="new_user.php">Signup now</a>
     </div>
  </form>
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
<script>
  $('#login-form').submit(function(e) {
    e.preventDefault()
    $('#login-form button[type="button"]').attr('disabled', true).html('Logging in...');
    if ($(this).find('.alert-danger').length > 0)
      $(this).find('.alert-danger').remove();
    $.ajax({
      url: 'ajax.php?action=login2',
      method: 'POST',
      data: $(this).serialize(),
      error: err => {
        console.log(err)
        $('#login-form button[type="button"]').removeAttr('disabled').html('Login');

      },
      success: function(resp) {
        if (resp == 1) {
          location.href = 'home.php?login=success';
        } else {
          $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
          $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
        }
      }
    })
  })
  $('#vsr-frm').submit(function(e) {
    e.preventDefault()
    start_load()
    if ($(this).find('.alert-danger').length > 0)
      $(this).find('.alert-danger').remove();
    $.ajax({
      url: 'ajax.php?action=login2',
      method: 'POST',
      data: $(this).serialize(),
      error: err => {
        console.log(err)
        end_load()
      }
    })
  })
  $('.number').on('input keyup keypress', function() {
    var val = $(this).val()
    val = val.replace(/[^0-9 \,]/, '');
    val = val.toLocaleString('en-US')
    $(this).val(val)
  })
</script>

</html>