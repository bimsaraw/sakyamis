<!DOCTYPE html>
<html>
  <head>
    <title>Print Receipt</title>
    <style>

    body {
      font-family: sans-serif;
    }

    h1 {
      font-size: 18px;
      margin: 5px 0;
    }

    p {
      margin: 5px 0;
    }

    .center {
      text-align: center;
    }

    .header {
      margin: 20px 0;
    }

    .content {
      margin: 20px 0;
    }

    .payment table th {
      padding: 5px;
    }

    .payment table td {
      padding: 5px;
    }

    .footer {
      margin: 10px 0;
      font-size: 14px;
    }

    .footer p {
      margin: 3px 0;
    }

    </style>
  </head>
  <body>
    <div class="center header">
      <h1>SIBT - Siksil Institute of Business & Technology </h1>
      <p>No. 08, Pietersz Place,Kohuwala, Nugegoda. 10250 Sri Lanka</p>
      <p>011 743 0000 | www.sibt.edu.lk</p>
    </div>
    <hr>
    <div class="content">
      <table>
        <tr>
          <td><b>Receipt No.</b></td><td><?= $print->studentId."-".$print->pplanId."-".$print->installmentId; ?></td>
        </tr>
        <tr>
          <td></td>
        </tr>
        <tr>
          <td></td>
        </tr>
        <tr>
          <td><b>Student ID </b></td><td><?= $print->studentId; ?></td>
        </tr>
        <tr>
          <td><b>Student Name </b></td><td><?= $print->studentName; ?></td>
        </tr>
        <tr>
          <td><b>Course </b></td><td><?= $print->courseName; ?></td>
        </tr>
        <tr>
          <td><b>Batch </b></td><td><?= $print->batchId; ?></td>
        </tr>
      </table>
    </div>

    <div class="payment">
      <table border=1>
        <tr>
          <th>Installment</th>
          <th>£ Amount</th>
          <th>Conv. Rate</th>
          <th>Amount</th>
        </tr>
        <tr>
          <td><?= $print->installmentName; ?></td>
          <td><?= $print->currency_amount; ?></td>
          <td><?= $print->rate; ?></td>
          <td><?= number_format($print->amount,2,".",",") ?></td>
        </tr>
      </table>
      <h3 class="center" style="margin-bottom:0px;">Total: <?= number_format($print->amount,2,".",",") ?></h3>
      <p class="center">Paid by <?= $print->type; ?></p>
    </div>

    <hr>
    <div class="center footer">
      <p>Cashier: <?= $print->username; ?> at <?= $print->datetime; ?></p>
    </div>
  </body>
</html>
