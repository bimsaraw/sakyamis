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
                    <h5 class="card-title"><?php echo $title; ?></h5>
                    <hr>

                    <form method="post">
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label>Intake</label>
                          <select class="form-control form-control-sm" name="intakeId" id="intakeId" required>
                            <?php if($_POST) { ?>
                              <option value="<?= $_POST['intakeId']; ?>"><?= $single_intake->name; ?></option>
                            <?php } else { ?>
                              <option value="">-- Please Select --</option>
                            <?php } ?>
                            <?php foreach ($intakes as $intake) { ?>
                              <option value="<?= $intake['id']; ?>"><?= $intake['name']; ?></option>
                            <?php } ?>
                          </select>
                        </div>

                        <div class="form-group col-md-4">
                          <label>Course</label>
                          <select class="form-control form-control-sm" name="courseId" id="courseId" required>
                            <?php if($_POST) { ?>
                              <option value="<?= $_POST['courseId']; ?>"><?= $single_course->name; ?></option>
                            <?php } else { ?>
                              <option value="">-- Please Select --</option>
                            <?php } ?>
                            <?php foreach ($courses as $course) { ?>
                              <option value="<?= $course['id']; ?>"><?= $course['name']; ?></option>
                            <?php } ?>
                          </select>
                        </div>

                        <div class="form-group col-md-4">
                          <label>Payment Plan</label>
                          <select class="form-control form-control-sm" name="pplanId" id="pplanId" required>
                            <option value="">-- Please Select --</option>
                          </select>
                        </div>

                        <div class="col-md-3">
                          <button type="submit" class="btn btn-primary btn-sm">Generate Report</button>
                        </div>

                      </div>
                    </form>


                    <?php if($_POST) { ?>
                      <hr>
                      <div class="table table-responsive">
                        <table class="table table-stripped" id="dataTable">
                          <thead>
                            <h6 class="text-center" style="text-decoration:underline"><?= $single_intake->name." | ".$single_course->name." | ".$single_pplan->name; ?></h6>
                            <tr>
                              <th>Student ID</th>
                              <th>Name with Initials</th>
                              <th>Mobile Number</th>
                              <th>Email Address</th>
                              <th>Batch</th>
                            </tr>
                          </thead>
                          <tbody>

                              <?php foreach($students as $student) { ?>
                                <tr>
                                  <td><?= $student['studentId']; ?></td>
                                  <td><?= $student['initials_name']; ?></td>
                                  <td><?= $student['mobile']; ?></td>
                                  <td><?= $student['email']; ?></td>
                                  <td><?= $student['batchName']; ?></td>
                                </tr>
                              <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

  $(document).ready(function() {
    get_payment_plans_by_intake_course()
      var table = $('#dataTable').DataTable( {
          lengthChange: false,
          buttons: [
              'copyHtml5',
              'excelHtml5',
              'csvHtml5',
              'print'
          ]
      } );

    table.buttons().container()
        .appendTo( '#dataTable_wrapper .col-md-6:eq(0)' );
        $('.dt-buttons > button').addClass('btn');
        $('.dt-buttons > button').addClass('btn-secondary');
        $('.dt-buttons > button').addClass('btn-sm');
  } );

  $('#intakeId').change(function() {

    if($('#courseId').val()!="") {
      get_payment_plans_by_intake_course();
    }

  });

  $('#courseId').change(function() {

    if($('#intakeId').val()!="") {
      get_payment_plans_by_intake_course();
    }

  });

  function get_payment_plans_by_intake_course() {
    $.blockUI();
    var intakeId = $('#intakeId').val();
    var courseId = $('#courseId').val();

    $('#pplanId').empty();

    $.ajax({
     type: "POST",
     url: '<?php echo base_url(); ?>index.php/payments/get_payment_plans_by_intake_course',
     data: { intakeId:intakeId, courseId:courseId },
     success: function(response) {
       $.each(response,function(key, val) {
         $('<option value='+val.id+'>'+val.name+'</option>').appendTo('#pplanId');
       });
       $.unblockUI();
     }
   });
  }

</script>
