
<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active"><?php echo $title; ?></li>
    </ol>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Edit Course Enrollment</h5>

            <form id="courseEnrollments">

              <input type="hidden" name="studentId" id="studentId" value="<?= $studentId; ?>">
              <input type="hidden" name="courseId" id="courseId" value="<?= $courseId; ?>">

              <?php foreach($course_enroll as $row) {
                $pplanId = $row['pplanId'];
              } 
                
              ?>

              <div class="form-row">
                <div class="form-group col-md-4">
                  <label>Batch ID</label>
                  <select name="batchId" id="batchId" class="form-control form-control-sm">
                    <?php foreach($course_enroll as $row) { ?>
                      <option value="<?= $row['batchId']; ?>"><?= $row['batchName']; ?></option>
                    <?php } ?>
                    <?php foreach($batches as $batch) { ?>
                      <option value="<?= $batch['id']; ?>"><?= $batch['name']; ?></option>
                    <?php } ?>
                  </select>

                </div>

                <?php if(!$this->payment_model->verify_payment_status($studentId,$pplanId)) { ?>
                  <div class="form-group col-md-4">
                    <label>Payment Plan</label>

                    <select name="pplanId" id="pplanId" class="form-control form-control-sm">
                      <?php foreach($course_enroll as $row) { ?>
                        <option value="<?= $row['pplanId']; ?>"><?= $row['paymentplanName']; ?></option>
                      <?php } ?>
                      <?php foreach($payment_plans as $payment_plan) { ?>
                        <option value="<?= $payment_plan['id']; ?>"><?= $payment_plan['name']; ?></option>
                      <?php } ?>
                    </select>

                  </div>
                <?php } ?>
              </div>
              <button class="btn btn-primary btn-sm" type="submit">Save</button>
              <button type="button" class="btn btn-default btn-sm" onclick="window.history.back();">Go Back</button>

            <?php echo form_close(); ?>


          </div>
        </div>
      </div>
    </div>
</div>

<script>
$('#courseEnrollments').submit(function(e){
  e.preventDefault();

  var form = $('#courseEnrollments');
  console.log(form.serialize());
  $.blockUI();
  $.ajax({
   type: "POST",
   url: '<?php echo base_url(); ?>index.php/enrollments/update_course_enrollment',
   data: form.serialize(),
   success: function(response) {
     if(response=='success') {
       $.notify({
        // options
        message: 'Enrollment details edited successfully!'
        },{
        // settings
        type: 'success'
        });
     } else {
       $.notify({
        // options
        message: 'There was an error when editing details!'
        },{
        // settings
        type: 'danger'
        });
     }
     $.unblockUI();
   }
 });


});
</script>
