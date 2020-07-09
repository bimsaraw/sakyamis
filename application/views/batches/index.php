
<div class="container-fluid">

<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
    </li>
    <li class="breadcrumb-item active"><?php echo $title; ?></li>
</ol>

<div class="row">
    <div class="col-xl-6 col-sm-6 mb-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Batches</h5>
                <p class="card-text">Student Batches enrolled to Saegis Campus</p>
                <div class="table-responsive">
                    <table class="table table-stripped" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Batch</th>
                                <th>Head Count</th>
                                <th>Course Enrolled</th>
                                <th>Enrollmnent Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($batches as $batch): ?>
                                <tr>
                                    <td><?php echo $batch['name']; ?></td>
                                    <td><?php echo $batch['heads']; ?></td>
                                    <td><?php echo $batch['courseName']; ?></td>
                                    <td><input type="checkbox" <?php if($batch['status']==1) { echo "checked"; } ?> id="status_<?= $batch['id']; ?>" onchange="set_status('<?= $batch['id']; ?>')" data-toggle="toggle" data-size="sm" value="1"></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-body">
                <?php if(isset($msg)) {
                        if($msg==1) { ?>
                            <div class="alert alert-success">Batch added successfully!</div>
                <?php
                        }
                } ?>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <?php echo form_open('batches/add'); ?>
            <div class="form-group">
                <label for="batchId">Batch Code</label>
                <input type="text" class="form-control form-control-sm" name="batchId" required>
            </div>
            <div class="form-group">
                <label for="batchName">Batch Name</label>
                <input type="text" class="form-control form-control-sm" name="batchName" required>
            </div>
            <div class="form-group">
                <label for="batchHeads">Batch Heads</label>
                <input type="text" class="form-control form-control-sm" name="batchHeads" required>
            </div>
            <div class="form-group">
                <label for="batchCourseId">Course enrolled</label>
                <select class="form-control form-control-sm" name="batchCourseId" required>
                    <option value=""></option>
                    <?php foreach($courses as $course) { ?>
                        <option value="<?php echo $course['id']; ?>"><?php echo $course['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
              <label for="batch_color">Select a Color</label>
              <input id="batch_color" name="batch_color" type="text" class="form-control form-control-sm col-md-2" style="color:#fff;" value="" autocomplete="off" required/>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Save Batch</button>
        <?php echo form_close(); ?>
    </div>
</div>

</div>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
        $('#batch_color').colorpicker();

        $('#batch_color').on('colorpickerChange', function(event) {
          $('#batch_color').css('backgroundColor',$('#batch_color').val());
        });
    } );

    function set_status(batchId) {

      if($('#status_'+batchId).is(":checked")) {
          $('#status_'+batchId).val(1);
      } else {
          $('#status_'+batchId).val(0);
      }

      var status = $('#status_'+batchId).val();

      $.blockUI();
      $.ajax({
          type : "POST",
          //set the data type
          url: '<?php echo base_url(); ?>index.php/batches/set_status', // target element(s) to be updated with server response
          data: {batchId:batchId,status:status},
          cache : false,
          //check this in Firefox browser
          success : function(response){
            $('#status_'+batchId).val(response);
            $.unblockUI();
          }
      });
    }
</script>
