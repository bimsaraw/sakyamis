<!DOCTYPE html>
<html lang="en">

<?php
    $username = $this->session->userdata('username');
if($username=="") {
    header('location:'.base_url().'index.php/users/login');
} ?>

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<title><?php echo $title; ?></title>

<!-- Bootstrap core CSS-->
<link href="<?php echo base_url(); ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom fonts for this template-->
<link href="<?php echo base_url(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600&display=swap" rel="stylesheet">

<!-- Page level plugin CSS-->
<link href="<?php echo base_url(); ?>vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

<!-- Custom styles for this template-->
<link href="<?php echo base_url(); ?>css/sb-admin.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script src="<?php echo base_url(); ?>vendor/jquery/jquery.min.js"></script>
<link href="<?php echo base_url(); ?>css/wickedpicker.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/timetablejs.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/bootstrap-colorpicker.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<link href="<?php echo base_url(); ?>css/main.css" rel="stylesheet">

<style>
  .form-control {
    height: 60px;
    font-size: 22px;
  }

  .btn-primary {
    height: 60px;
    font-size: 22px;
  }

  .alert {
    font-size: 20px;
  }

  .table {
    font-size: 18px;
  }
</style>
</head>

<body>
  <div id="wrapper" style="margin-top:15px;">

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Student Attendance - Entrance</h2>
                        <h5>Press F11 for full screen view</h5>
                        <hr>
                        <form id="frmAttendance">
                            <div class="form-row">
                              <div class="form-group col-md-3">
                                <input type="text" id="studentId" name="studentId" class="form-control" autocomplete="off" required>
                              </div>
                              <div class="form-group col-md-9">
                                <button class="btn btn-primary">Mark Attendance</button>
                              </div>
                              <div class="form-group col-md-2">
                                <a class="btn btn-secondary btn-sm" href="<?= base_url(); ?>index.php/attendance">Standard View</a>
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

      $('#studentId').on('input',function() {
        var value = $(this).val();

        if(value.length == 8) {
          $('#frmAttendance').submit();
        }
      });

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
           markup += "<tr>";
           markup += "<td>"+val.date+"</td><td>"+val.time+"</td><td>"+val.remarks+"</td>";
           markup += "</tr>"
       });

       $('#tblHistory').html(markup);
       $('#historyModal').modal('show');
       $.unblockUI();
     }
   });
  }

</script>

<script src="<?php echo base_url(); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?php echo base_url(); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Page level plugin JavaScript-->
<script src="<?php echo base_url(); ?>vendor/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>vendor/datatables/dataTables.bootstrap4.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="https://cloud.tinymce.com/5/tinymce.min.js"></script>
<script>tinymce.init({selector:'textarea'});</script>


<!-- Custom scripts for all pages-->
<script src="<?php echo base_url(); ?>js/sb-admin.min.js"></script>
<script src="<?php echo base_url(); ?>js/quicksearch.js"></script>
<script src="<?php echo base_url(); ?>js/wickedpicker.min.js"></script>
<script src="<?php echo base_url(); ?>js/timetable.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-colorpicker.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-notify.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script>

$('.timepicker').timepicker({
    timeFormat: 'HH:mm',
    interval: 30,
    dynamic: false,
    dropdown: false,
    scrollbar: true,
    startTime: '08:00',
});
</script>
</body>

</html>
