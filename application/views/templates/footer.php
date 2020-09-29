    <!-- Sticky Footer -->
    <footer class="sticky-footer">
        <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright © SIKSIL Institute <?= date('Y'); ?>. Solution by <a href="https://lk.linkedin.com/in/bimsara-walallawita">Dinuth Shamen</a>.</span>
        </div>
        </div>
    </footer>

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Profile Settings</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">
          <h6>Change Password</h6>
          <form id="changePassword">

            <div class="form-group">
              <label>Current Password</label>
              <input type="password" class="form-control form-control-sm" id="currentPassword" name="currentPassword"/>
              <div class="validation-feedback" id="fb_current"></div>
            </div>

            <div class="form-group">
              <label>New Password</label>
              <input type="password" class="form-control form-control-sm twin-passwords" id="newPassword" name="newPassword"/>
              <div class="validation-feedback fb_new" id="fb_new"></div>
            </div>

            <div class="form-group">
              <label>Confirm Password</label>
              <input type="password" class="form-control form-control-sm twin-passwords" id="confirmPassword" name="confirmPassword"/>
              <div class="validation-feedback fb_new"></div>
            </div>
            <button type="submit" class="btn btn-outline-primary btn-sm">Change Password</button>
          </form>
        </div>
        <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" id="btnChangePwd" href="login.html">Logout</a>
        </div>
    </div>
    </div>
</div>

<script>
  var current_pwd;
  var new_pwd;

  $('#currentPassword').change(function(){
    var currentPassword = $(this).val();
    $.ajax({
      type: "POST",
      url: '<?php echo base_url(); ?>index.php/users/validate_pwd',
      data: {password:currentPassword}, // serializes the form's elements.
      success: function(data) {
        if(data==1) {
          $('#currentPassword').addClass('is-valid');
          $('#currentPassword').removeClass('is-invalid');
          $('#fb_current').hide();
          current_pwd =1;
        } else {
          $('#currentPassword').addClass('is-invalid');
          $('#currentPassword').removeClass('is-valid');
          $('#fb_current').addClass('invalid-feedback');
          $('#fb_current').html('The current password you entered is incorrect.')
          $('#fb_current').show();
          current_pwd=0;
        }
      }
    });
  });

  $('.twin-passwords').change(function(){
    var newPassword = $('#newPassword').val();
    var confirmPassword = $('#confirmPassword').val();

    if(newPassword==confirmPassword) {
      $('.twin-passwords').removeClass('is-invalid');
      $('.twin-passwords').addClass('is-valid');
      $('.fb_new').hide();
      new_pwd = 1;
    } else {
      new_pwd = 0;
      $('.twin-passwords').removeClass('is-valid');
      $('.twin-passwords').addClass('is-invalid');
      $('.fb_new').addClass('invalid-feedback');
      $('.fb_new').html('Passwords do not match');
      $('.fb_new').show();
    }
  });

  $('#changePassword').submit(function(e){
    e.preventDefault();
    if(current_pwd==1 && new_pwd==1) {
      var password = $('#newPassword').val();
      $.blockUI();
      $.ajax({
        type: "POST",
        url: '<?php echo base_url(); ?>index.php/users/change_pwd_user',
        data: {password:password},
        success: function(response) {
          $.notify({
           // options
           title: 'Password changed!',
           message: 'Your password has been changed successfully.'
           },{
           // settings
           type: 'success'
           });
           $('#form-control').removeClass('is-valid');
           $('#settingsModal').modal('hide');
           $('#changePassword').trigger('reset');
        }
      });
    }
        $.unblockUI();
  });

</script>

<!-- Bootstrap core JavaScript-->

<script src="<?php echo base_url(); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?php echo base_url(); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Page level plugin JavaScript-->
<script src="<?php echo base_url(); ?>vendor/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>vendor/datatables/dataTables.bootstrap4.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="https://cloud.tinymce.com/5/tinymce.min.js"></script>
<script>tinymce.init({selector:'textarea'});</script>


<!-- Custom scripts for all pages-->
<script src="<?php echo base_url(); ?>js/sb-admin.min.js"></script>
<script src="<?php echo base_url(); ?>js/quicksearch.js"></script>
<script src="<?php echo base_url(); ?>js/wickedpicker.min.js"></script>
<script src="<?php echo base_url(); ?>js/timetable.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-colorpicker.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-notify.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script>

$('.timepicker').timepicker({
    timeFormat: 'HH:mm',
    interval: 30,
    dynamic: false,
    dropdown: false,
    scrollbar: true,
    startTime: '08:00',
});
</script>
</body>

</html>
