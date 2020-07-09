
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
                    <div class="table-responsive">
                        <table class="table" id="dataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Plan Name</th>
                                    <th>Course</th>
                                    <th>Intake</th>
                                    <th>Total Amount</th>
                                    <th><a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPayment">Add New</a></th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php foreach($pplans as $pplan) { ?>
                                <tr>
                                  <td><?= $pplan['name']; ?></td>
                                  <td><?= $pplan['courseName']; ?></td>
                                  <td><?= $pplan['intakeName']; ?></td>
                                  <td><?= $pplan['total']; ?></td>
                                  <td><a class='btn btn-primary btn-sm' href='#'><i class='fas fa-pencil-alt'></i></a>&nbsp;<button type="button" onclick="delete_pplan(<?= $pplan['id']; ?>)" class='btn btn-danger btn-sm' href='#'><i class="far fa-trash-alt"></i></button></td>
                              <?php } ?>
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
        $('#dataTable').DataTable();
    } );

    function delete_pplan(pplanId) {
      if (confirm("Are you really want to delete this Payment Plan?")) {
        window.location.assign("<?= base_url(); ?>index.php/payments/delete_payment_plan?id="+pplanId);
      }
    }
</script>
