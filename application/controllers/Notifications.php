<?php

class Messages extends CI_Controller {

  public function __construct() {
      parent::__construct();
      $this->load->library('session');
      $this->load->model('message_model');
      $this->load->model('user_model');
      $this->load->model('course_model');
      $this->load->helper('url_helper');
      $this->load->helper('url');
      $this->load->helper('form');
  }

  public function get_notifications($username) {
    $this->db->where('username',$username);
    $query = $this->db->get('notification');

    return $query->result_array();
  }

  public function add_notification() {
    $datetime = date('Y-m-d h:i:sa');
    
  }

}
