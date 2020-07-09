
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
                    <h5 class="card-title"><?php echo $title; ?></h5>
                    <hr>
                    <?php
                    if(isset($msg)) { ?>
                      <div class="alert alert-<?= $alert; ?>"><?= $msg; ?></div>
                    <?php
                    } ?>
                    <form method="post">
                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label>Report Name</label>
                          <input type="text" class="form-control form-control-sm" name="reportName" id="reportName" required>
                        </div>
                        <div class="form-group col-md-9">
                          <label>Generated Query</label>
                          <input type="text" class="form-control form-control-sm" name="query" id="query">
                        </div>
                        <div class="form-group col-md-6">
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="reportType" id="reportTypeTable" value="table" checked>
                            <label class="form-check-label" for="reportTypeTable">
                              Table
                            </label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="reportType" id="reportTypeBarChart" value="table">
                            <label class="form-check-label" for="reportTypeBarChart">
                              Bar Chart
                            </label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="reportType" id="reportTypePieChart" value="table">
                            <label class="form-check-label" for="reportTypePieChart">
                              Pie Chart
                            </label>
                          </div>
                        </div>

                        <div class="form-group col-md-12 select-row-wrap">
                          <hr>
                          <h6>Columns to SELECT</h6>

                          <div class="form-row select-row">
                            <div class="col-md-2">
                              <select class="form-control form-control-sm selectTables" onchange="showColumnsSelect(this)" name="selectTable[]" required>
                                <option value="">- Select Table -</option>
                                <?php foreach($tables as $table) { ?>
                                  <option value="<?= $table; ?>"><?= $table; ?></option>
                                <?php } ?>
                              </select>
                            </div>

                            <div class="col-md-2">
                              <select class="form-control form-control-sm selectColumns" name="selectColumn[]" required>
                                <option value="">- Select Column -</option>
                              </select>
                            </div>

                            <div class="col-md-2">
                              <input type="text" class="form-control form-control-sm columnAs" name="columnAs[]" required>
                            </div>

                            <div class="col-md-2">
                              <button type="button" class="btn btn-outline-danger btn-sm btnDelRow" onclick="deleteRow(this)"><i class="fas fa-trash"></i></button>
                            </div>
                          </div>

                        </div>
                        <div class="form-group col-md-12">
                          <button type="button" class="btn btn-outline-secondary btn-sm btnAddRowSelect"><i class="fas fa-plus"></i> Add Column</button>
                        </div>

                        <div class="form-group col-md-12 from-row-wrap">
                          <hr>
                          <h6>FROM</h6>
                          <div class="form-row from-row">
                            <div class="col-md-4">
                              <select class="form-control form-control-sm fromTables" name="fromTable">
                                <option value="">- Select Table -</option>
                                <?php foreach($tables as $table) { ?>
                                  <option value="<?= $table; ?>"><?= $table; ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="form-group col-md-12 join-row-wrap">
                          <hr>
                          <h6>JOINS</h6>
                          <div class="form-row join-row">
                            <div class="col-md-2">
                              <select class="form-control form-control-sm joinTables" onchange="showColumnsJoin(this)" name="joinTable[]">
                                <option value="">- Table to Join -</option>
                                <?php foreach($tables as $table) { ?>
                                  <option value="<?= $table; ?>"><?= $table; ?></option>
                                <?php } ?>
                              </select>
                            </div>

                            <div class="col-md-2">
                              <select class="form-control form-control-sm joinColumns" name="joinColumn[]">
                                <option value="">- Dependent Key -</option>
                              </select>
                            </div>

                            <div class="col-md-1">
                              <div style="text-align:center;">ON</div>
                            </div>

                            <div class="col-md-2">
                              <select class="form-control form-control-sm joinRootTable" onchange="showColumnsJoinRoot(this)" name="joinRootTable[]">
                                <option value="">- Select Table -</option>
                                <?php foreach($tables as $table) { ?>
                                  <option value="<?= $table; ?>"><?= $table; ?></option>
                                <?php } ?>
                              </select>
                            </div>

                            <div class="col-md-2">
                              <select class="form-control form-control-sm joinRootColumns" name="joinRootColumn[]">
                                <option value="">- Select Column -</option>
                              </select>
                            </div>

                            <div class="col-md-2">
                              <select class="form-control form-control-sm joinType" name="joinType[]">
                                <option value="Inner">Inner</option>
                                <option value="Outer">Outer</option>
                                <option value="Left">Left</option>
                                <option value="Right">Right</option>
                              </select>
                            </div>

                            <div class="col-md-1">
                              <button type="button" class="btn btn-outline-danger btn-sm btnDelRow" onclick="deleteRow(this)"><i class="fas fa-trash"></i></button>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-12">
                          <button type="button" class="btn btn-outline-secondary btn-sm btnAddRowJoin"><i class="fas fa-plus"></i> Add Join</button>
                        </div>

                        <div class="form-group col-md-12 variable-row-wrap">
                          <hr>
                          <h6>Variable Columns</h6>
                          <div class="form-row variable-row">
                            <div class="col-md-2">
                              <select class="form-control form-control-sm dbTables" onchange="showColumns(this)" name="table[]">
                                <option value="">- Select Table -</option>
                                <?php foreach($tables as $table) { ?>
                                  <option value="<?= $table; ?>"><?= $table; ?></option>
                                <?php } ?>
                              </select>
                            </div>

                            <div class="col-md-2">
                              <select class="form-control form-control-sm dbColumns" name="column[]">
                                <option value="">- Select Column -</option>
                              </select>
                            </div>

                            <div class="col-md-2">
                              <select class="form-control form-control-sm dbType" name="type[]">
                                <option value="Text">Text</option>
                                <option value="Dropdown">Dropdown</option>
                                <option value="Checkbox">Checkbox</option>
                              </select>
                            </div>

                            <div class="col-md-2">
                              <button type="button" class="btn btn-outline-danger btn-sm btnDelRow" onclick="deleteRow(this)"><i class="fas fa-trash"></i></button>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-12">
                          <button type="button" class="btn btn-outline-secondary btn-sm btnAddRowVariable"><i class="fas fa-plus"></i> Add Variable Column</button>
                        </div>

                        <div class="form-group col-md-12 group-row-wrap">
                          <hr>
                          <h6>GROUP BY</h6>

                          <div class="form-row select-row">
                            <div class="col-md-2">
                              <select class="form-control form-control-sm groupTables" onchange="showGroupSelect(this)" name="groupTable">
                                <option value="">- Select Table -</option>
                                <?php foreach($tables as $table) { ?>
                                  <option value="<?= $table; ?>"><?= $table; ?></option>
                                <?php } ?>
                              </select>
                            </div>

                            <div class="col-md-2">
                              <select class="form-control form-control-sm groupColumns" name="groupColumn">
                                <option value="">- Select Column -</option>
                              </select>
                            </div>

                          </div>
                        </div>

                        <div class="form-group col-md-12 order-row-wrap">
                          <hr>
                          <h6>ORDER BY</h6>

                          <div class="form-row order-row">
                            <div class="col-md-2">
                              <select class="form-control form-control-sm orderTables" onchange="showOrderSelect(this)" name="orderTable">
                                <option value="">- Select Table -</option>
                                <?php foreach($tables as $table) { ?>
                                  <option value="<?= $table; ?>"><?= $table; ?></option>
                                <?php } ?>
                              </select>
                            </div>

                            <div class="col-md-2">
                              <select class="form-control form-control-sm orderColumns" name="orderColumn">
                                <option value="">- Select Column -</option>
                              </select>
                            </div>

                            <div class="col-md-2">
                              <select class="form-control form-control-sm orderType" name="orderType">
                                <option value="">- Method -</option>
                                <option value="ASC">ASC</option>
                                <option value="DESC">DESC</option>
                              </select>
                            </div>

                          </div>
                        </div>

                        <div class="form-group col-md-12">
                          <button class="btn btn-primary">Save Report</button>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function() {

    $('.btnAddRowVariable').click(function() {
      $( ".variable-row").first().clone().appendTo(".variable-row-wrap");
    });

    $('.btnAddRowSelect').click(function() {
      $( ".select-row").first().clone().appendTo(".select-row-wrap");
    });

    $('.btnAddRowJoin').click(function() {
      $( ".join-row").first().clone().appendTo(".join-row-wrap");
    });

  });

  function showColumns(i) {
    $.blockUI();
    var table_name = $(i).val();
    var row = $(i).parent().parent().find('.dbColumns');

    $.ajax({
     type: "POST",
     url: '<?php echo base_url(); ?>index.php/reports/table_structure',
     data: { table_name:table_name },
     success: function(response) {
       row.empty();
       for (i = 0; i < response.length; i++) {
         $('<option value='+response[i]+'>'+response[i]+'</option>').appendTo(row);
       }
       $.unblockUI();
     }
   });
 }

  function showColumnsSelect(i) {
    $.blockUI();
    var table_name = $(i).val();
    var row = $(i).parent().parent().find('.selectColumns');

    $.ajax({
     type: "POST",
     url: '<?php echo base_url(); ?>index.php/reports/table_structure',
     data: { table_name:table_name },
     success: function(response) {
       row.empty();
       for (i = 0; i < response.length; i++) {
         $('<option value='+response[i]+'>'+response[i]+'</option>').appendTo(row);
       }
       $.unblockUI();
     }
   });
 }

 function showColumnsJoin(i) {
   $.blockUI();
   var table_name = $(i).val();
   var row = $(i).parent().parent().find('.joinColumns');

   $.ajax({
    type: "POST",
    url: '<?php echo base_url(); ?>index.php/reports/table_structure',
    data: { table_name:table_name },
    success: function(response) {
      row.empty();
      for (i = 0; i < response.length; i++) {
        $('<option value='+response[i]+'>'+response[i]+'</option>').appendTo(row);
      }
      $.unblockUI();
    }
  });
  }

  function showColumnsJoinRoot(i) {
    $.blockUI();
    var table_name = $(i).val();
    var row = $(i).parent().parent().find('.joinRootColumns');

    $.ajax({
     type: "POST",
     url: '<?php echo base_url(); ?>index.php/reports/table_structure',
     data: { table_name:table_name },
     success: function(response) {
       row.empty();
       for (i = 0; i < response.length; i++) {
         $('<option value='+response[i]+'>'+response[i]+'</option>').appendTo(row);
       }
       $.unblockUI();
     }
   });
   }

  function showGroupSelect(i) {
    $.blockUI();
    var table_name = $(i).val();
    var row = $(i).parent().parent().find('.groupColumns');

    $.ajax({
     type: "POST",
     url: '<?php echo base_url(); ?>index.php/reports/table_structure',
     data: { table_name:table_name },
     success: function(response) {
       row.empty();
       for (i = 0; i < response.length; i++) {
         $('<option value='+response[i]+'>'+response[i]+'</option>').appendTo(row);
       }
       $.unblockUI();
     }
   });
  }

  function showOrderSelect(i) {
    $.blockUI();
    var table_name = $(i).val();
    var row = $(i).parent().parent().find('.orderColumns');

    $.ajax({
     type: "POST",
     url: '<?php echo base_url(); ?>index.php/reports/table_structure',
     data: { table_name:table_name },
     success: function(response) {
       row.empty();
       for (i = 0; i < response.length; i++) {
         $('<option value='+response[i]+'>'+response[i]+'</option>').appendTo(row);
       }
       $.unblockUI();
     }
   });
  }

  function deleteRow(i) {
    $(i).parent().parent().remove();
  }
</script>
