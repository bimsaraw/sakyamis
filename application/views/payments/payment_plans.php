
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
                <?php if(isset($msg)) { ?>
                    <div class="alert alert-success"><?= $msg; ?></div>
                  <?php
                  } else if(isset($err)) { ?>
                    <div class="alert alert-danger"><?= $err; ?></div>
                <?php  } ?>
                <div class="card-body">
                    <h5 class="card-title">Payment Plans</h5>
                    <hr>
                      <form method="post">
                        <div class="form-row">
                          <div class="form-group col-md-3">
                            <label>Intake</label>
                            <select class="form-control form-control-sm" name="intakeId" id="intakeId">
                              <option value="">-- Please Select --</option>
                              <?php foreach($intakes as $intake) { ?>
                                <option value="<?= $intake['id']; ?>"><?= $intake['name']; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-md-3">
                            <label>Course</label>
                            <select class="form-control form-control-sm" name="courseId" id="courseId">
                              <option value="">-- Please Select --</option>
                              <?php foreach($courses as $course) { ?>
                                <option value="<?= $course['id']; ?>"><?= $course['name']; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                          </div>
                        </div>
                      </form>
                    <div class="table-responsive">
                        <table class="table" id="dataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Intake</th>
                                    <th>Course</th>
                                    <th>Plan Name</th>
                                    <th><a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPayment">Add New</a></th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php foreach($pplans as $pplan) { ?>
                                <tr>
                                  <td><?= $pplan['id']; ?></td>
                                  <td><?= $pplan['intakeName']; ?></td>
                                  <td><?= $pplan['courseName']; ?></td>
                                  <td><?= $pplan['name']; ?></td>

                                  <td><a class='btn btn-primary btn-sm' data-toggle="modal" data-target="#viewPaymentPlan" onclick="view_pplan(<?= $pplan['id']; ?>)" href='#'><i class='fas fa-list'></i></a>&nbsp;<a class='btn btn-primary btn-sm' data-toggle="modal" data-target="#clonePayment" onclick="duplicate_pplan(<?= $pplan['id']; ?>)" href='#'><i class='fas fa-copy'></i></a>&nbsp;<button type="button" onclick="delete_pplan(<?= $pplan['id']; ?>)" class='btn btn-danger btn-sm' href='#'><i class="far fa-trash-alt"></i></button></td>
                              <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addPayment" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Payment Plan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open_multipart('payments/add_payment_plan'); ?>
        <div class="modal-body">
          <div class="form-group">
            <label>Payment Plan Name</label>
            <input type="text" id="name" name="name" class="form-control form-control-sm" placeholder="Early Bird Discount Plan" required>
          </div>
          <div class="form-group">
            <label>Course</label>
            <select class="form-control form-control-sm" name="courseId" id="courseId" required>
              <option value="">-- Please Select --</option>
              <?php foreach($courses as $course) { ?>
                <option value="<?= $course['id']; ?>"><?= $course['name']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Intake</label>
            <select class="form-control form-control-sm" name="intakeId" id="intakeId" required>
              <option value="">-- Please Select --</option>
              <?php foreach($intakes as $intake) { ?>
                <option value="<?= $intake['id']; ?>"><?= $intake['name']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>CSV file for installments</label>
            <input type="file" class="form-control-file" name="csv_installment" id="csv_installment" required>
            <small class="form-text text-muted">Please use <a href="<?= base_url(); ?>uploads/paymentplan.csv">this format</a> to enter installments.</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Add Payment Plan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<div class="modal fade" id="clonePayment" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Payment Plan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open_multipart('payments/clone_payment_plan'); ?>
        <div class="modal-body">
          <div class="form-group">
            <label>Payment Plan Name</label>
            <input type="text" id="name" name="name" class="form-control form-control-sm" placeholder="Early Bird Discount Plan" required>
          </div>
          <div class="form-group">
            <label>Course</label>
            <select class="form-control form-control-sm" name="courseId" id="courseId" required>
              <option val="">-- Please Select --</option>
              <?php foreach($courses as $course) { ?>
                <option value="<?= $course['id']; ?>"><?= $course['name']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Intake</label>
            <select class="form-control form-control-sm" name="intakeId" id="intakeId" required>
              <option val="">-- Please Select --</option>
              <?php foreach($intakes as $intake) { ?>
                <option value="<?= $intake['id']; ?>"><?= $intake['name']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <div class="table-responsive">
              <table id="tblClonePlan" class="table table-stripped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Due Date</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Duplicate Plan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<div class="modal fade" id="viewPaymentPlan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Payment Plan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table id="tblPaymentPlan" class="table table-stripped">
            <thead>
              <tr>
                <th>#</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Due Date</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
      $('#dataTable').DataTable();
  } );

  function delete_pplan(pplanId) {
    if (confirm("Are you really want to delete this Payment Plan?")) {
      window.location.assign("<?= base_url(); ?>index.php/payments/delete_payment_plan?id="+pplanId);
    }
  }

  function view_pplan(pplanId) {
    $.ajax({
      type: "POST",
      url: '<?php echo base_url(); ?>index.php/payments/view_pplan',
      data: {pplanId:pplanId},
      cache: false,
      success: function(response) {
        var t = $('#tblPaymentPlan tbody').html('');

        $.each(response,function(key, val) {
          var amount = numeral(val.amount).format('0,0.00');
          t.append('<tr><td>'+val.id+'</td><td>'+val.name+'</td><td style="text-align:right;">'+amount+' '+val.currency+'</td><td>'+val.date+'</td></tr>');
        });
      }
    });
  }

  function duplicate_pplan(pplanId) {
    $.ajax({
      type: "POST",
      url: '<?php echo base_url(); ?>index.php/payments/view_pplan',
      data: {pplanId:pplanId},
      cache: false,
      success: function(response) {
        var t = $('#tblClonePlan tbody').html('');

        $.each(response,function(key, val) {
          var amount = numeral(val.amount).format('0,0.00');
          t.append('<tr><td><input type="hidden" name="installmentId[]" value='+val.id+'>'+val.id+'</td><td><input type="hidden" name="installmentName[]" value="'+val.name+'">'+val.name+'</td><td style="text-align:right;"><input type="hidden" name="amount[]" value="'+val.amount+'"> <input type="hidden" name="currency[]" value="'+val.currency+'">'+amount+' '+val.currency+'</td><td><input type="hidden" name="date[]" value="'+val.date+'">'+val.date+'</td></tr>');
        });
      }
    });
  }
</script>
