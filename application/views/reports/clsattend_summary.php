
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

                    <form id="frmattendance">
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
                        
                        <div class="form-group col-md-3" id="divschdate" style="display:none" >
                          <label>Schedule Date <span class="required"> *</span></label>
                          <input type="text" class="form-control form-control-sm" name="date" id="date" autocomplete="off" required>
                          <input type="hidden" id="startDate" name="startDate">
                          <input type="hidden" id="endDate" name="endDate">
                        </div>
              
                        </div>
                        <div class="form-row">
                                <div class="form-group col-md-3">
                                  <label>Course</label>
                                  <select class="form-control form-control-sm" name="courseId" id="courseId">
                                      <option value="">-- Please Select --</option>
                                  </select>
                                </div>
                                <div class="form-group col-md-3">
                                  <label>Module</label>
                                  <select class="form-control form-control-sm" name="moduleId" id="moduleId" >
                                      <option value="">-- Please Select --</option>
                                  </select>
                                </div>
                                <div class="form-group col-md-3">
                                  <label>Batch</label>
                                  <select class="form-control form-control-sm" name="batch" id="batch">
                                      <option value="">-- Please Select --</option>
                                  </select>
                                </div>
                            </div>
                      <div class="form-row">     
                        <div class="col-md-3">
                          <button type="submit" class="btn btn-primary btn-sm">Generate Report</button>
                        </div>
                      </div>
                   
                    </form>

                    <div class="table table-responsive">
                        <table class="table table-stripped" id="dataTable">
                          <thead>
                          <h6 class="text-center" style="text-decoration:underline">Attendance Summary</h6>
                            <tr>
                              <th>No</th>
                              <th>Student Id</th>
                              <th>Student Name</th>
                              <th>Date</th>
                              <th>Time</th>
                              <th>Batch</th>
                              <th>Module</th>
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

<script>

  $(document).ready(function() {
   
    $('#branchId').bind('change',function() {
      if ($('#branchId').val()==0){
        $('#divschdate').css('display', 'none');
      
      }else {
      $('#divschdate').css('display', 'block');
    
      }

      var branchId = $("#branchId").val();
      $.ajax({
                type : "get",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/reports/get_batchs_by_branch', // target element(s) to be updated with server response
                data: {branchId:branchId},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                  console.log(response)
                  $('#batch').children().remove().end()
                  $(' <option value="">-- Please Select --</option>').appendTo('#batch');
                    $.each(response,function(key, val) {
                        $('<option value='+val.batchId+'>'+val.batchId+'</option>').appendTo('#batch');
                    });
                }
            });

    });

    $('#courseId').bind('change',function() {
      var courseId = $("#courseId").val();
      var branchId = $("#branchId").val();
      var startdate= $('#startDate').val();
      var enddate= $('#endDate').val();
          $.ajax({
                type : "get",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/reports/get_module_by_schedule_course', // target element(s) to be updated with server response
                data: {courseId:courseId,startdate:startdate,enddate:enddate,branchId:branchId},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                  $('#moduleId').children().remove().end()
                  $(' <option value="">-- Please Select --</option>').appendTo('#moduleId');
                    $.each(response,function(key, val) {
                      
                        $('<option value='+val.moduleId+'>'+val.name+'</option>').appendTo('#moduleId');
                    });
                }
            });
    });
     
    $('#frmattendance').submit(function(e) {
        e.preventDefault();
        $.blockUI();
        var form = $('#frmattendance');

              $.ajax({
              type: "POST",
              url: '<?php echo base_url(); ?>index.php/reports/generate_attsummary_table',
              data: form.serialize(),
              success: function(response) {
                console.log(response);
                var table = $('#dataTable').DataTable();
                var count=1;
                table 
                    .clear()
                    .draw();
                $.each(response,function(key, val) {
                  table.row.add( [
                          count,
                          val.studentId,
                          val.full_name,
                          val.date,
                          val.time,
                          val.batch,
                          val.module
                   ] ).draw();
                   count++;
                });  
                $.unblockUI();             
              }
              });
            });

      var table = $('#dataTable').DataTable( {
          lengthChange: false,
          buttons: [
              'copyHtml5',
              'excelHtml5',
              'csvHtml5',
    
            {
              extend: 'print',
              
              customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .prepend(
                            '<h3>Attendance Summary</h3>'
                        );
              }
            }
          ]
      } );

    table.buttons().container()
        .appendTo( '#dataTable_wrapper .col-md-6:eq(0)' );
        $('.dt-buttons > button').addClass('btn');
        $('.dt-buttons > button').addClass('btn-secondary');
        $('.dt-buttons > button').addClass('btn-sm');
  
  })

  

  $(function() {
      //var options = { twentyFour: true }
      //$('.timepicker').wickedpicker(options);
      $('#date').daterangepicker({
          locale: {
            format: 'YYYY-MM-DD'
          },
          opens: 'right'
      }, function(start, end, label) {
          $('#startDate').val(start.format('YYYY-MM-DD'));
          $('#endDate').val(end.format('YYYY-MM-DD'));

          var startDate =start.format('YYYY-MM-DD');
          var endDate =end.format('YYYY-MM-DD');
          var branchId = $("#branchId").val();
          $.ajax({
                type : "get",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/reports/get_courses_by_schedule_dates', // target element(s) to be updated with server response
                data: {startDate:startDate,endDate:endDate,branchId:branchId},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                  console.log(response);
                  $('#courseId').children().remove().end()
                  $(' <option value="">-- Please Select --</option>').appendTo('#courseId');
                    $.each(response,function(key, val) {
                        console.log(val.name);
                        $('<option value='+val.id+'>'+val.name+'</option>').appendTo('#courseId');
                    });
                }
            });


        });
    });



</script>
