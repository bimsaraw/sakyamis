<?php

class Branches_model extends CI_Model {

    public function __construct() {
        $this->load->database();

    }

    public function get_branch() {
        $this->db->order_by('name','asc');
        $query = $this->db->get('branch');
        return $query->result_array();
    }

    public function get_single_branch($id) {
      $this->db->where('id',$id);
      $query = $this->db->get('branch');
      return $query->row();
    }

    public function add() {
        $this->load->helper('url');
        $data = array(
          'name'=>$this->input->post('branchname'),
          'location'=>$this->input->post('location'),
        );
        return $this->db->insert('branch', $data);
    }

    public function edit() {
        $branchid = $this->input->post('branchid');
        $branchname = $this->input->post('Branchname');
        $location = $this->input->post('location');
        $data = array(
          'name'=>$branchname,
          'Location'=>$location
        );
        $this->db->where('id',$branchid);
        return $this->db->update('branch',$data);
      }

      public function delete_branch($branchid) {
        $this->db->where('id',$branchid);
        return $this->db->delete('branch');
      }

      public function get_branch_detail($branchid) {
        $this->db->select('*');
        $this->db->from('branch');
        $this->db->where('id',$branchid);
  
        $query = $this->db->get();
        foreach ($query->result() as $data) {
            $response[] = $data;
        }
  
        return $response;
      }
}
