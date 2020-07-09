<?php

class Courses extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('course_model');
        $this->load->model('user_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
    }

    public function index() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,2)) {
        $data['title'] = 'Course Details';

        $data['courses'] = $this->course_model->get_courses();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('courses/index', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function addCourse()
    {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,2)) {
        $response = $this->course_model->add();
        $data['title'] = 'Course Details';
        $data['courses'] = $this->course_model->get_courses();

        if($response) {
            $data['msg'] = 1;
        } else {
            $data['msg'] = 0;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('courses/index', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function get_courses() {
      if($data = $this->course_model->get_courses()) {
        header('Content-Type: application/json');
        echo json_encode( $data );
      }
    }
}
