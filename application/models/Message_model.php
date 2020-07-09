<?php

class Message_model extends CI_Model {

  public function __construct() {
    $this->load->database();
    $this->load->helper('url_helper');
    $this->load->helper('url');
  }

  public function get_messages() {
    $this->db->select('course.name AS courseName, message.*');
    $this->db->join('course','course.id=message.courseId');
    $this->db->order_by('courseName','ASC');
    $query = $this->db->get('message');

    return $query->result_array();
  }

  public function get_messages_by_id($id) {
    $this->db->select('course.name AS courseName, message.*');
    $this->db->join('course','course.id=message.courseId');
    $this->db->where('message.id',$id);
    $query = $this->db->get('message');

    return $query->result_array();
  }

  public function save_template($attachment) {
    $data = array(
      'courseId' => $this->input->post('courseId'),
      'instance' => $this->input->post('instance'),
      'subject' => $this->input->post('subject'),
      'body' => $this->input->post('body'),
      'sms' => $this->input->post('sms'),
      'attachment' => $attachment
    );

    if($this->db->insert('message',$data)) {
        return true;
    } else {
      return false;
    }
  }

  public function update_template($attachment) {
    $data = array(
      'courseId' => $this->input->post('courseId'),
      'instance' => $this->input->post('instance'),
      'subject' => $this->input->post('subject'),
      'body' => $this->input->post('body'),
      'sms' => $this->input->post('sms'),
      'attachment' => $attachment
    );

    $this->db->where('id',$this->input->post('templateId'));

    if($this->db->update('message',$data)) {
        return true;
    } else {
      return false;
    }
  }

  public function delete_template($id) {
    $this->db->where('id',$id);
    return $this->db->delete('message');
  }

  public function get_message_by_course_instance($courseId,$instance) {
    $this->db->select('course.name AS courseName, message.*');
    $this->db->join('course','course.id=message.courseId');
    $this->db->where('message.courseId',$courseId);
    $this->db->where('message.instance',$instance);
    $query = $this->db->get('message');

    return $query->result_array();
  }

}

?>
