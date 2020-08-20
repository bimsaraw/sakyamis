<?php

class Classrooms extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('classroom_model');
        $this->load->model('batch_model');
        $this->load->model('user_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
    }

    public function index() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,2)) {
        $data['title'] = 'Classroom Details';

        $data['classes'] = $this->classroom_model->get_classes();

        $this->user_model->save_user_log($username,'Viewed classrooms.');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('classrooms/index', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function add()
    {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,2)) {
        $data['title'] = 'Classroom Details';
        $response = $this->classroom_model->add();

        $data['classes'] = $this->classroom_model->get_classes();
        
        $this->user_model->save_user_log($username,'Classroom added.');

        if($response) {
            $data['msg'] = 1;
        } else {
            $data['msg'] = 0;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('classrooms/index', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    
    public function availability() {
        $heads =0;
        $startDate = $this->input->get('startDate');
        //$endDate = $this->input->get('endDate');
        $startTime = $this->input->get('startTime');
        $endTime = $this->input->get('endTime');
        $scheduleDay = $this->input->get('scheduleDay');
        $batchId = $this->input->get('batchId');
        $branchId = $this->input->get('branchId');
        $selectedclsRId = $this->input->get('classroomId');

        if($batchId!="") {
        $heads = $this->batch_model->get_batch_heads($batchId);
        }
        //$startTime = date('H:i:sa',strtotime($startTime));
        //$endTime = date('H:i:sa',strtotime($endTime));

        $data = $this->classroom_model->availability($startDate,$startTime,$endTime,$scheduleDay,$heads,$branchId,$selectedclsRId);

        header('Content-Type: application/json');
        echo json_encode( $data );
    }
}
