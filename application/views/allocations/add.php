
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
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#lecture">Lectures</a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#event">Events</a>
      </li> -->
    </ul>
    
    <div class="tab-content">
      <div class="tab-pane container active" id="lecture">
        <?php echo form_open('allocations/save_lecture'); ?>
        <div class="form-row">
        <div class="col-md-3">
                    <div class="form-group">
                        <label for="lecturerId">Select Branch</label>
                        <select id="L_allocateBranch" name="L_allocateBranch" class="form-control form-control-sm">
                        <option value="">--- Select Branch ---</option>
                        <?php foreach ($branches as $branch) { ?>
                            <option value="<?= $branch['id']; ?>"><?= $branch['name']; ?></option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
        </div>
            <div class="form-row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="courseId">Select Course</label>
                        <select name="courseId" id="courseId" class="form-control form-control-sm" required>
                            <option value="">- Please select the Course -</option>
                            <?php foreach ($courses as $course) { ?>
                                <option value="<?=$course['id'];?>"><?=$course['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="batchId">Select Batch</label>
                        <select name="batchId" id="batchId" class="form-control form-control-sm" required>
                            <option value="">- Please select the Batch -</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="semesterId">Select Semester</label>
                        <select name="semesterId" id="semesterId" class="form-control form-control-sm" required>
                                <option value="">- Please select the Semester -</option>
                                <?php foreach ($semesters as $semester) { ?>
                                    <option value="<?=$semester['id']; ?>"><?=$semester['name']; ?></option>
                                <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="moduleId">Select Module</label>
                        <select name="moduleId" id="moduleId" class="form-control form-control-sm" required>
                                <option value="">- Please select the Module -</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dateRange">Date Range</label>
                        <input type="text" name="daterange" id="daterange" class="form-control form-control-sm" autocomplete="off" required>
                        <input type="hidden" id="startDate" value="<?php echo date("yy-m-d"); ?>" name="startDate">
                        <input type="hidden" id="endDate" value="<?php echo date("yy-m-d"); ?>" name="endDate">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="scheduleDay">Day of the Week</label>
                        <input type="text" id="scheduleDay" class="form-control form-control-sm" name="scheduleDay"  readonly="true" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Time Duration (08:00 - 14:00)</label>
                        <div class="form-row">
                            <div class="col-md-6">
                                <input type="text" name="startTime" id="startTime" autocomplete="off" class="timepicker form-control form-control-sm" required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="endTime" id="endTime" autocomplete="off" class="timepicker form-control form-control-sm" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <label>Purpose of Allocation</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="scheduleType" id="scheduleLecture" value="1" checked>
                        <label class="form-check-label" for="scheduleLecture">
                            Lecture
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="scheduleType" id="scheduleExam" value="2">
                        <label class="form-check-label" for="scheduleExam">
                            Examination
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="classroomId">Select Classroom</label>
                        <select name="classroomId" id="classroomId" class="form-control form-control-sm" required>
                        <option value="">- Select a classroom from available -</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="lecturerId">Select Lecturer</label>
                        <select name="lecturerId" id="lecturerId" class="form-control form-control-sm" required>
                            <option value="">- Select a Lecturer from available -</option>
                        </select>
                    </div>
                </div>
               
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p>Once you select everything, verify the selection and save. System will automatically reserve classroom throughout the given range.</p>
                    <button type="submit" class="btn btn-primary btn-sm">Save Allocation</button>
                    <a class="btn btn-secondary btn-sm" href="<?php echo base_url(); ?>index.php/allocations/">Go Back</a>
                </div>
            </div>

        <?php echo form_close(); ?>
      </div>

    
</div>


<script>
  $(document).ready(function() {
    var d = new Date();
            var weekday = new Array(7);
            weekday[0] = "Sunday";
            weekday[1] = "Monday";
            weekday[2] = "Tuesday";
            weekday[3] = "Wednesday";
            weekday[4] = "Thursday";
            weekday[5] = "Friday";
            weekday[6] = "Saturday";

            var n = weekday[d.getDay()];
            
            $('#scheduleDay').val(n);
            $('#scheduleDayEvent').val(n);
  })
           

    $('#courseId').bind('change',function() {
        var courseId = $(this).val();
        $('#batchId').empty();
        $('#semesterId').val('');
        $('#moduleId').empty();
        $('#startTime').val('');
        $('#endTime').val('');
        //$('#classroomId').empty();
        $('#lecturerId').empty();
        $.ajax({
                type : "GET",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/batches/get_batches_by_course', // target element(s) to be updated with server response
                data: {courseId:courseId},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                    $.each(response,function(key, val) {
                        console.log(val.moduleName);
                        $('<option value='+val.id+'>'+val.name+'</option>').appendTo('#batchId');
                    });
                }
            });
    });

    $('#batchId').bind('change',function() {
      $('#semesterId').val('');
      $('#moduleId').empty();
      $('#startTime').val('');
      $('#endTime').val('');
      //$('#classroomId').empty();
      $('#lecturerId').empty();
    });

    $('#L_allocateBranch').bind('change',function () {

        var branchId = $('#L_allocateBranch').val();
        $.ajax({
                type : "GET",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/classrooms/get_classroom_by_branch', // target element(s) to be updated with server response
                data: {branchId:branchId},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                    $('#classroomId').empty();
                    $('<option>-Please Select-</option>').appendTo('#classroomId');
                    $.each(response,function(key, val) {
                        console.log(val.name);
                        $('<option value='+val.id+'>'+val.name+'</option>').appendTo('#classroomId');
                    });
                }
            });
    });
    $('#EventeBranch').bind('change',function () {

    var branchId = $('#EventeBranch').val();
    $.ajax({
            type : "GET",
            //set the data type
            url: '<?php echo base_url(); ?>index.php/classrooms/get_classroom_by_branch', // target element(s) to be updated with server response
            data: {branchId:branchId},
            cache : false,
            //check this in Firefox browser
            success : function(response){
                $('#classroomIdEvent').empty();
                $('<option>-Please Select-</option>').appendTo('#classroomIdEvent');
                $.each(response,function(key, val) {
                    console.log(val.name);
                    $('<option value='+val.id+'>'+val.name+'</option>').appendTo('#classroomIdEvent');
                });
            }
        });
    });

    $('#semesterId').bind('change',function() {
        var courseId = $('#courseId').val();
        var semesterId = $(this).val();
        $('#moduleId').empty();
        $('#startTime').val('');
        $('#endTime').val('');
        //$('#classroomId').empty();
        $('#lecturerId').empty();
        $.ajax({
                type : "GET",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/modules/get_modules_by_course_semester', // target element(s) to be updated with server response
                data: {courseId:courseId,semesterId:semesterId},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                    $.each(response,function(key, val) {
                        console.log(val.name);
                        $('<option value='+val.id+'>'+val.name+'</option>').appendTo('#moduleId');
                    });
                }
            });
    });

    $('#moduleId').bind('change',function() {
      $('#startTime').val('');
      $('#endTime').val('');
      $('#classroomId').prop('selectedIndex', 0);
      $('#lecturerId').empty();
    });


//lectures classroom availability check
    $('#lecturerId').change(function() { 
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var startTime = $('#startTime').val();
        var endTime = $('#endTime').val();
        var scheduleDay = $('#scheduleDay').val();
        var batchId = $('#batchId').val();
        var lecturerId = $('#lecturerId').val();
        var branchId = $('#L_allocateBranch').val();


        var error =[];  

        if(startDate==""){error.push("start date ");}
        if(endDate==""){error.push("/ End date ");}
        if(startTime==""){error.push("/ start Time ");}
        if(endTime==""){error.push("/ End time ");}
        if(scheduleDay==""){error.push("/ schedule ");}
        if(batchId==""){error.push("/ batch ");}
        if(branchId==""){error.push("/ branch ");}


        startTime = $.trim(startTime.replace(/\s\s+/g, ''));
        endTime = $.trim(endTime.replace(/\s\s+/g, ''));
        if (!Array.isArray(error) || !error.length) {
        $.ajax({
                type : "GET",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/lecturers/availability', // target element(s) to be updated with server response
                data: {
                    startDate:startDate,
                    startTime:startTime,
                    endTime:endTime,
                    scheduleDay:scheduleDay,
                    batchId:batchId,
                    lecturerId:lecturerId,
                    branchId:branchId},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                    console.log(response);  
                     if (response.length >=1){
                        $.each(response,function(key, val) {    
                        $("#lecturerId").addClass('is-invalid');
                                var c = confirm('Leturer you selected has been allocated to '+ val.course+'  and  batch '+val.batch +' lecture during same hours. Please click on Confirm to proceed.');
                                if(c==true){
                                    $("#lecturerId").removeClass('is-invalid');
                                } else {
                                    $("#lecturerId option:selected").prop("selected", false);
                                    $("#lecturerId").removeClass('is-invalid');
                                }
                        });
                     }
                }
            });

        } else {
            alert(error + "empty..!");
            $("#lecturerId option:selected").prop("selected", false);
        }
    });

    $('#classroomId').change(function() {
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var startTime = $('#startTime').val();
        var endTime = $('#endTime').val();
        var scheduleDay = $('#scheduleDay').val();
        var batchId = $('#batchId').val();
        var classroomId = $('#classroomId').val();
        var branchId = $('#L_allocateBranch').val();


        var error =[];  

        if(startDate==""){error.push("start date ");}
        if(endDate==""){error.push("/ End date ");}
        if(startTime==""){error.push("/ start Time ");}
        if(endTime==""){error.push("/ End time ");}
        if(scheduleDay==""){error.push("/ schedule ");}
        if(batchId==""){error.push("/ batch ");}
        if(branchId==""){error.push("/ branch ");}


        startTime = $.trim(startTime.replace(/\s\s+/g, ''));
        endTime = $.trim(endTime.replace(/\s\s+/g, ''));
        if (!Array.isArray(error) || !error.length) {
        $.ajax({
                type : "GET",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/classrooms/availability', // target element(s) to be updated with server response
                data: {
                    startDate:startDate,
                    startTime:startTime,
                    endTime:endTime,
                    scheduleDay:scheduleDay,
                    batchId:batchId,
                    classroomId:classroomId,
                    branchId:branchId},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                    console.log(response);  
                     if (response.length >=1){
                        $.each(response,function(key, val) {    
                        $("#classroomId").addClass('is-invalid');
                                var c = confirm('The classroom you selected has been allocated to '+ val.course+'  and  batch '+val.batch +' lecture during same hours. Please click on Confirm to proceed.');
                                if(c==true){
                                    $("#batchId").removeClass('is-invalid');
                                } else {
                                    $("#classroomId option:selected").prop("selected", false);
                                    $("#batchId").removeClass('is-invalid');
                                }
                        });
                     }
                }
            });

        } else {
            alert(error + "empty..!");
            $("#classroomId option:selected").prop("selected", false);
        }
    });
    
    //event
    $('#endTimeEvent').bind('keyup',function() {
        var startDate = $('#startDateEvent').val();
        var endDate = $('#endDateEvent').val();
        var startTime = $('#startTimeEvent').val();
        var endTime = $('#endTimeEvent').val();
        var scheduleDay = $('#scheduleDayEvent').val();
        var branchId = $('#EventeBranch').val();

        startTime = $.trim(startTime.replace(/\s\s+/g, ''));
        endTime = $.trim(endTime.replace(/\s\s+/g, ''));
       
        $.ajax({
                type : "GET",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/classrooms/availability', // target element(s) to be updated with server response
                data: {startDate:startDate,endDate:endDate,startTime:startTime,endTime:endTime,scheduleDay:scheduleDay,branchId:branchId},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                    console.log(response);
                    $.each(response,function(key, val) {
                        $('<option value='+val.id+'>'+val.name+'</option>').appendTo('#classroomIdEvent');
                    });
                }
            });
    });
   
   //lecture
    $('#moduleId').change(function() {
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var startTime = $('#startTime').val();
        var endTime = $('#endTime').val();
        var scheduleDay = $('#scheduleDay').val();
        var moduleId = $('#moduleId').val();

     
        startTime = $.trim(startTime.replace(/\s\s+/g, ''));
        endTime = $.trim(endTime.replace(/\s\s+/g, ''));
        //$('#lecturerId').empty();
        $.ajax({
                type : "GET",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/lecturers/moduleLecturer', // target element(s) to be updated with server response
                data: {startDate:startDate,endDate:endDate,startTime:startTime,endTime:endTime,scheduleDay:scheduleDay,moduleId:moduleId},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                    console.log(response);
                    $('<option>--- Select ----</option>').appendTo('#lecturerId');
                    $.each(response,function(key, val) {
                       
                        $('<option value='+val.id+'>'+val.name+'</option>').appendTo('#lecturerId');
                    });
                    $('<option value="22">Examination</option>').appendTo('#lecturerId');
                }
            });
    });

//event
    $('#endTime').bind('keyup',function() {
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var startTime = $('#startTime').val();
        var endTime = $('#endTime').val();
        var scheduleDay = $('#scheduleDay').val();
        var batchId = $('#batchId').val();

        startTime = $.trim(startTime.replace(/\s\s+/g, ''));
        endTime = $.trim(endTime.replace(/\s\s+/g, ''));
        $.ajax({
                type : "GET",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/allocations/batch_conflict', // target element(s) to be updated with server response
                data: {startDate:startDate,endDate:endDate,startTime:startTime,endTime:endTime,scheduleDay:scheduleDay,batchId:batchId},
                cache : false,
                //check this in Firefox browser
                success : function(response){

                    if(response=='conflict') {
                        $("#batchId").addClass('is-invalid');
                        var c = confirm('The batch you selected has been allocated to another lecture during same hours. This may be permitted only if there are two groups present in this batch. Please click on Confirm to proceed.');
                        if(c==true){
                            $("#batchId").removeClass('is-invalid');
                        } else {
                            $('#batchId').val("");
                            $("#batchId").removeClass('is-invalid');
                        }
                    } else {
                        $("#batchId").addClass('is-valid');
                    }
                }
            });
    });

    $(function() {
        //var options = { twentyFour: true }
        //$('.timepicker').wickedpicker(options);
        $('input[name="daterange"]').daterangepicker({
            opens: 'right'
        }, function(start, end, label) {
            $('#startDate').val(start.format('YYYY-MM-DD'));
            $('#endDate').val(end.format('YYYY-MM-DD'));

            $('#startDateEvent').val(start.format('YYYY-MM-DD'));
            $('#endDateEvent').val(end.format('YYYY-MM-DD'));

            var d = new Date($('#startDate').val());
            var weekday = new Array(7);
            weekday[0] = "Sunday";
            weekday[1] = "Monday";
            weekday[2] = "Tuesday";
            weekday[3] = "Wednesday";
            weekday[4] = "Thursday";
            weekday[5] = "Friday";
            weekday[6] = "Saturday";

            var n = weekday[d.getDay()];

            $('#scheduleDay').val(n);
            $('#scheduleDayEvent').val(n);

            $('#startTime').val('');
            $('#endTime').val('');
            //$('#classroomId').empty();
            $('#lecturerId').empty();

            $('#startTimeEvent').val('');
            $('#endTimeEvent').val('');
            //$('#classroomIdEvent').empty();
            //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });

        $('#color').colorpicker();

        $('#color').on('colorpickerChange', function(event) {
          $('#color').css('backgroundColor',$('#color').val());
        });
    });
</script>
