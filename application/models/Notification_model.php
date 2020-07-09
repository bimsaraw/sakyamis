<?php

class Message_model extends CI_Model {

  public function __construct() {
    $this->load->database();
    $this->load->helper('url_helper');
    $this->load->helper('url');
  }
}
