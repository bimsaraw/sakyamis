
<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active"><?php echo $title; ?></li>
    </ol>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Intakes</h5>
                    <div class="table-responsive">
                        <table class="table" id="dataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Intake Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($intakes as $intake): ?>
                                    <tr>
                                      <td><?php echo $intake['name']; ?></td>
                                      <td><?= $intake['startDate']; ?></td>
                                      <td><?= $intake['endDate']; ?></td>
                                      <td><a href="<?= base_url(); ?>index.php/inquiries/targets?intakeId=<?= $intake['id']; ?>&intakeName=<?= $intake['name']; ?>" class="btn btn-sm btn-warning">Targets</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body">
                    <?php if(isset($msg)) {
                            if($msg==1) { ?>
                                <div class="alert alert-success">Intake added successfully!</div>
                    <?php
                            }
                    } ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <?php echo form_open('inquiries/add_intake'); ?>
                <div class="form-group">
                    <label for="intakeName">Intake Name</label>
                    <input type="text" class="form-control form-control-sm" name="intakeName" required>
                </div>
                <div class="form-group">
                    <label for="dateRange">Date Range</label>
                    <input type="text" name="daterange" class="form-control form-control-sm" required>
                    <input type="hidden" id="startDate" name="startDate">
                    <input type="hidden" id="endDate" name="endDate">
                </div>
                <div class="form-group">
                    <button type="submit" name="btnAddIntake" class="btn btn-primary btn-sm">Add Intake</button>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();

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
    } );
</script>
