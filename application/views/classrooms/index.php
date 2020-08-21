
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
                <h5 class="card-title">Classrooms</h5>
                <p class="card-text">Classrooms available at Saegis Campus</p>
                <div class="table-responsive">
                    <table class="table table-stripped" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Classroom</th>
                                <th>Capacity</th>
                                <th>Type</th>
                                <th>Branch</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($classes as $class): ?>
                                <tr>
                                    <td><?php echo $class['name']; ?></td>
                                    <td><?php echo $class['capacity']; ?></td>
                                    <td><?php echo $class['type']; ?></td>
                                    <td><?php echo $class['branch']; ?></td>
                                    <td></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
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
        <?php echo form_open('classrooms/add'); ?>
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
                <label for="className">Identifier</label>
                <input type="text" class="form-control form-control-sm" name="className" required>
            </div>
            <div class="form-group">
                <label for="classType">Type</label>
                <select name="classType" class="form-control form-control-sm" required>
                    <option></option>
                    <option value="1">Standard Classroom</option>
                    <option value="2">Computer Lab</option>
                    <option value="3">Auditorium</option>
                </select>
            </div>
            <div class="form-group">
                <label for="capacity">Capacity</label>
                <input type="text" class="form-control form-control-sm" name="capacity" required>
            </div>      
            <button type="submit" name="btnAdd" class="btn btn-primary btn-sm">Add Classroom</button>  
        <?php echo form_close(); ?>
    </div>
</div>

</div>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    } );
</script>
