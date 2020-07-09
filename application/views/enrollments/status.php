
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
            <hr>

            <?php if($status=='success') { ?>
              <div class="alert alert-success">
                Student enrolled successfully.

                <a href="<?= base_url(); ?>index.php/enrollments/print?studentId=<?= $studentId; ?>&courseId=<?= $courseId; ?>" class="btn btn-primary btn-sm">Print Details</a>
                <button type="button" id="btnCourseEnrollments" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#imageModal"><i class="fas fa-camera-retro"></i> Student Photograph</button>
              </div>
            <?php } else if($status='duplicate-entry') { ?>
              <div class="alert alert-warning">
                Student is a previous or a current student of Saegis Campus. You may use <a href="<?= base_url(); ?>index.php/enrollments/course-enroll">this link</a> to Enroll the student to a new course.
                Or else, you might be entering a duplicated NIC number.

              </div>

            <?php } else { ?>
              <div class="alert alert-danger">
                Student is already enrolled in the same course.

              </div>
            <?php } ?>


          </div>
        </div>
      </div>
    </div>
</div>

<!-- Course Enrollments -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
  <?php echo form_open_multipart('enrollments/update_image'); ?>
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageModalLabel">Student Image</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div class="modal-body">

            <hr>
            <div class="form-group">
              <label>Select a New Photograph</label>
              <input type="hidden" name="studentId" value="<?= $studentId; ?>">
              <input type="hidden" name="inquiryId" value="<?= $inquiryId; ?>">
              <input type="file" id="image" class="form-control-file form-control-sm" name="image" accept="image/*" capture="camera">
            </div>
          </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  <?php echo form_close(); ?>
</div>

<script>

</script>
