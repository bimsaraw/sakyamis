
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
                    <h5 class="card-title"><?php echo $title; ?></h5>
                    <hr>

                    <?php echo form_open('exam/addExam'); ?>
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
                          <div class="form-group col-md-2">
                            <label>Exam Date  <span class="required"> *</span></label>
                            <input type="text" name="date" id="daterange" class="form-control form-control-sm date" autocomplete="off" required>
                          </div>  
                          <div class="form-group col-md-2">
                            <label>Start Time  <span class="required"> *</span></label>
                            <input type="text" name="startTime" id="startTime" class="form-control form-control-sm time" autocomplete="off" required>
                          </div>  
                          <div class="form-group col-md-2">
                            <label>End Time  <span class="required"> *</span></label>
                            <input type="text" name="endTime" id="endTime" class="form-control form-control-sm time" autocomplete="off" required>
                          </div>  

                          <div class="form-group col-md-3">
                                  <label>Purpose  <span class="required"> *</span></label>
                                  <select class="form-control form-control-sm" name="purpose" id="purpose" required >
                                      <option value="1">Final Exam</option>
                                      <option value="2">Repeat Exam 1 </option>
                                      <option value="3">Repeat Exam 2 </option>
                                      <option value="4">Repeat Exam 3 </option>
                                      <option value="5">Repeat Exam 4 </option>
                                      <option value="6">Assignment </option>
                                      <option value="7">Presentation </option>
                                      <option value="8">MOCK exam </option>
                                  </select>
                                </div>
                              </div> 
                        <div class="form-row">  
                            <div class="form-group col-md-9">
                              <label>Exam Name</label>
                              <input type="text" name="name" id="name" class="form-control form-control-sm" autocomplete="off" >
                          </div> 
                        </div>
                      <div class="form-row">     
                        <div class="col-md-3">
                          <button type="submit" class="btn btn-primary btn-sm">Save Exam</button>
                          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#clone"><i class="fa fa-clone"></i>  Clone Schedule</button>
                        </div>
                      </div>
                   
                      <?php echo form_close(); ?>
                  </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="clone" tabindex="-1" role="dialog" aria-labelledby="modalLbl">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Clone Examination Schedule</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            </div>
            <div class="modal-body"> 
            <?php echo form_open('exam/cloneExam'); ?>
                <div class="form-group">
                <div class="form-row">  
                        
                          <div class="form-group col-md-12"> 
                            <label>Name</label>
                            <input type="text" name="name" id="cloneEname" class="form-control form-control-sm" autocomplete="off">
                          </div>
                                <div class="form-group col-md-5">
                                  <label>Purpose  <span class="required"> *</span></label>
                                  <select class="form-control form-control-sm" name="purpose" id="purpose" required >
                                      <option value="1">Final Exam</option>
                                      <option value="2">Repeat Exam 1 </option>
                                      <option value="3">Repeat Exam 2 </option>
                                      <option value="4">Repeat Exam 3 </option>
                                      <option value="5">Repeat Exam 4 </option>
                                      <option value="6">Assignment </option>
                                      <option value="7">Presentation </option>
                                      <option value="8">MOCK exam </option>
                                  </select>
                            </div>
                  </div>
                <table class="table table-stripped" id="dataTable">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Branch</th>
                              <th>Batch</th>
                              <th>Module</th>
                              <th>Date</th>
                              <th>Start Time</th>
                              <th>End Time</th>
                              <th></th>
                            </tr>
                          </thead>
                              <tbody>
                            <?php $count = 1; foreach($allocates as $allocate){ ?>
                            <tr>
                            <td><?= $count;?> </td>
                                <td><?= $allocate['branchName'];?> </td>
                                <td><?= $allocate['batchId'];?> </td>
                                <td><?= $allocate['moduleName'];?> </td>
                                <td><?= $allocate['date'];?> </td>
                                <td><?= $allocate['startTime'];?> </td>
                                <td><?= $allocate['endTime'];?> </td>
                                <td><div class="col-2 align-self-center"> <input class="form-check-input" type="radio" name="allocateId" id="allocateId" required value="<?=$allocate['id']; ?>"></div> </td>
                            </tr>
                            <?php $count++; }?>
                              </tbody>
                        </table>
                </div>
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-outline-danger btn-sm"> <i class="fa fa-clone"></i> Clone</button>
            <?php echo form_close(); ?>
            <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {

  $('body').on('focus',".date", function(){
      $(this).daterangepicker(
        {
      locale: {format: 'YYYY-MM-DD'},
      singleDatePicker: true,
      showDropdowns: true,
      minYear: 2018,
      maxYear: parseInt(moment().format('YYYY'),10)
    }, function(start, end, label) {
      $(this).val(end.format('YYYY-MM-DD'));
    }
      );
    })

    $('body').on('focus',".time", function(){
      $(this).timepicker(
        {
          timeFormat: 'HH:mm',
          interval: 30,
          minTime: '06:00am',
          maxTime: '9:00pm',
          defaultTime: '08:30am',
          startTime: '06:00am',
          dynamic: false,
          dropdown: true,
          scrollbar: true
    });
    })


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
  
  
})

function clone(allocateId){
  $.ajax({
              type : "get",
              //set the data type
              url: '<?php echo base_url(); ?>index.php/exam/get_allocate_exam_details', // target element(s) to be updated with server response
              data: {allocateId:allocateId},
              cache : false,
              //check this in Firefox browser
              success : function(response){
                console.log(response); 
                  
                  $.each(response,function(key, val) {
                    $('#branchId').val(val.branchId).change();
                    $('#courseId').val(val.courseId);
                   
                    
                    $('#startTime').removeClass('time');
                    $('#startTime').val(val.startTime);
                    $('#endTime').removeClass('time');
                    $('#endTime').val(val.endTime);
                    $('#daterange').removeClass('date');
                    $('#daterange').val(val.date);
                    $('#batchId').empty();
                    $(' <option value="'+val.batchId+'">'+val.batchId+'</option>').appendTo('#batchId');
                    $('#moduleId').empty();
                    $(' <option value="'+val.moduleId+'">'+val.moduleName+'</option>').appendTo('#moduleId');
                  });
              }
          });
}


</script>       
