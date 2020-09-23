<div class="container header" >
<div class="page-header">
  <div class="row ">
    <div class="col-2 ">
    <img src="<?php echo base_url(); ?>/uploads/logo.jpg">
    </div>
    <div class="col ">
    <h4 style="font-family:'Times New Roman', Times, serif;"><strong>SIKSIL INSTITUTE OF BUSINESS & TECHNOLOGY (PVT)LTD</strong> </h4>
    
    <div class="col">
   
    <?php foreach($exam as $exam){ ?>
      
         <div class="row height ">
            <div class="col-3">
            Course
            </div>
            <div class="col-9 ">
            <?= $exam['courseName'];?> - 
            <?php 
                 $p= $exam['purpose'];
           
                 switch ($p) {
                     case 1:
                      echo  "Final Exam";
                     
                       break;
                     case 2:
                         echo  "Repeat Exam 1";
                        
                       break;
                     case 3:
                         echo  "Repeat Exam 2";
                       
                       break;
                     case 4:
                         echo  "Repeat Exam 3";
                        
                         break;
                     case 5:
                         echo  "Repeat Exam 4";
                         
                         break;
                     case 6:
                         echo  "Assignment";
                        
                         break;
                     case 7:
                         echo  "Presentation";
                       
                         break;
                     case 8:
                         echo  "MOCK exam";
                        
                         break;
                        }
            ?>
            </div>
        </div>
        <div class="row height">
            <div class="col-3 ">
            Batch
            </div>
            <div class="col-9 ">
            <?= $exam['batchId']; ?>
            </div>
        </div>
        <div class="row height">
            <div class="col-3 ">
            Examination Module
            </div>
            <div class="col-9 ">
            <?= $exam['moduleName']; ?>
            </div>
        </div>
        <div class="row height ">
            <div class="col-3 ">
            Examination Date
            </div>
            <div class="col-9 ">
            <?= $exam['date']; ?>
            </div>
        </div>
        <div class="row height ">
            <div class="col-3 ">
            Issue Date
            </div>
            <div class="col-9">
            <?=date('Y-m-d') ?>
            </div>
        </div>
 
    <?php } ?>
    
    </div>
   
    </div>
    </div>
</div>

<div class="container" >
    <div class="page-footer">
        <div class="container">
            <div class="row">
                <div class="col">.....................................................</div>
                <div class="col">.....................................................</div>
                <div class="col">.....................................................</div>
            </div>
            <div class="row">
                <div class="col">Course Coodinator</div>
                <div class="col">Examination Coordinator</div>
                <div class="col">Administrative Officer</div>
            </div>
        </div>
    </div>

<br>



<div class="contentbody" id="cbody">
<table class="sticky">

    <thead>
      <tr>
        <td>
          <!--place holder for the fixed-position header-->
          <div class="page-header-space"></div>
        </td>
      </tr>
    </thead>

   <tbody>
        <td>
        <table class="table table-bordered sticky" id="dataTable">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody >
                    <?php foreach($results as $result){ ?>
                        <tr>
                        <td><?= $result['studentId']; ?> </td>
                        <td><?= $result['grade']; ?> </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            
            
        </td>
    </tbody>
   
    

    <tfoot>
      <tr>
        <td>
          <!--place holder for the fixed-position footer-->
          <div class="page-footer-space"></div>
        </td>
      </tr>
    </tfoot>

</table>
</div>

<script>
$(document).ready(function(){

    var rowcount = $('#dataTable tr').length;
    if (rowcount>23){
        $('#cbody').addClass("column");
    }
})
</script>