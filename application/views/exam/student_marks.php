<div class="container-fluid">

<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
    </li>
    <li class="breadcrumb-item active"><?php echo $title; ?></li>
</ol>

<?php 
    if ($this->session->flashdata('success')) {
    echo '<div class="alert alert-success">'; echo $this->session->flashdata('success'); echo'</div> ';
    }else if ($this->session->flashdata('danger')) {
      echo '<div class="alert alert-success">'; echo $this->session->flashdata('danger'); echo'</div> ';
    }else if ($this->session->flashdata('warning')) {
      echo '<div class="alert alert-success">'; echo $this->session->flashdata('warning'); echo'</div> ';
    }else if ($this->session->flashdata('info')) {
      echo '<div class="alert alert-success">'; echo $this->session->flashdata('info'); echo'</div> ';
    }
    ?>
     <div id="alertArea" class="alert" style="display:none;"> </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Student Examination Results</h5>
                    <hr>
                    <form id="studentExams">
                        <div class="form-row">
                          <div class="form-group col-md-2">
                            <input type="text" id="studentId" name="studentId" class="form-control" placeholder="19S08002" autofocus autocomplete="off" required>
                          </div>
                          <div class="form-group col-md-10">
                            <button type="submit" class="btn btn-primary">View Exam Results</button>
                          </div>
                        </div>
                   </form>
                   
                   <hr>
                    <h6 class="card-title" id="studentname" style="display:none;">Student Name - Report</h6>
                    <div class="table-responsive">
                    <h6  id='student_name' class="text-info">Student Name:</h6>
                        <table class="table" id="dataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Branch</th>
                                    <th>Batch</th>
                                    <th>Exam Date</th>
                                    <th>Course</th>
                                    <th>Module</th>
                                    <th>Purpose</th>
                                    <th>Grade</th>
                                    <th>Grade Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link href="<?php echo base_url(); ?>css/rowGroup.bootstrap.min" rel="stylesheet">
<script>
  $(document).ready(function() {
      
    var table = $('#dataTable').DataTable({
        "columnDefs": [
            { "visible": false, "targets": 2 }
        ],
        "order": [[ 1, 'asc' ]],
        "displayLength": 25,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(5, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="9"><p class="text-primary">'+group+'</p></td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    } );
      
      var t = $('#dataTable').DataTable();

      $('#studentExams').submit(function(e) {
          e.preventDefault();
          var form = $('#studentExams');
          t.clear().draw();

          $.blockUI();
            $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/exam/get_student_attend_Exams',
            data: form.serialize(),
            success: function(response) {
             
                console.log(response);
                var counter = 1;
                $.each(response,function(key, val) {
                  var purposeName = purpose(parseInt(val.purpose));
                  var gradeStat = get_grade_status(val.mark);
                  $('#student_name').html('Student Name: '+val.studentName)
                  console.log (purposeName);
                          t.row.add( [
                              counter,
                              val.branchName,
                              val.batchId,
                              val.date,
                              val.courseName,
                              val.moduleName,
                              purposeName,
                             '<h6 class="text-danger" >'+val.grade+'</h6>',
                              gradeStat,
                          ] ).draw( false );
                          counter++;
                });
                $.unblockUI();
              }
            
          });
      });

  })

  function purpose(id) {
    switch (id) {
          case 1:
           return  "<p class='text-danger'>Final Exam</p>";
            break;
          case 2:
            return  "<p class='text-primary'>Repeat Exam 1</p>";
            break;
          case 3:
            return  "<p class='text-primary'>Repeat Exam 2</p>";
            break;
          case 4:
            return  "<p class='text-primary'>Repeat Exam 3</p>";
              break;
          case 5:
            return  "<p class='text-primary'>Repeat Exam 4</p>";
              break;
          case 6:
            return  "<p class='text-info'>Assignment</p>";
              break;
          case 7:
            return  "<p class='text-success'>Presentation</p>";
              break;
          case 8:
            return  "<p class='text-warning'>MOCK exam</p>";
              break;
          default:
            break;
        }
  }

  function get_grade_status(id) {
   if (id>=40){
    return "<h6 class='text-success'>Pass</h6>";
   }else{
     return "<h6 class='text-danger'>Fail</h6>"
   }
  }
   
  </script>