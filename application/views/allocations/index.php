<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active"><?php echo $title; ?></li>
    </ol>

    <?php echo form_open('allocations/get_allocations_date'); ?>
        <div class="form-row">
            <div class="col-md-3">
                <select id="allocatedDates" name="allocatedDates" class="form-control form-control-sm">
                    <?php if(isset($selectedDate)) { ?>
                        <option value="<?=$selectedDate; ?>"><?=$selectedDate; ?></option>
                    <?php } ?>
                    <?php foreach($dates as $date) { ?>
                        <option value="<?=$date['date']; ?>"><?=$date['date']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-6">
                <button type="submit" id="btnDate" class="btn btn-primary btn-sm">Show Schedule</button>
                <a class="btn btn-secondary btn-sm" href="<?php echo base_url(); ?>index.php/allocations/add">Schedule</a>
                <?php if(isset($selectedDate)) { ?>
                  <a class="btn btn-dark btn-sm" target="_blank" href="<?php echo base_url(); ?>index.php/allocations/print_allocations_date?date=<?=$selectedDate;?>">Print</a>
                <?php } ?>
                <a href="<?php echo base_url(); ?>index.php/allocations/bulk_action" class="btn btn-info btn-sm">Bulk Actions</a>
            </div>
        </div>
    <?php echo form_close(); ?>
    <br>
    <style>
      <?php foreach($batches as $batch) {
        echo '.batch'.$batch['id'].'{';
          echo 'background-color: '.$batch['batch_color'].' !important; border:0 !important; cursor:pointer;';
        echo '}';
      } ?>

      <?php foreach($events as $event) {
        echo '.event'.$event['id'].'{';
          echo 'background-color: '.$event['color'].' !important; border:0 !important; cursor:pointer;';
        echo '}';
      } ?>
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="timetable" id="timetable">
            </div>
        </div>
    </div>

</div>

<div class="modal" tabindex="-1" id="viewModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalViewTitle">Subject Title and Date</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table table-stripped">
                    <tbody>
                        <tr>
                            <td>Batch</td>
                            <td id="tblBatch"></td>
                        </tr>
                        <tr>
                            <td>Time</td>
                            <td id="tblTime"></td>
                        </tr>
                        <tr>
                            <td>Lecturer</td>
                            <td id="tblLecturer"></td>
                        </tr>
                        <tr>
                            <td>Purpose</td>
                            <td id="tblPurpose"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" id="inputAllocateId">
            <input type="hidden" id="inputDate">
            <a href="" type="button" class="btn btn-info btn-sm"  id="btnmarkAttEvent">Mark Attendance</a>
            <button type="button" class="btn btn-danger btn-sm" id="btnDelete">Delete Allocation</button>
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="viewModalEvent" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalEventViewTitle">Subject Title and Date</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table table-stripped">
                    <tbody>
                        <tr>
                            <td>Time</td>
                            <td id="tblTimeEvent"></td>
                        </tr>
                        <tr>
                            <td>Purpose</td>
                            <td id="tblPurposeEvent"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" id="inputEventId">
            <input type="hidden" id="inputEventDate">
            <button type="button" class="btn btn-danger btn-sm" id="btnDeleteEvent">Delete Event</button>
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        var timetable = new Timetable();
        timetable.setScope(8, 21);

        timetable.addLocations([
            <?php foreach($classes as $class) {
                echo "'".$class['name']."',";
            } ?>
        ]);

        <?php foreach($allocations as $a) { ?>

            var allocateId = <?= $a['id']; ?>;

            var options = {
                class: 'batch<?= $a["batchId"]; ?>', // additional css class
                title: '<?= $a["courseName"]; ?> - <?= $a["batchId"]; ?>',
                data: { // each property will be added to the data-* attributes of the DOM node for this event
                },
                onClick: function(event, timetable, clickEvent) {
                    editAllocation(<?= $a['id']; ?>);
                }
            };

            timetable.addEvent("<?= $a['batchId']; ?> - <?= $a['moduleName']; ?>", "<?= $a['classroomName']; ?>", new Date("<?= $a['date']; ?> <?= $a['startTime']; ?>"), new Date("<?= $a['date']; ?> <?= $a['endTime']; ?>"),options);
        <?php } ?>

        <?php foreach($events as $a) { ?>

            var eventId = <?= $a['id']; ?>;

            var optionsEvent = {
                class: 'event<?= $a["id"]; ?>',
                title: '<?= $a["name"]; ?>',
                data: { // each property will be added to the data-* attributes of the DOM node for this event
                },
                onClick: function(event, timetable, clickEvent) {
                    editEvent(<?= $a['id']; ?>);
                }              
            };

            timetable.addEvent("<?= $a['name']; ?>","<?= $a['classroomName']; ?>", new Date("<?= $a['date']; ?> <?= $a['startTime']; ?>"), new Date("<?= $a['date']; ?> <?= $a['endTime']; ?>"),optionsEvent);
        <?php } ?>



        var renderer = new Timetable.Renderer(timetable);
        renderer.draw('.timetable'); // any css selector

    });

    $('#btnDelete').click(function() {
        var id = $('#inputAllocateId').val();
        var date = $('#inputDate').val();
        console.log(id);

        window.location.href = '<?php echo base_url(); ?>index.php/allocations/delete_allocation?id='+id+'&date='+date;
    });

    $('#btnDeleteEvent').click(function() {
        var id = $('#inputEventId').val();
        var date = $('#inputEventDate').val();
        console.log(id);

        window.location.href = '<?php echo base_url(); ?>index.php/allocations/delete_event?id='+id+'&date='+date;
    });

    $('#btnPrint').click(function() {
        $("#timetable").print();
    });

    function editAllocation(id) {
        console.log(id);
        $.blockUI();
        $.ajax({
            type : "GET",
            url: '<?php echo base_url(); ?>index.php/allocations/get_allocation_by_id',
            data : {id:id},
            cache: false,
            success: function(response) {
                $.each(response,function(key, val) {
                    $('#inputAllocateId').val(id);
                    $('#modalViewTitle').html(val.moduleName+' - '+val.date);
                    $('#inputDate').val(val.date);
                    $('#tblBatch').html(val.batchName);
                    $('#tblTime').html(val.startTime+" - "+val.endTime);
                    $('#tblLecturer').html(val.lecturerName);
                    $("#btnmarkAttEvent").attr("href", "<?= base_url(); ?>index.php/attendance/classroom_attendance?allocate_id="+id);
                    if(val.purpose==1) {
                        $('#tblPurpose').html('Lecture');
                    } else if(val.purpose==2) {
                        $('#tblPurpose').html('Examination');
                    }
                    $('#viewModal').modal('show');
                    $.unblockUI();
                });
            }
        });
    }

    function editEvent(id) {
        console.log(id);
        $.blockUI();
        $.ajax({
            type : "GET",
            url: '<?php echo base_url(); ?>index.php/allocations/get_event_by_id',
            data : {id:id},
            cache: false,
            success: function(response) {
                $.each(response,function(key, val) {
                    $('#inputEventId').val(id);
                    $('#modalEventViewTitle').html(val.name);
                    $('#inputEventDate').val(val.date);
                    $('#tblTimeEvent').html(val.startTime+" - "+val.endTime);
                    $('#tblPurposeEvent').html(val.name);
                    $('#viewModalEvent').modal('show');
                    $.unblockUI();
                });
            }
        });
    }


</script>
