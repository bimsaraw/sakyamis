
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
                    <h5 class="card-title">Student Attendance - Classroom Report</h5>
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
                                    <th>Allocations</th>
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

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation!</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>
        <form id="frmdeleteAttendance">
        <div class="modal-body"> 
            <div class="form-group">
              <input type="hidden" name="studentId" id="m_studentID" />
              <input type="hidden" name="date" id="m_date" />
              <input type="hidden" name="time" id="m_time" />
              <input type="hidden" name="allocateId" id="m_allocateId" />
              ​<p>Are you Sure want to delete this attendance?</p>
              <div class="validation-feedback fb_new2" id="fb_new2"></div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button>
        </div>
        </form>
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

      $('#frmdeleteAttendance').submit(function(e) {
          e.preventDefault();
          var form = $('#frmdeleteAttendance');
          $.ajax({
                type : "POST",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/attendance/delete_clss_attendance', // target element(s) to be updated with server response
                data: form.serialize(),
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
                    get_attendance_details()
                    $('#deleteModal').modal('hide');
                }
            }); 
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
                url: '<?php echo base_url(); ?>index.php/attendance/get_classroom_attendance_detail', // target element(s) to be updated with server response
                data: {studentId:studentId},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                  console.log(response)
                  if(response=='no-perm'){
                    $('#alertArea').show();
                    $('#alertArea').addClass("alert-warning");
                    $('#alertArea').html("Permissions denied!");
                    }
                var t = $('#dataTable').DataTable();
                t.clear().draw();
                var counter = 1;    
                    $.each(response,function(key, val) {
                    
                            t.row.add( [
                                  counter,
                                  val.date,
                                  val.time,
                                  val.batch + " - " + val.batchname,
                                  "<button class='btn btn-danger btn-sm' onclick=delete_cls_attendance('" + val.studentId+"','"+val.date+"','"+val.time +"','"+val.allocateId + "') data-toggle='modal' data-target='#deleteModal'><i class='far fa-trash-alt'></i></button>"
                              ] ).draw( false );
                            studentname=val.full_name;  
                            counter++;
                    });
                    document.getElementById("studentname").innerHTML ="Student Name : " + studentname;
                    document.getElementById("studentname").style.display="block";
                    $.unblockUI();
                }
            });
        }  
 

function delete_cls_attendance(studentid,date,time,allocateId){
  $.blockUI();
  console.log(studentid,date,time,allocateId);
  document.getElementById("m_studentID").value = studentid;
  document.getElementById("m_date").value = date;
  document.getElementById("m_time").value = time;
  document.getElementById("m_allocateId").value = allocateId;
  $.unblockUI();
}     
</script>
