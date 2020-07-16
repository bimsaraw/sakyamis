
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
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Branches</h5>
                    <div class="table-responsive">
                        <table class="table" id="dataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Branches Avaiable</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($branches as $branch): ?>
                                    <tr>
                                        <td id="td_course_name"><?php echo $branch['name']; ?></td>
                                        <td id="td_course_name"><?php echo $branch['Location']; ?></td>
                                        <td>    
                                        <button class="btn btn-primary btn-sm" onclick="get_branch_details('<?= $branch['id']; ?>')"><i class="far fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger" onclick="get_delete_branch('<?= $branch['id']; ?>')"><i class="far fa-trash-alt"></i></button>     
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
                                <div class="alert alert-success">Branch added successfully!</div>
                    <?php
                            }
                    } ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <?php echo form_open('branches/add'); ?>
                <div class="form-group">
                    <label for="branchname">Branch Name</label>
                    <input type="text" class="form-control form-control-sm" name="branchname" required>
                </div>
                <div class="form-group">
                    <label for="branch_location">Branch Location</label>
                    <input type="text" class="form-control form-control-sm" name="location" >
                </div>
                <div class="form-group">
                    <button type="submit" name="btnAddCourse" class="btn btn-primary btn-sm">Add Branch</button>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>


<div class="modal fade" id="editbranch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Branch</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body"> 
        <?php $attributes = array('id' => 'updatebranch', 'method' => 'post');
                        echo form_open('Branches/edit_branch', $attributes); ?>

            <div class="form-group">
              <label>Branch Name</label>
              <input type="hidden" name="branchid" id="branch_id" value="" />
              <input type="text" class="form-control form-control-sm user-passwords" id="m_branch_name" name="Branchname"/>
              <div class="validation-feedback fb_new2" id="fb_new2"></div>
            </div>
            <div class="form-group">
                    <label for="branch_location">Branch Location</label>
                    <input type="text" class="form-control form-control-sm" name="location"  id="location" required>
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



<div class="modal fade" id="deletebranch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
              <input type="hidden" name="md_branchid" id="md_branchid" />
              <div class="validation-feedback fb_new2" id="fb_new2"></div>
            </div>
        </div>
        <div class="modal-footer">
        <a href="" type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal" onclick="delete_confirm()">Delete</a>
        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    } );

    function get_branch_details(branchid) {
      $.blockUI();
      $.ajax({
          type : "GET",
          //set the data type
          url: '<?php echo base_url(); ?>index.php/branches/get_branch_detail', // target element(s) to be updated with server response
          data: {branchid:branchid},
          cache : false,
          //check this in Firefox browser
          success : function(response){
              $.each(response,function(key, val) {
                document.getElementById("branch_id").value = branchid;
                document.getElementById("m_branch_name").value = val.name;  
                document.getElementById("location").value = val.Location;  
              });
              $('#editbranch').modal('show');
          }
      });
    
      $.unblockUI();
    }

    function get_delete_branch(branchid) {
      $.blockUI();
      $.ajax({
          type : "GET",
          //set the data type
          url: '<?php echo base_url(); ?>index.php/branches/get_branch_detail', // target element(s) to be updated with server response
          data: {branchid:branchid},
          cache : false,
          //check this in Firefox browser
          success : function(response){
              $.each(response,function(key, val) {
                document.getElementById("md_branchid").value = val.id;
                document.getElementById("delete_lable").innerHTML ="Are you sure want to delete "+val.name + "?"
              });
          }
      });
      $('#deletebranch').modal('show');
      $.unblockUI();
    }

    function delete_confirm() {
        var id =document.getElementById("md_branchid").value;
        window.location.assign("branches/delete?branchid="+id)
    }

</script>