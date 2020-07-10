<?php

class Lecturers extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('lecturer_model');
        $this->load->model('module_model');
        $this->load->model('user_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
    }

    public function index() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,36)) {
        $data['title'] = 'Lecturers';

        $data['lecturers'] = $this->lecturer_model->get_lecturers();
        $data['modules'] = $this->module_model->get_all_modules();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('lecturers/index', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function add() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,36)) {
        $response = $this->lecturer_model->add_lecturer();
        $data['title'] = 'Lecturers';
        $data['lecturers'] = $this->lecturer_model->get_lecturers();
        $data['modules'] = $this->module_model->get_all_modules();

        if($response) {
            $data['msg'] = 1;
        } else {
            $data['msg'] = 0;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('lecturers/index', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function delete_lecturer() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,36)) {
        $response = $this->lecturer_model->delete_lecturer();
     
        if($response) {
          $this->session->set_flashdata('info', 'Lecturer delete Successfully..!');
          redirect(base_url() . 'index.php/lecturers');
        } else {
          $this->session->set_flashdata('info', 'Lecturer delete Unsuccessfully..!');
          redirect(base_url() . 'index.php/lecturers');
        }
      
      } else {
        $this->session->set_flashdata('info', 'you cannot access to delete..!');
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function allocate() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,36)) {
        $response = $this->lecturer_model->allocate_lecturer();
        $data['title'] = 'Lecturers';
        $data['lecturers'] = $this->lecturer_model->get_lecturers();
        $data['modules'] = $this->module_model->get_all_modules();

        if($response) {
            $data['allocate'] = 1;
        } else {
            $data['allocate'] = 0;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('lecturers/index', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function remove_allocation() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,36)) {
        $module_list = $this->input->post('selectAllocated');
        $lecturerId = $this->input->post('allocateName');

        if($module_list != "" && $lecturerId!="") {
            foreach($module_list as $key=>$value) {
                $response = $this->lecturer_model->remove_allocation($lecturerId,$value);
            }
        } else {
            $data['delete']=0;
        }

        $data['title'] = 'Lecturers';
        $data['lecturers'] = $this->lecturer_model->get_lecturers();
        $data['modules'] = $this->module_model->get_all_modules();

        if($response) {
            $data['delete'] = 1;
        } else {
            $data['delete'] = 0;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('lecturers/index', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function allocated_modules() {
        $lecturerId = $this->input->get('lecturerId');

        if($lecturerId != "") {
            $data = $this->lecturer_model->get_allocated_modules($lecturerId);

            header('Content-Type: application/json');
            echo json_encode( $data );
        }
    }

    public function availability() {
        $startDate = $this->input->get('startDate');
        $endDate = $this->input->get('endDate');
        $startTime = $this->input->get('startTime');
        $endTime = $this->input->get('endTime');
        $scheduleDay = $this->input->get('scheduleDay');
        $moduleId = $this->input->get('moduleId');

        //$startTime = date('H:i:sa',strtotime($startTime));
        //$endTime = date('H:i:sa',strtotime($endTime));

        $data = $this->lecturer_model->availability($startDate,$endDate,$startTime,$endTime,$scheduleDay,$moduleId);

        header('Content-Type: application/json');
        echo json_encode( $data );
    }
}
