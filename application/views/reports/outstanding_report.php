
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
                      <label>Branch <span class="required"> *</span></label>
                                  <select class="form-control form-control-sm" name="branchId" id="branchId" required>
                                      <option value="">-- Please Select --</option>
                                    <?php foreach ($branches as $branch) { ?>
                                      <option value="<?= $branch['id']; ?>" <?php if ($_POST) {if($branch['id'] ===$single_branch->id){echo "selected";}}?>><?= $branch['name'];?></option>
                                    <?php } ?>
                                  </select>
                          </div>
                        </div>
                        
                        <div class="form-row">
                        <div class="form-group col-md-3">
                          <label>Intake</label>
                          <select class="form-control form-control-sm" name="intakeId" id="intakeId" >
                            <option value="">-- Please Select --</option>
                            <?php foreach ($intakes as $intake) { ?>
                              <option value="<?= $intake['id']; ?>"  <?php if ($_POST) {if($intake['id'] ===$single_intake->id){echo "selected";}}?>><?= $intake['name']; ?></option>
                            <?php } ?>
                          </select>
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
                          <label>Date</label>
                          <input type="text" class="form-control form-control-sm" name="date" id="date" autocomplete="off" required>
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
                            <h6 class="text-center" style="text-decoration:underline" id="report_desc">Outstanding Report
                            <?= $single_branch->name; ?>
                            <?php if($single_intake) {echo " - "; echo $single_intake->name;} ?> 
                            <?php if ($single_batch){echo " - "; echo $single_batch->id; }; ?>
                            <?php if ($single_course){echo " - "; echo $single_course->name; }; ?> 
                            </h6>
                            <tr>
                              <th>Student ID</th>
                              <th>Name with Initials</th>
                              <th>Mobile Number</th>
                              <th>Email Address</th>
                              <?php if($_POST['courseId']=="") { ?>
                                <th>Course</th>
                              <?php } ?>
                              <?php if($_POST['batchId']=="") { ?>
                                <th>Batch</th>
                              <?php } ?>
                              <th>Installments</th>
                              <th>Amount</th>
                              <th>Currency</th>
                            </tr>
                          </thead>
                          <tbody>

                              <?php foreach($students as $student) { ?>
                                <tr>
                                  <td><?= $student['studentId']; ?></td>
                                  <td><?= $student['initials_name']; ?></td>
                                  <td><?= $student['mobile']; ?></td>
                                  <td><?= $student['email']; ?></td>
                                  <?php if($_POST['courseId']=="") { ?>
                                    <td><?= $student['courseName']; ?></td>
                                  <?php } ?>
                                  <?php if($_POST['batchId']=="") { ?>
                                    <td><?= $student['batchName']; ?></td>
                                  <?php } ?>
                                  <td><?= $student['installments']; ?></td>
                                  <td style="text-align:right;"><?= number_format($student['amount'],2); ?></td>
                                  <td><?= $student['currency']; ?></td>
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
    var report_desc = $('#report_desc').text();
      var table = $('#dataTable').DataTable( {

          lengthChange: false,
          buttons: [
              'copyHtml5',
              'excelHtml5',
              'csvHtml5',
          
          { extend: 'print',
              
              customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .prepend(
                            '<h3>'+ report_desc +' </h3>'
                        );
              }
            }
            ]
      } );

    table.buttons().container()
        .appendTo( '#dataTable_wrapper .col-md-6:eq(0)' );
        $('.dt-buttons > button').addClass('btn');
        $('.dt-buttons > button').addClass('btn-secondary');
        $('.dt-buttons > button').addClass('btn-sm');
  } );

  $(function() {
    $('#date').daterangepicker({
      locale: {
    format: 'YYYY-MM-DD'
},
      singleDatePicker: true,
      showDropdowns: true,
      minYear: 2018,
      maxYear: parseInt(moment().format('YYYY'),10)
    }, function(start, end, label) {
      $('#date').val(end.format('YYYY-MM-DD'));

    });
  });



</script>
