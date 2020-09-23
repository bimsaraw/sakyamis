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
                <h5 class="card-title">Student Examination Enrollment </h5>
                <form method="post">
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
                          <div class="form-group col-md-5">
                            <label>Exam <span class="required"> *</span></label>
                                  <select class="form-control form-control-sm" name="exam" id="exam" required>
                                      <option value="">-- Please Select --</option>
                                  </select>
                          </div>

                      </div>
                   
                  </form>
                <div class="row">
                  <div class="col-md-6">
                      <div class="card">
                          <div class="card-body">
                              <h5 class="card-title">Non Applied Students </h5>

                                  <div class="table-responsive">
                                      <table class="table table-stripped" id="table_nas" >
                                        <thead>
                                          <tr>
                                              <th>No</th>
                                              <th>Student Id</th>
                                              <th>Action</th>
                                          </tr>
                                        </thead>
                                            <tbody>
                                            </tbody>
                                      </table>
                                  </div> 
                                  <!-- close table -->
                                </div>
                              </div>
                          </div>
                      

                      <div class="col-md-6">
                        <div class="card">
                          <div class="card-body">
                              <h5 class="card-title">Applied Students </h5>

                                  <div class="table-responsive">
                                      <table class="table table-stripped" id="table_as" >
                                        <thead>
                                          <tr>
                                              <th>No</th>
                                              <th>Student Id</th>
                                              <th>Action</th>
                                          </tr>
                                        </thead>
                                            <tbody>
                                            </tbody>
                                      </table>
                                  </div> 
                                  <!-- close table -->
                                </div>
                              </div>
                        
                      </div>
                </div>
            </div>
        </div>
    </div>




<script>

  $(document).ready(function() {
    $('#table_nas').DataTable(); //data table 
    $('#table_as').DataTable(); //data table 
 
  
 //get batches by branch
 $('#branchId').bind('change',function() {
 var branchId = $("#branchId").val();
      $.ajax({
                type : "get",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/exam/get_exams_by_branch', // target element(s) to be updated with server response
                data: {branchId:branchId},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                  console.log(response)
                  $('#exam').children().remove().end()
                  $(' <option value="">-- Please Select --</option>').appendTo('#exam');
                    $.each(response,function(key, val) {
                        
                        var purposename = purpose(parseInt(val.purpose));
                        $('<option value='+val.id+'>'+val.batchId+' - '+val.moduleName+ '~'+purposename+'</option>').appendTo('#exam');
                    });
                }
            });
  })

  //exam select function
  $('#exam').bind('change',function() {
    get_details();
  })
})

function get_details(){
  var examId = $("#exam").val();
      $.ajax({
                type : "get",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/exam/get_students_by_batch', // target element(s) to be updated with server response
                data: {examId:examId},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                  var t1 = $('#table_nas').DataTable(); var t2 = $('#table_as').DataTable();
                  t1.clear().draw(); t2.clear().draw();
                  var counter1 = 1; var counter2 = 1;   
                  
                    $.each(response['non_applied'],function(key, val) {
                      t1.row.add( [
                          counter1,
                          val.studentId,
                          '<button class="btn btn-primary btn-sm" onclick="apply_exam(`'+val.studentId+'`)"><i class="fa fa-plus"></i></button>'
                      ] ).draw( false );
                      counter1++;
                    });
                
                    $.each(response['applied'],function(key, val) {
                      console.log(val.studentId)
                      t2.row.add( [
                          counter2,
                          val.studentId,
                          '<button onclick="delete_RSID(`'+val.studentId+'`)" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i> </button>'
                      ] ).draw( false );
                      counter2++;
                    });
                }
            });         
}

function apply_exam(studentId){
  var examId = $("#exam").val();

  $.ajax({
                type : "post",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/exam/add_EF_student', // target element(s) to be updated with server response
                data: {examId:examId,studentId:studentId},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                  console.log(response)
                  get_details();
                }
            });

}

function test(){
  console.log("done");
}

function delete_RSID(studentId){
  var examId = $("#exam").val();

  $.ajax({
                type : "post",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/exam/delete_EF_student', // target element(s) to be updated with server response
                data: {examId:examId,studentId:studentId},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                  console.log(response)
                  get_details();
                }
            });

}

function purpose(id) {
    switch (id) {
          case 1:
           return  "Final Exam";
            break;
          case 2:
            return  "Repeat Exam 1";
            break;
          case 3:
            return  "Repeat Exam 2";
            break;
          case 4:
            return  "Repeat Exam 3";
              break;
          case 5:
            return  "Repeat Exam 4";
              break;
          case 6:
            return  "Assignment";
              break;
          case 7:
            return  "Presentation";
              break;
          case 8:
            return  "MOCK exam";
              break;
          default:
            break;
        }
  }

</script>
