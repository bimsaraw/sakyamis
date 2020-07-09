
<div class="container-fluid">

  <!-- Breadcrumbs-->
  <ol class="breadcrumb">
      <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
      </li>
      <li class="breadcrumb-item">
          <a href="#">Inquiries</a>
      </li>
      <li class="breadcrumb-item active"><?php echo $title; ?></li>
  </ol>

  <div class="row">
    <div class="col-md-3">
      <div class="info-box">
        <div class="info-box-title">
          <h5 class="text-info"><i class="far fa-meh-blank"></i> Pending</h5>
        </div>
        <div class="info-box-body">
          <?php
            if(isset($pending)) {
              $total = 0;
              foreach($pending as $row) {
                $total = $total + $row['count'];
              } ?>
              <div class="info-box-insight text-info"><?=$total; ?></div>
          <?php  }
          ?>
          <a href="<?=base_url() ?>index.php/inquiries/view?type=is_pending&title=Pending Inquiries" class="btn btn-sm btn-info">View Inquiries</a>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="info-box">
        <div class="info-box-title">
          <h5 class="text-warning"><i class="far fa-smile"></i> Positive</h5>
        </div>
        <div class="info-box-body">
          <?php
            if(isset($positive)) {
              $total = 0;
              foreach($positive as $row) {
                $total = $total + $row['count'];
              } ?>
              <div class="info-box-insight text-warning"><?=$total; ?></div>
          <?php  }
          ?>
          <a href="<?=base_url() ?>index.php/inquiries/view?type=is_positive&title=Positive Inquiries" class="btn btn-sm btn-warning">View Inquiries</a>
        </div>
      </div>
  </div>

  <div class="col-md-3">
    <div class="info-box">
      <div class="info-box-title">
        <h5 class="text-success"><i class="far fa-smile-beam"></i> Registered</h5>
      </div>
      <div class="info-box-body">
        <?php
          if(isset($registered)) {
            $total = 0;
            foreach($registered as $row) {
              $total = $total + $row['count'];
            } ?>
            <div class="info-box-insight text-success"><?=$total; ?></div>
        <?php  }
        ?>
        <a href="<?=base_url() ?>index.php/inquiries/view?type=is_registered&title=Registered Inquiries" class="btn btn-sm btn-success">View Inquiries</a>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="info-box">
      <div class="info-box-title">
        <h5 class="text-danger"><i class="far fa-frown-open"></i> Failed</h5>
      </div>
      <div class="info-box-body">
        <?php
          if(isset($failed)) {
            $total = 0;
            foreach($failed as $row) {
              $total = $total + $row['count'];
            } ?>
            <div class="info-box-insight text-danger"><?=$total; ?></div>
        <?php  }
        ?>

        <a href="<?=base_url() ?>index.php/inquiries/view?type=is_failed&title=Failed Inquiries" class="btn btn-sm btn-danger">View Inquiries</a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <form id="filterInquiries">
      <div class="form-row">
        <div class="form-group col-md-3">
          <label>Select Course</label>
          <select id="courseId" name="courseId" class="form-control form-control-sm" required>
            <option value="">- Select Course -</option>
            <?php foreach($courses as $course) { ?>
              <option value="<?= $course['id']; ?>"><?= $course['name']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group col-md-3">
          <label>Number of Follow ups</label>
          <input type="text" id="followUps" name="followUps" class="form-control form-control-sm">
        </div>
        <input type="hidden" name="type" id="type" value="<?= $type; ?>">
        <input type="hidden" name="username" id="username" value="<?= $username; ?>">
        <div class="form-group col-md-3">
          <label>Select Latest..</label>
          <input type="text" id="range" name="range" class="form-control form-control-sm" placeholder="100,200">
        </div>
      </div>
    </form>
  </div>
</div>
<hr/>
<div class="row">
  <div class="col-md-12">
    <table id="dataTable" class="table table-stripped">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Telephone</th>
          <th>Email</th>
          <th>Date / Time</th>
          <th>Counselor</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="inq_table">

      </tbody>

    </table>
  </div>
</div>

</div>

<script>
    var t;
    $(document).ready(function() {
        t = $('#dataTable').DataTable({
          "autoWidth": false,
          "paging": false,
          "order": [[ 0, 'desc' ]]
        });
        $(".nav-pills li:first a").addClass('active');
        $(".nav-pills li:first a").trigger('click');

        $(".nav-pills li a").click(function(){
          $(".nav-pills li a").removeClass('active');
          $(this).addClass('active');
        });
    } );

    $('#filterInquiries').submit(function(e)) {
      e.preventDefault();

      var form = $('#filterInquiries');

      $.blockUI();

      $.ajax({
        type: "POST",
        url: '<?php echo base_url(); ?>index.php/inquiries/view_inquiries',
        data: form.serialize(),
        cache: false,
        success: function(response) {
          t.clear().draw();

          var remarks;

          $.each(response,function(key, val) {

            var register;
            if(type=='is_registered') {
              register = "<a class='btn btn-danger btn-sm' href='<?= base_url(); ?>index.php/enrollments/modify_enroll?studentId="+val.id+"'><i class='fas fa-pencil-alt'></i></a>&nbsp;"
              register += "<a href='<?= base_url(); ?>index.php/enrollments/print_duplicate?inquiryId="+val.id+"&courseId="+courseId+"' target='_blank' class='btn btn-warning btn-sm'><i class='fas fa-print'></i></a>";
            } else {
              register = "<a class='btn btn-danger btn-sm' href='<?= base_url(); ?>index.php/inquiries/edit_inquiry?inquiry_id="+val.id+"'><i class='fas fa-pencil-alt'></i></a>&nbsp;"
              register += "<a href='<?= base_url(); ?>index.php/enrollments/enroll?inquiryId="+val.id+"' class='btn btn-warning btn-sm'><i class='fas fa-user-graduate'></i></a>";
            }

            t.row.add([
              val.id,
              val.name,
              val.mobile,
              val.email,
              val.datetime,
              val.username,
              '<div class="inq-status" id="inq_'+val.id+'"></div>',
              "<button type='button' data-toggle='collapse' data-target='#collapse_"+val.id+"' aria-expanded='false' aria-controls='collapse_"+val.id+"' class='btn btn-primary btn-sm'><i class='fas fa-plus'></i></button>&nbsp;"
              +register
            ]).draw();

            $.ajax({
              type: "POST",
              url: '<?php echo base_url(); ?>index.php/inquiries/get_status_inquiry',
              data: {inq_id:val.id},
              cache: false,
              success: function(status) {
                console.log(status);
                $.each(status,function(k, v) {
                  $('#inq_'+val.id).append("<span class="+v.status+">"+v.datetime+" - "+v.remarks+"</span>");
                });

                var markup = "<div class='collapse inq-collapse' id='collapse_"+val.id+"'><form id='form_"+val.id+"' onsubmit='event.preventDefault(); saveremark("+val.id+")'><div class='form-row'>";
                markup += "<div class='form-group col-md-12'><input type='text' class='form-control form-control-sm' id='remarks_"+val.id+"' placeholder='Remarks' required></div>";
                markup += "</div><div class='form-row'><div class='form-group col-md-10'><select class='form-control form-control-sm' id='status_"+val.id+"' required>";
                markup += "<option value=''>-Please Select-</option>";
                markup += "<option value='Pending'>Pending</option>";
                markup += "<option value='Positive'>Positive</option>";
                markup += "<option value='Failed'>Failed</option></select></div>";
                markup += "<div class='form-group col-md-2'><button type='submit' class='btn btn-default btn-sm'><i class='far fa-save'></i></button></div>";
                markup += "</div></form></div>";
                $('#inq_'+val.id).append(markup);
              }
            });

            console.log(val.id);
          });

          $.unblockUI();
        }
      });
    });

    function updateInfoBox() {
      $.ajax({
        type: "POST",
        url: '<?php echo base_url(); ?>index.php/inquiries/update_infobox',
        cache: false,
        success: function(response) {
          console.log(response);
        }
      });
    }

    function saveremark(id) {
      $('#form_'+id).find('button').html('<i class="fa fa-sync fa-spin"></i>');
      $('#form_'+id).find('button').prop('disabled',true);
      $('#remarks_'+id).prop('readonly',true);

      var remarks = $('#remarks_'+id).val();
      var status = $('#status_'+id).val()

      $.ajax({
        type: "POST",
        url: '<?php echo base_url(); ?>index.php/inquiries/save_status',
        data: {remarks:remarks,status:status,id:id},
        cache: false,
        success: function(response) {
          if(response==1) {
            $('#inq_'+id).html('');
            $.ajax({
              type: "POST",
              url: '<?php echo base_url(); ?>index.php/inquiries/get_status_inquiry',
              data: {inq_id:id},
              cache: false,
              success: function(status) {
                console.log(status);
                $.each(status,function(k, v) {
                  $('#inq_'+id).append("<span class="+v.status+">"+v.datetime+" - "+v.remarks+"</span>");
                });

                var markup = "<div class='collapse inq-collapse' id='collapse_"+id+"'><form id='form_"+id+"' onsubmit='event.preventDefault(); saveremark("+id+")'><div class='form-row'>";
                markup += "<div class='form-group col-md-12'><input type='text' class='form-control form-control-sm' id='remarks_"+id+"' placeholder='Remarks' required></div>";
                markup += "</div><div class='form-row'><div class='form-group col-md-10'><select class='form-control form-control-sm' id='status_"+val.id+"' required>";
                markup += "<option value=''>-Please Select-</option>";
                markup += "<option value='Pending'>Pending</option>";
                markup += "<option value='Positive'>Positive</option>";
                markup += "<option value='Failed'>Failed</option></select></div>";
                markup += "<div class='form-group col-md-2'><button type='submit' class='btn btn-default btn-sm'><i class='far fa-save'></i></button></div>";
                markup += "</div></form></div>";
                $('#inq_'+id).append(markup);
              }
            });
            $(".nav-pills li:first a").trigger('click');
            //updateInfoBox();
          } else {
            $('#remarks_'+id).addClass('is-invalid');
            $('#status_'+id).addClass('is-invalid');
          }
        }
        });
    }
</script>
