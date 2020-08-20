<?php

class Branches_model extends CI_Model {

    public function __construct() {
        $this->load->database();

    }

    public function get_branch() {
        $this->db->order_by('id','asc');
        $query = $this->db->get('branch');
        return $query->result_array();
    }

    public function get_branch_name($branchId) {
      $this->db->where('id',$branchId);
      $this->db->order_by('id','asc');
      $query = $this->db->get('branch');
      return $query->result_array();
  }

    public function get_branch_byuser($username) {
      $this->db->select('branch.*');
      $this->db->from('user_branch');
      $this->db->join('branch','user_branch.branchId=branch.id','inner');
      $this->db->where('user_branch.username',$username);
      $query = $this->db->get();
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

      public function schedule_branches($branchId){
        $sql = "SELECT batchId from allocate  where branchId=? Group by batchId";
        $query = $this->db->query($sql,$branchId);
        return $query->result_array();
      }
}
