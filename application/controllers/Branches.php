<?php

class Branches extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('branches_model');
        $this->load->model('user_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
    }

    public function index() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,38)) {
        $data['title'] = 'Branch Details';

        $data['branches'] = $this->branches_model->get_branch();

        $this->user_model->save_user_log($username,'Viewed branches.');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('branches/index', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function edit_branch() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,38)) {
        $response = $this->branches_model->edit();
     
        if($response) {
            $data['msg'] = 1;
        } else {
            $data['msg'] = 0;
        }

        $this->user_model->save_user_log($username,'Branch edited.');

        $this->session->set_flashdata('info', 'Branch Edit Successfully..!');
        redirect(base_url() . 'index.php/branches');
      } else {
        $this->session->set_flashdata('danger', 'Branch Edit Unsuccessfully..!');
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function delete() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,38)) {
        $branchid = $this->input->get('branchid');
        $response = $this->branches_model->delete_branch($branchid);

        $this->user_model->save_user_log($username,'Branch deleted '.$branchid);
       
        if($response) {
          $this->session->set_flashdata('info', 'Branch Delete Successfully..!');
          redirect(base_url() . 'index.php/branches');
         
        } else {
          $this->session->set_flashdata('info', 'Branch Delete Unsuccessfully..!');
            redirect(base_url() . 'index.php/branches');
        }

      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function add()
    {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,38)) {
        $response = $this->branches_model->add();
        $data['title'] = 'Branch Details';
        $data['branch'] = $this->branches_model->get_branch();

        $this->user_model->save_user_log($username,'Branch added.');

        if($response) {
          $this->session->set_flashdata('info', 'Branch Insert Successfully..!');
          $data['msg'] = 1;
          redirect(base_url() . 'index.php/branches');
        } else {
          $this->session->set_flashdata('info', 'Branch Insert Unsuccessfully..!');
          $data['msg'] = 0;
          redirect(base_url() . 'index.php/branches');
        }
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function get_branch() {
      if($data = $this->branches_model->get_branch()) {
        header('Content-Type: application/json');
        echo json_encode( $data );
      }
    }

    public function get_branch_detail() {
      $branchid= $this->input->get('branchid');
      $data = $this->branches_model->get_branch_detail($branchid);

      header('Content-Type: application/json');
      echo json_encode($data);
  }

  public function get_branch_user(){
    $username = $this->session->userdata('username');
    $data = $this->branches_model->get_branch_byuser($username);
    echo json_encode($data);
  }
}
