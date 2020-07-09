
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
                    <h5 class="card-title">Courses</h5>
                    <div class="table-responsive">
                        <table class="table" id="dataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Courses Avaiable</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($courses as $course): ?>
                                    <tr><td><?php echo $course['name']; ?></td></tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body">
                    <?php if(isset($msg)) { 
                            if($msg==1) { ?>
                                <div class="alert alert-success">Course added successfully!</div>
                    <?php
                            }
                    } ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <?php echo form_open('courses/addCourse'); ?>
                <div class="form-group">
                    <label for="courseName">Course Name</label>
                    <input type="text" class="form-control form-control-sm" name="courseName" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="btnAddCourse" class="btn btn-primary btn-sm">Add Course</button>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    } );
</script>