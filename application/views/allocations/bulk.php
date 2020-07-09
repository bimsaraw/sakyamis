
<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active"><?php echo $title; ?></li>
    </ol>

    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#lecture">Lectures</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#event">Events</a>
      </li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane container active" id="lecture">
        <form id="search_lecture">
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
                        <select name="batchId" id="batchId" class="form-control form-control-sm" >
                            <option value="">- Please select the Batch -</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="semesterId">Select Semester</label>
                        <select name="semesterId" id="semesterId" class="form-control form-control-sm" >
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
                        <select name="moduleId" id="moduleId" class="form-control form-control-sm" >
                                <option value="">- Please select the Module -</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dateRange">Date Range</label>
                        <input type="text" name="daterange" class="form-control form-control-sm" autocomplete="off">
                        <input type="hidden" id="startDate" name="startDate">
                        <input type="hidden" id="endDate" name="endDate">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="scheduleDay">Day of the Week</label>
                        <input type="text" id="scheduleDay" class="form-control form-control-sm" name="scheduleDay" readonly="true">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-sm">Search</button>
                    <a class="btn btn-secondary btn-sm" href="<?php echo base_url(); ?>index.php/allocations/">Go Back</a>
                </div>
            </div>

        </form>
        <hr>
        <?php echo form_open('allocations/delete_lectures'); ?>
          <div class="text-right">
            <button type="button" id="selectAll" data-selected="false" class="btn btn-outline-primary btn-sm">Select All</button>
            <button type="submit" id="deleteAll" onclick="return confirm('Are you sure you want to delete selected?')" disabled class="btn btn-outline-danger btn-sm"><i class="far fa-trash-alt"></i> Delete Selected</button>
          </div>
          <div class="table-responsive">
            <table id="lectureTable" class="table table-stripped">
              <thead>
                <tr>
                  <th></th>
                  <th>Date</th>
                  <th>Time Slot</th>
                  <th>Classroom</th>
                  <th>Course</th>
                  <th>Batch</th>
                  <th>Module</th>
                  <th>Lecturer</th>
                </tr>
              </thead>
              <tbody>

              </tbody>

            </table>
          </div>
        <?php echo form_close(); ?>
      </div>

      <div class="tab-pane container" id="event">
        <?php echo form_open('allocations/save_event'); ?>

          <div class="form-row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Name of the Event</label>
                <input type="text" class="form-control form-control-sm" name="name" required>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label>Date Range</label>
                <input type="text" name="daterange" class="form-control form-control-sm" autocomplete="off" required>
                <input type="hidden" id="startDateEvent" name="startDate">
                <input type="hidden" id="endDateEvent" name="endDate">
              </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="scheduleDay">Day of the Week</label>
                    <input type="text" id="scheduleDayEvent" class="form-control form-control-sm" name="scheduleDay" readonly="true" required>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Time Duration</label>
                    <div class="form-row">
                        <div class="col-md-6">
                            <input type="text" name="startTime" id="startTimeEvent" autocomplete="off" class="timepicker form-control form-control-sm" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="endTime" id="endTimeEvent" autocomplete="off" class="timepicker form-control form-control-sm" required>
                        </div>
                    </div>
                </div>
            </div>
          </div>

          <div class="row">
              <div class="col-md-12">
                  <button type="submit" class="btn btn-primary btn-sm">Search</button>
                  <a class="btn btn-secondary btn-sm" href="<?php echo base_url(); ?>index.php/allocations/">Go Back</a>
              </div>
          </div>



        <?php echo form_close(); ?>
      </div>
    </div>

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


    $('#search_lecture').submit(function(e) {
        $.blockUI();
        e.preventDefault();
        var form = $('#search_lecture');
        $.ajax({
                type : "POST",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/allocations/search_lecture', // target element(s) to be updated with server response
                data: form.serialize(),
                cache : false,
                //check this in Firefox browser
                success : function(response){
                    $.each(response,function(key, val) {
                      t.row.add([
                        "<input type='hidden' name='id[]' value='"+val.id+"'><input type='checkbox' onchange='enableDelete()' name='delete[]' value='"+val.id+"' class='form-check-input delete_checkbox'>",
                        val.date,
                        val.startTime+" - "+val.endTime,
                        val.classroomName,
                        val.courseName,
                        val.batchName,
                        val.moduleName,
                        val.lecturerName
                      ]).draw();
                    });
                    $.unblockUI();
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
            $('#classroomId').empty();
            $('#lecturerId').empty();

            $('#startTimeEvent').val('');
            $('#endTimeEvent').val('');
            $('#classroomIdEvent').empty();
            //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });

        $('#color').colorpicker();

        $('#color').on('colorpickerChange', function(event) {
          $('#color').css('backgroundColor',$('#color').val());
        });
    });

    $(document).ready(function() {
        var buttonCommon = {
            exportOptions: {
                format: {
                    body: function ( data, row, column, node ) {
                        // Strip $ from salary column to make it numeric
                        return column === 5 ?
                            data.replace( /[$,]/g, '' ) :
                            data;
                    }
                }
            }
        };
        t = $('#lectureTable').DataTable({
          "autoWidth": false,
          "order": [[ 0, 'desc' ]],
          "drawCallback": function() {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select class="form-control form-control-sm"><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );

          },
          dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'print'
            ],
        });

        t.buttons().container()
            .appendTo( '#dataTable_wrapper .col-md-6:eq(0)' );
            $('.dt-buttons > button').addClass('btn');
            $('.dt-buttons > button').addClass('btn-secondary');
            $('.dt-buttons > button').addClass('btn-sm');


        $('#selectAll').click(function() {
          if($(this).data("selected")==false) {
            $('#selectAll').data("selected",true);
            $('#selectAll').html('Deselect All');
            $('.delete_checkbox').prop("checked",true);
            enableDelete();
          } else {
            $('#selectAll').data("selected",false);
            $('.delete_checkbox').prop("checked",false);
            $('#selectAll').html('Select All');
            enableDelete();
          }
        });

        <?php
        if($this->session->flashdata('message')) {
          $message = $this->session->flashdata('message');
            ?>
            $.notify({
               // options
               title: '<?php echo $message['title']; ?>',
               message: '<?php echo $message['message']; ?>'
               },{
               // settings
               type: '<?php echo $message['class']; ?>'
             });
         <?php } ?>

      });

      function enableDelete() {
        console.log('test');
        if($('.delete_checkbox').prop("checked")==true) {
          $('#deleteAll').prop("disabled",false);
        } else {
          $('#deleteAll').prop("disabled",true);
        }
      }

</script>
