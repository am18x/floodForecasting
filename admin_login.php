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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="index.css">
  <?php include('./header.php'); ?>
  <?php
  if (isset($_SESSION['login_id']))
    header("location:admin_index.php?page=home");

  ?>

</head>
<style>
  body {
    width: 100%;
    height: calc(100%);
    position: fixed;
    top: 0;
    left: 0;
    align-items: center !important;
    background: linear-gradient(to bottom, #ff33cc 0%, #ff99cc 100%);
  }

  main#main {
    width: 100%;
    height: calc(100%);
    display: flex;
  }
</style>

<body>


  <main id="main">

    <div class="align-self-center w-100">
      <h4 class="text-white text-center"><b>Flood Forecasting</b></h4>
      <div id="login-center" class=" row justify-content-center">
        <div class="card col-md-4">
          <div class="card-body">
            <form id="login-form">
              <div class="form-group">
                <label for="username" class="control-label text-dark">Username</label>
                <input type="text" id="username" name="username" class="form-control form-control-sm">
              </div>
              <div class="form-group">
                <label for="password" class="control-label text-dark">Password</label>
                <input type="password" id="password" name="password" class="form-control form-control-sm">
              </div>
              <div class="w-100 d-flex justify-content-center align-items-center">
                <button class="btn-sm btn-block btn-wave col-md-4 btn-primary m-0 mr-1" style="background-color: #E84F62">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

</body>
<script>
  $('#login-form').submit(function(e) {
    e.preventDefault()
    $('#login-form button[type="button"]').attr('disabled', true).html('Logging in...');
    if ($(this).find('.alert-danger').length > 0)
      $(this).find('.alert-danger').remove();
    $.ajax({
      url: 'ajax.php?action=login',
      method: 'POST',
      data: $(this).serialize(),
      error: err => {
        console.log(err)
        $('#login-form button[type="button"]').removeAttr('disabled').html('Login');

      },
      success: function(resp) {
        if (resp == 1) {
          location.href = 'admin_index.php?page=home';
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
      url: 'ajax.php?action=login',
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