<?php

class Attendance extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->library('session');
    $this->load->model('payment_model');
    $this->load->model('enrollment_model');
    $this->load->model('batch_model');
    $this->load->model('user_model');
    $this->load->model('inquiry_model');
    $this->load->model('attendance_model');
    $this->load->model('course_model');
    $this->load->helper('url_helper');
    $this->load->helper('url');
    $this->load->helper('form');
  }

  public function index() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,24)) {
      $data['title'] = 'Student Attendance - Entrance';

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('attendance/index', $data);
      $this->load->view('templates/footer');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function full_screen() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,24)) {
      $data['title'] = 'Student Attendance - Entrance';

      $this->load->view('attendance/full_screen', $data);
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function mark_attendance_entrance() {
    $studentId = $this->input->post('studentId');
    $date = date('Y-m-d');
    $time = date('H:i:sa');

    if($response = $this->payment_model->validate_payments($studentId,$date)) {
      if($response == 1) {
        echo 'success';
        $this->attendance_model->save_attendance($studentId,$date,$time,0,'');
      } else {
        header('Content-Type: application/json');
        $this->attendance_model->save_attendance($studentId,$date,$time,1,'Pending Payments');
        echo json_encode( $response );
      }
    }
  }

  public function get_attendance_history() {
      $studentId = $this->input->post('studentId');
      $data = $this->attendance_model->get_attendance_history($studentId);

      header('Content-Type: application/json');
      echo json_encode( $data );
  }
}
