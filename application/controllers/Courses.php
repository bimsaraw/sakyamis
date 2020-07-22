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

      if($this->user_model->validate_permission($username,35)) {
        $data['title'] = 'Course Details';

        $data['courses'] = $this->course_model->get_courses();

        $this->user_model->save_user_log($username,'Viewed courses.');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('courses/index', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function edit_course() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,35)) {
        $response = $this->course_model->edit_course();
     
        if($response) {
            $data['msg'] = 1;
        } else {
            $data['msg'] = 0;
        }

        $this->user_model->save_user_log($username,'Course edited.');

        $this->session->set_flashdata('info', 'Course Edit Successfully..!');
        redirect(base_url() . 'index.php/courses');
      } else {
        $this->session->set_flashdata('info', 'Course Edit Unsuccessfully..!');
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function delete_course() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,35)) {
        $courseid = $this->input->get('courseid');
        $response = $this->course_model->delete_course($courseid);

        $this->user_model->save_user_log($username,'Course deleted'.$courseid);
       
        if($response) {
          $this->session->set_flashdata('info', 'Course Delete Successfully..!');
          redirect(base_url() . 'index.php/courses');
         
        } else {
          $this->session->set_flashdata('info', 'Course Delete Unsuccessfully..!');
            redirect(base_url() . 'index.php/courses');
        }

      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function addCourse()
    {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,35)) {
        $response = $this->course_model->add();
        $data['title'] = 'Course Details';
        $data['courses'] = $this->course_model->get_courses();

        $this->user_model->save_user_log($username,'Course added.');

        if($response) {
          $this->session->set_flashdata('info', 'Course Insert Successfully..!');
        } else {
          $this->session->set_flashdata('info', 'Course Insert Unsuccessfully..!');
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

    public function get_course_detail() {
      $courseid= $this->input->get('courseid');
      $data = $this->course_model->get_course_detail($courseid);

      header('Content-Type: application/json');
      echo json_encode($data);
  }
}
