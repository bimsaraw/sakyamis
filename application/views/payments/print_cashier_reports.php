<!DOCTYPE html>
<html>
  <head>
    <title><?= $studentId; ?> - Student ID Card</title>
    <link href="<?php echo base_url(); ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>

      @page { margin: 0px 0; }

      body {
          font-family: 'Roboto', sans-serif;
      }

      .left-column {
        float: left;
        width: 40%;
      }

      p {
        margin: 0px 0px;
        line-height: 16px;
        font-family: 'Roboto', sans-serif;
      }

      .right-column {
        float: left;
        width: 60%;
      }

      /* Clear floats after the columns */
      .row:after {
        content: "";
        display: table;
        clear: both;
      }

    </style>
  </head>
    <body>

      <div style="position: relative; background-image:url('<?= "data:image/jpeg;base64,".$base64_front; ?>'); height: 153pt; background-repeat: no-repeat;">
        <div style="position: absolute; top: 30px; left: 10px;">
          <img src="<?= $base64_image; ?>" width="100px">
        </div>
        <div style="position: absolute; top: 85px; left:118px;">
          <p style="font-weight: bold; margin-bottom: 5px;"><?= $student->title.". ".$student->initials_name; ?></p>
          <p style="font-weight: bold;"><?= $student->studentId; ?></p>
          <p style="font-size: 14px;"><?= $student->nic; ?></p>
        </div>
      </div>

      <div style="position: relative; background-image:url('<?= "data:image/jpeg;base64,".$base64_back; ?>'); height: 153pt; background-repeat: no-repeat;">
        <div style="position: absolute; top: 120px; left: 20px;">
          <?php $barcode = $this->barcode->generate($studentId); ?>
        </div>
      </div>
    </body>
</html>
