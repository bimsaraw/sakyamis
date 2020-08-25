
<style type="text/css" media="print">
  @page { size: landscape; }
</style>
<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <h4><?=$selectedDate;?> ~ <?php foreach($selectBranch as $branch){ echo $branch['name']; } ;?></h4>
    </ol>

    <style>
      <?php foreach($batches as $batch) {
        echo '.batch'.$batch['id'].'{';
          echo 'background-color: '.$batch['batch_color'].' !important; border:0 !important';
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

<script>
    $(document).ready(function() {

        var timetable = new Timetable();
        timetable.setScope(8, 19);

        timetable.addLocations([
            "",
            <?php foreach($batches as $batch) {
                echo "'".$batch['batchId']."',";
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

            timetable.addEvent("<?= $a['lecturerName']; ?> -<?= $a['courseName']; ?> - <?= $a['moduleName']; ?> | <?= $a['classroomName']; ?>", "<?= $a['batchId']; ?>", new Date("<?= $a['date']; ?> <?= $a['startTime']; ?>"), new Date("<?= $a['date']; ?> <?= $a['endTime']; ?>"),options);
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

    $('#btnPrint').click(function() {
        $("#timetable").print();
    });

    function editAllocation(id) {
        console.log(id);
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
                });
            }
        });
    }


</script>
