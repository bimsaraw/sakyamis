<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active"><?php echo $title; ?></li>
    </ol>

    <div class="">
      <h5>Add Inquiry</h5>
      <hr>
      <form id="edit_inquiry" >
        <?php foreach($results as $result) { ?>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label>Student's Name</label><span class="required"> *</span>
            <input type="text" name="name" id="name" value="<?= $result['name']; ?>" class="form-control form-control-sm" placeholder="John Doe" required>
          </div>
          <div class="form-group col-md-4">
            <label>Mobile Number</label><span class="required"> *</span>
            <input type="text" name="mobile" id="mobile" class="form-control form-control-sm" value="0<?= $result['mobile']; ?>" placeholder="0770430000" required>
            <div class="validation-feedback" id="mobile_validation"></div>
          </div>
          <div class="form-group col-md-4">
            <label>Home Number</label>
            <input type="text" name="home" id="home" class="form-control form-control-sm" value="0<?= $result['home']; ?>" placeholder="0117430000">
            <div class="validation-feedback" id="home_validation"></div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label>Present Address</label>
            <input type="text" name="address" id="address" value="<?= $result['address']; ?>" class="form-control form-control-sm" placeholder="135, S De S Jayasinghe Mw,">
          </div>
          <div class="form-group col-md-4">
            <label>City</label>
            <input type="text" name="city" id="city" value="<?= $result['city']; ?>" class="form-control form-control-sm" placeholder="Nugegoda">
          </div>
          <div class="form-group col-md-4">
            <label>Email Address</label>
            <input type="text" name="email" id="email" value="<?= $result['email']; ?>" class="form-control form-control-sm" placeholder="johndoe@example.com">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label>Preffered Course</label><span class="required"> *</span>
            <select class="form-control form-control-sm" id="course" name="course" required>
              <option value="<?=$result['course']; ?>"><?=$result['courseName']; ?></option>
              <?php foreach($courses as $course) { ?>
                <option value="<?=$course['id']; ?>"><?=$course['name']; ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="form-group col-md-4">
            <label>Counselor</label><span class="required"> *</span>
            <select class="form-control form-control-sm" id="username" name="username" required>
              <option value="<?=$result['username']; ?>"><?=$result['username']; ?></option>
              <?php foreach($users as $user) { ?>
                <option value="<?=$user['username']; ?>"><?=$user['name']; ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="form-group col-md-2">
            <label>Student Type</label>
            <select class="form-control form-control-sm" id="student_type" name="student_type" required>
              <option value="<?=$result['student_type']; ?>"><?=$result['student_type']; ?></option>
              <option value="Sakya Student">Sakya Student</option>
              <option value="Nanik Student">Nanik Student</option>
              <option value="Non-Sakya Student">Non-Sakya Student</option>
            </select>
          </div>

          <div class="form-group col-md-2">
            <label>Inquiry #</label>
            <input type="text" name="inquiry_id" id="inquiry_id" value="<?= $result['id']; ?>" class="form-control form-control-sm" readonly>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Update Inquiry</button>
            <button type="button" id="btnDiscard" class="btn btn-secondary btn-sm"><i class="fa fa-trash-alt"></i> Go Back</button>
          </div>
        </div>
      <?php } ?>
      </form>
    </div>
</div>

<script>
  $(document).ready(function(){

    $('#edit_inquiry').submit(function(e){
      e.preventDefault();

      var re = /[0-9]{2}\d{8}/;
      var mobile = $('#mobile').val();
      var home = $('#home').val();

      var flag_mobile;
      var flag_home;

      $('.form-control').addClass('is-valid');

      if(!re.test(mobile)) {
        $('#mobile').removeClass('is-valid');
        $('#mobile').addClass('is-invalid');
        $('#mobile_validation').show();
        $('#mobile_validation').addClass('invalid-feedback');
        $('#mobile_validation').html('Mobile number is not valid.');
        flag_mobile = 0;
      } else {
        flag_mobile = 1;
        $('#mobile').removeClass('is-invalid');
        $('#mobile').addClass('is-valid');
        $('#mobile_validation').hide();
      }

      if(home!='' && !re.test(home)) {
        $('#home').removeClass('is-valid');
        $('#home').addClass('is-invalid');
        $('#home_validation').show();
        $('#home_validation').addClass('invalid-feedback');
        $('#home_validation').html('Home number is not valid.');
        flag_home = 0;
      } else {
        flag_home = 1;
        $('#home').addClass('is-invalid')
        $('#home').removeClass('is-invalid');
        $('#home_validation').hide();
      }

      var form = $(this);

      if(flag_mobile==1 && flag_home==1) {
        $.blockUI();
        $.ajax({
         type: "POST",
         url: '<?php echo base_url(); ?>index.php/inquiries/update_inquiry',
         data: form.serialize(), // serializes the form's elements.
         success: function(data)
         {
           if(data!=0) {
             $.notify({
              // options
              title: 'Inquiry updated successfully!',
              },{
              // settings
              type: 'success'
              });
              $('#add_inquiry').trigger('reset');
              $('.form-control').removeClass('is-valid');
              $('.form-control').removeClass('is-invalid');
              $('.validation-feedback').hide();
              $.unblockUI();
           } else {
             $.notify({
              // options
              title: 'Inquiry cannot be added!',
              message: 'May be the student has already made an inquiry on the same course. '+data
              },{
              // settings
              type: 'danger'
              });
              $.unblockUI();
           }
         }
       });
      }

    });

    $('#btnDiscard').click(function(){
      window.history.back();
    });

  });
</script>
