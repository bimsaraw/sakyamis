<?php

class Batch_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function get_batches()
    {
        $this->db->select('batch.*,course.name AS courseName');
        $this->db->from('batch');
        $this->db->join('course', 'course.id=batch.courseId', 'inner');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_batch()
    {
        $this->load->helper('url');
        $data = array(
            'id'=>$this->input->post('batchId'),
            'name'=>$this->input->post('batchName'),
            'heads'=>$this->input->post('batchHeads'),
            'courseId'=>$this->input->post('batchCourseId'),
            'batch_color'=>$this->input->post('batch_color'),
            'status'=>1
        );
        return $this->db->insert('batch', $data);
    }

    public function get_batches_by_course($courseId)
    {
        $this->db->select('course.name As courseName, batch.*');
        $this->db->from('batch');
        $this->db->join('course', 'batch.courseId=course.id', 'inner');
        $this->db->where('courseId', $courseId);

        $query = $this->db->get();
        foreach ($query->result() as $data) {
            $response[] = $data;
        }

        return $response;
    }

    public function get_batches_by_course_active($courseId)
    {
        $this->db->select('course.name As courseName, batch.*');
        $this->db->from('batch');
        $this->db->join('course', 'batch.courseId=course.id', 'inner');
        $this->db->where('courseId', $courseId);
        $this->db->where('status', 1);

        $query = $this->db->get();
        foreach ($query->result() as $data) {
            $response[] = $data;
        }

        return $response;
    }

    public function get_batches_by_course_2($courseId)
    {
        $this->db->select('course.name As courseName, batch.*');
        $this->db->from('batch');
        $this->db->join('course', 'batch.courseId=course.id', 'inner');
        $this->db->where('courseId', $courseId);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function set_status($batchId,$status)
    {
      $data = array(
        'status' => $status
      );
      $this->db->where('id',$batchId);
      $response = $this->db->update('batch',$data);

      if($response) {
        $this->db->where('id',$batchId);
        return $this->db->get('batch')->row();
      }

    }

    public function get_batch_heads($batchId) {
      $this->db->where('id',$batchId);
      $query = $this->db->get('batch')->row();

      return $query->heads;
    }

    public function get_single_batch($id) {
      $this->db->where('id',$id);
      $query = $this->db->get('batch');
      return $query->row();
    }

    public function edit_batch() {
      $batchId = $this->input->post('batchId');
     
      $data = array(
        'name'=>$this->input->post('batchName'),
        'heads'=>$this->input->post('batchHeads'),
        'batch_color'=>$this->input->post('batch_color'),
        'batch_color'=>$this->input->post('batch_color'),
      );
      $this->db->where('id',$batchId);
      return $this->db->update('batch',$data);
    }

    public function delete_batch($batchid) {
    
      $this->db->where('id',$batchid);
      return $this->db->delete('batch');
    }
    

    public function get_batch_detail($batchid) {
      $this->db->select('*');
      $this->db->from('batch');
      $this->db->where('id',$batchid);

      $query = $this->db->get();
      foreach ($query->result() as $data) {
          $response[] = $data;
      }

      return $response;
    }
}
