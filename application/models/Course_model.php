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

    public function edit_course() {
        $courseid = $this->input->post('courseid');
        $coursename = $this->input->post('coursename');
        $data = array('name'=>$coursename);
        $this->db->where('id',$courseid);
        return $this->db->update('course',$data);
      }

      public function delete_course($courseid) {
        $this->db->where('id',$courseid);
        return $this->db->delete('course');
      }

      public function get_course_detail($courseid) {
        $this->db->select('*');
        $this->db->from('course');
        $this->db->where('id',$courseid);
  
        $query = $this->db->get();
        foreach ($query->result() as $data) {
            $response[] = $data;
        }
  
        return $response;
      }
}
