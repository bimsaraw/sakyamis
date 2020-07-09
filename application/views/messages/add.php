
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
            <h5>Add Message Template</h5>
            <hr>

            <?php if(isset($error)) { ?>
              <div class="alert alert-danger"><?= $error; ?></div>
            <?php } ?>

            <?php echo form_open_multipart('messages/save_template'); ?>

            <div class="form-row">
              <div class="form-group col-md-3">
                <label>Course</label><span class="required"> *</span>
                <select name="courseId" id="courseId" class="form-control form-control-sm" required>
                  <option value="">- Please Select -</option>
                  <?php foreach($courses as $course) { ?>
                    <option value="<?= $course['id']; ?>"><?= $course['name']; ?></option>
                  <?php } ?>
                </select>
              </div>

              <div class="form-group col-md-3">
                <label>Message Instance</label><span class="required"> *</span>
                <select name="instance" id="instance" class="form-control form-control-sm" required>
                  <option value="">- Please Select -</option>
                  <option value="Inquiry">Inquiry</option>
                  <option value="PaymentPlan">PaymentPlan</option>
                  <option value="Enrollment">Enrollment</option>
                </select>
              </div>

              <div class="form-group col-md-6">
                <label>Subject of Email</label>
                <input type="text" class="form-control form-control-sm" name="subject" id="subject">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Email Template</label>
                <textarea id="body" name="body" class="form-control form-control-sm">
                </textarea>
                <small class="form-text text-muted">
                  Variables available: [STUDENT_NAME] [COUNSELOR_MOBILE] [COUNSELOR_NAME] [COURSE_NAME]
                </small>
              </div>
            </div>

            <div class="form-row">
              <div class="from-group col-md-8">
                <label>SMS (limit characters to 160)</label><span class="required"> *</span>
                <input type="text" id="sms" class="form-control form-control-sm" name="sms" requried>
                <small id="sms_count" class="form-text text-muted">
                  Your sms length is 0 characters. Everything after 160th character will not be sent.
                </small>
              </div>

              <div class="form-group col-md-4">
                <label>Set the attachment</label>
                <input type="file" id="attachment" class="form-control-file form-control-sm" name="attachment">
              </div>
            </div>

            <div class="form-row" style="margin-top:15px;">
              <div class="form-group col-md-12">
                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                <button type="button" class="btn btn-default btn-sm" onclick="window.history.back();">Go Back</button>
              </div>
            </div>

            <?php echo form_close(); ?>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
          'autoWidth':false
        });
    } );

    $('#sms').keyup(function() {
      var length = $('#sms').val().length
      $('#sms_count').html('Your sms length is '+length+' characters. Everything after 160th character will not be sent.');

      if(length>160) {
        $('#sms_count').addClass('required !important');
      }
    });
</script>

<script src="https://cloud.tinymce.com/5/tinymce.min.js"></script>
<script>tinymce.init({selector:'textarea'});</script>
