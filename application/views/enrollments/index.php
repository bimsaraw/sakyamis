
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
              <h5 class="card-title">Student Enrollments</h5>
              <hr>

              <form id="frmEnrolledStudents">
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label>Student Name</label>
                    <input type="text" class="form-control form-control-sm" name="full_name" id="full_name">
                  </div>

                  <div class="form-group col-md-3">
                    <label>Filter by Course</label>
                    <select name="courseId" id="courseId" class="form-control form-control-sm">
                      <option value=""></option>
                      <?php foreach($courses as $course) { ?>
                        <option value="<?=$course['id']; ?>"><?=$course['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group col-md-2">
                    <label>Filter by Intake</label>
                    <select name="intakeId" id="intakeId" class="form-control form-control-sm">
                      <option value=""></option>
                      <?php foreach($intakes as $intake) { ?>
                        <option value="<?=$intake['id']; ?>"><?=$intake['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group col-md-2">
                    <label>Filter by Batch</label>
                    <select name="batchId" id="batchId" class="form-control form-control-sm">
                      <option value=""></option>
                      <?php foreach($batches as $batch) { ?>
                        <option value="<?=$batch['id']; ?>"><?=$batch['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group col-md-2">
                    <label>Confirmation Status</label>
                    <select name="is_valid" id="is_valid" class="form-control form-control-sm">
                      <option value=""></option>
                      <option value="1">Registered</option>
                      <option value="0">Provisionally Registered</option>
                    </select>
                  </div>

                  <div class="form-group col-md-4">
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    <button class="btn btn-default btn-sm">Reset</button>
                  </div>
                </div>
              </form>

              <hr>
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id="dataTable" class="table table-stripped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Telephone</th>
                          <th>Email</th>
                          <th>NIC</th>
                          <th>Course</th>
                          <th>Gender</th>
                          <th>Date of Birth</th>
                            <th>Address</th>
                          <th>City</th>
                          <th>Intake</th>
                          <th>Batch</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody id="inq_table">

                      </tbody>

                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Telephone</th>
                          <th>Email</th>
                          <th>NIC</th>
                          <th>Course</th>
                          <th>Gender</th>
                          <th>Date of Birth</th>
                          <th>Address</th>
                          <th>City</th>
                          <th>Intake</th>
                          <th>Batch</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                      </tfoot>

                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
</div>

<script>
  var t;
  $(document).ready(function() {
      var buttonCommon = {
          exportOptions: {
              format: {
                  body: function ( data, row, column, node ) {
                      // Strip $ from salary column to make it numeric
                      return column === 5 ?
                          data.replace( /[$,]/g, '' ) :
                          data;
                  }
              }
          }
      };
      t = $('#dataTable').DataTable({
        "autoWidth": false,
        "order": [[ 0, 'desc' ]],
        "drawCallback": function() {
          this.api().columns().every( function () {
              var column = this;
              var select = $('<select class="form-control form-control-sm"><option value=""></option></select>')
                  .appendTo( $(column.footer()).empty() )
                  .on( 'change', function () {
                      var val = $.fn.dataTable.util.escapeRegex(
                          $(this).val()
                      );

                      column
                          .search( val ? '^'+val+'$' : '', true, false )
                          .draw();
                  } );

              column.data().unique().sort().each( function ( d, j ) {
                  select.append( '<option value="'+d+'">'+d+'</option>' )
              } );
          } );

        },
        dom: 'Bfrtip',
          buttons: [
              'copy', 'csv', 'excel', 'print'
          ],
      });

      t.buttons().container()
          .appendTo( '#dataTable_wrapper .col-md-6:eq(0)' );
          $('.dt-buttons > button').addClass('btn');
          $('.dt-buttons > button').addClass('btn-secondary');
          $('.dt-buttons > button').addClass('btn-sm');

          
      $(".nav-pills li:first a").addClass('active');

      $(".nav-pills li a").click(function(){
        $(".nav-pills li a").removeClass('active');
        $(this).addClass('active');
      });

      $('#frmEnrolledStudents').submit(function(e) {
          e.preventDefault();
          var form = $('#frmEnrolledStudents');
          $.blockUI();
          $.ajax({
           type: "POST",
           url: '<?php echo base_url(); ?>index.php/enrollments/filter_students',
           data: form.serialize(),
           success: function(response) {
             t.clear().draw();

             var remarks;

             $.each(response,function(key, val) {

               var status;
               if(val.is_valid==1) {
                 status = "Enrollment Confirmed";
               } else {
                 status = "Enrollment Pending";
               }

               t.row.add([
                 val.studentId,
                 val.full_name,
                 val.mobile,
                 val.email,
                 val.nic,
                 val.courseName,
                 val.gender,
                 val.dob,
                 val.address,
                 val.city,
                 val.intakeName,
                 val.batchName,
                 status,
                 '<a href="<?= base_url(); ?>index.php/enrollments/confirm_enroll?studentId='+val.inquiryId+'" class="btn btn-success btn-sm" target="_blank">More<a href="<?= base_url(); ?>index.php/enrollments/print_studentId?studentId='+val.studentId+'" target="_blank" class="btn btn-secondary btn-sm"><i class="far fa-address-card"></i></a>',
               ]).draw();
             });
             $.unblockUI();
           }
         });
      });

  } );

  function viewStudents(courseId) {
    $.blockUI();

    $.ajax({
      type: "GET",
      url: '<?php echo base_url(); ?>index.php/enrollments/get_students_enrolled',
      data: {courseId:courseId},
      cache: false,
      success: function(response) {

      }
    });
  }
</script>
