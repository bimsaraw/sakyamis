
<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active"><?php echo $title; ?></li>
    </ol>
    <?php 
    if ($this->session->flashdata('success')) {
    echo '<div class="alert alert-success">'; echo $this->session->flashdata('success'); echo'</div> ';
    }else if ($this->session->flashdata('danger')) {
      echo '<div class="alert alert-danger">'; echo $this->session->flashdata('danger'); echo'</div> ';
    }else if ($this->session->flashdata('warning')) {
      echo '<div class="alert alert-warning">'; echo $this->session->flashdata('warning'); echo'</div> ';
    }else if ($this->session->flashdata('info')) {
      echo '<div class="alert alert-info">'; echo $this->session->flashdata('info'); echo'</div> ';
    }
    ?>
<div id="alertArea" class="alert" style="display:none;"> </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Customized Payment Plan Approval</h5>
                    <div class="table-responsive">
                      <table class="table table-stripped" id="dataTable">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Plan Name</th>
                            <th>Student Id</th>
                            <th>Action</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $count=1; foreach($payment_plan as $plan) { ?>
                            <tr>
                              <td><?php echo $count; ?></td>
                              <td><?= $plan['name']; ?></td>
                              <td><?= $plan['studentId']; ?></td>
                              <td>
                                <button type="button" data-toggle="modal" data-target="#viewPaymentPlan" onclick="view_pplan(<?= $plan['id']; ?>)" class="btn btn-outline-primary btn-sm">View Details</button>
                                <button type="button" onclick="Accept_approval('<?= $plan['id']; ?>','<?= $plan['studentId']; ?>')" class="btn btn-outline-danger btn-sm">Approve</button>
                              </td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="approval_confirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Approval Confirmation!</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>
     
        <form id="Ppapproval">
        <div class="modal-body"> 
            <div class="form-group">
              ​<p>Are you sure you want to Approve this Payment Plan?</p>
              <input type="hidden" name="PPlanId" id="c_PPlanId" />
              <input type="hidden" name="studentId" id="c_studentId" />
              <div class="validation-feedback fb_new2" id="fb_new2"></div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-outline-danger btn-sm" >Confirm</button>
        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button>
        </div>
        </form>
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
 
 function Accept_approval(planid,StudentId) {
    document.getElementById('c_PPlanId').value=planid;
    document.getElementById('c_studentId').value=StudentId;
    $('#approval_confirmation').modal('show');  
  }

 $(document).ready(function() {

  $('#Ppapproval').submit(function(e) {
    e.preventDefault();

    var form = $('#Ppapproval');

    $.ajax({
     type: "POST",
     url: '<?php echo base_url(); ?>index.php/payments/Pplan_approval',
     data: form.serialize(),
     success: function(response) {
       console.log(response);
               $('#alertArea').show();
               $('#alertArea').addClass("alert-success");
               $('#alertArea').html("Approved Successfully.");
               document.location.reload();
        }
      
    });
  })
})  
        
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
</script>
