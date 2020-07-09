
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
                <h5 class="card-title">Course Modules</h5>

                <?php foreach($courses as $course) { ?>
                    <div class="course-area">
                        <a onclick="get_modules(<?php echo $course['id']; ?>)" href="#collapse"><h6><?php echo $course['name']; ?></h6></a>
                    </div>
                <?php } ?>
            </div>
            <div class="card-body">
                <?php if(isset($msg)) {
                        if($msg==1) { ?>
                            <div class="alert alert-success">Classroom added successfully!</div>
                <?php
                        }
                } ?>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="card">
            <div class="card-body" id="moduleArea">
                <p>Select a course from left hand side to see available modules</p>
                <div id="collapse">
                    <ul class="module-list" id="moduleList">

                    </ul>
                </div>
                <button type="button" id="btnAdd" class="btn btn-primary btn-sm" data-toggle="modal" style="display:none;" data-target="#modalAddModule">Add Module</button>
            </div>
        </div>
    </div>
</div>

</div>



<!-- Add Module Modal -->
<div class="modal" tabindex="-1" role="dialog" id="modalAddModule">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add Course</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php echo form_open('modules/addModule', array('id'=>'frmAddModule')); ?>
        <div class="modal-body">
            <input type="hidden" id="moduleCourse" class="form-control form-control-sm" readonly>
            <div class="form-group">
                <label for="moduleName">Module Name</label>
                <input type="text" class="form-control form-control-sm" id="moduleName" required>
            </div>
            <div class="form-group">
                <label for="moduleSemester">Semester</label>
                <select id="moduleSemester" class="form-control form-control-sm" required>
                    <option value="">- Select Semester -</option>
                    <?php foreach($semesters as $semester) { ?>
                        <option value="<?php echo $semester['id']; ?>"><?php echo $semester['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" name="btnAddModule" class="btn btn-primary btn-sm">Save changes</button>
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
</div>
<!--/ Add course modal -->

<script>
    function get_modules(courseId) {
        document.getElementById('moduleList').innerHTML ="";
        $('#btnAdd').show();
        $('#moduleCourse').val(courseId);
        $.ajax({
            type : "GET",
            //set the data type
            url: '<?php echo base_url(); ?>index.php/modules/show', // target element(s) to be updated with server response
            data: {courseId:courseId},
            cache : false,
            //check this in Firefox browser
            success : function(response){
                $.each(response,function(key, val) {
                    console.log(val.name);
                    $('<li>'+val.name+'</li>').appendTo('#moduleList');
                });
            }
        });
    }

    $(document).ready(function () {
        $("#frmAddModule").submit(function(event) {

            event.preventDefault();

            var name = $('#moduleName').val();
            var course = $('#moduleCourse').val();
            var semester = $('#moduleSemester').val();
            $.ajax({
                type : "POST",
                url: '<?php echo base_url(); ?>index.php/modules/add',
                data : {moduleName:name, moduleCourse:course, moduleSemester:semester},
                cache: false,
                success: function(response) {
                    if(response==1) {
                        get_modules(course);
                        $('#modalAddModule').modal('hide');
                    }
                }
            });
        });
    });
</script>
