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
    h2 {
      font-size: 16px;
      margin: 5px 0;
    }

    p {
      margin: 5px 0;
    }

    .center {
      text-align: center;
    }

    .strong{
      font-size: 18px;
      margin: 20px 0;
     
    }

    .header {
      margin: 20px 0;
    }

    .content {
      margin: 20px 0;
    }
    .border-solid {
      border: 1px solid black;
    }
    
    .payment table {
      border-collapse: collapse;
      width: 100%;
    }

    .payment table th {
     text-align:center;
      padding: 5px;
      height: 50px;
      border: 1px solid black;
    }

    .payment table td {
      padding: 5px;
      border: 1px solid black;
    }




    .tfooter table {
      border-collapse: collapse;

    }

    .tfooter table th {
     text-align:center;
      padding: 5px;
      height: 50px;
    
    }

    .tfooter table td {
      padding: 5px;
      
    }



    .footer {
      margin: 10px 0;
      font-size: 14px;
    }

    .footer p {
      margin: 3px 0;
    }
    .parent {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      grid-template-rows: 1fr;
      grid-column-gap: 5px;
      grid-row-gap: 0px;
      align-items: left;
      }

      .div1 { grid-area: 1 / 1 / 2 / 2; }
      .div2 { grid-area: 1 / 2 / 2 / 3; }

    </style>
  </head>
  <body>
  <?php $grandTotal =0;
  
  $l_precentage = floatval ($_GET['L_precentage']);
  $I_precentage = 100- $l_precentage;

  
  ?>
    <div class="center header">
      <h1>SIKSIL INSTITUTE OF BUSINESS & TECHNOLOGY </h1>
      <p>No.08,Pietersz Place,Kohuwala,Nugegoda.10250 Sri Lanka</p>
      <p>011 743 0000 | www.sibt.edu.lk</p>
     
    </div>
    <hr>
    <div class="content payment">
      <table class="border-solid">
      
      <thead>
      <h1><?php echo $title ?> as <?php echo $_GET['startDate']?> - <?php echo $_GET['endDate']?>  </h1>
                    <tr>
                        <th>Date Time</th>
                        <th>User</th>
                        <th>Student ID</th>
                        <th>Batch</th>
                        <th>Installment</th>
                        <th>Fee Type</th>
                        <th>Payment Method</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody >
                    <?php  foreach($payments as $payment){ ?>
                        <tr>
                        <td><?= $payment['dateTime']; ?> </td>
                        <td><?= $payment['username']; ?> </td>
                        <td><?= $payment['studentId']; ?> </td>
                        <td><?= $payment['batchId']; ?> </td>
                        <td><?= $payment['instName']; ?> </td>
                        <td><?php
                        $fee_type_name="";
                        if($payment['fee_type']==1) {
                          $fee_type_name="Course Fees";
                        } else {
                          $fee_type_name="Royalty Fees";
                        }
                        echo $fee_type_name; ?> </td>
                        <td><?= $payment['type']; ?> </td>
                        <td><?=number_format($payment['amount'], 2, '.', ',');  ?></td>
                        </tr>
                    <?php $grandTotal+=$payment['amount'];   } ?>
                </tbody>
      </table>
    </div>

  
    <div class="parent">
        <div class="div2 tfooter"> 
              <table>
              
              <tr style="text-align:right;">
                  <td> <strong>For Institute  <?=$I_precentage?>%</strong> </td>            
                  <td> : </td>
                  <td><strong><?=number_format($grandTotal*$I_precentage/100, 2, '.', ','); ?> </strong></td> 
              </tr>
              <tr style="text-align:right;">
                  <td><strong> For lecturer <?=$l_precentage?>%</strong> </td> 
                  <td> : </td>           
                  <td><strong><?=number_format($grandTotal*$l_precentage/100, 2, '.', ',');   ?></strong> </td> 
              </tr>
              <tr style="text-align:right;">
                  <td><strong> Grand Total</strong> </td>  
                  <td> : </td>          
                  <td style='border-bottom: double; border-top: 1px solid'><strong><?= number_format($grandTotal, 2, '.', ', ');?></strong></td> 
              </tr>
            
              </table>
        </div>
    </div>
  

    <hr>
    <div class="center footer">
      <p>Print Date & Time: <?= date('d-M-yy h:m:s') ?></p>
    </div>
  </body>
</html>

<script>
  window.onload = function() { 
    
    window.focus();
    window.print();
    //window.close();
  }
</script>