             
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
                <h5 class="card-title">Available Exams</h5>
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
                              <th><a href="<?=base_url();?>index.php/exam/add" class="btn btn-primary btn-sm">Add New</a></th>
                            </tr>
                          </thead>
                              <tbody>
                            <?php $count = 1; foreach($exams as $exam){ ?>
                            <tr>
                            <td><?= $count;?> </td>
                                <td><?= $exam['branchName'];?> </td>
                                <td><?= $exam['batchId'];?>  </td>
                                <td><?= $exam['moduleName'];?> </td>
                                <td><?= $exam['date'];?> </td>
                                <td><?php $p= $exam['purpose'];
                                switch ($p) {
                                    case 1:
                                     echo  "Final Exam";
                                      break;
                                    case 2:
                                        echo  "Repeat Exam 1";
                                      break;
                                    case 3:
                                        echo  "Repeat Exam 2";
                                      break;
                                    case 4:
                                        echo  "Repeat Exam 3";
                                        break;
                                    case 5:
                                        echo  "Repeat Exam 4";
                                        break;
                                    case 6:
                                        echo  "Assignment";
                                        break;
                                    case 7:
                                        echo  "Presentation";
                                        break;
                                    case 8:
                                        echo  "MOCK exam";
                                        break;
                                  }
                                ?> </td>
                                <td><?= $exam['name'];?></td>
                                <td><?= $exam['start_time'];?> </td>
                                <td><?= $exam['end_time'];?> </td>
                                <td>
                                <input type="checkbox" <?php if($exam['status']==1) { echo "checked"; } ?> id="status_<?=$exam['id']; ?>" onchange="set_status('<?=$exam['id']; ?>')" data-toggle="toggle" data-size="sm" value="1"></input>
                                <button class="btn btn-danger btn-sm" onclick="delete_exam(<?=$exam['id']; ?>)"  data-toggle="modal" data-target="#delete"><i class="fa fa-trash" aria-hidden="true"></i></button> </div>
                                 
                                 </td>
                            </tr>
                            <?php $count++; }?>
                              </tbody>
                        </table>
                    </div>
                    <p><span> If the status is off after the refresh can't view that exam on the table. </span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="modalLbl">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation!</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>
        <?php $attributes = array('id' => 'deleteexam', 'method' => 'post');
                        echo form_open('exam/delete_exam', $attributes); ?>
        <div class="modal-body"> 
            <div class="form-group">
              <input type="hidden" name="examId" id="examId" />
              <p> Are you sure want to delete this Exam? </p>
              <div class="validation-feedback fb_new2" id="fb_new2"></div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
        <?php echo form_close(); ?>
        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>
</div>

<script>

  $(document).ready(function() {
    $('#dataTable').DataTable(); //data table 
    
  })
 
</script>

<script>
 function delete_exam(examId){
    $('#examId').val(examId);

    }

function set_status(examId){
var state =$('#status_'+examId).val();
var status;
if (state==1){
    $('#status_'+examId).val(0);
    status =0;
}
if (state==0) {
    $('#status_'+examId).val(1);
    status =1;
}
$.blockUI();

    $.ajax({
        type : "POST",
        //set the data type
        url: '<?php echo base_url(); ?>index.php/exam/set_status', // target element(s) to be updated with server response
        data: {examId:examId,status:status},
        cache : false,
        //check this in Firefox browser
        success : function(response){
        console.log("done")
        $.unblockUI();
        }
    });

}
</script>
