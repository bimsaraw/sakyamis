
<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active"><?php echo $title; ?></li>
    </ol>

    <?php echo form_open('allocations/save'); ?>
        <div class="form-row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="courseId">Select Course</label>
                    <select name="courseId" id="courseId" class="form-control form-control-sm" required>
                        <option value="">- Please select the Course -</option>
                        <?php foreach($courses as $course) { ?>
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
                            <?php foreach($semesters as $semester) { ?>
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
                    <input type="text" name="daterange" class="form-control form-control-sm" required>
                    <input type="hidden" id="startDate" name="startDate">
                    <input type="hidden" id="endDate" name="endDate">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="scheduleDay">Day of the Week</label>
                    <input type="text" id="scheduleDay" class="form-control form-control-sm" name="scheduleDay" readonly="true" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Time Duration</label>
                    <div class="form-row">
                        <div class="col-md-6">
                            <input type="text" name="startTime" id="startTime" class="timepicker form-control form-control-sm" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="endTime" id="endTime" class="timepicker form-control form-control-sm" required>
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
                    <input class="form-check-input" type="radio" name="scheduleType" id="scheduleExam" value="12">
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
                        <option value="0">Examination</option>
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

<script>
    $('#courseId').bind('change',function() {
        var courseId = $(this).val();
        $('#batchId').empty();
        $('#semesterId').val('');
        $('#moduleId').empty();
        $('#startTime').val('');
        $('#endTime').val('');
        $('#classroomId').empty();
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
      $('#classroomId').empty();
      $('#lecturerId').empty();
    });

    $('#semesterId').bind('change',function() {
        var courseId = $('#courseId').val();
        var semesterId = $(this).val();
        $('#moduleId').empty();
        $('#startTime').val('');
        $('#endTime').val('');
        $('#classroomId').empty();
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
      $('#classroomId').empty();
      $('#lecturerId').empty();
    });

    $('#endTime').bind('keyup',function() {
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var startTime = $('#startTime').val();
        var endTime = $('#endTime').val();
        var scheduleDay = $('#scheduleDay').val();
        var batchId = $('#batchId').val();

        startTime = $.trim(startTime.replace(/\s\s+/g, ''));
        endTime = $.trim(endTime.replace(/\s\s+/g, ''));
        $('#classroomId').empty();
        $.ajax({
                type : "GET",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/classrooms/availability', // target element(s) to be updated with server response
                data: {startDate:startDate,endDate:endDate,startTime:startTime,endTime:endTime,scheduleDay:scheduleDay,batchId:batchId},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                    $.each(response,function(key, val) {
                        console.log(val.name);
                        $('<option value='+val.id+'>'+val.name+'</option>').appendTo('#classroomId');
                    });
                }
            });
    });

    $('#endTime').bind('keyup',function() {
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var startTime = $('#startTime').val();
        var endTime = $('#endTime').val();
        var scheduleDay = $('#scheduleDay').val();
        var moduleId = $('#moduleId').val();

        startTime = $.trim(startTime.replace(/\s\s+/g, ''));
        endTime = $.trim(endTime.replace(/\s\s+/g, ''));
        $('#lecturerId').empty();
        $.ajax({
                type : "GET",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/lecturers/availability', // target element(s) to be updated with server response
                data: {startDate:startDate,endDate:endDate,startTime:startTime,endTime:endTime,scheduleDay:scheduleDay,moduleId:moduleId},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                    $.each(response,function(key, val) {
                        console.log(val.name);
                        $('<option value='+val.id+'>'+val.name+'</option>').appendTo('#lecturerId');
                    });
                    $('<option value="22">Examination</option>').appendTo('#lecturerId');
                }
            });
    });

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
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });
</script>
