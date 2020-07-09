
<div class="container-fluid">

<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
    </li>
    <li class="breadcrumb-item active"><?php echo $title; ?></li>
</ol>

<div class="row">
    <div class="col-xl-4 col-sm-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $title; ?></h5>

                <?php foreach($lecturers as $lecturer) { ?>
                    <div class="course-area">
                        <a onclick="get_allocations(<?php echo $lecturer['id']; ?>)" href="#collapse"><h6><?php echo $lecturer['name']; ?></h6></a>
                    </div>
                <?php } ?>
            </div>
            <div class="card-body">
                <?php if(isset($msg)) {
                        if($msg==1) { ?>
                            <div class="alert alert-success">Lecturer added successfully!</div>
                <?php
                        }
                } ?>

                <?php echo form_open('lecturers/add'); ?>
                    <div class="form-group">
                        <label for="lecturerName">Lecturer Name</label>
                        <input type="text" name="lecturerName" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Add Lecturer</button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-body" id="moduleArea">
                <p id="instructions">Select a lecturer from left side to allocated modules for him/her.</p>
                    <?php if(isset($allocate)) {
                            if($allocate==1) { ?>
                                        <div class="alert alert-success">Lecturer allocated successfully!</div>
                            <?php
                                }
                    } ?>

                    <?php if(isset($delete)) {
                            if($delete==1) { ?>
                                        <div class="alert alert-success">Lecturer removed successfully!</div>
                            <?php
                                }
                        } ?>

                <div class="row" id="allocatedModules" style="display:none;">
                    <div class="col-md-6">
                        <h6>Allocated Modules</h6>
                        <?php echo form_open('lecturers/remove_allocation'); ?>
                            <input type="hidden" name="allocateName" class="allocateName">
                            <div class="form-group">
                                <select id="selectAllocated" name="selectAllocated[]" class="form-control" multiple required="" size="15">
                                </select>
                            </div>
                            <button type="submit" id="btnRemove" class="btn btn-warning btn-sm">Remove from this Lecturer</button>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="col-md-6">
                        <h6>Modules available for allocation</h6>
                        <?php echo form_open('lecturers/allocate'); ?>
                            <input type="hidden" name="allocateName" class="allocateName">
                            <div class="form-group">
                                <select id="selectAllocations" name="selectAllocations[]" class="form-control" required="" size="15" multiple>
                                    <?php foreach($modules as $module) { ?>
                                        <option value="<?php echo $module['id']; ?>"><?php echo $module['name']." - ".$module['courseName']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm" id="searchAllocation" placeholder="Search">
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" id="btnAdd" class="btn btn-success btn-sm">Add to this Lecturer</button>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <button type="submit" id="btnAdd" class="btn btn-primary btn-sm" data-toggle="modal" style="display:none;" data-target="#modalAddModule">Add Module</button>
            </div>
        </div>
    </div>
</div>

</div>

<script>
    function get_allocations(lecturerId) {
        $.blockUI();
        $('.alert').hide();
        $('#selectAllocated').empty();
        $('.allocateName').val(lecturerId);
        $('#allocatedModules').show();
        $('#instructions').hide();
        $.ajax({
            type : "GET",
            //set the data type
            url: '<?php echo base_url(); ?>index.php/lecturers/allocated_modules', // target element(s) to be updated with server response
            data: {lecturerId:lecturerId},
            cache : false,
            //check this in Firefox browser
            success : function(response){
                $.each(response,function(key, val) {
                    console.log(val.moduleName);
                    $('<option value='+val.moduleId+'>'+val.moduleName+'</option>').appendTo('#selectAllocated');
                });
                $.unblockUI();
            }
        });
    }

    $('#searchAllocation').bind('change', function() {
        $.blockUI();
        var search = $(this).val();
        $('#selectAllocations').empty();
        $.ajax({
            type : "GET",
            //set the data type
            url: '<?php echo base_url(); ?>index.php/modules/search', // target element(s) to be updated with server response
            data: {searchString:search},
            cache : false,
            //check this in Firefox browser
            success : function(response){
                $.each(response,function(key, val) {
                    console.log(val.moduleName);
                    $('<option value='+val.id+'>'+val.name+' - '+this.courseName+'</option>').appendTo('#selectAllocations');
                });
                $.unblockUI();
            }
        });
    });
</script>
