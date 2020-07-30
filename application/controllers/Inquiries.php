<?php

class Inquiries extends CI_Controller {

  public function __construct() {
      parent::__construct();
      $this->load->library('session');
      $this->load->model('inquiry_model');
      $this->load->model('enrollment_model');
      $this->load->model('batch_model');
      $this->load->model('user_model');
      $this->load->model('course_model');
      $this->load->helper('url_helper');
      $this->load->helper('url');
      $this->load->helper('form');
  }

  public function index() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,4)) {
      $data['title'] = 'Sales Management';

      if($this->user_model->validate_permission($username,5)) {
        $data['positive'] = $this->inquiry_model->get_inquiries_count('','is_positive');
        $data['pending'] = $this->inquiry_model->get_inquiries_count('','is_pending');
        $data['registered'] = $this->inquiry_model->get_inquiries_count('','is_registered');
        $data['failed'] = $this->inquiry_model->get_inquiries_count('','is_failed');

      }

      if($this->user_model->validate_permission($username,25)) {
        $data['positive'] = $this->inquiry_model->get_inquiries_count($username,'is_positive');
        $data['pending'] = $this->inquiry_model->get_inquiries_count($username,'is_pending');
        $data['registered'] = $this->inquiry_model->get_inquiries_count($username,'is_registered');
        $data['failed'] = $this->inquiry_model->get_inquiries_count($username,'is_failed');
      }

      $data['intakes'] = $this->inquiry_model->get_intakes();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('inquiry/index', $data);
      $this->load->view('templates/footer');

      $this->user_model->save_user_log($username,'View Dashboard');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function view_all() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,8)) {
      $data['title'] = 'All Inquiries';

      $data['inquiries'] = $this->inquiry_model->view_all();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('inquiry/view_all', $data);
      $this->load->view('templates/footer');

      $this->user_model->save_user_log($username,'View All Inquiries');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function self_register() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,13)) {
      $data['title'] = 'Search Inquiry for Enrollments';

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('inquiry/self_register', $data);
      $this->load->view('templates/footer');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function view() {
    $inq_type = $this->input->get('type');
    $username = $this->session->userdata('username');

    $data['title'] = $this->input->get('title');

    if($this->user_model->validate_permission($username,5) || $this->user_model->validate_permission($username,25)) {

      if($this->user_model->validate_permission($username,5)) {
        $data['positive'] = $this->inquiry_model->get_inquiries_count('','is_positive');
        $data['pending'] = $this->inquiry_model->get_inquiries_count('','is_pending');
        $data['registered'] = $this->inquiry_model->get_inquiries_count('','is_registered');
        $data['failed'] = $this->inquiry_model->get_inquiries_count('','is_failed');

        $data['inquiries'] = $this->inquiry_model->view_all_inquiries('',$inq_type);
      }

      if($this->user_model->validate_permission($username,25)) {
        $data['positive'] = $this->inquiry_model->get_inquiries_count($username,'is_positive');
        $data['pending'] = $this->inquiry_model->get_inquiries_count($username,'is_pending');
        $data['registered'] = $this->inquiry_model->get_inquiries_count($username,'is_registered');
        $data['failed'] = $this->inquiry_model->get_inquiries_count($username,'is_failed');

        $data['inquiries'] = $this->inquiry_model->view_all_inquiries($username,$inq_type);
      }

      $data['courses'] = $this->course_model->get_courses();
      $data['intakes'] = $this->inquiry_model->get_intakes();
      $data['batches'] = $this->batch_model->get_batches();
      $data['username'] = $username;
      $data['type'] = $inq_type;

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('inquiry/view_inquiries', $data);
      $this->load->view('templates/footer');

      $this->user_model->save_user_log($username,'View Inquiries');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function view_inquiries() {
    $courseId = $this->input->post('courseId');
    $username = $this->input->post('username');
    $followUps = $this->input->post('followUps');
    $range = $this->input->post('range');
    $name = $this->input->post('name');
    $type = $this->input->post('type');

    if($this->user_model->validate_permission($username,25)) {
      if($type!='is_registered') {
        $data = $this->inquiry_model->view_inquiries($courseId,$username,$type,$followUps,$range,$name);

        header('Content-Type: application/json');
        echo json_encode( $data );
      } else {
        $data = $this->enrollment_model->filter_students_by_user($username);

        header('Content-Type: application/json');
        echo json_encode( $data );
      }
    }

    if($this->user_model->validate_permission($username,5)) {
      if($type!='is_registered') {
        $data = $this->inquiry_model->view_inquiries($courseId,'',$type,$followUps,$range,$name);

        header('Content-Type: application/json');
        echo json_encode( $data );
      } else {
        $data = $this->enrollment_model->filter_students();

        header('Content-Type: application/json');
        echo json_encode( $data );
      }
    }
  }

  public function get_status_inquiry() {
    $inq_id = $this->input->post('inq_id');

    $data = $this->inquiry_model->get_status_inquiry($inq_id);

    header('Content-Type: application/json');
    echo json_encode( $data );
  }

  public function update_infobox() {
    if($this->user_model->validate_permission($username,9)) {
      $data = $this->inquiry_model->get_inquiries_count($courseId,$username,$type);

      header('Content-Type: application/json');
      echo json_encode( $data );
    }

    if($this->user_model->validate_permission($username,5)) {
      $data = $this->inquiry_model->get_inquiries_count($courseId,'',$type);

      header('Content-Type: application/json');
      echo json_encode( $data );
    }
  }

  public function save_status() {
    $username = $this->session->userdata('username');
    $response = $this->inquiry_model->save_status($username);

    if($response) {
        echo "1";
    } else {
        echo "0";
    }
  }

  public function intakes() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,4)) {
      $data['title'] = 'Intakes';

      $data['intakes'] = $this->inquiry_model->get_intakes();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('inquiry/intakes', $data);
      $this->load->view('templates/footer');

      $this->user_model->save_user_log($username,'View Intakes');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function add_intake() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,5)) {
      $response = $this->inquiry_model->add_intake();
      $data['title'] = 'Intakes';
      $data['intakes'] = $this->inquiry_model->get_intakes();

      if($response) {
          $data['msg'] = 1;
      } else {
          $data['msg'] = 0;
      }

      $intakeName = $this->input->post('intakeName');

      $this->user_model->save_user_log($username,'Added Intake: '.$intakeName);

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('inquiry/intakes', $data);
      $this->load->view('templates/footer');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function targets() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,5)) {

      $intakeId = $this->input->get('intakeId');
      $intakeName = $this->input->get('intakeName');

      $data['title'] = 'Targets of '.$intakeName;

      $data['intakeId'] = $intakeId;
      $data['users'] = $this->user_model->get_users_marketing();
      $data['courses'] = $this->course_model->get_courses();
      $data['targets'] = $this->inquiry_model->get_targets($intakeId);

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('inquiry/targets', $data);
      $this->load->view('templates/footer');

      $this->user_model->save_user_log($username,'View Targets');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function get_targets_by_username_course() {
    $username = $this->input->post('username');
    $courseId = $this->input->post('courseId');
    $intakeId = $this->input->post('intakeId');

    $response = $this->inquiry_model->get_targets_by_username_course($username,$courseId,$intakeId);

    header('Content-Type: application/json');
    echo json_encode( $response );
  }

  public function get_targets_by_intake_course() {
    $courseId = $this->input->post('courseId');
    $intakeId = $this->input->post('intakeId');

    $response = $this->inquiry_model->get_targets_by_intake_course($courseId,$intakeId);

    header('Content-Type: application/json');
    echo json_encode( $response );
  }

  public function update_target() {
    $response = $this->inquiry_model->update_target();

    $user = $this->input->post('username');
    $username = $this->session->userdata('username');
    $this->user_model->save_user_log($username,'Target updated for '.$user);

    if($response) {
        echo "1";
    } else {
        echo "0";
    }
  }

  public function add_inquiry() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,6)) {
      $data['title'] = 'Add Inquiry';

      $data['courses'] = $this->course_model->get_courses();
      $data['mediums'] = $this->inquiry_model->get_inquiry_medium();
      $data['references'] = $this->inquiry_model->get_inquiry_reference();
      $data['type'] = '2';

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('inquiry/add_inquiry', $data);
      $this->load->view('templates/footer');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function edit_inquiry() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,7)) {

      $inquiry_id = $this->input->get('inquiry_id');

      $data['title'] = 'Edit Inquiry';

      $data['courses'] = $this->course_model->get_courses();
      $data['mediums'] = $this->inquiry_model->get_inquiry_medium();
      $data['references'] = $this->inquiry_model->get_inquiry_reference();
      $data['users'] =  $this->user_model->get_users_marketing();
      $data['results'] = $this->inquiry_model->get_inquiry_by_id($inquiry_id);

      $data['type'] = '2';

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('inquiry/edit_inquiry', $data);
      $this->load->view('templates/footer');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function add_inquiry_individual() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,9)) {
      $data['title'] = 'Add Inquiry - Individual';

      $data['courses'] = $this->course_model->get_courses();
      $data['mediums'] = $this->inquiry_model->get_inquiry_medium();
      $data['references'] = $this->inquiry_model->get_inquiry_reference();
      $data['type'] = '1';

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('inquiry/add_inquiry', $data);
      $this->load->view('templates/footer');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function save_inquiry() {
    $courseId = $this->input->post('course');
    $username = $this->inquiry_model->get_next_rotation($courseId);

    $response = $this->inquiry_model->save_inquiry($username);

    if($response) {
      $rotation = $this->inquiry_model->save_rotation($username);
      $status = $this->inquiry_model->set_status($username,$response);
      if($rotation && $status) {
        echo $username;
      } else {
        echo 0;
      }
    } else {
      echo 0;
    }
  }

  public function save_inquiry_individual() {
    $username = $this->session->userdata('username');

    $response = $this->inquiry_model->save_inquiry($username);

    if($response) {
      $status = $this->inquiry_model->set_status($username,$response);
      if($status) {
        echo $username;
      } else {
        echo 0;
      }
    } else {
      echo 0;
    }
  }

  public function update_inquiry() {

    $response = $this->inquiry_model->update_inquiry();

    if($response) {
      echo 1;
    } else {
      echo 0;
    }
  }

  public function register() {
    $username = $this->session->userdata('username');

    $data['title'] = 'Register a Student';

    if($this->user_model->validate_permission($username,13)) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('inquiry/register', $data);
      $this->load->view('templates/footer');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function search_student(){
    if($data = $this->inquiry_model->search_student()) {
      header('Content-Type: application/json');
      echo json_encode( $data );
    }
  }

  public function get_inquiries_by_course() {

  }

  public function get_intake_dates(){
    if($data = $this->inquiry_model->get_intake_dates()) {
      header('Content-Type: application/json');
      echo json_encode( $data );
    }
  }

  public function get_target_by_course() {
    if($data = $this->inquiry_model->get_target_by_course()) {
      header('Content-Type: application/json');
      echo json_encode( $data );
    }
  }

  public function get_target_by_course_username() {
    if($data = $this->inquiry_model->get_target_by_course_username()) {
      header('Content-Type: application/json');
      echo json_encode( $data );
    }
  }

  public function count_inquiries_by_course() {
    if($data = $this->inquiry_model->count_inquiries_by_course()) {
      header('Content-Type: application/json');
      echo json_encode( $data );
    }
  }

  public function count_inquiries_by_course_username() {
    if($data = $this->inquiry_model->count_inquiries_by_course_username()) {
      header('Content-Type: application/json');
      echo json_encode( $data );
    }
  }

  public function get_inquiry_sources_by_course() {
    $courseId = $this->input->post('courseId');
    $startDate = $this->input->post('startDate');
    $endDate = $this->input->post('endDate');

    if($data = $this->inquiry_model->get_inquiry_sources_by_course($courseId,$startDate,$endDate)) {
      header('Content-Type: application/json');
      echo json_encode( $data );
    }
  }

  public function search_inquiries(){
    $mobile = $this->input->get('mobile');
    if($data = $this->inquiry_model->search_inquiries($mobile)) {
      header('Content-Type: application/json');
      echo json_encode( $data );
    }
  }
  public function edit_intake() {
    $username = $this->session->userdata('username');
    if($this->user_model->validate_permission($username,7)) {
      $response = $this->inquiry_model->edit_intake();
      if($response) {
        $data['msg'] = 1;
        $this->session->set_flashdata('info', 'Intake Edit Successfully..!');
        redirect(base_url() . 'index.php/inquiries/intakes');
      } else {
          $data['msg'] = 0;
          $this->session->set_flashdata('info', 'Intake Edit Unsuccessfully..!');
      }
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }
  public function set_intakestatus()
    {
      $username = $this->session->userdata('username');
      if($this->user_model->validate_permission($username,7)) {
        $status = $this->input->post('status');
        $intake_id = $this->input->post('intakeId');

        $response = $this->inquiry_model->set_intakestatus($intake_id,$status);

        if($response) {
          echo $response->status;
        }
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

  public function delete_intake() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,7)) {  
      $intakeid = $this->input->get('intakeid');
      $response = $this->inquiry_model->delete_intake($intakeid);
      if($response) {
        $this->session->set_flashdata('info', 'Intake Delete Successfully..!');
        redirect(base_url() . 'index.php/inquiries/intakes');
      } else {
        $this->session->set_flashdata('info', 'Intake Delete Unsuccessfully..!');
          redirect(base_url() . 'index.php/inquiries/intakes');
      }
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }
  public function get_intake_detail() {
    $intakeid= $this->input->get('intakeid');
    $data = $this->inquiry_model->get_intake_detail($intakeid);

    header('Content-Type: application/json');
    echo json_encode($data);
}
}
