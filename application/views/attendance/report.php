
<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active"><?php echo $title; ?></li>
    </ol>
    <?php 
    if ($this->session->flashdata('success')) {
    echo '<div class="alert alert-success">'; echo $this->session->flashdata('success'); echo'</div> ';
    }else if ($this->session->flashdata('danger')) {
      echo '<div class="alert alert-success">'; echo $this->session->flashdata('danger'); echo'</div> ';
    }else if ($this->session->flashdata('warning')) {
      echo '<div class="alert alert-success">'; echo $this->session->flashdata('warning'); echo'</div> ';
    }else if ($this->session->flashdata('info')) {
      echo '<div class="alert alert-success">'; echo $this->session->flashdata('info'); echo'</div> ';
    }
    ?>
     <div id="alertArea" class="alert" style="display:none;"> </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Student Attendance - Report</h5>
                    <hr>
                    <form id="view_attendance">
                        <div class="form-row">
                          <div class="form-group col-md-2">
                            <input type="text" id="studentId" name="studentId" class="form-control" placeholder="19S08002" autofocus autocomplete="off" required>
                          </div>
                          <div class="form-group col-md-10">
                            <button type="submit" class="btn btn-primary">View Attendance</button>
                          </div>
                        </div>
                   </form>
                   
                   <hr>
                    <h6 class="card-title" id="studentname" style="display:none;">Student Name - Report</h6>
                    <div class="table-responsive">
                        <table class="table" id="dataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Finance Visit</th>
                                    <th>Finance Remark</th>
                                    <th>Action</th>
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

<div class="modal fade" id="addremarks" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
    <form id="frmremark_submit">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Remarks</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body"> 
            <div class="form-group">
              <label>Remarks</label>
              <input type="hidden" name="mr_studentID" id="mr_studentID" />
              <input type="hidden" name="mr_date" id="mr_date" />
              <input type="hidden" name="mr_time" id="mr_time" />
              <input type="text" name="m_remarks" id="m_remarks" class="form-control"  autofocus required/>
              <div class="validation-feedback fb_new2" id="fb_new2"></div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-outline-primary btn-sm">Save Changes</button>
        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button>
        </div>
       </form>
    </div>
    </div>
</div>

<div class="modal fade" id="deleteattendance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation!</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body"> 
            <div class="form-group">
              ​<p id="delete_lable"></p>
              <input type="hidden" name="m_studentID" id="m_studentID" />
              <input type="hidden" name="m_date" id="m_date" />
              <input type="hidden" name="m_time" id="m_time" />
              <div class="validation-feedback fb_new2" id="fb_new2"></div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal" onclick="delete_confirm()">Delete</button>
        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>

<script>

  $(document).ready(function() {
    $('#dataTable').DataTable(); //data table 
    $('#view_attendance').submit(function(e) {
      e.preventDefault();
      get_attendance_details();
    }); // get attendance details


    $('#frmremark_submit').submit(function(e) {
      e.preventDefault();
      add_remark();
      $('#addremarks').modal('hide');
      get_attendance_details(); 
    });
  }); 

  function get_attendance_details(){
            $.blockUI();
            var studentId = document.getElementById("studentId").value;
            var studentname="";
            $("#dataTable tbody").empty();
            $.ajax({
                type : "POST",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/attendance/get_attendance_detail', // target element(s) to be updated with server response
                data: {studentId:studentId},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                  if(response=='no-perm'){
                    $('#alertArea').show();
                    $('#alertArea').addClass("alert-warning");
                    $('#alertArea').html("Permissions denied!");
                    }
                var t = $('#dataTable').DataTable();
                t.clear().draw();
                var counter = 1;    
                    $.each(response,function(key, val) {
                      var vstatus;
                      var checked;
                      
                      switch (val.visited_finance) {
                      case '1':
                        vstatus="Visited";
                        checked="checked"
                        break;
                      case '0':
                        vstatus="Visited";
                        break;  
                      default:
                        vstatus="Not Visited";
                    }
                            t.row.add( [
                                  counter,
                                  val.date,
                                  val.time,
                                  "<input class='form-check-input' type='checkbox' "+checked+" id='vstatus"+ val.studentId+val.date+val.time +"' onclick=visitstatus('" + val.studentId+"','"+val.date+"','"+val.time + "')>" + vstatus,
                                  val.finance_remarks,
                                  "<button class='btn btn-info btn-sm' onclick=get_attendance_remark('" + val.studentId+"','"+val.date+"','"+val.time + "')>Remarks</button> <button class='btn btn-danger btn-sm' onclick=get_delete_attendance('" + val.studentId+"','"+val.date+"','"+val.time + "')><i class='far fa-trash-alt'></i></button>"
                              ] ).draw( false );
                            studentname=val.full_name;  
                            counter++;
                    });
                    document.getElementById("studentname").innerHTML ="Student Name : " + studentname;
                    document.getElementById("studentname").style.display="block";
                    $.unblockUI();
                }
            });//ajax
        }  
  function add_remark(){
          $.blockUI();
             $.ajax({
                 type : "POST",
                 //set the data type
                 url: '<?php echo base_url(); ?>index.php/attendance/add_remark', // target element(s) to be updated with server response
                 data: $('#frmremark_submit').serialize(),
                 //check this in Firefox browser
                 success : function(response){
                   $("#dataTable tbody").empty();
                   $.unblockUI();
                 
                   if(response=='no-perm'){
                     $('#alertArea').show();
                     $('#alertArea').addClass("alert-warning");
                     $('#alertArea').html("Permissions denied!");
                     }else if (response=='success'){
                     $('#alertArea').show();
                     $('#alertArea').addClass("alert-success");
                     $('#alertArea').html("Remark Changed Successfully.");
                     }else if (response=='unsuccess'){
                     $('#alertArea').show();
                     $('#alertArea').addClass("alert-success");
                     $('#alertArea').html("Remark Changed Unsuccessfully.");
                     }
                   
                 }
             }); 
            
     }

          function get_delete_attendance(studentid,date,time) {
            $.blockUI();
            $.ajax({
                type : "POST",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/attendance/get_single_detail', // target element(s) to be updated with server response
                data: {studentId:studentid,date:date,time:time},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                    $.each(response,function(key, val) {
                      var base_url = window.location.origin;
                      document.getElementById("m_studentID").value = val.studentId;
                      document.getElementById("m_date").value = val.date;
                      document.getElementById("m_time").value = val.time;
                      document.getElementById("delete_lable").innerHTML ="Are you sure want to delete "+val.date +" " +val.time+ " attendance?"
                    });
                }
            });
            $('#deleteattendance').modal('show');
            $.unblockUI();

          }

          function get_attendance_remark(studentid,date,time) {
            $.blockUI();
           
            $.ajax({
                type : "POST",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/attendance/get_single_detail', // target element(s) to be updated with server response
                data: {studentId:studentid,date:date,time:time},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                    $.each(response,function(key, val) {
                      var base_url = window.location.origin;
                      document.getElementById("mr_studentID").value = val.studentId;
                      document.getElementById("mr_date").value = val.date;
                      document.getElementById("mr_time").value = val.time;
                      document.getElementById("m_remarks").value = val.finance_remarks;
                    });
                }
            });
            $("#m_remarks").focus();
            $('#addremarks').modal('show');
            $.unblockUI();
          }

          function delete_confirm(){
            $.blockUI();
              var studentId =document.getElementById("m_studentID").value;
              var date =document.getElementById("m_date").value;
              var time =document.getElementById("m_time").value;
            $.ajax({
                type : "POST",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/attendance/delete_attendance', // target element(s) to be updated with server response
                data: {studentId:studentId,date:date,time:time},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                  if(response=='no-perm'){
                    $('#alertArea').show();
                    $('#alertArea').addClass("alert-warning");
                    $('#alertArea').html("Permissions denied!");
                    }else if (response=='success'){
                    $('#alertArea').show();
                    $('#alertArea').addClass("alert-success");
                    $('#alertArea').html("Attendance Successfully Deleted.");
                    }else if (response=='unsuccess'){
                    $('#alertArea').show();
                    $('#alertArea').addClass("alert-success");
                    $('#alertArea').html("Attendance Deleted Unuccessfully .");
                    }
                  console.log(response);
                }
            }); 
            $("#dataTable tbody").empty();
            get_attendance_details(); 
            $('#deleteattendance').modal('hidden');
            $.unblockUI();
          }

        
            function visitstatus(studentid,date,time) {
              var checkBox = document.getElementById("vstatus"+studentid+date+time);
              var status= "";
              if (checkBox.checked == true){
                status = 1;
              } else if(checkBox.checked == false) {
                status = 0;
              }
              $.blockUI();
             
              $.ajax({
                type : "POST",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/attendance/change_status', // target element(s) to be updated with server response
                data: {studentId:studentid,date:date,time:time,status:status},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                  if(response=='no-perm'){
                    $('#alertArea').show();
                    $('#alertArea').addClass("alert-warning");
                    $('#alertArea').html("Permissions denied!");
                    }else if (response=='success'){
                    $('#alertArea').show();
                    $('#alertArea').addClass("alert-success");
                    $('#alertArea').html("Status Changed Successfully.");
                    }else if (response=='unsuccess'){
                    $('#alertArea').show();
                    $('#alertArea').addClass("alert-success");
                    $('#alertArea').html("Status Changed Unsuccessfully.");
                    }
                      console.log(response);
                }
            });
            $("#dataTable tbody").empty();
            get_attendance_details(); 
            $.unblockUI();
            }
</script>
