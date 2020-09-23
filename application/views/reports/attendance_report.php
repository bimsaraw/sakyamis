
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

                        <div class="form-group col-md-3">
                          <label>Date Range</label>
                          <input type="text" class="form-control form-control-sm" name="date" id="date" autocomplete="off" required>
                          <input type="hidden" name="startDate" value="<?= date('Y-m-d'); ?>" id="startDate">
                          <input type="hidden" name="endDate" value="<?= date('Y-m-d'); ?>" id="endDate">
                        </div>


                        <div class="form-group col-md-3">
                          <label>Course</label>
                          <select class="form-control form-control-sm" name="courseId" id="courseId">
                            <?php if($_POST['courseId']!="") { ?>
                              <option value="<?= $_POST['courseId']; ?>"><?= $single_course->name; ?></option>
                            <?php } else { ?>
                              <option value="">-- Please Select --</option>
                            <?php } ?>
                            <?php foreach ($courses as $course) { ?>
                              <option value="<?= $course['id']; ?>"><?= $course['name']; ?></option>
                            <?php } ?>
                          </select>
                        </div>

                        <div class="form-group col-md-3">
                          <label>Batch</label>
                          <select class="form-control form-control-sm" name="batchId" id="batchId">
                            <?php if($_POST['batchId']!="") { ?>
                              <option value="<?= $_POST['batchId']; ?>"><?= $single_batch->name; ?></option>
                            <?php } else { ?>
                              <option value="">-- Please Select --</option>
                            <?php } ?>
                            <?php foreach ($batches as $batch) { ?>
                              <option value="<?= $batch['id']; ?>"><?= $batch['name']; ?></option>
                            <?php } ?>
                          </select>
                        </div>

                        <div class="form-group col-md-3">
                          <label>Payment Status</label>
                          <select class="form-control form-control-sm" name="is_pending_payment" id="is_pending_payment">
                            <?php if($_POST['is_pending_payment']!="") { ?>
                              <option value="<?= $_POST['is_pending_payment']; ?>">
                                <?php

                                  if($_POST['is_pending_payment']==1) {
                                    echo "Pending Payments";
                                  } else {
                                    echo "Completed Payments";
                                  }

                                ?>

                              </option>
                            <?php } ?>
                              <option value="">All</option>
                              <option value="1">Pending Payments</option>
                              <option value="0">Completed Payments</option>
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
                            <h6 class="text-center" style="text-decoration:underline">Attendance Summary</h6>
                            <tr>
                              <th>#</th>
                              <th>Student ID</th>
                              <th>Batch</th>
                              <th>Name with Initials</th>
                              <th>Date</th>
                              <th>Time</th>
                              <th>Remarks</th>
                            
                            </tr>
                          </thead>
                          <tbody>

                              <?php $count=1; foreach($students as $student)  { ?>
                                <tr <?php if($student['is_pending_payment']) { echo "style='color:red;'"; } ?>>
                                  <td><?= $count; ?></td>
                                  <td><?= $student['studentId']; ?></td>
                                  <td><?= $student['batchId']; ?></td>
                                  <td><?= $student['initials_name']; ?></td>
                                  <td><?= $student['date']; ?></td>
                                  <td><?= $student['time']; ?></td>
                                  <td>
                                    <?php
                                      echo $student['remarks'];

                                      //if($student['is_pending_payment']==1) {
                                        //if($student['visited_finance']==0) {
                                          //echo " <span class='badge badge-danger'>Didn't visit cashier / finance</span>";
                                        //} else {
                                          //echo " <span class='badge badge-success'>Visited Finance / cashier</span>";
                                        //}
                                      //}
                                    ?>
                                  </td>
                                </tr>
                              <?php $count++; } ?>
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

  $(function() {
      //var options = { twentyFour: true }
      //$('.timepicker').wickedpicker(options);
      $('#date').daterangepicker({
          locale: {
            format: 'YYYY-MM-DD'
          },
          opens: 'right'
      }, function(start, end, label) {
          $('#startDate').val(start.format('YYYY-MM-DD'));
          $('#endDate').val(end.format('YYYY-MM-DD'));

          $('#startDateEvent').val(start.format('YYYY-MM-DD'));
          $('#endDateEvent').val(end.format('YYYY-MM-DD'));
        });
    });



</script>
