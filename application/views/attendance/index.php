
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
                    <h5 class="card-title">Student Attendance - Entrance</h5>
                    <hr>
                    <form id="frmAttendance">
                        <div class="form-row">
                          <div class="form-group col-md-2">
                            <input type="text" id="studentId" name="studentId" class="form-control" placeholder="19S08002" autocomplete="off" required>
                          </div>
                          <div class="form-group col-md-10">
                            <button class="btn btn-primary">Mark Attendance</button>
                          </div>
                          <div class="form-group col-md-2">
                            <a class="btn btn-secondary btn-sm" href="<?= base_url(); ?>index.php/attendance/full_screen">Full Screen View</a>
                          </div>
                        </div>
                    </form>
                    <div id="alertArea" class="alert" style="display:none;">

                    </div>
                    <div class="table table-responsive">
                      <table id="responseTable" style="display:none;" class="table table-stripped">
                        <thead>
                          <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Installments Pending</th>
                            <th>Amount</th>
                            <th>Currency</th>
                            <th>Due Date</th>
                          </tr>
                        </thead>
                        <tbody id="responseText">

                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="histoModalLabel">Attendance History</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-stripped">
            <thead>
              <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Remarks</th>
                <th>Visited Finance</th>
                <th>Finance Remarks</th>
            </thead>
            <tbody id="tblHistory">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
      var t = $('#dataTable').DataTable();

      $('#frmAttendance').submit(function(e) {
          e.preventDefault();
          var form = $('#frmAttendance');

          var studentId = $('#studentId').val();
          $.blockUI();
          $.ajax({
           type: "POST",
           url: '<?php echo base_url(); ?>index.php/attendance/mark_attendance_entrance',
           data: form.serialize(),
           success: function(response) {
             if($.isArray(response)) {
               $('#responseTable').show();
               var markup;
               $.each(response,function(key, val) {
                 var amount = val.amount.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                 markup += "<tr>"
                 markup += "<td>"+val.studentId+"</td><td>"+val.initials_name+"</td><td>"+val.name+"</td><td style='text-align:right; color:red;'>"+amount+"</td><td style='text-transform:uppercase;'>"+val.currency+"</td><td>"+val.date+"</td>";
                 markup +="</tr>";
               });

               $('#responseText').html(markup);
               $('#alertArea').show();
               $('#alertArea').removeClass("alert-success");
               $('#alertArea').addClass("alert-danger");

               $('#alertArea').html("There are some issues with payments! <button class='btn btn-sm btn-danger' onclick=viewHistory('"+studentId+"')>History</button>");
             } else {
               $('#responseTable').hide();
               $('#alertArea').show();
               $('#alertArea').addClass("alert-success");
               $('#alertArea').removeClass("alert-danger");
               $('#alertArea').html("Successfully marked attendance. <button class='btn btn-sm btn-success' onclick=viewHistory('"+studentId+"')>History</button>");
             }
             $.unblockUI();
             $('#studentId').focus();
             $('#studentId').val('');
           },
           error: function() {
             $('#alertArea').show();
             $('#alertArea').removeClass("alert-success");
             $('#alertArea').addClass("alert-danger");

             $('#alertArea').html("System is unavailable or Student ID number is invalid! Please contact an adminstrator if this problem persists.");
             $.unblockUI();
             $('#studentId').focus();
           }
         });
      });
  } );

  function viewHistory(studentId) {
    $.blockUI();
    $.ajax({
     type: "POST",
     url: '<?php echo base_url(); ?>index.php/attendance/get_attendance_history',
     data: { studentId: studentId },
     success: function(response) {
       var markup;
       $.each(response,function(key, val) {
          var vstatus = "";
          if (val.visited_finance==1) {vstatus="Visited"; checked="checked"} else {vstatus="Not Visited";};
           markup += "<tr>";
           markup += "<td>"+val.date+"</td><td>"+val.time+"</td><td>"+val.remarks+"</td><td>"+vstatus+"</td><td>"+val.finance_remarks+"</td>";   
           markup += "</tr>"
       });

       $('#tblHistory').html(markup);
       $('#historyModal').modal('show');
       $.unblockUI();
     }
   });
  }
</script>
