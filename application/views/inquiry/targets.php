
<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Intakes</a>
        </li>
        <li class="breadcrumb-item active"><?php echo $title; ?></li>
    </ol>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?=$title; ?></h5>
                    <div class="table-responsive">
                        <table class="table" id="dataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Course Name</th>
                                    <?php foreach($users as $user) { ?>
                                      <th><?= $user['name']; ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($courses as $course): ?>
                                    <tr>
                                      <td><?=$course['name']; ?></td>
                                      <?php foreach($users as $user) { ?>
                                        <td>
                                          <form class="" id="form_<?=$course['id']; ?>_<?=$user['username']; ?>">
                                            <input name="intakeId" type="hidden" value="<?=$intakeId; ?>">
                                            <input name="courseId" type="hidden" value="<?=$course['id']; ?>">
                                            <input name="username" type="hidden" value="<?=$user['username']; ?>">
                                            <div class="input-group mb-3">
                                              <input type="text" id="target_<?=$course['id']; ?>_<?=$user['username']; ?>" class="form-control form-control-sm" name="target" required>
                                              <div class="input-group-append">
                                                <button type="submit" id="btn_<?=$course['id']; ?>_<?=$user['username']; ?>" class="btn btn-outline-secondary btn-sm" text="<i class='fa fa-spinner fa-spin '></i>">
                                                  <i class="far fa-edit"></i>
                                                </button>
                                              </div>
                                            </div>
                                          </form>
                                        </td>
                                      <?php } ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body">
                    <?php if(isset($msg)) {
                            if($msg==1) { ?>
                                <div class="alert alert-success">Intake added successfully!</div>
                    <?php
                            }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            'iDisplayLength': 100
        });
        <?php
        foreach($courses as $course) {
          foreach($users as $user) {

            echo 'var courseId='.$course['id'].';';
            echo 'var username="'.$user['username'].'";';
            echo 'var intakeId="'.$intakeId.'";';
            echo 'get_targets(courseId,username,intakeId);'; ?>

            $('#form_'+courseId+'_'+username).on('submit', function(e){
              e.preventDefault();

              var form = $(this);

              $(this).find('button').html('<i class="fa fa-sync fa-spin"></i>');

              $.ajax({
               type: "POST",
               url: '<?php echo base_url(); ?>index.php/inquiries/update_target',
               data: form.serialize(), // serializes the form's elements.
               success: function(data)
               {
                   if(data==1) {
                     $(form).find('button').html('<i class="far fa-edit"></i>');
                     $(form).find('button').removeClass('btn-outline-danger');
                     $(form).find('button').addClass('btn-outline-secondary');
                   } else {
                     $(form).find('button').html('<i class="far fa-edit"></i>');
                     $(form).find('button').addClass('btn-outline-danger');
                     $(form).find('button').removeClass('btn-outline-secondary');
                   }
               }
             });
            });

            <?php
          }
        } ?>

    } );

    function get_targets(courseId,username,intakeId) {
      $.blockUI();
      $.ajax({
       type: "POST",
       url: '<?php echo base_url(); ?>index.php/inquiries/get_targets_by_username_course',
       data: {username:username,courseId:courseId,intakeId:intakeId},
       success: function(data)
       {
         if(data.length) {
           $('#target_'+courseId+'_'+username).val(data[0]['target']);
         } else {
           $('#target_'+courseId+'_'+username).val(0);
         }
        $.unblockUI();
       }
     });
    }
</script>
