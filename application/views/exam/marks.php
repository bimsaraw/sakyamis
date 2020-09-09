             
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
  echo '<div class="alert alert-danger">'; echo $this->session->flashdata('danger'); echo'</div> ';
}else if ($this->session->flashdata('warning')) {
  echo '<div class="alert alert-warning">'; echo $this->session->flashdata('warning'); echo'</div> ';
}else if ($this->session->flashdata('info')) {
  echo '<div class="alert alert-info">'; echo $this->session->flashdata('info'); echo'</div> ';
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Student Exam Marks</h5>
                    <div class="table-responsive">
                        <table class="table table-stripped" id="dataTable">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Branch</th>
                              <th>Batch</th>
                              <th>Module</th>
                              <th>Date</th>
                              <th>Purpose</th>
                              <th>Name</th>
                              <th>Start Time</th>
                              <th>End Time</th>
                              <th>Graded Scheme</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                              <tbody>
                            <?php $count = 1; foreach($exams as $exam){ ?>
                            <tr>
                            <td><?= $count;?> </td>
                                <td><?= $exam['branchName'];?> </td>
                                <td><?= $exam['batchId'];?> </td>
                                <td><?= $exam['moduleName'];?> </td>
                                <td><?= $exam['date'];?> </td>
                                <td><?php $p= $exam['purpose'];
                                $purposeCaption='';
                                switch ($p) {
                                    case 1:
                                     echo  "Final Exam";
                                     $purposeCaption = "Final Exam";
                                      break;
                                    case 2:
                                        echo  "Repeat Exam 1";
                                        $purposeCaption = "Repeat Exam 1";
                                      break;
                                    case 3:
                                        echo  "Repeat Exam 2";
                                        $purposeCaption = "Repeat Exam 2";
                                      break;
                                    case 4:
                                        echo  "Repeat Exam 3";
                                        $purposeCaption = "Repeat Exam 3";
                                        break;
                                    case 5:
                                        echo  "Repeat Exam 4";
                                        $purposeCaption = "Repeat Exam 4";
                                        break;
                                    case 6:
                                        echo  "Assignment";
                                        $purposeCaption = "Assignment";
                                        break;
                                    case 7:
                                        echo  "Presentation";
                                        $purposeCaption = "Presentation";
                                        break;
                                    case 8:
                                        echo  "MOCK exam";
                                        $purposeCaption = "MOCK exam";
                                        break;
                                  }
                                ?> </td>
                                <td><?= $exam['name'];?> </td>
                                <td><?= $exam['start_time'];?> </td>
                                <td><?= $exam['end_time'];?> </td>
                                <td><?= $exam['grade_scal'];?> </td>
                                <td><button class="btn btn-primary btn-sm" onclick="add_marks('<?=$exam['batchId']; ?>','<?=$exam['id']; ?>','<?=$exam['moduleName']; ?>','<?php echo $purposeCaption; ?>')"  data-toggle="modal" data-backdrop="static" data-keyboard="false"  data-target="#marksModal"><i class="fa fa-paperclip" aria-hidden="true"></i> Exam Marks</button> </div></td>
                            </tr>
                            <?php $count++; }?>
                              </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="marksModal" tabindex="-1" role="dialog" aria-labelledby="modalLbl">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Insert Student Marks </h5>
       
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>
     
        <?php $attributes = array('id' => 'insertMarks', 'method' => 'post');
                        echo form_open('exam/insert_marks', $attributes); ?>
        <div class="modal-body"> 
            <div class="form-group">
            <h6 id="moduleName"></h6>
            <input name="examId" id="examId" type="hidden">        
            <button type="submit" class="btn btn-outline-primary btn-sm">Save Marks</button>
            <table class="table table-stripped" id="marksTable" style="display:none;">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Student Id</th>
                              <th>Mark</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                              <tbody>
                              <div class="loader spinner" id="loader-2">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                              </tbody>
                        </table>
          
            </div>
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-outline-primary btn-sm">Save Marks</button>
        <?php echo form_close(); ?>
        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>
</div>
<link href="<?php echo base_url(); ?>css/spinner.css" rel="stylesheet">
<script>

  $(document).ready(function() {
    //$('#marksTable').DataTable(); //data table 
    $('#dataTable').DataTable(); //data table 
      $('#marksTable').dataTable({
      "bPaginate": false
      });

      $('.marksvalue').change(function() {
          var value = $(this).val();
          if(value>100){
            alert("Sorry.. invalid mark..!")
          }
          if(value<0){
            alert("Sorry.. invalid mark..!")
          }
      });
  })
 
</script>

<script>
 function delete_exam(examId){
    $('#examId').val(examId);
    }

function add_marks(batchId,examId,moduleName,purpose){
    $(".spinner").css("display", "block");
    $("#marksTable").css("display", "none");
    $("#moduleName"). html( moduleName + " - " + purpose +" - "+batchId );
    $('#examId').val(examId);
    $.ajax({
              type : "POST",
              //set the data type
              url: '<?php echo base_url(); ?>index.php/exam/get_batch_student', // target element(s) to be updated with server response
              data: {batchId:batchId,examId:examId},
              cache : false,
              //check this in Firefox browser
              success : function(response){
                console.log(response)
                var t = $('#marksTable').DataTable();
                var counter = 1;
                t.clear().draw();
                  $.each(response,function(key, val) {
                            t.row.add( [
                                counter,
                                val.studentId +'<input type="hidden" name="studentId[]" class="form-control form-control-sm" readonly value='+val.studentId+'>',
                                '<input type="text" name="marks[]" class="form-control form-control-sm marksvalue" value="0" id="mark_'+counter+'">',
                                '<button type="button" class="btn btn-warning btn-sm" onClick="lock_marks('+counter+')" ><i class="fa fa-lock"></i></button>'
                            ] ).draw( false );
                            counter++;
                  });
                  $(".spinner").css("display", "none");
                  $("#marksTable").css("display", "block");
              }
          });
    }

    function lock_marks(index){
        $("#mark_"+index).attr('readonly','readonly');

    }
</script>
