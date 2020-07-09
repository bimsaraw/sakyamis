
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
      <div class="table-responsive">
        <table id="dataTable" class="table table-stripped">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Course</th>
              <th>Mobile No.</th>
              <th>Counselor</th>
              <th>Inquired Date</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($inquiries as $inquiry) { ?>
              <tr>
                <td><?= $inquiry['id']; ?></td>
                <td><?= $inquiry['name']; ?></td>
                <td><?= $inquiry['courseName']; ?></td>
                <td><?= $inquiry['mobile']; ?></td>
                <td><?= $inquiry['username']; ?></td>
                <td><?= $inquiry['datetime']; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    } );
</script>
