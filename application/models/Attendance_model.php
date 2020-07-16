<?php

class Attendance_model extends CI_Model {

  public function __construct() {
    $this->load->database();
  }

  public function save_attendance($studentId,$date,$time,$is_pending_payment,$remarks) {
    $data = array(
      'studentId'=>$studentId,
      'date'=>$date,
      'time'=>$time,
      'is_pending_payment'=>$is_pending_payment,
      'remarks'=>$remarks
    );

    return $this->db->insert('attendance',$data);
  }

  public function get_attendance_history($studentId) {
    $this->db->where('studentId',$studentId);
    $this->db->limit(14);
    $this->db->order_by('date desc,time desc');
    $query = $this->db->get('attendance');

    return $query->result_array();
  }

  public function get_attendance_detail($studentId) {
    $this->db->select('attendance.*,student.full_name');
    $this->db->from('attendance');
    $this->db->join('student', 'attendance.studentId = student.studentId');
    $this->db->where('attendance.studentId',$studentId);
    $this->db->order_by('date desc,time desc');
    $query = $this->db->get();
    
    return $query->result_array();
  }

  public function get_single_detail($studentId,$date,$time) {
    $this->db->select('attendance.*,student.full_name');
    $this->db->from('attendance');
    $this->db->join('student', 'attendance.studentId = student.studentId');
    $this->db->where('attendance.studentId',$studentId);
    $this->db->where('attendance.date',$date);
    $this->db->where('attendance.time',$time);
    $this->db->order_by('date desc,time desc');
    $query = $this->db->get();
    
    return $query->result_array();
  }

  public function delete_attendance(){
    $id= $this->input->post('studentId');
    $date= $this->input->post('date');
    $time = $this->input->post('time');
    $this->db-> where('studentId', $id);
    $this->db-> where('date', $date);
    $this->db-> where('time', $time);
    
    return $this->db->delete('attendance');
  }

  public function add_remark(){
    $id= $this->input->post('mr_studentID');
    $date= $this->input->post('mr_date');
    $time = $this->input->post('mr_time');
   
    $this->db-> where('studentId', $id);
    $this->db-> where('date', $date);
    $this->db-> where('time', $time);

    $data = array(
      'finance_remarks'=> $this->input->post('m_remarks')
    );
    return $this->db->update('attendance',$data);
  }

  public function change_status(){
    $id= $this->input->post('studentId');
    $date= $this->input->post('date');
    $time = $this->input->post('time');
   
    $this->db-> where('studentId', $id);
    $this->db-> where('date', $date);
    $this->db-> where('time', $time);

    $data = array(
      'visited_finance'=> $this->input->post('status')
    );
    return $this->db->update('attendance',$data);
  }

}
