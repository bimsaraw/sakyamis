
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
                    <h5 class="card-title"><?php echo $title; ?></h5>
                    <hr>

                    <form id="parameter">
                      <div class="form-row">
                              <div class="form-group col-md-3">
                                  <label>Branch <span class="required"> *</span></label>
                                        <select class="form-control form-control-sm" name="branchId" id="branchId" required>
                                            <option value="">-- Please Select --</option>
                                          <?php foreach ($branches as $branch) { ?>
                                            <option value="<?= $branch['id']; ?>"><?= $branch['name']; ?></option>
                                          <?php } ?>
                                        </select>
                                </div>
                                <div class="form-group col-md-3">
                                  <label>Batch  <span class="required"> *</span></label>
                                  <select class="form-control form-control-sm" name="batchId" id="batchId">
                                      <option value="">-- Please Select --</option>
                                  </select>
                                </div>
                               
                                <input type="hidden" name="courseId" id="courseId">
                                  
                                <div class="form-group col-md-3">
                                  <label>Module  <span class="required"> *</span></label>
                                  <select class="form-control form-control-sm" name="moduleId" id="moduleId" >
                                      <option value="">-- Please Select --</option>
                                  </select>
                                </div>
                              </div>
                     
                      <div class="form-row">     
                        <div class="col-md-3">
                          <button type="submit" class="btn btn-primary btn-sm">Find Exams</button>
                        </div>
                      </div>
                   
                     </form>
                  </div>
        </div>
        <br>
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
                              <th>Date</th>
                              <th>Purpose</th>
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
    </div>
    
 
<script>
$(document).ready(function() {

  $('#branchId').bind('change',function() {
    var branchId = $("#branchId").val();
    $.ajax({
              type : "get",
              //set the data type
              url: '<?php echo base_url(); ?>index.php/exam/get_batchs_by_branch', // target element(s) to be updated with server response
              data: {branchId:branchId},
              cache : false,
              //check this in Firefox browser
              success : function(response){
                console.log(response)
                $('#moduleId').children().remove().end()
                $('#batchId').children().remove().end()
                $(' <option value="">-- Please Select --</option>').appendTo('#batchId');
                  $.each(response,function(key, val) {
                      $('<option value='+val.id+'>'+val.id+'</option>').appendTo('#batchId');
                  });
              }
          });

  });

 

  $('#batchId').bind('change',function() {
 
    var batchId = $("#batchId").val();

        $.ajax({
              type : "get",
              //set the data type
              url: '<?php echo base_url(); ?>index.php/exam/get_courseModules_by_batch', // target element(s) to be updated with server response
              data: {batchId:batchId},
              cache : false,
              //check this in Firefox browser
              success : function(response){
                $('#courseId').val(response['courseId'])
                $('#moduleId').children().remove().end()
                $(' <option value="">-- Please Select --</option>').appendTo('#moduleId');
                  $.each(response['modules'],function(key, val) {
                    
                      $('<option value='+val.id+'>'+val.name+'</option>').appendTo('#moduleId');
                  });
              }
          });
  });
  
  $('#parameter').submit(function(e) {
          e.preventDefault();
          var form = $('#parameter');

          $.blockUI();
          $.ajax({
           type: "POST",
           url: '<?php echo base_url(); ?>index.php/exam/find_exams',
           data: form.serialize(),
           success: function(response) {
             console.log(response);
             var t = $('#dataTable').DataTable();
                var counter = 1;
                t.clear().draw();
                  $.each(response,function(key, val) {
                    var purposeName = purpose(parseInt(val.purpose));
                            t.row.add( [
                                counter,
                                val.date,
                                purposeName,
                                '<button class="btn btn-primary btn-sm" onclick="printSheet('+val.id +')">Print Result Sheet</button> '
                            ] ).draw( false );
                            counter++;
                  });

             $.unblockUI();
           }
          
         });
       
      });
    
})

function purpose(id) {
    switch (id) {
          case 1:
           return  "<p class='text-danger'>Final Exam</p>";
            break;
          case 2:
            return  "<p class='text-primary'>Repeat Exam 1</p>";
            break;
          case 3:
            return  "<p class='text-primary'>Repeat Exam 2</p>";
            break;
          case 4:
            return  "<p class='text-primary'>Repeat Exam 3</p>";
              break;
          case 5:
            return  "<p class='text-primary'>Repeat Exam 4</p>";
              break;
          case 6:
            return  "<p class='text-info'>Assignment</p>";
              break;
          case 7:
            return  "<p class='text-success'>Presentation</p>";
              break;
          case 8:
            return  "<p class='text-warning'>MOCK exam</p>";
              break;
          default:
            break;
        }
  }

function printSheet(examId) {
  var printWindow = window.open('<?= base_url(); ?>index.php/exam/results_summary?examId='+examId, 'Print Result Sheet', 'height=600,width=1000');
  printWindow.onload=function(){ // necessary if the div contain images

       printWindow.focus(); // necessary for IE >= 10
       printWindow.print();
       //printWindow.close();
   };
}
</script>       
