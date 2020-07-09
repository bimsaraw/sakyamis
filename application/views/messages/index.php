
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
            <h5>Message Templates</h5>
            <?php if(isset($msg)) { ?>
                        <div class="alert alert-success"><?= $msg; ?></div>
            <?php
            } ?>

            <?php if(isset($error)) { ?>
                        <div class="alert alert-danger"><?= $error; ?></div>
            <?php
            } ?>
            <div class="table-responsive">
                <table class="table" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Course</th>
                            <th>Instance</th>
                            <th>Subject</th>
                            <th>SMS</th>
                            <th>Attachment</th>
                            <th><a href="<?= base_url() ?>index.php/messages/add" class="btn btn-outline-primary btn-sm">Add New</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $message): ?>
                            <tr>
                              <td><?php echo $message['courseName']; ?></td>
                              <td><?php echo $message['instance']; ?></td>
                              <td><?php echo $message['subject']; ?></td>
                              <td><?php echo $message['sms']; ?></td>
                              <td><a href="<?=base_url(); ?>uploads/<?= $message['attachment']; ?>" target="_blank">View</a></td>
                              <td>
                                <a href="<?=base_url(); ?>index.php/messages/edit?id=<?=$message['id']; ?>" class="btn btn-sm btn-primary"><i class='fas fa-pencil-alt'></i></a>
                                <a href="<?=base_url(); ?>index.php/messages/delete?id=<?=$message['id']; ?>" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></a>
                              </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
          'autoWidth':false
        });
    } );
</script>
