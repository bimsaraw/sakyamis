
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($intakes as $intake): ?>
                                    <tr>
                                      <td><?php echo $intake['name']; ?></td>
                                      <td><?= $intake['startDate']; ?></td>
                                      <td><?= $intake['endDate']; ?></td>
                                      <td><a href="<?= base_url(); ?>index.php/inquiries/targets?intakeId=<?= $intake['id']; ?>&intakeName=<?= $intake['name']; ?>" class="btn btn-sm btn-warning">Targets</a></td>
                                      <td>
                                            <button class="btn btn-primary btn-sm" onclick="get_intake_details('<?= $intake['id']; ?>')"><i class="far fa-edit"></i></button>             
                                            <button class="btn btn-sm btn-danger" onclick="get_delete_intake('<?= $intake['id']; ?>')"><i class="far fa-trash-alt"></i></button>
                                      </td>  
                                     
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

<div class="modal fade" id="editintakes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Course</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body"> 
        <?php $attributes = array('id' => 'updatecourse', 'method' => 'post');
                        echo form_open('inquiries/edit_intake', $attributes); ?>

            <div class="form-group">
              <label>Intake Name</label>
              <input type="hidden" name="m_intakeid" id="m_intakeid" value="" />
              <input type="text" class="form-control form-control-sm " id="m_intake_name" name="m_name"/>
              <div class="validation-feedback fb_new2" id="fb_new2"></div>
            </div>
            <div class="form-group">
                    <label for="dateRange">Date Range</label>
                    <input type="text" name="daterange" id="m_range_date" class="form-control form-control-sm" required>
                    <input type="hidden" id="m_startDate" name="m_startDate">
                    <input type="hidden" id="m_endDate" name="m_endDate">
            </div>
            <div class="form-group">
                    <label for="dateRange">Status</label>
                    <input type="checkbox"  name="m_status" id="checkbox" data-toggle="toggle" data-size="sm" value="1" >
            </div>
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-outline-primary">Save Changes</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
        </div>
         <?php echo form_close(); ?>
    </div>
    </div>
</div>



<div class="modal fade" id="deleteintake" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation!</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body"> 
            <div class="form-group">
              ​<p id="delete_lable"></p>
              <input type="hidden" name="md_intakeid" id="md_intakeid" />
           
              <div class="validation-feedback fb_new2" id="fb_new2"></div>
            </div>
        </div>
        <div class="modal-footer">
        <a href="somelink" type="button" class="btn btn-outline-danger " data-dismiss="modal" onclick="delete_confirm()">Delete</a>
       
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
        </div>
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

    $(document).ready(function() {
        $('#dataTable').DataTable();

        $(function() {
            //var options = { twentyFour: true }
            //$('.timepicker').wickedpicker(options);
            $('input[name="daterange"]').daterangepicker({
                opens: 'right'
            }, function(start, end, label) {
                $('#m_startDate').val(start.format('YYYY-MM-DD'));
                $('#m_endDate').val(end.format('YYYY-MM-DD'));

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

    // --start edit delete section--
    //edit area
    function get_intake_details(intakeid) {
      $.blockUI();
     
      $.ajax({
          type : "GET",
          //set the data type
          url: '<?php echo base_url(); ?>index.php/inquiries/get_intake_detail', // target element(s) to be updated with server response
          data: {intakeid:intakeid},
          cache : false,
          //check this in Firefox browser
          success : function(response){
              $.each(response,function(key, val) {
                document.getElementById("m_intakeid").value = val.id;
                document.getElementById("m_intake_name").value = val.name;
                document.getElementById("m_range_date").value = val.startDate + " - " + val.endDate;
                document.getElementById("m_startDate").value = val.startDate;
                document.getElementById("m_endDate").value = val.endDate;   
                if (val.status==1){
                    $("#checkbox").prop("checked", true);
                }else{
                    $("#checkbox").prop("checked", false);
                }
                
              });
          }
      });
      $('#editintakes').modal('show');
      $.unblockUI();
    }

    function get_delete_intake(intakeid) {
      $.blockUI();
      $.ajax({
          type : "GET",
          //set the data type
          url: '<?php echo base_url(); ?>index.php/inquiries/get_intake_detail', // target element(s) to be updated with server response
          data: {intakeid:intakeid},
          cache : false,
          //check this in Firefox browser
          success : function(response){
              $.each(response,function(key, val) {
                var base_url = window.location.origin;
                document.getElementById("md_intakeid").value = val.id;
                document.getElementById("delete_lable").innerHTML ="Are you sure want to delete "+val.name + "?"
              });
          }
      });
      $('#deleteintake').modal('show');
      $.unblockUI();
    }
    

    function delete_confirm() {
        var id =document.getElementById("md_intakeid").value;
        window.location.assign("delete_intake?intakeid="+id)
    }
</script>
