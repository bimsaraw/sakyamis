
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
            <h5 class="card-title">Search for a Student</h5>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label>Value</label>
                <input type="text" id="value" class="form-control" placeholder="Enter a value and press enter">
              </div>
              <div class="form-group col-md-3">
                <label>Search By</label>
                <select id="by" class="form-control">
                  <option value="name">Name</option>
                  <option value="mobile">Mobile Phone Number</option>
                </select>
              </div>
            </div>

            <div class="table-responsive">
              <table id="dataTable" class="table table-stripped">
                <thead>
                  <th>#</th>
                  <th>Name</th>
                  <th>Course</th>
                  <th>Mobile</th>
                  <th>Counselor</th>
                  <th></th>
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
  var t;
  $(document).ready(function() {

    t = $('#dataTable').DataTable({
      "autoWidth": false,
      "paging": false,
      "order": [[ 0, 'desc' ]]
    });

    $('#value').change(function() {

      var value=$('#value').val();
      var by=$('#by').val();

      t.clear().draw();

      if(value!="") {

        $.ajax({
          type: "GET",
          url: '<?php echo base_url(); ?>index.php/inquiries/search_student',
          data: {value:value,by:by},
          cache: false,
          success: function(response) {
            t.clear().draw();
            $.each(response,function(key, val) {
              t.row.add([
                val.id,
                val.name,
                val.courseName,
                val.mobile,
                val.username,
                "<a href='<?= base_url(); ?>index.php/enrollments/enroll?inquiryId="+val.id+"' class='btn btn-warning btn-sm'><i class='fas fa-user-graduate'></i></a>"
              ]).draw();
            });
          }
        });
      }

    });

  });
</script>
