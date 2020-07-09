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
    $this->db->limit(8);
    $this->db->order_by('date desc,time desc');
    $query = $this->db->get('attendance');

    return $query->result_array();
  }
}
