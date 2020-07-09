<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<title><?php echo $title; ?></title>

<!-- Bootstrap core CSS-->
<link href="<?php echo base_url(); ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom fonts for this template-->
<link href="<?php echo base_url(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

<!-- Page level plugin CSS-->
<link href="<?php echo base_url(); ?>vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

<!-- Custom styles for this template-->
<link href="<?php echo base_url(); ?>css/sb-admin.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
<script src="<?php echo base_url(); ?>vendor/jquery/jquery.min.js"></script>
<link href="<?php echo base_url(); ?>css/wickedpicker.min.css" rel="stylesheet">
</head>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login</div>
        <div class="card-body">
            <?php echo form_open('users/process'); ?>
                <?php if(isset($msg)) echo $msg;?>  
                <div class="form-group">
                <div class="form-label-group">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" required="required" autofocus="autofocus">
                    <label for="username">Username</label>
                </div>
                </div>
                <div class="form-group">
                <div class="form-label-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                    <label for="password">Password</label>
                </div>
                </div>
                <div class="form-group">
                <div class="checkbox">
                    <label>
                    <input type="checkbox" value="remember-me">
                    Remember Password
                    </label>
                </div>
                </div>
                <input type="submit" class="btn btn-primary btn-block" value="Login">
            <?php echo form_close(); ?>
          <div class="text-center">
            <br>
            <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
          </div>
        </div>
      </div>
    </div>

<!-- Bootstrap core JavaScript-->

<script src="<?php echo base_url(); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?php echo base_url(); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Page level plugin JavaScript-->
<script src="<?php echo base_url(); ?>vendor/chart.js/Chart.min.js"></script> 
<script src="<?php echo base_url(); ?>vendor/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>vendor/datatables/dataTables.bootstrap4.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?php echo base_url(); ?>js/sb-admin.min.js"></script>
<script src="<?php echo base_url(); ?>js/quicksearch.js"></script>
<script src="<?php echo base_url(); ?>js/wickedpicker.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


</body>

</html>
