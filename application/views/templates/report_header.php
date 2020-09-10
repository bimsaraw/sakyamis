<!DOCTYPE html>
<html lang="en">

<?php
    $username = $this->session->userdata('username');
if($username=="") {
    header('location:/timetable/index.php/users/login');
} ?>

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<title><?php echo $title; ?></title>

<!-- Bootstrap core CSS-->
<link href="<?php echo base_url(); ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/main.css" rel="stylesheet">

<style>
@media screen {
  div.divFooter {
    display: none;
  }
  .page-footer{
    display: none;
  }
}


@page {
  margin: 10mm
}

@media print {
   thead {display: table-header-group;} 
   tfoot {display: table-footer-group;}
   
   body {margin: 0;}

   /* Styles go here */

.page-header, .page-header-space {
  height: 250px;
}


.page-footer, .page-footer-space {
  height: 10mm;
  margin-top: 10mm;
}

.page-footer {
  position: fixed;
  bottom: 0;
  width: 100%;
}

.page-header {
  position: fixed;
  top: 0mm;
  width: 100%;
  height:100mm;
}

tbody {
  max-height: 200px;
 
}

.page {
  page-break-after: always;
  
}
body { 
  columns:2;
}
}

.sticky{
  table-layout: auto;
  width: 65%;
}

.height{
  height:35px;
}
</style>
</head>
