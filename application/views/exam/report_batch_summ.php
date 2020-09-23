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
                <h5 class="card-title">Batch Graded Summary </h5>
                <form method="post">
                <div class="form-row">
                          <div class="form-group col-md-3">
                            <label>Branch <span class="required"> *</span></label>
                                  <select class="form-control form-control-sm" name="branchId" id="branchId" required>
                                      <option value="">-- Please Select --</option>
                                    <?php foreach ($branches as $branch) { ?>
                                      <option value="<?= $branch['id']; ?>"><?= $branch['name']; ?></option>
                                    <?php } ?>
                                  </select>
                          </div>
                          <div class="form-group col-md-3">
                            <label>Batch <span class="required"> *</span></label>
                                  <select class="form-control form-control-sm" name="batch" id="batch" required>
                                      <option value="">-- Please Select --</option>
                                  </select>
                          </div>

                      </div>
                   
                  </form>
                    
                    <div class="table-responsive">
                        <table class="table table-stripped" id="dataTable" >
                          <thead>
                            <tr>
                                <th>No</th>
                                <th>Student Id</th>
                              <?php foreach ($modules as $module) { ?>
                              <th><?= $module['moduleName'];?></th>
                              <?php } ?>
                              <th>Total</th>
                              <th>Average</th>
                            </tr>
                          </thead>
                              <tbody>
                              <?php $count=1; foreach ($results as $result) { ?>
                                <tr>
                                <td> <?= $count ?> </td>
                                <?php foreach ($result as $i) { ?>
                                    <td> <?php if($i=="NA"){  echo "<p style='color:red'>NA</p>"; }else {echo $i;} ?> </td>
                                <?php } ?>
                                </tr>
                              <?php $count++; }  ?>
                           
                              </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>

  $(document).ready(function() {
    //$('#marksTable').DataTable(); //data table 

    var table = $('#dataTable').DataTable( {
          lengthChange: false,
          buttons: [
              'copyHtml5',
              'excelHtml5',
              'csvHtml5',
              'print',
              {
              extend: 'print',
              
              customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .prepend(
                            '<h3><?php echo $this->input->get('batchId');?> </h3>',
                           // selectedCourse
                        );
              }
            }
              ]
      } );

      table.buttons().container()
        .appendTo( '#dataTable_wrapper .col-md-6:eq(0)' );
        $('.dt-buttons > button').addClass('btn');
        $('.dt-buttons > button').addClass('btn-secondary');
        $('.dt-buttons > button').addClass('btn-sm');
 
  $('#batch').bind('change',function() {
    var batchId = $("#batch").val();
    window. location. replace("<?=base_url()?>index.php/exam/batch_result_summ?batchId="+batchId);
  })
 //get batches by branch
 $('#branchId').bind('change',function() {
 var branchId = $("#branchId").val();
      $.ajax({
                type : "get",
                //set the data type
                url: '<?php echo base_url(); ?>index.php/batches/get_batches_by_branch', // target element(s) to be updated with server response
                data: {branchId:branchId},
                cache : false,
                //check this in Firefox browser
                success : function(response){
                  console.log(response)
                  $('#batch').children().remove().end()
                  $(' <option value="">-- Please Select --</option>').appendTo('#batch');
                    $.each(response,function(key, val) {
                        $('<option value='+val.batchId+'>'+val.batchId+'</option>').appendTo('#batch');
                    });
                }
            });
  })
  
 
  
})

</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/toolbar/bootstrap-table-toolbar.js"></script>