<?php

class Course_model extends CI_Model {

    public function __construct() {
        $this->load->database();

    }

    public function get_courses() {
        $this->db->order_by('name','asc');
        $query = $this->db->get('course');
        return $query->result_array();
    }

    public function get_single_course($id) {
      $this->db->where('id',$id);
      $query = $this->db->get('course');
      return $query->row();
    }

    public function add() {
        $this->load->helper('url');
        $data = array('name'=>$this->input->post('courseName'));
        return $this->db->insert('course', $data);
    }
}
