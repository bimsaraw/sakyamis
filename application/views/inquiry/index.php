
<div class="container-fluid">

  <!-- Breadcrumbs-->
  <ol class="breadcrumb">
      <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
      </li>
      <li class="breadcrumb-item active"><?php echo $title; ?></li>
  </ol>

  <div class="row">
    <div class="col-lg-3 col-md-6">
      <div class="info-box">
        <div class="info-box-title">
          <h5 class="text-info"><i class="far fa-meh-blank"></i> Pending</h5>
        </div>
        <div class="info-box-body">
          <?php
            if(isset($pending)) {
              $total = 0;
              foreach($pending as $row) {
                $total = $total + $row['count'];
              } ?>
              <div class="info-box-insight text-info"><?=$total; ?></div>
          <?php  }
          ?>
          <a href="<?=base_url() ?>index.php/inquiries/view?type=is_pending&title=Pending Inquiries" class="btn btn-sm btn-info">View Inquiries</a>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6">
      <div class="info-box">
        <div class="info-box-title">
          <h5 class="text-warning"><i class="far fa-smile"></i> Positive</h5>
        </div>
        <div class="info-box-body">
          <?php
            if(isset($positive)) {
              $total = 0;
              foreach($positive as $row) {
                $total = $total + $row['count'];
              } ?>
              <div class="info-box-insight text-warning"><?=$total; ?></div>
          <?php  }
          ?>
          <a href="<?=base_url() ?>index.php/inquiries/view?type=is_positive&title=Positive Inquiries" class="btn btn-sm btn-warning">View Inquiries</a>
        </div>
      </div>
  </div>

  <div class="col-lg-3 col-md-6">
    <div class="info-box">
      <div class="info-box-title">
        <h5 class="text-success"><i class="far fa-smile-beam"></i> Registered</h5>
      </div>
      <div class="info-box-body">
        <?php
          if(isset($registered)) {
            $total = 0;
            foreach($registered as $row) {
              $total = $total + $row['count'];
            } ?>
            <div class="info-box-insight text-success"><?=$total; ?></div>
        <?php  }
        ?>
        <a href="<?=base_url() ?>index.php/inquiries/view?type=is_registered&title=Registered Inquiries" class="btn btn-sm btn-success">View Inquiries</a>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6">
    <div class="info-box">
      <div class="info-box-title">
        <h5 class="text-danger"><i class="far fa-frown-open"></i> Failed</h5>
      </div>
      <div class="info-box-body">
        <?php
          if(isset($failed)) {
            $total = 0;
            foreach($failed as $row) {
              $total = $total + $row['count'];
            } ?>
            <div class="info-box-insight text-danger"><?=$total; ?></div>
        <?php  }
        ?>

        <a href="<?=base_url() ?>index.php/inquiries/view?type=is_failed&title=Failed Inquiries" class="btn btn-sm btn-danger">View Inquiries</a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-3 col-md-6">
    <div class="info-box">
      <div class="info-box-title">
        <h5 class="text-primary"><i class="fa fa-search"></i> Other Links</h5>
      </div>
      <div class="info-box-body">
        <a class="info-box-link" href="<?php echo base_url(); ?>index.php/inquiries/self_register">Register a Student</a>
        <a class="info-box-link" href="<?php echo base_url(); ?>index.php/inquiries/view_all">View All Inquiries</a>
        <a href="#" class="info-box-link">Enrollments with pending payments</a>
        <a href="#" class="info-box-link">Un-confirmed Enrollments</a>
      </div>
    </div>
  </div>
</div>

</div>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    } );
</script>
