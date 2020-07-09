
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
            <h5 class="card-title">Enrollment Status</h5>

            <?php echo form_open_multipart('enrollments/print_studentId_manual') ?>

              <div class="form-row">
                <div class="form-group col-md-1">
                  <label>Title <span class="required">*</span></label>
                  <select class="form-control form-control-sm" name="title" id="title" required>
                    <option value="">- Select -</option>
                    <option value="Mr">Mr</option>
                    <option value="Miss">Miss</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Dr">Dr</option>
                    <option value="Rev">Rev</option>
                  </select>
                </div>
                <div class="form-group col-md-5">
                  <label>Name with Initials <span class="required">*</span></label>
                  <input type="text" id="initials_name" name="initials_name" class="form-control form-control-sm" placeholder="R.A.I.S. RANASINGHE" required>
                </div>
                <div class="form-group col-md-3">
                  <label>Student ID <span class="required">*</span></label>
                  <input type="text" id="studentId" name="studentId" class="form-control form-control-sm" placeholder="19S08002" required>
                </div>
                <div class="form-group col-md-3">
                  <label>NIC <span class="required">*</span></label>
                  <input type="text" id="nic" name="nic" class="form-control form-control-sm" placeholder="973771480V" required>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-12">
                  <label>Select Photograph</label>
                  <input type="file" id="image" class="form-control-file form-control-sm" name="image">
                </div>
              </div>

              <button type="submit" class="btn btn-primary btn-sm">Print</button>



            <?php echo form_close(); ?>


          </div>
        </div>
      </div>
    </div>
</div>

<script>

</script>
