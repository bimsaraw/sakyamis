
<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active"><?php echo $title; ?></li>
    </ol>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Saved Reports</h5>
                    <hr>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Additional Reporting Tools</h5>
                    <hr>
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
