
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

                var register = "<a class='btn btn-outline-primary btn-sm' href='<?= base_url(); ?>index.php/enrollments/enroll?inquiryId="+val.id+"'>Register</a>";

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
</script>
