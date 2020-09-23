<?php

class Batches extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('batch_model');
        $this->load->model('course_model');
        $this->load->model('user_model');
        $this->load->model('branches_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
    }

    public function index()
    {
        $username = $this->session->userdata('username');

        if ($this->user_model->validate_permission($username,34)) {
            $data['title'] = 'Batch Details';

            $data['batches'] = $this->batch_model->get_batches();
            $data['courses'] = $this->course_model->get_courses();
            $data['branch'] = $this->branches_model->get_branch();

            $this->user_model->save_user_log($username, 'Open Batches');

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('batches/index', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('/?msg=noperm', 'refresh');
        }
    }

    public function add()
    {
        $username = $this->session->userdata('username');

        if ($this->user_model->validate_permission($username,34)) {
            $response = $this->batch_model->add_batch();
            $data['title'] = 'Course Details';
            $data['batches'] = $this->batch_model->get_batches();
            $data['courses'] = $this->course_model->get_courses();

            if ($response) {
                $data['msg'] = 1;
            } else {
                $data['msg'] = 0;
            }

            $this->user_model->save_user_log($username,'Batch Added');

            redirect('Batches');
        } else {
            redirect('/?msg=noperm', 'refresh');
        }
    }

    public function edit_batch() {
        $username = $this->session->userdata('username');
  
        if($this->user_model->validate_permission($username,34)) {
          $response = $this->batch_model->edit_batch();
       
          if($response) {
              $data['msg'] = 1;
          } else {
              $data['msg'] = 0;
          }
          $this->user_model->save_user_log($username,'Batch edited.');

          $this->session->set_flashdata('info', 'Batch Edit Successfully..!');
          redirect(base_url() . 'index.php/Batches');
        } else {
          $this->session->set_flashdata('info', 'Batch Edit Unsuccessfully..!');
          redirect('/?msg=noperm', 'refresh');
        }
      }
  
      public function delete_batch() {
        $username = $this->session->userdata('username');
  
        if($this->user_model->validate_permission($username,34)) {
        
          $batchid = $this->input->get('batchid');
          $response = $this->batch_model->delete_batch($batchid);
          $this->user_model->save_user_log($username,'Batch deleted. '.$batchId);
          if($response) {
            $this->session->set_flashdata('info', 'Batch Delete Successfully..!');
            redirect(base_url() . 'index.php/Batches');
           
          } else {
            $this->session->set_flashdata('info', 'Batch Delete Unsuccessfully..!');
              redirect(base_url() . 'index.php/Batches');
          }
  
        } else {
          redirect('/?msg=noperm', 'refresh');
        }
      }

    public function get_batches_by_course()
    {
        $courseId = $this->input->get('courseId');

        if ($courseId != "") {
            $data = $this->batch_model->get_batches_by_course($courseId);

            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    public function get_batches_by_course_active()
    {
        $courseId = $this->input->get('courseId');

        if ($courseId != "") {
            $data = $this->batch_model->get_batches_by_course_active($courseId);

            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    public function set_status()
    {
      $username = $this->session->userdata('username');
      if($this->user_model->validate_permission($username,34)) {
        $status = $this->input->post('status');
        $batchId = $this->input->post('batchId');

        $response = $this->batch_model->set_status($batchId,$status);

        $this->user_model->save_user_log($username,'Set registration status of batch. '.$batchId.' to '.$status);

        if($response) {
          echo $response->status;
        }
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function get_batch_detail() {
      $batchid= $this->input->get('batchid');
      $data = $this->batch_model->get_batch_detail($batchid);

      header('Content-Type: application/json');
      echo json_encode($data);
  }

  public function get_batches_by_branch(){
   $branchId = $this->input->get('branchId');
    $data =$this->batch_model->get_batches_byBranch($branchId);
    header('Content-Type: application/json');
    echo json_encode($data);
  }
}
