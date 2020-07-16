
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
                    <h5 class="card-title">Search for Student</h5>
                    <hr>
                    <form id="frmPaymentStudent">
                        <div class="form-row">
                          <div class="form-group col-md-2">
                            <input type="text" id="studentId" name="studentId" class="form-control" placeholder="19S08002" autofocus required>
                          </div>
                          <div class="form-group col-md-1">
                            <button class="btn btn-primary">Search</button>
                          </div>
                          <div class="form-group col-md-8">
                            <h6 id="studentName"></h6>
                          </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                      <table class="table table-stripped" id="dataTable">
                        <thead>
                          <tr>
                            <th>Course Name</th>
                            <th>Batch Enrolled</th>
                            <th>Payment Plan</th>
                            <th>Enrolled Date</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function() {
      var t = $('#dataTable').DataTable();

      $('#frmPaymentStudent').submit(function(e) {
          e.preventDefault();
          var form = $('#frmPaymentStudent');
          $.blockUI();
          $.ajax({
           type: "GET",
           url: '<?php echo base_url(); ?>index.php/enrollments/search_student_by_id',
           data: form.serialize(),
           success: function(response) {
             t.clear().draw();

             $.each(response,function(key, val) {
               $('#studentName').html(val.initials_name);
             });
           }
         });

          $.ajax({
           type: "GET",
           url: '<?php echo base_url(); ?>index.php/enrollments/get_course_enrollments_by_id',
           data: form.serialize(),
           success: function(response) {
             t.clear().draw();

             $.each(response,function(key, val) {

               t.row.add([
                 val.courseName,
                 val.batchName,
                 val.paymentplanName,
                 val.datetime,
                 '<a href="<?= base_url(); ?>index.php/payments/view_installments_by_pplan?pplanId='+val.pplanId+'&studentId='+val.studentId+'" class="btn btn-success btn-sm">View Installments</a>',
               ]).draw();
             });
             $.unblockUI();
           }
         });
      });
  } );
</script>
