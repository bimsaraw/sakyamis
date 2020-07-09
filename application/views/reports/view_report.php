
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
                    print_r($report);
                    $newArray = array_keys($report[0]);
                    ?>

                    <div class="table table-responsive">
                      <table class="table table-stripped">
                        <thead>
                          <tr>
                          </tr>
                        </thead>
                      </table>
                    </div>
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
