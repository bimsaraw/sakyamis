<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active"><?php echo $title; ?></li>
    </ol>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Mark Dropouts</h5>

                    <?php echo form_open_multipart('enrollments/save_dropouts'); ?>
                    <div class="form-group">
                      <label>CSV with Dropouts</label>
                      <input type="file" class="form-control-file" name="dropout_file" id="dropout_file" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
