
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
              <?php if(isset($msg)) {
                      if($msg==1) { ?>
                          <div class="alert alert-success">Action performed successfully!</div>
              <?php
                      } else { ?>
                          <div class="alert alert-danger">There's an error! Please contact administrator.</div>
              <?php   }
              } ?>
          </div>
            <div class="card-body">
                <h5 class="card-title">Users</h5>
                <p class="card-text">Registered Users in the System</p>
                <div class="table-responsive">
                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['name']; ?></td>
                                    <td>
                                      <a class="btn btn-outline-primary btn-sm change_pwd" id="user_<?= $user['username']; ?>" data-username="<?= $user['username']; ?>" data-toggle="modal" href="#changepwdModal"><i class="far fa-edit"></i></a>
                                      <button class="btn btn-primary btn-sm" onclick="get_permissions('<?= $user['username']; ?>')"><i class="far fa-user"></i></button>
                                      <a href="<?= base_url(); ?>index.php/users/remove?username=<?= $user['username']; ?>" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <?php echo form_open('users/add'); ?>
            <div class="form-group">
                <label for="className">Username</label>
                <input type="text" class="form-control form-control-sm" name="username" required>
            </div>
            <div class="form-group">
                <label for="className">Name</label>
                <input type="text" class="form-control form-control-sm" name="name" required>
            </div>
            <div class="form-group">
                <label for="className">Email</label>
                <input type="email" class="form-control form-control-sm" name="email" required>
            </div>
            <div class="form-group">
                <label for="className">Telephone</label>
                <input type="telephone" class="form-control form-control-sm" name="telephone" required>
            </div>
            <div class="form-group">
                <label for="className">Department</label>
                <select name="department" class="form-control form-control-sm" required>
                  <option>-- Please Select --</option>
                  <?php foreach($departments as $department) { ?>
                    <option value="<?= $department['id'] ?>"><?= $department['name']; ?></option>
                  <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control form-control-sm" name="password" required>
            </div>
            <hr>
            <div class="form-group row">
              <?php foreach($permissions as $permission) { ?>
                <label for="user_level" class="col-sm-5 col-form-label"><?= $permission['permission']; ?></label>
                <input type="hidden" name="perm_id[]" value="<?= $permission['id']; ?>">
                <select name="perm_stat[]" class="form-control form-control-sm col-sm-4" required>
                    <option value="0">Deny</option>
                    <option value="1">Allow</option>
                </select>
              <?php } ?>
            </div>
            <button type="submit" name="btnAdd" class="btn btn-primary btn-sm">Add User</button>
        <?php echo form_close(); ?>
    </div>
</div>

</div>

<div class="modal" tabindex="-1" id="viewModal" role="dialog">
    <?php echo form_open('users/modify_permissions'); ?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalViewTitle">Modify User Permissions</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <input type="hidden" id="modal_username" name="username">
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table id="tblPermissions" class="table table-stripped">
                    <thead>
                      <th>User</th>
                      <th>Permission Status</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" id="inputAllocateId">
            <input type="hidden" id="inputDate">
            <button type="submit" class="btn btn-primary btn-sm">Save changes</button>
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<div class="modal fade" id="changepwdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">
          <h6>Change Password</h6>
          <form id="changePwd">

            <div class="form-group">
              <label>New Password</label>
              <input type="hidden" id="username2" />
              <input type="password" class="form-control form-control-sm user-passwords" id="newPassword2" name="newPassword"/>
              <div class="validation-feedback fb_new2" id="fb_new2"></div>
            </div>

            <div class="form-group">
              <label>Confirm Password</label>
              <input type="password" class="form-control form-control-sm user-passwords" id="confirmPassword2" name="confirmPassword"/>
              <div class="validation-feedback fb_new2"></div>
            </div>
            <button type="submit" class="btn btn-outline-primary btn-sm">Change Password</button>
          </form>
        </div>
        <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>

<script>
  function get_permissions(username) {
      $.blockUI();
      $('#tblPermissions > tbody').children().remove();
      $('#modalViewTitle').html('Modify permissions of '+username);
      $('#modal_username').val(username);
      $.ajax({
          type : "GET",
          //set the data type
          url: '<?php echo base_url(); ?>index.php/users/get_permissions_in', // target element(s) to be updated with server response
          data: {username:username},
          cache : false,
          //check this in Firefox browser
          success : function(response){
              $.each(response,function(key, val) {
                  $('#tblPermissions > tbody:last-child').append(
                    '<tr><td>'
                    +val.permission+
                    '<input type="hidden" name="perm_id[]" value='+val.id+'>'+
                    '</td><td>'+
                    '<select name="perm_stat[]" class="form-control form-control-sm" required>'+
                    '<option value="0">Deny</option><option value="1" selected>Allow</option></select>'+
                    '</td></tr>'
                  );
              });
          }
      });

      $.ajax({
          type : "GET",
          //set the data type
          url: '<?php echo base_url(); ?>index.php/users/get_permissions_not_in', // target element(s) to be updated with server response
          data: {username:username},
          cache : false,
          //check this in Firefox browser
          success : function(response){
              $.each(response,function(key, val) {
                  $('#tblPermissions > tbody:last-child').append(
                    '<tr><td>'
                    +val.permission+
                    '<input type="hidden" name="perm_id[]" value='+val.id+'>'+
                    '</td><td>'+
                    '<select name="perm_stat[]" class="form-control form-control-sm" required>'+
                    '<option value="0" selected>Deny</option><option value="1">Allow</option></select>'+
                    '</td></tr>'
                  );
              });
          }
      });
      $('#viewModal').modal('show');
      $.unblockUI();
  }

  $(document).ready(function() {
    $('.user-passwords').change(function(){
      var newPassword = $('#newPassword2').val();
      var confirmPassword = $('#confirmPassword2').val();

      if(newPassword==confirmPassword) {
        $('.user-passwords').removeClass('is-invalid');
        $('.user-passwords').addClass('is-valid');
        $('.fb_new2').hide();
        new_pwd = 1;
      } else {
        new_pwd = 0;
        $('.user-passwords').removeClass('is-valid');
        $('.user-passwords').addClass('is-invalid');
        $('.fb_new2').addClass('invalid-feedback');
        $('.fb_new2').html('Passwords do not match');
        $('.fb_new2').show();
      }
    });

    $(".change_pwd").on('click', function(){
      var username = $(this).data('username');
      $('#username2').val(username);
    });

    $('#changePwd').submit(function(e){
      e.preventDefault();
      if(new_pwd==1) {
        var password = $('#newPassword2').val();
        var username = $('#username2').val();
        $.blockUI();
        $.ajax({
          type: "POST",
          url: '<?php echo base_url(); ?>index.php/users/change_pwd_user_admin',
          data: {username:username,password:password},
          success: function(response) {
            $.notify({
             // options
             title: 'Password changed!',
             message: 'Users password has been changed successfully.'
             },{
             // settings
             type: 'success'
             });
             $('#form-control').removeClass('is-valid');
             $('#changepwdModal').modal('hide');
             $('#changePwd').trigger('reset');
          }
        });
      }
          $.unblockUI();
    });
  });
</script>
