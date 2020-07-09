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
        $this->load->helper('url_helper');
        $this->load->helper('form');
    }

    public function index()
    {
        $username = $this->session->userdata('username');

        if ($this->user_model->validate_permission($username, 2)) {
            $data['title'] = 'Batch Details';

            $data['batches'] = $this->batch_model->get_batches();
            $data['courses'] = $this->course_model->get_courses();

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

        if ($this->user_model->validate_permission($username, 2)) {
            $response = $this->batch_model->add_batch();
            $data['title'] = 'Course Details';
            $data['batches'] = $this->batch_model->get_batches();
            $data['courses'] = $this->course_model->get_courses();

            if ($response) {
                $data['msg'] = 1;
            } else {
                $data['msg'] = 0;
            }

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('batches/index', $data);
            $this->load->view('templates/footer');
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
        $status = $this->input->post('status');
        $batchId = $this->input->post('batchId');

        $response = $this->batch_model->set_status($batchId,$status);

        if($response) {
          echo $response->status;
        }
    }
}
