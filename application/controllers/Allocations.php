<?php

class Allocations extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('allocation_model');
        $this->load->model('course_model');
        $this->load->model('semester_model');
        $this->load->model('classroom_model');
        $this->load->model('batch_model');
        $this->load->model('user_model');
        $this->load->model('branches_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
    }

    public function index() {
        $username = $this->session->userdata('username');

        if($this->user_model->validate_permission($username,1)) {
          $data['title'] = 'View Schedule';
          $today = date('Y-m-d');
          $data['batches'] = $this->batch_model->get_active_batches_by_Branch(0,$today);
          $data['dates'] = $this->allocation_model->get_dates(1);
          $data['classes'] = $this->classroom_model->get_classes();
          $data['branches'] = $this->branches_model->get_branch_byuser($username);
          $data['selectBranch'] = $this->branches_model->get_branch_name(0);
          $data['Alecturer'] =array();
          $this->user_model->save_user_log($username,'Viewed schedule');
          $data['allocations'] =array();
          $data['events'] = array();
          $this->load->view('templates/header', $data);
          $this->load->view('templates/sidebar', $data);
          $this->load->view('allocations/index', $data);
          $this->load->view('templates/footer');
        } else {
          redirect('/?msg=noperm', 'refresh');
        }
    }

    public function bulk() {
        $data['title'] = 'Bulk Timetable Actions';

        $data['allocations'] = $this->allocation_model->get_allocations();
        $data['classes'] = $this->classroom_model->get_classes();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('allocations/bulk', $data);
        $this->load->view('templates/footer');
    }

    public function add() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,2)) {
        $data['title'] = 'Schedule a Lecture';

        $data['courses'] = $this->course_model->get_courses();
        $data['semesters'] = $this->semester_model->get_semesters();
        $data['branches'] = $this->branches_model->get_branch_byuser($username);
        $data['classes'] = $this->classroom_model->get_classes();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('allocations/add', $data);
        $this->load->view('templates/footer');

        $this->user_model->save_user_log($username,'Open Add schedule screen');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function bulk_action() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,2)) {
        $data['title'] = 'Schedule a Lecture';

        $data['courses'] = $this->course_model->get_courses();
        $data['semesters'] = $this->semester_model->get_semesters();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('allocations/bulk', $data);
        $this->load->view('templates/footer');

        $this->user_model->save_user_log($username,'Open Bulk action schedule screen');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function save_lecture() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,2)) {
        $response = $this->allocation_model->save_allocation();
        $data['title'] = 'Schedule a Lecture';

        if($response) {
            $data['allocate'] = 1;
            $this->session->set_flashdata('info', 'Allocated successfully saved..!');
        } else {
            $data['allocate'] = 0;
            $this->session->set_flashdata('danger', 'Allocated unsuccessfully..!');
        }

        $data['courses'] = $this->course_model->get_courses();
        $data['semesters'] = $this->semester_model->get_semesters();

        $this->user_model->save_user_log($username,'Saved a lecture');
        redirect('/allocations/add', 'refresh');
        // $this->load->view('templates/header', $data);
        // $this->load->view('templates/sidebar', $data);
        // $this->load->view('allocations/add', $data);
        // $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function save_event() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,2)) {
        $response = $this->allocation_model->save_event();
        $data['title'] = 'Schedule a Lecture';

        if($response) {
            $data['allocate'] = 1;
        } else {
            $data['allocate'] = 0;
        }

        $data['courses'] = $this->course_model->get_courses();
        $data['semesters'] = $this->semester_model->get_semesters();

        $this->user_model->save_user_log($username,'Saved an event');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('allocations/add', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function batch_conflict() {
        $startDate = $this->input->get('startDate');
        $endDate = $this->input->get('endDate');
        $startTime = $this->input->get('startTime');
        $endTime = $this->input->get('endTime');
        $scheduleDay = $this->input->get('scheduleDay');
        $batchId = $this->input->get('batchId');
        $branchId = $this->input->get('branchId');

        //$startTime = date('H:i:sa',strtotime($startTime));
        //$endTime = date('H:i:sa',strtotime($endTime));

        $data = $this->allocation_model->batch_conflict($startDate,$endDate,$startTime,$endTime,$scheduleDay,$batchId,$branchId);

        echo $data;
    }

    public function get_allocations_date() {
      $username = $this->session->userdata('username');
      
      if($this->user_model->validate_permission($username,1)) {
        $date = $this->input->post('allocatedDates');
        $branch = $this->input->post('allocateBranch');
        //$today = date('Y-m-d');
        
        $data['branches'] = $this->branches_model->get_branch_byuser($username);
        $data['selectBranch'] = $this->branches_model->get_branch_name($branch);
        $data['allocations'] = $this->allocation_model->get_allocations_date(date('Y-m-d',strtotime($date)),$branch);
        $data['Alecturer'] =$this->allocation_model->get_allocation_lecture_by_dateBranch($date,$branch);
        if ($date){
          $data['selectedDate'] = $date;
          $data['selectedBranch'] =  $branch;
         
        }else {
          $data['selectedDate'] = "";
          $data['selectedBranch'] ="";
        }
      
        $data['events'] = $this->allocation_model->get_events_date(date('Y-m-d',strtotime($date)),$branch);

        $data['title'] = 'View Schedule';

        $data['dates'] = $this->allocation_model->get_dates($branch);
        $data['classes'] = $this->classroom_model->get_classes();
        $data['batches'] = $this->batch_model->get_active_batches_by_Branch($branch,$date);

        $this->user_model->save_user_log($username,'Viewed schedule for date'.$date);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('allocations/index', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function print_allocations_date() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,1)) {
        $date = $this->input->get('date');
        $branch = $this->input->get('branch');
        $data['selectedDate'] = $date;
        $data['selectBranch'] = $this->branches_model->get_branch_name($branch);
        $data['allocations'] = $this->allocation_model->get_allocations_date(date('Y-m-d',strtotime($date)),$branch);
        $data['Alecturer'] =$this->allocation_model->get_allocation_lecture_by_dateBranch($date,$branch);
      
        $data['title'] = 'PrintSchedule';

        $data['dates'] = $this->allocation_model->get_dates($branch);
        $data['classes'] = $this->classroom_model->get_classes();
        $data['batches'] = $this->batch_model->get_active_batches_by_Branch($branch,$date);

        $this->user_model->save_user_log($username,'Printed allocation for date'.$date);

        $this->load->view('templates/print_header', $data);
        $this->load->view('allocations/print', $data);
        $this->load->view('templates/print_footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function get_allocations_by_date($date) {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,2)) {
        $data['selectedDate'] = $date;

        $data['allocations'] = $this->allocation_model->get_allocations_date(date('Y-m-d',strtotime($date)));

        $data['title'] = 'View Schedule';

        $data['dates'] = $this->allocation_model->get_dates();
        $data['classes'] = $this->classroom_model->get_classes();
        $data['batches'] = $this->batch_model->get_batches();

        $this->user_model->save_user_log($username,'Viewed schedule for date'.$date);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('allocations/index', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function get_allocate_date_by_branch(){
      $branch= $this->input->post('branchId');
      $data = $this->allocation_model->get_dates($branch);
      header('Content-Type: application/json');
      echo json_encode($data);
    }

    public function get_allocation_by_id() {
        $id = $this->input->get('id');
        $data = $this->allocation_model->get_allocation_by_id($id);

        header('Content-Type: application/json');
        echo json_encode( $data );
    }

    public function search_lecture() {
        $data = $this->allocation_model->search_lecture();

        header('Content-Type: application/json');
        echo json_encode( $data );
    }

    public function get_event_by_id() {
        $id = $this->input->get('id');
        $data = $this->allocation_model->get_event_by_id($id);

        header('Content-Type: application/json');
        echo json_encode( $data );
    }

    public function delete_allocation() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,2)) {
        $id = $this->input->get('id');
        $date = $this->input->get('date');

        if($this->allocation_model->delete($id)) {
            $this->get_allocations_by_date($date);
        }

        $this->user_model->save_user_log($username,'Viewed schedule for date'.$date);
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function delete_event() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,2)) {
        $id = $this->input->get('id');
        $date = $this->input->get('date');

        if($this->allocation_model->delete_event($id)) {
            $this->get_allocations_by_date($date);
        }

        $this->user_model->save_user_log($username,'Deleted event for date'.$date);
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function delete_lectures() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,2)) {
        $response = $this->allocation_model->delete_lectures();

        if($response) {
            $this->session->set_flashdata('message', array('title' => 'Deleted Successfully!','message' => 'Your selection was successfully deleted.','class' => 'success'));
            redirect('allocations/bulk_action');
        } else {
            $this->session->set_flashdata('message', array('title' => 'Error!','message' => 'Selected allocations cannot be deleted.','class' => 'danger'));
            redirect('allocations/bulk_action');
        }

        $this->user_model->save_user_log($username,'Deleted bulk lectures');

      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }
}
