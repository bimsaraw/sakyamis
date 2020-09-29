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
            <div class="card-body">
                <h5 class="card-title">Cash Bulk</h5>
                <form id="get_payments">
               
                <div class="form-row">
                          <div class="form-group col-md-3">
                                  
                                  <select class="form-control form-control-sm" name="branchId" id="branchId" required>
                                      <option value="">-- Select Branch --</option>
                                    <?php foreach ($branches as $branch) { ?>
                                      <option value="<?= $branch['id']; ?>"><?= $branch['name']; ?></option>
                                    <?php } ?>
                                  </select>
                          </div>
                          <div class="form-group col-md-5">
                        
                                  <select class="form-control form-control-sm" name="username" id="username" required>
                                      <option value="<?= $this->session->userdata('username');?>">Username - <?= $this->session->userdata('username');?></option>
                                  </select>
                          </div>
                          <div class="form-group col-md-2">
                         
                          <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                          </div>
                      </div>
                   
                  </form>
                <div class="row">
                  <div class="col-md-6">
                      <div class="card">
                      <form id="add_bulk">
                          <div class="card-body">
                              <h5 class="card-title">Non bulk Payments
                              <button type="submit" class="btn btn-info btn-sm">Add Selected</button>
                              <button type="button" class="btn btn-info btn-sm">Add All</button>
                               </h5>
                                  <hr>
                                  <div class="table-responsive">
                                      <table class="table table-stripped" id="table_NBP" >
                                        <thead>
                                          <tr>
                                              <th>No</th>
                                              <th>Date</th>
                                              <th>Receipt No</th>
                                              <th>Amount</th>
                                              <th>Action</th>
                                          </tr>
                                        </thead>
                                            <tbody>
                                           
                                            </tbody>
                                            <tr>
                                                <th> </th>
                                                <th> </th>
                                                <th> </th>
                                                <th>Total Amount:</th>
                                                <th><div id="nbtotal1">00.00:</div></th>
                                            </tr>
                                      </table>
                                  </div> 
                                  <!-- close table -->
                                  
                                </div>
                               
                              </div>
                          </div>
                          </form>
                      

                      <div class="col-md-6">
                        <div class="card">
                          <div class="card-body">
                              <h5 class="card-title">New bulked Payments  <button type="button" class="btn btn-primary btn-sm">Save Bulk</button></h5>
                              
                              <hr>
                                  <div class="table-responsive">
                                      <table class="table table-stripped" id="table_NEWBP" >
                                        <thead>
                                          <tr>
                                              <th>No</th>
                                              <th>Date</th>
                                              <th>Receipt No</th>
                                              <th>Amount</th>
                                              <th>Action</th>
                                          </tr>
                                        </thead>
                                            <tbody>
                                            </tbody>
                                            <tr>
                                                <th> </th>
                                                <th> </th>
                                                <th> </th>
                                                <th>Total Amount:</th>
                                                <th><div id="nbtotal2">00.00:</div></th>
                                            </tr>
                                      </table>
                                  </div> 
                                  <!-- close table -->
                                 
                                </div>
                               
                              </div>
                        
                      </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {

        $('#get_payments').submit(function(e) {
          e.preventDefault();
          var form = $('#get_payments');

          $.blockUI();
          $.ajax({
           type: "POST",
           url: '<?php echo base_url(); ?>index.php/finance/get_non_bulk_payments',
           data: form.serialize(),
                success: function(response) {

                    console.log(response);
                    var t = $('#table_NBP').DataTable();
                    var counter = 1;
                    t.clear().draw();
                    var sum = 0;
                    $.each(response,function(key, val) {
                            t.row.add( [
                               counter,
                               '<input type="hidden" name="studentId[]" value="'+val.studentId+'">'+val.datetime,
                               '<input type="hidden" name="pplanId[]" value="'+val.pplanId+'"><input type="hidden" name="installmentId[]" value="'+val.installmentId+'">'+ val.studentId+"-"+val.pplanId+"-"+val.installmentId,
                                val.amount,
                                '<input class="form-check-input" type="checkbox" name="count[]" value="'+counter+'" id="select">'
                            ] ).draw( false );
                            counter++;
                            sum += parseFloat(val.amount);

                    });
                    $.unblockUI();
                    $('#nbtotal1').text(sum.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,"));
                }
               
            });
           
         })


         $('#get_payments').submit(function(e) {
          e.preventDefault();
          var form = $('#add_bulk');

          $.blockUI();
          $.ajax({
           type: "POST",
           url: '<?php echo base_url(); ?>index.php/finance/add_bulk_payment',
           data: form.serialize(),
                success: function(response) {

                    console.log(response);
                    //var t = $('#table_NBP').DataTable();
                    //var counter = 1;
                    //t.clear().draw();
                    //var sum = 0;
                    $.each(response,function(key, val) {
                            // t.row.add( [
                            //    counter,
                            //    '<input type="hidden" name="studentId" value="'+val.studentId+'">'+val.datetime,
                            //    '<input type="hidden" name="pplanId" value="'+val.pplanId+'"><input type="hidden" name="installmentId" value="'+val.installmentId+'">'+ val.studentId+"-"+val.pplanId+"-"+val.installmentId,
                            //     val.amount,
                            //     '<input class="form-check-input" type="checkbox" value="'+counter+'" id="select">'
                            // ] ).draw( false );
                            // counter++;
                            // sum += parseFloat(val.amount);

                    });
                    $.unblockUI();
                    //$('#nbtotal1').text(sum.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,"));
                }
               
            });
           
         })
    })


    </script>