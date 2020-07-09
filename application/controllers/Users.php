<?php

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url_helper');
        $this->load->model('user_model');
        $this->load->library('session');
        $this->load->helper('form');
    }

    public function index() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,3)) {
        $data['title'] = 'Users';

        $data['users'] = $this->user_model->get_users();
        $data['permissions'] = $this->user_model->get_permissions();
        $data['departments'] = $this->user_model->get_departments();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('users/index', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function login() {
        $data['title'] = 'Login';
        $this->load->view('users/login', $data);
    }

    public function add() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,3)) {
        $data['title'] = 'Users';

        $response = $this->user_model->add();

        if($response) {
            $data['msg'] = 1;
        } else {
            $data['msg'] = 0;
        }

        $data['users'] = $this->user_model->get_users();
        $data['permissions'] = $this->user_model->get_permissions();
        $data['departments'] = $this->user_model->get_departments();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('users/index', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function change_pwd_user() {
      $username = $this->session->userdata('username');
      $password = $this->security->xss_clean($this->input->post('password'));

      if($this->user_model->change_pwd($username,$password)) {
        echo 1;
      } else {
        echo 0;
      }

    }

    public function change_pwd_user_admin() {
      $username = $this->input->post('username');
      $password = $this->security->xss_clean($this->input->post('password'));

      if($this->user_model->change_pwd($username,$password)) {
        echo 1;
      } else {
        echo 0;
      }

    }

    public function remove() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,3)) {
        $data['title'] = 'Users';

        $username = $this->input->get('username');

        $response = $this->user_model->remove_user($username);

        if($response) {
            $data['msg'] = 1;
        } else {
            $data['msg'] = 0;
        }

        $data['users'] = $this->user_model->get_users();
        $data['permissions'] = $this->user_model->get_permissions();
        $data['departments'] = $this->user_model->get_departments();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('users/index', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function process() {
        $result = $this->user_model->validate();
        if(! $result){
            // If user did not validate, then show them login page again
            $data['msg'] = '<div class="alert alert-danger">Invalid Username or Password</div>';
            $data['title'] = 'Login';
            $this->load->view('users/login', $data);
        }else{
            // If user did validate,
            // Send them to members area

            redirect('/', 'refresh');
        }
    }

    public function validate_pwd() {
      $username = $this->session->userdata('username');
      $password = $this->security->xss_clean($this->input->post('password'));

      if($this->user_model->validate_pwd($username,$password)) {
        echo 1;
      } else {
        echo 0;
      }
    }

    public function get_permissions_in() {
        $username= $this->input->get('username');
        $data = $this->user_model->get_permissions_in($username);

        header('Content-Type: application/json');
        echo json_encode( $data );
    }

    public function get_permissions_not_in() {
        $username= $this->input->get('username');
        $data = $this->user_model->get_permissions_not_in($username);

        header('Content-Type: application/json');
        echo json_encode( $data );
    }

    public function modify_permissions() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,3)) {
        $data['title'] = 'Users';

        $response = $this->user_model->modify_permissions();

        if($response) {
            $data['msg'] = 1;
        } else {
            $data['msg'] = 0;
        }

        $data['users'] = $this->user_model->get_users();
        $data['permissions'] = $this->user_model->get_permissions();
        $data['departments'] = $this->user_model->get_departments();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('users/index', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function logout() {
        $this->session->unset_userdata('username');
    		$data['title'] = "Timetable Management";

    		$this->load->view('templates/header',$data);
    		$this->load->view('templates/sidebar');
    		$this->load->view('home');
    		$this->load->view('templates/footer');
    }
}
