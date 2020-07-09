  <div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
    <li class="breadcrumb-item active">Overview</li>
    </ol>
    <?php

    if(isset($_GET['msg'])) {
      if($_GET['msg']=='noperm') { ?>
        <div class="alert alert-warning">
          You don't have necessary permissions to view this page.
        </div>
      <?php
      }
    } else { ?>

     <div class="form-row">
       <?php if(isset($show_inquiries)) { ?>
         <div class="col-md-6">
           <div class="card">
             <div class="card-body" style="height: 100vh; overflow-y: scroll;">
               <div class="inquiry-dashboard">
                 <div class="row">
                   <div class="col-md-8">
                     <h5 class="card-title">Student Enrollment Progress</h5>
                   </div>
                   <div class="col-md-4">
                     <div class="form-group">
                       <select id="intakeId" class="form-control form-control-sm">
                         <?php foreach ($intakes as $intake) { ?>
                           <option value="<?= $intake['id']; ?>"><?= $intake['name']; ?></option>
                         <?php } ?>
                       </select>

                       <input type="hidden" id="startDate">
                       <input type="hidden" id="endDate">
                     </div>
                   </div>
                 </div>

                 <?php foreach($courses as $course) { ?>
                   <div class="progress-group">
                     <div class="row">
                       <div class="col-md-8">
                         <?php if($all==1) { ?>
                           <a href="#" class="progress-span" data-toggle="modal" data-target="#courseCountModal" onclick="get_numbers_by_course(<?= $course['id']; ?>,'<?= $course['name']; ?>')"><?= $course['name']; ?></a>
                        <?php } else { ?>
                          <a href="#" class="progress-span"><?= $course['name']; ?></a>
                        <?php } ?>
                         <input type="hidden" id="course_<?= $course['id']; ?>" value="<?= $course['id']; ?>">
                       </div>
                       <div class="col-md-4 progress-span text-right">
                         <span id="achieved_<?= $course['id']; ?>">0</span> /
                         <span id="target_<?= $course['id']; ?>">0</span>
                         <input type="hidden" id="target_<?= $course['id']; ?>">
                       </div>
                     </div>
                     <div class="progress">
                       <div id="progress_<?= $course['id']; ?>" class="progress-bar bg-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                     </div>
                     <span id="pending_<?= $course['id']; ?>" class="progress-info progress-pending">Pending: 0</span>
                     <span id="positive_<?= $course['id']; ?>" class="progress-info progress-positive">Positive: 0</span>
                     <span id="registered_<?= $course['id']; ?>" class="progress-info progress-registered">Enrolled: 0</span>
                     <span id="failed_<?= $course['id']; ?>" class="progress-info progress-failed">Failed: 0</span>
                   </div>
                 <?php } ?>

              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
                  <h5>Inquiry Sources</h5>
                  <hr>
                  <form id="inquirySources">
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label>Course</label>
                        <select class="form-control form-control-sm" id="courseId" name="courseId">
                          <option value="">- Select Course -</option>
                          <?php foreach($courses as $course) { ?>
                            <option value="<?=$course['id']; ?>"><?= $course['name']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <label>Date Range</label>
                        <input type="text" id="dateRange" class="form-control form-control-sm" required>
                        <input type="hidden" id="startDate2" name="startDate">
                        <input type="hidden" id="endDate2" name="endDate">
                      </div>

                      <div class="form-group col-md-6">
                        <button type="submit" class="btn btn-primary btn-sm">View</button>
                      </div>
                    </div>
                  </form>
              <canvas id="sourceChart" width="400" height="300" ></canvas>
            </div>
          </div>

          <div class="card" style="margin-top: 15px;">
            <div class="card-body">
              <h5>Payment Details</h5>
              <hr>
              <p>Will be available soon!</p>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>

    <?php }
    ?>

    <!-- Icon Cards-->

</div>

<div class="modal fade" id="courseCountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="courseCountTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="courseCountBody">

      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

<script>

$(function() {
    //var options = { twentyFour: true }
    //$('.timepicker').wickedpicker(options);
    $('#dateRange').daterangepicker({
        opens: 'right'
    }, function(start, end, label) {
        $('#startDate2').val(start.format('YYYY-MM-DD'));
        $('#endDate2').val(end.format('YYYY-MM-DD'));
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
});

function get_numbers_by_course(courseId,courseName) {
  $('#courseCountTitle').html(courseName);
  var intakeId = $('#intakeId').val();
  var startDate;
  var endDate;

  $.blockUI();
  $.ajax({
    type: "POST",
    url: '<?php echo base_url(); ?>index.php/inquiries/get_intake_dates',
    data: {intakeId:intakeId},
    cache: false,
    success: function(response) {
      $.each(response,function(key, val) {
        startDate = val.startDate;
        endDate = val.endDate;
      });

      $.ajax({
        type: "POST",
        url: '<?php echo base_url(); ?>index.php/inquiries/get_targets_by_intake_course',
        data: {intakeId:intakeId,courseId:courseId},
        cache: false,
        success: function(response) {
          var markup = "";
          $.each(response,function(key, val) {
            var target = val.target;
            var username = val.username;
            var registered;
            var enrolled;
            var positive;
            var pending;
            var failed;

            markup += '<div class="one-counselor"><div class="row">';
            markup += '<div class="col-md-8" style="font-weight: bold; margin-top: 10px; margin-bottom:5px;">'+val.usersname+'</div>';
            markup += '<div class="col-md-4 text-right"><span id="registered_'+username+'"></span> / '+val.target+'</div>';
            markup += '<div class="col-md-12"><div class="progress"><div id="progress_'+username+'" class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div></div></div>';
            markup += '<div class="col-md-12">';
            markup += '<span id="pending_'+username+'" class="progress-info progress-pending">Pending: 0</span>';
            markup += '<span id="positive_'+username+'" class="progress-info progress-positive">Positive: 0</span>';
            markup += '<span id="enrolled_'+username+'" class="progress-info progress-registered">Enrolled: 0</span>';
            markup += '<span id="failed_'+username+'" class="progress-info progress-failed">Failed: 0</span>';
            markup += '</div>';
            markup += '</div></div>';

            //registered
            $.ajax({
              type: "GET",
              url: '<?php echo base_url(); ?>index.php/enrollments/get_registered_students_by_course',
              data: {intakeId:intakeId,courseId:courseId,username:val.username},
              cache: false,
              success: function(response) {
                $.each(response,function(registered_key, registered_val) {
                  $('#registered_'+username).html(registered_val.inquiries);

                  var progress = (registered_val.inquiries/target)*100;

                  $('#progress_'+username).attr("style","width:"+progress+"%");
                  $('#progress_'+username).attr("area-valuenow",progress);
                });
              }
            });

            //pending
            $.ajax({
              type: "GET",
              url: '<?php echo base_url(); ?>index.php/inquiries/count_inquiries_by_course_username',
              data: {intakeId:intakeId,courseId:courseId,username:username,type:'is_pending',startDate:startDate,endDate:endDate},
              cache: false,
              success: function(response) {
                $.each(response,function(pending_key, pending_val) {
                  $('#pending_'+username).html('Pending: '+pending_val.inquiries);
                });
              }
            });

            //positive
            $.ajax({
              type: "GET",
              url: '<?php echo base_url(); ?>index.php/inquiries/count_inquiries_by_course_username',
              data: {intakeId:intakeId,courseId:courseId,username:username,type:'is_positive',startDate:startDate,endDate:endDate},
              cache: false,
              success: function(response) {
                $.each(response,function(positive_key, positive_val) {
                  $('#positive_'+username).html('Positive: '+positive_val.inquiries);
                });
              }
            });

            //failed
            $.ajax({
              type: "GET",
              url: '<?php echo base_url(); ?>index.php/inquiries/count_inquiries_by_course_username',
              data: {intakeId:intakeId,courseId:courseId,username:username,type:'is_failed',startDate:startDate,endDate:endDate},
              cache: false,
              success: function(response) {
                $.each(response,function(failed_key, failed_val) {
                  $('#failed_'+username).html('Failed: '+failed_val.inquiries);
                });
              }
            });

            //enrolled
            $.ajax({
              type: "GET",
              url: '<?php echo base_url(); ?>index.php/enrollments/get_enrolled_students_by_course',
              data: {intakeId:intakeId,courseId:courseId,username:username},
              cache: false,
              success: function(response) {
                $.each(response,function(enrolled_key, enrolled_val) {
                  $('#enrolled_'+username).html('Enrolled: '+enrolled_val.inquiries);
                });
              }
            });

          });
          $('#courseCountBody').html(markup);
        }
      });
      $.unblockUI();
    }
  });
}

  $(document).ready(function() {

    var intakeId = $('#intakeId').val();
    var startDate;
    var endDate;

    $.blockUI();
    $.ajax({
      type: "POST",
      url: '<?php echo base_url(); ?>index.php/inquiries/get_intake_dates',
      data: {intakeId:intakeId},
      cache: false,
      success: function(response) {
        $.each(response,function(key, val) {
          startDate = val.startDate;
          endDate = val.endDate;
        });

        <?php foreach($courses as $course) { ?>
          var target;
          //targets
          $.ajax({
            type: "GET",
            <?php if($all==1) { ?>
              url: '<?php echo base_url(); ?>index.php/inquiries/get_target_by_course',
            <?php } else { ?>
              url: '<?php echo base_url(); ?>index.php/inquiries/get_target_by_course_username',
            <?php } ?>
            data: {intakeId:intakeId,courseId:<?= $course['id']; ?>,username:'<?= $username; ?>'},
            cache: false,
            success: function(response) {
              $.each(response,function(key, val) {
                $('#target_<?= $course['id']; ?>').html(val.target);
                target = val.target;

                if(val.target==null) {
                  $('#target_<?= $course['id']; ?>').html(0);
                }
              });
            }
          });

          //pending
          $.ajax({
            type: "GET",
            <?php if($all==1) { ?>
              url: '<?php echo base_url(); ?>index.php/inquiries/count_inquiries_by_course',
            <?php } else { ?>
              url: '<?php echo base_url(); ?>index.php/inquiries/count_inquiries_by_course_username',
            <?php } ?>
            data: {intakeId:intakeId,courseId:<?= $course['id']; ?>,username:'<?= $username; ?>',type:'is_pending',startDate:startDate,endDate:endDate},
            cache: false,
            success: function(response) {
              $.each(response,function(pending_key, pending_val) {
                $('#pending_<?= $course['id']; ?>').html('Pending: '+pending_val.inquiries);
              });
            }
          });

          $.ajax({
            type: "GET",
            <?php if($all==1) { ?>
              url: '<?php echo base_url(); ?>index.php/inquiries/count_inquiries_by_course',
            <?php } else { ?>
              url: '<?php echo base_url(); ?>index.php/inquiries/count_inquiries_by_course_username',
            <?php } ?>
            data: {intakeId:intakeId,courseId:<?= $course['id']; ?>,username:'<?= $username; ?>',type:'is_positive',startDate:startDate,endDate:endDate},
            cache: false,
            success: function(response) {
              $.each(response,function(key, val) {
                $('#positive_<?= $course['id']; ?>').html('Positive: '+val.inquiries);
              });
            }
          });

          $.ajax({
            type: "GET",
            url: '<?php echo base_url(); ?>index.php/enrollments/get_enrolled_students_by_course',
            <?php if($all==1) { ?>
              data: {intakeId:intakeId,courseId:<?= $course['id']; ?>,username:''},
            <?php } else { ?>
              data: {intakeId:intakeId,courseId:<?= $course['id']; ?>,username:'<?= $username; ?>'},
            <?php } ?>
            cache: false,
            success: function(response) {
              $.each(response,function(key, val) {
                $('#registered_<?= $course['id']; ?>').html('Enrolled: '+val.inquiries);
              });
            }
          });

          $.ajax({
            type: "GET",
            url: '<?php echo base_url(); ?>index.php/enrollments/get_registered_students_by_course',
            <?php if($all==1) { ?>
              data: {intakeId:intakeId,courseId:<?= $course['id']; ?>,username:''},
            <?php } else { ?>
              data: {intakeId:intakeId,courseId:<?= $course['id']; ?>,username:'<?= $username; ?>'},
            <?php } ?>
            cache: false,
            success: function(response) {
              $.each(response,function(key, val) {
                $('#achieved_<?= $course['id']; ?>').html(val.inquiries);
                var progress = (val.inquiries/target)*100;
                $('#progress_<?= $course['id']; ?>').attr("style","width:"+progress+"%");
                $('#progress_<?= $course['id']; ?>').attr("area-valuenow",progress);
              });
            }
          });

          $.ajax({
            type: "GET",
            <?php if($all==1) { ?>
              url: '<?php echo base_url(); ?>index.php/inquiries/count_inquiries_by_course',
            <?php } else { ?>
              url: '<?php echo base_url(); ?>index.php/inquiries/count_inquiries_by_course_username',
            <?php } ?>
            data: {intakeId:intakeId,courseId:<?= $course['id']; ?>,username:'<?= $username; ?>',type:'is_failed',startDate:startDate,endDate:endDate},
            cache: false,
            success: function(response) {
              $.each(response,function(key, val) {
                $('#failed_<?= $course['id']; ?>').html('Failed: '+val.inquiries);
              });
            }
          });
        <?php } ?>
        $.unblockUI();
      }
    });
  });

  $('#intakeId').change(function() {

    var intakeId = $('#intakeId').val();
    var startDate;
    var endDate;

    $.blockUI();
    $.ajax({
      type: "POST",
      url: '<?php echo base_url(); ?>index.php/inquiries/get_intake_dates',
      data: {intakeId:intakeId},
      cache: false,
      success: function(response) {
        $.each(response,function(key, val) {
          startDate = val.startDate;
          endDate = val.endDate;
        });

        <?php foreach($courses as $course) { ?>
          var target;
          //targets
          $.ajax({
            type: "GET",
            <?php if($all==1) { ?>
              url: '<?php echo base_url(); ?>index.php/inquiries/get_target_by_course',
            <?php } else { ?>
              url: '<?php echo base_url(); ?>index.php/inquiries/get_target_by_course_username',
            <?php } ?>
            data: {intakeId:intakeId,courseId:<?= $course['id']; ?>,username:'<?= $username; ?>'},
            cache: false,
            success: function(response) {
              $.each(response,function(key, val) {
                $('#target_<?= $course['id']; ?>').html(val.target);
                target = val.target;
              });
            }
          });

          //pending
          $.ajax({
            type: "GET",
            <?php if($all==1) { ?>
              url: '<?php echo base_url(); ?>index.php/inquiries/count_inquiries_by_course',
            <?php } else { ?>
              url: '<?php echo base_url(); ?>index.php/inquiries/count_inquiries_by_course_username',
            <?php } ?>
            data: {intakeId:intakeId,courseId:<?= $course['id']; ?>,username:'<?= $username; ?>',type:'is_pending',startDate:startDate,endDate:endDate},
            cache: false,
            success: function(response) {
              $.each(response,function(key, val) {
                $('#pending_<?= $course['id']; ?>').html('Pending: '+val.inquiries);
              });
            }
          });

          $.ajax({
            type: "GET",
            <?php if($all==1) { ?>
              url: '<?php echo base_url(); ?>index.php/inquiries/count_inquiries_by_course',
            <?php } else { ?>
              url: '<?php echo base_url(); ?>index.php/inquiries/count_inquiries_by_course_username',
            <?php } ?>
            data: {intakeId:intakeId,courseId:<?= $course['id']; ?>,username:'<?= $username; ?>',type:'is_positive',startDate:startDate,endDate:endDate},
            cache: false,
            success: function(response) {
              $.each(response,function(key, val) {
                $('#positive_<?= $course['id']; ?>').html('Positive: '+val.inquiries);
              });
            }
          });

          $.ajax({
            type: "GET",
            url: '<?php echo base_url(); ?>index.php/enrollments/get_enrolled_students_by_course',
            <?php if($all==1) { ?>
              data: {intakeId:intakeId,courseId:<?= $course['id']; ?>,username:''},
            <?php } else { ?>
              data: {intakeId:intakeId,courseId:<?= $course['id']; ?>,username:'<?= $username; ?>'},
            <?php } ?>
            cache: false,
            success: function(response) {
              $.each(response,function(key, val) {
                $('#registered_<?= $course['id']; ?>').html('Enrolled: '+val.inquiries);
              });
            }
          });

          $.ajax({
            type: "GET",
            url: '<?php echo base_url(); ?>index.php/enrollments/get_registered_students_by_course',
            <?php if($all==1) { ?>
              data: {intakeId:intakeId,courseId:<?= $course['id']; ?>,username:''},
            <?php } else { ?>
              data: {intakeId:intakeId,courseId:<?= $course['id']; ?>,username:'<?= $username; ?>'},
            <?php } ?>
            cache: false,
            success: function(response) {
              $.each(response,function(key, val) {
                $('#achieved_<?= $course['id']; ?>').html(val.inquiries);
                var progress = (val.inquiries/target)*100;
                $('#progress_<?= $course['id']; ?>').attr("style","width:"+progress+"%");
                $('#progress_<?= $course['id']; ?>').attr("area-valuenow",progress);
              });
            }
          });

          $.ajax({
            type: "GET",
            <?php if($all==1) { ?>
              url: '<?php echo base_url(); ?>index.php/inquiries/count_inquiries_by_course',
            <?php } else { ?>
              url: '<?php echo base_url(); ?>index.php/inquiries/count_inquiries_by_course_username',
            <?php } ?>
            data: {intakeId:intakeId,courseId:<?= $course['id']; ?>,username:'<?= $username; ?>',type:'is_failed',startDate:startDate,endDate:endDate},
            cache: false,
            success: function(response) {
              $.each(response,function(key, val) {
                $('#failed_<?= $course['id']; ?>').html('Failed: '+val.inquiries);
              });
            }
          });
        <?php } ?>
        $.unblockUI();
      }
    });

  });
</script>
<script src="<?php echo base_url(); ?>vendor/chart.js/Chart.min.js"></script>

<script>

$('#inquirySources').submit(function(e) {
  e.preventDefault();

  $.blockUI();


  var inquiry_sources = new Array();
  var count = new Array();

  var form = $('#inquirySources');

  var courseId = $('#selectCourse').val();

  var myChart;

  if(myChart) {
    myChart.destroy();
  }

  $.ajax({
    type: 'POST',
    url: '<?php echo base_url(); ?>index.php/inquiries/get_inquiry_sources_by_course',
    data: form.serialize(),
    cache: false,
    success: function(response) {
      $.each(response,function(key, val) {
        inquiry_sources.push(val.reference);
        count.push(val.count);
      });
      console.log(inquiry_sources);
      console.log(count);

      var ctx = document.getElementById('sourceChart').getContext('2d');

      myChart = new Chart(ctx, {
          type: 'doughnut',
          data: {
              labels: inquiry_sources,
              datasets: [{
                  label: '# of Inquiries',
                  data: count,
                  backgroundColor: [
                      '#CB4335',
                      '#76448A',
                      '#1A5276',
                      '#117864',
                      '#D4AC0D',
                      '#AF601A',
                      '#7B7D7D',
                      '#283747',
                      '#C0392B',
                      '#BB8FCE',
                      '#85C1E9',
                      '#76D7C4',
                      '#F4D03F',
                      '#DC7633',
                      '#6E2C00'
                  ],
              }]
          },

      });
      $.unblockUI();
    }
  });

});

</script>
