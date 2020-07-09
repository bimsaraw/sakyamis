<!DOCTYPE html>
<html>
  <head>
    <title><?= $studentId; ?> - Application Form</title>
    <link href="<?php echo base_url(); ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
          position: relative;
        }

        @page { margin: 20px 50px; }

        .pdf_row {
            position: relative;
            width: 100%;
            margin: 10px 0;
            margin-right: 20px;
        }
        .left {
            display: block;
            width: 30%;
            padding-top: 5px;
            margin-right: -30%;
            float: left;
            page-break-inside: avoid;
        }
        .right {
            display: block;
            font-size: 13px;
            margin-left: 30%;
            padding: 5px 10px;
            width: 70%;
            color: #555;
            border: 1px solid #999;
            border-radius: 5px;
            height: 20px;
        }

        .half-left {
            display: block;
            width: 50%;
            padding-top: 5px;
            margin-right: -50%;
            float: left;
            page-break-inside: avoid;
        }
        .half-right {
            display: block;
            margin-left: 50%;
            padding: 5px 0;
            width: 50%;
        }
        h1 {
          font-size: 25px !important;
        }

        h2 {
          font-size: 18px !important;
        }
        h3 {
          margin-top: 25px;
          color: #253b80;
          font-size: 20px !important;
        }

        .block {
          margin: 25px 0;
        }

        .footer {
          position: absolute;
          bottom: 0;
          right: 0;
          font-size: 12px !important;
        }

        .footer-2 {
          position: absolute;
          bottom: 0px;
          right: 0;
        }

        .footer p {
          color: #999;
          margin: 0;
          padding: 0;
        }

    </style>
  </head>
  <?php foreach($student as $row) { ?>
    <body>
      <table>
        <tr>
          <td>
            <img width="100"  src="data:image/jpeg;base64,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" alt="" />
          </td>
          <td>
            <h1 style="color: #253b80;">SAEGIS UNIVERSITY CAMPUS</h1>
            <h2><br>APPLICATION FORM - <?= strtoupper($row['courseName']); ?></h2>
          </td>
        </tr>
      </table>
      <hr size="3" style="color: #253b80;">
      <h3>Personal Information</h3>
      <hr>
      <div class="pdf_row">
        <div class="left">
          Full Name
        </div>
        <div class="right">
          <?= $row['full_name']; ?>
        </div>
      </div>

      <div class="pdf_row">
        <div class="left">
          Name with Initials
        </div>
        <div class="right">
          <?= $row['initials_name']; ?>
        </div>
      </div>

      <div class="pdf_row">
        <div class="left">
          Date of Birth
        </div>
        <div class="right">
          <?= $row['dob']; ?>
        </div>
      </div>

      <div class="pdf_row">
        <div class="left">
          Nationality
        </div>
        <div class="right">
          <?= $row['nationality']; ?>
        </div>
      </div>

      <div class="pdf_row">
        <div class="left">
          NIC/Passport No.
        </div>
        <div class="right">
          <?= $row['nic']; ?>
        </div>
      </div>

      <div class="pdf_row">
        <div class="left">
          Postal Address
        </div>
        <div class="right">
          <?= $row['address']; ?>
        </div>
      </div>

      <div class="pdf_row">
        <div class="left">
          Mobile Phone
        </div>
        <div class="right">
          0<?= $row['mobile']; ?>
        </div>
      </div>

      <div class="pdf_row">
        <div class="left">
          Home Phone
        </div>
        <div class="right">
          0<?= $row['home']; ?>
        </div>
      </div>

      <div class="pdf_row">
        <div class="left">
          Email Address
        </div>
        <div class="right">
          <?= $row['email']; ?>
        </div>
      </div>

      <h3>Educational Details</h3>
      <hr>

      <div class="pdf_row">
        <div class="left">
          Schools Attended
        </div>
        <div class="right">
          <?= $row['schools']; ?>
        </div>
      </div>

      <div class="pdf_row">
        <div class="left">
          G.C.E. O/L Results
        </div>
        <div class="right">
          <?= $row['ol']; ?> | Year: <?= $row['ol_year']; ?>
        </div>
      </div>

      <div class="pdf_row">
        <div class="left">
          G.C.E. A/L Results
        </div>
        <div class="right">
          <?= $row['al']; ?> | Year: <?= $row['al_year']; ?>
        </div>
      </div>

      <div class="pdf_row">
        <div class="left">
          Other Qualifications
        </div>
        <div class="right">
          <?= $row['other_edu']; ?>
        </div>
      </div>

      <h3>Emergency Contact Details</h3>
      <hr>

      <div class="pdf_row">
        <div class="left">
          Person to be contacted
        </div>
        <div class="right">
          <?= $row['guardian_name']; ?>
        </div>
      </div>

      <div class="pdf_row">
        <div class="left">
          Relationship
        </div>
        <div class="right">
          <?= $row['relationship']; ?>
        </div>
      </div>

      <div class="pdf_row">
        <div class="left">
          Mobile Phone
        </div>
        <div class="right">
          0<?= $row['guardian_mobile']; ?>
        </div>
      </div>

      <div class="pdf_row">
        <div class="left">
          Home Phone
        </div>
        <div class="right">
          0<?= $row['guardian_home']; ?>
        </div>
      </div>

      <h3>Enrollment Details</h3>
      <hr>

      <div class="pdf_row">
        <div class="left">
          Student ID Number
        </div>
        <div class="right">
          <?= $row['studentId']; ?>
        </div>
      </div>

      <div class="pdf_row">
        <div class="left">
          Intake Enrolled
        </div>
        <div class="right">
          <?= $row['intakeName']; ?>
        </div>
      </div>

      <div class="pdf_row">
        <div class="left">
          Course Enrolled
        </div>
        <div class="right">
          <?= $row['courseName']; ?>
        </div>
      </div>

      <div class="pdf_row">
        <div class="left">
          Payment Plan
        </div>
        <div class="right">
          <?= $row['pplan_name']; ?>
        </div>
      </div>

      <div class="pdf_row">
        <div class="left">
          Batch
        </div>
        <div class="right">
          <?= $row['batchName']; ?> | <?= $row['batchId']; ?>
        </div>
      </div>

      <div class="block">
        <h2 style="color:#253b80;">REFUND POLICY</h2>
        <p>Full Registration Fee / Semester Fee or any other Monthly Fee payments will not be refunded after the Commencement of the Programme / Semester.

        <div class="pdf_row" style="margin-top: 40px">
          <div class="half-left">
            Date: <?= $row['datetime'];?>
          </div>
          <div class="half-right">
            Signature of the Applicant: ___________________
          </div>
        </div>
      </div>

      <h3>For official use only </h3>
      <hr>
      <div class="pdf_row">
        <div class="left">
          Counselor
        </div>
        <div class="right">
          <?= $row['counselor']; ?>
        </div>
      </div>

      <div class="pdf_row">
        <div class="left">
          Registered by
        </div>
        <div class="right">
          <?= $row['username']; ?>
        </div>
      </div>

      <div class="block">
        <h2 style="color:#253b80;">DOCUMENTS</h2>
        <ol>
          <li>A copy of Birth Certificate - <?php if($row['birth_certificate']==1) { echo 'Available'; } else { echo 'Not available'; } ?></li>
          <li>O/L Certificate - <?php if($row['ol_certificate']==1) { echo 'Available.'; } else { echo 'Not available'; } ?></li>
          <li>A/L Certificate - <?php if($row['al_certificate']==1) { echo 'Available.'; } else { echo 'Not available'; } ?></li>
          <li>A copy of NIC / Passport - <?php if($row['nic_copy']==1) { echo 'Available.'; } else { echo 'Not available'; } ?><li>
          <li>Other qualification certificates - <?php if($row['other_certificates']==1) { echo 'Available.'; } else { echo 'Not available'; } ?></li>
        </ol>

        <div class="pdf_row" style="margin-top: 40px">
          <div class="half-left">
            Date: <?= $row['datetime'];?>
          </div>
          <div class="half-right">
            Signature: ________________________
          </div>
        </div>
      </div>

      <div class="footer">
        <p>Saegis Campus</p>
        <p>135, S De S Jayasinghe Mawatha,</p>
        <p>Kohuwala, Nugegoda</p>
        <p>Tel: 0117430000</p>
        <p>Email: info@saegis.edu.lk</p>
        <p>www.saegis.edu.lk</p>
      </div>

      <div class="footer-2">
                  <img width="100"  src="data:image/jpeg;base64,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" alt="" />
                </div>

  </body>
  <?php } ?>
</html>
