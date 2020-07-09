
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

            <?php echo form_open_multipart('messages/update_template'); ?>

            <?php foreach($edit as $row) { ?>
              <input type="hidden" id="templateId" name="templateId" value="<?= $row['id']; ?>">
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label>Course</label><span class="required"> *</span>
                  <select name="courseId" id="courseId" class="form-control form-control-sm" required>
                    <option value="<?= $row['courseId']; ?>"><?= $row['courseName']; ?></option>
                    <?php foreach($courses as $course) { ?>
                      <option value="<?= $course['id']; ?>"><?= $course['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group col-md-3">
                  <label>Message Instance</label><span class="required"> *</span>
                  <select name="instance" id="instance" class="form-control form-control-sm" required>
                    <option value="<?= $row['instance']; ?>"><?= $row['instance']; ?></option>
                    <option value="Inquiry">Inquiry</option>
                    <option value="PaymentPlan">PaymentPlan</option>
                    <option value="Enrollment">Enrollment</option>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label>Subject of Email</label>
                  <input type="text" class="form-control form-control-sm" name="subject" id="subject" value="<?= $row['subject']; ?>">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-12">
                  <label>Email Template</label>
                  <textarea id="body" name="body" class="form-control form-control-sm">
                    <?= $row['body']; ?>
                  </textarea>
                  <small id="passwordHelpBlock" class="form-text text-muted">
                    Variables available: [STUDENT_NAME] [STUDENT_ADDRESS] [COUNSELOR_MOBILE] [COUNSELOR_EMAIL]
                  </small>
                </div>
              </div>

              <div class="form-row">
                <div class="from-group col-md-8">
                  <label>SMS (limit characters to 160)</label><span class="required"> *</span>
                  <input type="text" id="sms" class="form-control form-control-sm" name="sms" value="<?= $row['sms']; ?>" requried>
                </div>

                <div class="from-group col-md-4">
                  <label>Set the attachment</label>
                  <a href="<?=base_url(); ?>uploads/<?= $row['attachment']; ?>" target="_blank"><?= $row['attachment']; ?> (Current)</a>
                  <input type="hidden" name="filename" id="filename" value="<?= $row['attachment']; ?>">
                  <input type="file" id="attachment" class="form-control-file form-control-sm" name="attachment">
                  <small id="passwordHelpBlock" class="form-text text-muted">
                    If you select a new one, old attachment will be replaced.
                  </small>
                </div>
              </div>

              <div class="form-row" style="margin-top:15px;">
                <div class="form-group col-md-12">
                  <button type="submit" class="btn btn-primary btn-sm">Save</button>
                  <button type="button" class="btn btn-default btn-sm" onclick="window.history.back();">Go Back</button>
                </div>
              </div>
            <?php } ?>
            <?php echo form_close(); ?>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
          'autoWidth':false
        });

        $('#attachment').change(function() {
          $('#filename').val('');
          $('#attachment').attr('required','');
        });

    } );
</script>
