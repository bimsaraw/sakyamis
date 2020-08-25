<!-- Sidebar -->
<ul class="sidebar navbar-nav">
  <li class="nav-item active">
      <a class="nav-link" href="<?php echo base_url(); ?>index.php/">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
      </a>
  </li>
  <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-tasks"></i>
      <span>Student Attendance</span>
      </a>
      <div class="dropdown-menu" aria-labelledby="pagesDropdown">

          <h6 class="dropdown-header">Standard:</h6>
          <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/allocations">Mark Attendance - M</a>
          <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/attendance/automated">Mark Attendance - A</a>
          
          
          <div class="dropdown-divider"></div>

          <h6 class="dropdown-header">Advance Options:</h6>
          <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/attendance/entrance_report">Entrance Report</a>
          <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/attendance/classroom_report">Classroom Report</a>
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Reports:</h6>
          <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/reports/attendance_summary">Classroom Summary</a>
      </div>
  </li>
  <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-fw fa-table"></i>
      <span>Academic Administration</span>
      </a>
      <div class="dropdown-menu" aria-labelledby="pagesDropdown">

          <h6 class="dropdown-header">Standard:</h6>
          <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/allocations">View Schedules</a>
          <div class="dropdown-divider"></div>

          <h6 class="dropdown-header">Advance Options:</h6>
          <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/classrooms">Classrooms</a>
          <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/batches">Batches</a>
          <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/courses">Courses</a>
          <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/modules">Modules</a>
          <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/lecturers">Lecturers</a>
          <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/branches">Branches</a>  

      </div>
  </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user-plus"></i>
        <span>Sales Department</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">

            <h6 class="dropdown-header">Standard:</h6>
            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/inquiries/">Inquiries</a>
            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/inquiries/add_inquiry">Add Inquiry - Roster Basis</a>
            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/inquiries/add_inquiry_individual">Add Inquiry</a>
            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/inquiries/view_all">View All Inquiries</a>
            <div class="dropdown-divider"></div>

            <h6 class="dropdown-header">Advance Options:</h6>
            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/inquiries/intakes">Manage Targets</a>
            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/messages">Message Templates</a>
            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/inquiries/">View All Inquiries</a>
            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/inquiries/">Reports</a>
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user-graduate"></i>
        <span>Enrollments</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/enrollments">Enrolled Students</a>
            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/enrollments/student_id">Print Student ID</a>
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-money-check-alt"></i>
        <span>Finance Department</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">

            <h6 class="dropdown-header">Standard:</h6>
            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/payments/">Student Payments</a>
            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/payments/cashier_reports">Cashier Reports</a>
            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Advance Options:</h6>
            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/payments/payment_plans">Payment Plans</a>
            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/payments/payment_plan_approval">Payment Plans Approval</a>
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-file-alt"></i>
        <span>Reports</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">

            <h6 class="dropdown-header">Standard:</h6>
            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/reports/payment_plans_report">Payment Plan wise Students</a>
            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/reports/payment_report">Total Payments Report</a>
            <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/reports/outstanding_report">Payment Outstanding Report</a>
            <div class="dropdown-divider"></div>

            <h6 class="dropdown-header">Advance Options:</h6>
            <a class="dropdown-item" href="<?php echo base_url(); ?>">Create Custom Reports</a>
        </div>
    </li>
</ul>

<div id="content-wrapper">
