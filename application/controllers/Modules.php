<?php

class Modules extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('module_model');
        $this->load->model('semester_model');
        $this->load->model('course_model');
        $this->load->model('user_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
    }

    public function index() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,2)) {
        $data['title'] = 'Module Details';

        $data['semesters'] = $this->semester_model->get_semesters();
        $data['courses'] = $this->course_model->get_courses();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('modules/index', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function show() {
        $courseId = $this->input->get('courseId');

        if($courseId != "") {
            $data = $this->module_model->get_modules($courseId);

            header('Content-Type: application/json');
            echo json_encode( $data );
        }
    }

    public function search() {
        $string = $this->input->get('searchString');
        $data = $this->module_model->search($string);

        header('Content-Type: application/json');
        echo json_encode( $data );
    }

    public function get_modules_by_course_semester() {
        $courseId = $this->input->get('courseId');
        $semesterId = $this->input->get('semesterId');

        if($courseId != "" && $semesterId != "") {
            $data = $this->module_model->get_modules_by_course_semester($courseId,$semesterId);
            header('Content-Type: application/json');
            echo json_encode( $data );
        }
    }

    public function add() {
        $username = $this->session->userdata('username');
        if($this->user_model->validate_permission($username,37)) {
            $response = $this->module_model->add_module();
                if($response) {
                    echo "1";
                    $this->session->set_flashdata('info', 'Course Module Added Successfully..!');
                } else {
                    echo "0";
                    $this->session->set_flashdata('info', 'Course Module Added Unsuccessfully..!');  
                }
        } else {
            redirect('/?msg=noperm', 'refresh');
        }  
    }

    public function delete() {
        $username = $this->session->userdata('username');
        if($this->user_model->validate_permission($username,37)) {

            $response = $this->module_model->delete_module();
            if($response) {
                $this->session->set_flashdata('info', 'Course Module Delete Successfully..!');
                redirect(base_url() . 'index.php/modules');
            } else {
                $this->session->set_flashdata('info', 'Course Module Delete Unsuccessfully..!');
                redirect(base_url() . 'index.php/modules');
            }
        } else {
            redirect('/?msg=noperm', 'refresh');
        }
    }
}
