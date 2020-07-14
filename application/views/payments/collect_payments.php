
<div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active"><?php echo $title; ?></li>
    </ol>
    <div id="alertArea" class="alert" style="display:none;"> </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Payment Plan</h5>
                    <div class="table-responsive">
                      <table class="table table-stripped" id="dataTable">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Due Date</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($installments as $installment) { ?>
                            <tr>
                              <td><?= $installment['id']; ?></td>
                              <td><?= $installment['name']; ?></td>
                              <td><?= number_format($installment['amount'],2,".",",")." ".$installment['currency']; ?></td>
                              <td><?= $installment['date']; ?></td>
                              <td>

                                <?php
                                $response = $this->payment_model->get_payment_status($studentId,$pplanId,$installment['id']);
                                if($response>0) { ?>
                                  Completed.
                                                                    <button type="button" onclick="printReceipt('<?= $studentId; ?>','<?= $pplanId; ?>','<?= $installment['id']; ?>')" class="btn btn-outline-secondary btn-sm">Receipt</button>
                                                                    <button type="button" onclick="deleteReceipt('<?= $studentId; ?>','<?= $pplanId; ?>','<?= $installment['id']; ?>')" class="btn btn-outline-danger btn-sm">Delete</button>
                                <?php } else { ?>
                                  <button type="button" onclick="fillModal('<?= $studentId; ?>','<?= $pplanId; ?>','<?= $installment['id']; ?>','<?= $installment['amount']; ?>','<?= $installment['currency']; ?>','<?= $installment['name']; ?>')" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#paymentModal">Payment</button>
                                <?php } ?>

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

<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="frmPayments">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Student ID</label>
            <input type="text" id="studentId" name="studentId" class="form-control form-control-sm" readonly>
          </div>
          <div class="form-row">
            <div class="form-group col-md-8">
              <label>Installment</label>
              <input type="hidden" id="pplanId" name="pplanId">
              <input type="hidden" id="installmentId" name="installmentId">
              <input type="text" id="installmentName" class="form-control form-control-sm" readonly>
            </div>
            <div class="form-group col-md-4">
              <label>Fee Type</label>
              <select class="form-control form-control-sm" id="fee_type" name="fee_type">
                <option value="1">Course Fee</option>
                <option value="2">University / Royalty Fee</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-2">
              <label>Method</label>
              <select id="type" name="type" class="form-control form-control-sm" required>
                <option value="Cash">Cash</option>
                <option value="Card">Card</option>
                <option value="Bank Deposit">Bank Deposit</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <label>Currency</label>
              <input type="text" id="currency" name="currency" class="form-control form-control-sm" readonly>
            </div>
            <div class="form-group col-md-4">
              <label>Amount (Foreign)</label>
              <input type="text" id="currency_amount" name="currency_amount" class="form-control form-control-sm" readonly>
            </div>
            <div class="form-group col-md-4">
              <label>Rate</label>
              <input type="text" id="rate" name="rate" class="form-control form-control-sm" readonly>
            </div>
          </div>
          <div class="form-group">
            <label>Amount</label>
            <input type="text" id="amount" name="amount" class="form-control form-control-sm" readonly required>
          </div>
          <div class="form-group">
            <label>Remarks</label>
            <input type="text"  name="remarks" id="remarks" class="form-control form-control-sm">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-sm">Confirm Payment</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="deletePayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation!</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>
     
        <form id="deletePayment">
        <div class="modal-body"> 
            <div class="form-group">
              ​<p>Are you sure you want to delete this Payment?</p>
              <input type="hidden" name="m_studentID" id="m_studentID" />
              <input type="hidden" name="m_pplanId" id="m_pplanId" />
              <input type="hidden" name="m_installmentId" id="m_installmentId" />
              <div class="validation-feedback fb_new2" id="fb_new2"></div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-outline-danger btn-sm" >Delete</button>
        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button>
        </div>
        </form>
    </div>
    </div>
</div>

<script>

function fillModal(studentId,pplanId,installmentId,amount,currency,name) {
  $('#studentId').val(studentId);
  $('#pplanId').val(pplanId);
  $('#installmentId').val(installmentId);
  $('#installmentName').val(name);
  $('#currency').val(currency);

  if(currency!="lkr") {
    $('#rate').removeAttr('readonly');
    $('#currency_amount').val(amount);
    $('#amount').val("");
    $('#fee_type').val(2);
  } else {
    $('#rate').attr('readonly',true);
    $('#rate').val("");
    $('#amount').val(amount);
    $('#currency_amount').val("");
    $('#fee_type').val(1);
  }
}

function printReceipt(studentId,pplanId,installmentId) {
  var printWindow = window.open('<?= base_url(); ?>index.php/payments/print_receipt?studentId='+studentId+'&pplanId='+pplanId+'&installmentId='+installmentId, 'Print Receipt', 'height=400,width=600');
  printWindow.onload=function(){ // necessary if the div contain images

       printWindow.focus(); // necessary for IE >= 10
       printWindow.print();
       //printWindow.close();
   };
}

$(document).ready(function() {

  $('#frmPayments').submit(function(e) {
    e.preventDefault();

    var form = $('#frmPayments');

    var studentId = $('#studentId').val();
    var pplanId = $('#pplanId').val();
    var installmentId = $('#installmentId').val();

    $.ajax({
     type: "POST",
     url: '<?php echo base_url(); ?>index.php/payments/save_payment',
     data: form.serialize(),
     success: function(response) {
       console.log(response);
       var printWindow = window.open('<?= base_url(); ?>index.php/payments/print_receipt?studentId='+studentId+'&pplanId='+pplanId+'&installmentId='+installmentId, 'Print Receipt', 'height=400,width=600');
       printWindow.onload=function(){ // necessary if the div contain images

            printWindow.focus(); // necessary for IE >= 10
            printWindow.print();
            printWindow.close();
        };
       document.location.reload();
     }
   });


  });

  $('#rate').change(function() {
    var currency_amount = $('#currency_amount').val();
    var rate = $('#rate').val();

    var amount = currency_amount*rate;

    $('#amount').val(amount);
  })

  $('#deletePayment').submit(function(e) {
    e.preventDefault();

    var form = $('#deletePayment');

    var studentId = $('#m_studentID').val();
    var pplanId = $('#m_pplanId').val();
    var installmentId = $('#m_installmentId').val();

    $.ajax({
      type: "POST",
      url: '<?php echo base_url(); ?>index.php/payments/delete_payment',
      data: 
      { studentId:studentId,
        pplanId:pplanId,
        installmentId:installmentId
      },
      cache : false,
      success: function(response) {
        console.log(response);
        if(response=='no-perm'){
               $('#alertArea').show();
               $('#alertArea').addClass("alert-warning");
               $('#alertArea').html("Permissions denied!");
              }else if (response=='success'){
               $('#alertArea').show();
               $('#alertArea').addClass("alert-success");
               $('#alertArea').html("Deleted Successfully.");
              }else if (response=='error'){
               $('#alertArea').show();
               $('#alertArea').addClass("alert-success");
               $('#alertArea').html("Deleted Unsuccessfully.");
              }
          }
         
      });
      document.location.reload();
    });
  

});

function deleteReceipt(studentId,pplanId,installmentId) {
  document.getElementById("m_studentID").value = studentId;
  document.getElementById("m_pplanId").value = pplanId;
  document.getElementById("m_installmentId").value = installmentId;
  $('#deletePayment').modal('show');
}

</script>
