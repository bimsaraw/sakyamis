
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

      <form id="searchStudent">
        <div class="form-row">
          <div class="form-group col-md-4">
            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number <770438888>" required>
          </div>
          <div class="form-group col-md-2">
            <button type="submit" class="btn btn-primary">Search</button>
          </div>
        </div>
      </form>

      <div class="table-responsive">
        <table id="dataTable" class="table table-stripped">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Course</th>
              <th>Date Inquired</th>
              <th>Counselor</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="inq_table">

          </tbody>

        </table>
      </div>

    </div>

  </div>
</div>

<div class="modal fade" id="enrollModal" tabindex="-1" role="dialog" aria-labelledby="enrollModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Student Enrollment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>If the student is an exsiting student of Saegis Campus, you don't have to fill the application again. Please validate it from here before proceeding.</p>
        <form id="validate_nic">
          <div class="form-group form-row">
            <div class="col-md-3">
              NIC / Passport No.
            </div>
            <div class="col-md-4">
              <input type="hidden" id="inquiryId" name="inquiryId">
              <input type="text" class="form-control" required id="nic" name="nic">
            </div>
            <div class="col-md-5">
              <button type="submit" class="btn btn-primary">Validate</button>
            </div>
          </div>
        </form>
        <div id="validateReponse">

        </div>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
      var t = $('#dataTable').DataTable();

        $('#searchStudent').submit(function(e) {
          $.blockUI();
          e.preventDefault();

          var form = $('#searchStudent');
          $.ajax({
            type: "GET",
            url: '<?php echo base_url(); ?>index.php/inquiries/search_inquiries',
            data: form.serialize(),
            cache: false,
            success: function(response) {
              $.unblockUI();
              t.clear().draw();

              $.each(response,function(key, val) {

                var register = "<button type='button' class='btn btn-outline-primary btn-sm' onclick='validate_nic("+val.id+")'>Register</a>";

                t.row.add([
                  val.id,
                  val.name,
                  val.courseName,
                  val.datetime,
                  val.username,
                  register
                ]).draw();
              });
            }
          });
        });

    } );

    $('#validate_nic').submit(function(e) {
      e.preventDefault();
      var form = $('#validate_nic');
      $.ajax({
         type: "POST",
         url: '<?php echo base_url(); ?>index.php/enrollments/studentId_by_nic',
         data: form.serialize(),
         success: function(response) {
           if(response == "no-student") {
             $('#validateReponse').addClass('alert alert-success');
             $('#validateReponse').html("<p>Student is a new student. <a href='<?php echo base_url(); ?>index.php/enrollments/enroll?inquiryId="+$('#inquiryId').val()+"'>Click here</a> to proceed.");
           } else {
             $('#validateReponse').addClass('alert alert-success');
             $('#validateReponse').html("<p>Student is an existing student <strong>("+response+")</strong>. <a href='<?php echo base_url(); ?>index.php/enrollments/course_enroll?inquiryId="+$('#inquiryId').val()+"&studentId="+response+"'>Click here</a> to proceed.");
           }
         }
       });
    });

    function validate_nic(inquiryId) {
      $('#inquiryId').val(inquiryId);
      $("#enrollModal").modal("show");
    }
</script>
