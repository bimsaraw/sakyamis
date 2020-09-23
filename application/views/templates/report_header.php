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
<script src="<?php echo base_url(); ?>vendor/jquery/jquery.min.js"></script>
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
  height: 220px;
}


.page-footer, .page-footer-space {
  height: 20mm;
 
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
  height:90mm;
}

tbody {
  height: 190mm;
 
}
table{
  height:500px;
}

.page {
  page-break-after: always;
  
}
.contentbody { 
  width:100%;
}
.column{
  columns:2;
}
}

.sticky{
  table-layout: auto;
  width: 100%;
}

.height{
  height:35px;
}
</style>
</head>
