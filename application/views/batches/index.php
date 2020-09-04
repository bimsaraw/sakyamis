
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
     <?php if(isset($msg)) {
        if($msg==1) { ?>
        <div class="alert alert-success">Batch added successfully!</div>
        <?php }} ?>
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
                                <th>Branch</th>
                                <th>Head Count</th>
                                <th>Course Enrolled</th>
                                <th>Enrollmnent Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($batches as $batch): ?>
                                <tr>
                                    <td><?php echo $batch['name']; ?></td>
                                    <td><?php echo $batch['branchName']; ?></td>
                                    <td><?php echo $batch['heads']; ?></td>
                                    <td><?php echo $batch['courseName']; ?></td>
                                    <td><input type="checkbox" <?php if($batch['status']==1) { echo "checked"; } ?> id="status_<?= $batch['id']; ?>" onchange="set_status('<?= $batch['id']; ?>')" data-toggle="toggle" data-size="sm" value="1"></td>
                                    <td>
                                    <button class="btn btn-primary btn-sm" onclick="get_batch_details('<?= $batch['id']; ?>')"><i class="far fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger" onclick="get_delete_batch('<?= $batch['id']; ?>')"><i class="far fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-body">
               
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <?php echo form_open('batches/add'); ?>
        <div class="form-group">
                <label for="branchtype">Branch</label>
                <select name="branchId" class="form-control form-control-sm" required>
                    <option></option>
                    <?php foreach ($branch as $branches): ?>
                        <option value="<?php echo $branches['id']; ?>"><?php echo $branches['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
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
                        <option value="<?php echo $course['id'];?>"><?php echo $course['name']; ?></option>
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


<div class="modal fade" id="editbatch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Batch</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body"> 
        <?php $attributes = array('id' => 'updatebatch', 'method' => 'post');
                        echo form_open('Batches/edit_batch', $attributes); ?>
            <div class="form-group">
                <input type="text" class="form-control form-control-sm" name="batchId" id="m_batchid" readonly required>
            </div>
            <div class="form-group">
                <label for="batchName">Batch Name</label>
                <input type="text" class="form-control form-control-sm" name="batchName" id="m_batchname"required>
            </div>
            <div class="form-group">
                <label for="batchHeads">Batch Heads</label>
                <input type="text" class="form-control form-control-sm" name="batchHeads" id="m_batchheads"  required>
            </div>
            <div class="form-group">
                <label for="batchCourseId">Course enrolled</label>
                <select class="form-control form-control-sm" name="batchCourseId" id="m_batchcourse" required>
                    <option value=""></option>
                    <?php foreach($courses as $course) { ?>
                        <option value="<?php echo $course['id']; ?>">
                        <?php echo $course['name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="branchtype">Branch</label>
                <select name="branchId" id="m_branchId" class="form-control form-control-sm" required>
                    <option></option>
                    <?php foreach ($branch as $branches): ?>
                        <option value="<?php echo $branches['id']; ?>"><?php echo $branches['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
              <label for="batch_color">Select a Color</label>
              <input id="m_batchcolor" name="batch_color" type="text" class="form-control form-control-sm col-md-2" style="color:#fff;" value="" autocomplete="off" required/>
            </div>
          
        <div class="modal-footer">
        <button type="submit" class="btn btn-outline-primary">Save Changes</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
        </div>
         <?php echo form_close(); ?>
    </div>
    </div>
    </div>
</div>


<div class="modal fade" id="deletebatch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
              <input type="hidden" name="batchid" id="md_batchid" />
           
              <div class="validation-feedback fb_new2" id="fb_new2"></div>
            </div>
        </div>
        <div class="modal-footer">
        <a href="somelink" type="button" class="btn btn-outline-danger btn-sm " data-dismiss="modal" onclick="delete_confirm()">Delete</a>
       
        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button>
        </div>

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

    $(document).ready(function() {
        $('#dataTable').DataTable();
        $('#m_batchcolor').colorpicker();

        $('#m_batchcolor').on('colorpickerChange', function(event) {
          $('#m_batchcolor').css('backgroundColor',$('#m_batchcolor').val());
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

    // --start edit delete section--
    //edit area
    function get_batch_details(batchid) {
      $.blockUI();
      var m_batchcolor = document.getElementById("m_batchcolor");
      $.ajax({
          type : "GET",
          //set the data type
          url: '<?php echo base_url(); ?>index.php/batches/get_batch_detail', // target element(s) to be updated with server response
          data: {batchid:batchid},
          cache : false,
          //check this in Firefox browser
          success : function(response){
              $.each(response,function(key, val) {
                document.getElementById("m_batchid").value = batchid;
                document.getElementById("m_batchname").value = val.name;
                document.getElementById("m_batchheads").value = val.heads;
                document.getElementById("m_batchcourse").value = val.courseId;  
                document.getElementById("m_batchcolor").value = val.batch_color; 
                document.getElementById("m_branchId").value = val.branch; 
                m_batchcolor.style.backgroundColor = val.batch_color;   
              });
          }
      });
      $('#editbatch').modal('show');
      $.unblockUI();
    }

    function get_delete_batch(batchid) {
      $.blockUI();
      $.ajax({
          type : "GET",
          //set the data type
          url: '<?php echo base_url(); ?>index.php/batches/get_batch_detail', // target element(s) to be updated with server response
          data: {batchid:batchid},
          cache : false,
          //check this in Firefox browser
          success : function(response){
              $.each(response,function(key, val) {
                var base_url = window.location.origin;
                document.getElementById("md_batchid").value = val.id;
                document.getElementById("delete_lable").innerHTML ="Are you sure want to delete "+val.name + "?"
              });
          }
      });
      $('#deletebatch').modal('show');
      $.unblockUI();
    }

    function delete_confirm() {
        var id =document.getElementById("md_batchid").value;
        window.location.assign("Batches/delete_batch?batchid="+id)
    }
</script>
