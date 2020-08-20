<?php

class Reports extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('payment_model');
        $this->load->model('user_model');
        $this->load->model('batch_model');
        $this->load->model('inquiry_model');
        $this->load->model('course_model');
        $this->load->model('module_model');
        $this->load->model('branches_model');
        $this->load->model('report_model');
        $this->load->model('allocation_model');
        $this->load->helper('url_helper');
        $this->load->helper('url');
        $this->load->helper('form');
    }

    public function index()
    {
        $username = $this->session->userdata('username');

        if ($this->user_model->validate_permission($username, 29)) {
            $data['title'] = 'Reports';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('reports/index', $data);
            $this->load->view('templates/footer');

            $this->user_model->save_user_log($username, 'Opened Reports');
        } else {
            redirect('/?msg=noperm', 'refresh');
        }
    }

    public function create_report()
    {
        $username = $this->session->userdata('username');

        if ($this->user_model->validate_permission($username, 30)) {
            $data['title'] = 'Create Report';

            $data['tables'] = $this->report_model->get_tables();

            if ($_POST) {
                $reportName = $this->input->post('reportName');
                $query = $this->input->post('query');
                $reportType = $this->input->post('reportType');
                $fromTable = $this->input->post('fromTable');
                $groupTable = $this->input->post('groupTable');
                $groupColumn = $this->input->post('groupColumn');
                $orderTable = $this->input->post('orderTable');
                $orderColumn = $this->input->post('orderColumn');
                $orderType = $this->input->post('orderType');

                if ($reportId = $this->report_model->create_report($reportName, $query, $reportType, $fromTable, $groupTable, $groupColumn, $orderTable, $orderColumn, $orderType)) {
                    $this->report_model->create_report_columns($reportId);
                    $this->report_model->create_report_selects($reportId);
                    $this->report_model->create_report_joins($reportId);

                    $data['msg'] = "Report created successfully.";
                    $data['alert'] = "success";

                    $this->user_model->save_user_log($username, 'Report created '.$reportId);
                } else {
                    $data['msg'] = "Report could not be created.";
                    $data['alert'] = "danger";
                }
            }

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('reports/create_report', $data);
            $this->load->view('templates/footer');

            $this->user_model->save_user_log($username, 'Create report');
        } else {
            redirect('/?msg=noperm', 'refresh');
        }
    }

    public function view_report()
    {
        $username = $this->session->userdata('username');

        if ($this->user_model->validate_permission($username, 29)) {
            $reportId = $this->uri->segment(3);

            $report = $this->report_model->get_report($reportId);
            $data['title'] = 'View Report';
            $data['report'] = $report;
            $data['vari_columns'] = $this->report_model->get_variable_fields($reportId);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('reports/view_report', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('/?msg=noperm', 'refresh');
        }
    }

    public function payment_plans_report()
    {
        {
          $username = $this->session->userdata('username');

          if ($this->user_model->validate_permission($username, 31)) {
              $data['title'] = 'Payment Plan wise Students Report';

              $data['intakes'] = $this->inquiry_model->get_intakes();
              $data['courses'] = $this->course_model->get_courses();

              if ($_POST) {
                $data['students'] = $this->report_model->payment_plan_wise_students($_POST);

                $data['single_pplan'] = $this->payment_model->get_single_pplan($_POST['pplanId']);
                $data['single_course'] = $this->course_model->get_single_course($_POST['courseId']);
                $data['single_intake'] = $this->inquiry_model->get_single_intake($_POST['intakeId']);
              }

              $this->load->view('templates/header', $data);
              $this->load->view('templates/sidebar', $data);
              $this->load->view('reports/payment_plans_report', $data);
              $this->load->view('templates/footer');

              $this->user_model->save_user_log($username, 'Viewed payment plan wise student report');
          } else {
              redirect('/?msg=noperm', 'refresh');
          }
      }
    }


    public function outstanding_report()
    {
        {
          $username = $this->session->userdata('username');

          if ($this->user_model->validate_permission($username, 32)) {
              $data['title'] = 'Outstanding Report';

              $data['intakes'] = $this->inquiry_model->get_intakes();
              $data['batches'] = $this->batch_model->get_batches();
              $data['courses'] = $this->course_model->get_courses();

              if ($_POST) {
                $data['students'] = $this->report_model->outstanding_report($_POST);

                $data['single_batch'] = $this->batch_model->get_single_batch($_POST['batchId']);
                $data['single_course'] = $this->course_model->get_single_course($_POST['courseId']);
                $data['single_intake'] = $this->inquiry_model->get_single_intake($_POST['intakeId']);
              }

              $this->load->view('templates/header', $data);
              $this->load->view('templates/sidebar', $data);
              $this->load->view('reports/outstanding_report', $data);
              $this->load->view('templates/footer');

              $this->user_model->save_user_log($username, 'Viewed payment outstanding report');
          } else {
              redirect('/?msg=noperm', 'refresh');
          }
      }
    }

    public function final_report()
    {
        {
          $username = $this->session->userdata('username');

          if ($this->user_model->validate_permission($username, 32)) {
              $data['title'] = 'Outstanding Report';

              $data['intakes'] = $this->inquiry_model->get_intakes();
              $data['batches'] = $this->batch_model->get_batches();
              $data['courses'] = $this->course_model->get_courses();

              if ($_POST) {
                $data['students'] = $this->report_model->final_report($_POST);

                $data['single_batch'] = $this->batch_model->get_single_batch($_POST['batchId']);
                $data['single_course'] = $this->course_model->get_single_course($_POST['courseId']);
                $data['single_intake'] = $this->inquiry_model->get_single_intake($_POST['intakeId']);
              }

              $this->load->view('templates/header', $data);
              $this->load->view('templates/sidebar', $data);
              $this->load->view('reports/final_report', $data);
              $this->load->view('templates/footer');
          } else {
              redirect('/?msg=noperm', 'refresh');
          }
      }
    }

    public function payment_report()
    {
        {
          $username = $this->session->userdata('username');

          if ($this->user_model->validate_permission($username, 32)) {
              $data['title'] = 'Total Payments Report';

              $data['intakes'] = $this->inquiry_model->get_intakes();
              $data['batches'] = $this->batch_model->get_batches();
              $data['courses'] = $this->course_model->get_courses();

              if ($_POST) {
                $data['students'] = $this->report_model->payment_report($_POST);

                $data['single_batch'] = $this->batch_model->get_single_batch($_POST['batchId']);
                $data['single_course'] = $this->course_model->get_single_course($_POST['courseId']);
                $data['single_intake'] = $this->inquiry_model->get_single_intake($_POST['intakeId']);
              }

              $this->load->view('templates/header', $data);
              $this->load->view('templates/sidebar', $data);
              $this->load->view('reports/payment_report', $data);
              $this->load->view('templates/footer');

              $this->user_model->save_user_log($username, 'Viewed total payments report');
          } else {
              redirect('/?msg=noperm', 'refresh');
          }
        }
    }

    public function attendance_report()
    {
        {
          $username = $this->session->userdata('username');

          if ($this->user_model->validate_permission($username, 32)) {
              $data['title'] = 'Student Attendance Report';

              $data['batches'] = $this->batch_model->get_batches();
              $data['courses'] = $this->course_model->get_courses();

              if ($_POST) {
                $data['students'] = $this->report_model->attendance_report($_POST);

                $data['single_batch'] = $this->batch_model->get_single_batch($_POST['batchId']);
                $data['single_course'] = $this->course_model->get_single_course($_POST['courseId']);
              }

              $this->load->view('templates/header', $data);
              $this->load->view('templates/sidebar', $data);
              $this->load->view('reports/attendance_report', $data);
              $this->load->view('templates/footer');

              $this->user_model->save_user_log($username, 'Viewed attendance report');
          } else {
              redirect('/?msg=noperm', 'refresh');
          }
        }
    }

    public function table_structure()
    {
        $table_name = $this->input->post('table_name');
        header('Content-Type: application/json');
        echo json_encode($this->report_model->table_structure($table_name));
    }

    //attendance summary
    public function attendance_summary()
    {
        {
          $username = $this->session->userdata('username');

          if ($this->user_model->validate_permission($username, 31)) {
              $data['title'] = 'Attendance Summary Report';
              $data['intakes'] = $this->report_model->clsatt_summary();
              $data['batches'] = $this->batch_model->get_batches();
              $data['branches'] = $this->branches_model->get_branch_byuser($username);

              if ($_POST) {
                $data['students'] = $this->report_model->payment_plan_wise_students($_POST);

                $data['single_alocation'] = $this->allocation_model->get_allocation_by_id($_POST['schedule']);
                $data['single_course'] = $this->course_model->get_single_course($_POST['courseId']);
              }


              $this->load->view('templates/header', $data);
              $this->load->view('templates/sidebar', $data);
              $this->load->view('reports/clsattend_summary', $data);
              $this->load->view('templates/footer');

              $this->user_model->save_user_log($username, 'Viewed Attendance Summary report');
          } else {
              redirect('/?msg=noperm', 'refresh');
          }
      }
    }

    public function get_courses_by_schedule_dates(){
        $username = $this->session->userdata('username');

        if ($this->user_model->validate_permission($username, 31)) {

        $startDate = $this->input->get('startDate');
        $endDate = $this->input->get('endDate');
        $branch = $this->input->get('branchId');

        $data= $this->course_model->schedule_date_course($startDate,$endDate,$branch);
        
        header('Content-Type: application/json');
        echo json_encode($data);
        }
    }

    public function get_module_by_schedule_course(){
        $username = $this->session->userdata('username');

        if ($this->user_model->validate_permission($username, 31)) {

        $courseId = $this->input->get('courseId');
        $startdate = $this->input->get('startdate');
        $enddate = $this->input->get('enddate');
        $branch = $this->input->get('branchId');

        $data= $this->module_model->schedule_date_course($courseId,$branch,$startdate,$enddate);
        
        header('Content-Type: application/json');
        echo json_encode($data);
        }
    }
    public function get_batchs_by_branch(){
        $username = $this->session->userdata('username');

        if ($this->user_model->validate_permission($username, 31)) {

        $branchId = $this->input->get('branchId');

        $data= $this->branches_model->schedule_branches($branchId);
        
        header('Content-Type: application/json');
        echo json_encode($data);
        }
    }
//attendance symmary report
    public function generate_attsummary_table(){
        $username = $this->session->userdata('username');

        if ($this->user_model->validate_permission($username, 31)) {

        $data= $this->report_model->clsatt_summary();
        
        header('Content-Type: application/json');
        echo json_encode($data);
        }
    }
}
