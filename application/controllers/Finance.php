<?php

class Finance extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('branches_model');
        $this->load->model('finance_model');
        $this->load->model('user_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
    }

    public function index() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,44)) {
        $data['title'] = 'Create Cash Bulk';

        //$data['exams'] = $this->exam_model->get_exams();
        $data['branches'] = $this->branches_model->get_branch_byuser($username);
        $this->user_model->save_user_log($username,'Viewed lecturers.');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('finance/cash_bulk', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function get_non_bulk_payments() {
        $branchId = $this->input->post('branchId');
        $username = $this->input->post('username');
    
        if($data = $this->finance_model->get_non_bulk_payments($branchId,$username)) {
          header('Content-Type: application/json');
          echo json_encode( $data );
        }
      }
      
}