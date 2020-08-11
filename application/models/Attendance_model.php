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

  public function save_attendance_classroom($studentId,$date,$time,$allocateId) {
    $data = array(
      'studentId'=>$studentId,
      'date'=>$date,
      'time'=>$time,
      'allocateId'=>$allocateId
    );

    return $this->db->insert('classroom_attendance',$data);
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

  public function check_clss_attendance($studentId,$allocate_id) {
    $this->db->select('allocate.batchId,allocate.courseId');
    $this->db->from('allocate');
    $this->db->where('id',$allocate_id);
    $query = $this->db->get();
    $allocate = $query->result_array();
    $allocate_batch; 
    $allocate_courseId;
    foreach ($allocate as $allc){
      $allocate_batch= $allc['batchId'];
      $allocate_courseId = $allc['courseId'];
    }

    $this->db->select('course_enroll.batchId');
    $this->db->from('course_enroll');
    $this->db->where('studentId',$studentId);
    $this->db->where('courseId',$allocate_courseId);
    $query2 = $this->db->get();
    $course_e = $query2->result_array();
    $rows = $query2->num_rows();
    //check rows 
    if ($rows>=1){
      $course_enroll_batch=0;
      foreach ($course_e as $ce){
        $course_enroll_batch= $ce['batchId'];
      }
      //check batch ids
        if ($allocate_batch==$course_enroll_batch){
          return 1;
        } else{
          return 0;
        }
    } else {
      return 2;
    }
  }

  public function get_classroom_attendance_detail($studentId) {
    $this->db->select('classroom_attendance.*,student.full_name,allocate.batchId as batch,batch.name as batchname');
    $this->db->from('classroom_attendance');
    $this->db->join('student', 'classroom_attendance.studentId = student.studentId');
    $this->db->join('allocate', 'classroom_attendance.allocateId = allocate.id');
    $this->db->join('batch', 'allocate.batchId = batch.id');
    $this->db->where('classroom_attendance.studentId',$studentId);
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

  public function delete_clss_attendance(){
    $id= $this->input->post('studentId');
    $date= $this->input->post('date');
    $time = $this->input->post('time');
    $allocateId = $this->input->post('allocateId');
    
    $this->db-> where('studentId', $id);
    $this->db-> where('date', $date);
    $this->db-> where('time', $time);
    $this->db-> where('allocateId',$allocateId);
    
    return $this->db->delete('classroom_attendance');
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

  public function get_schedule_name($allocate_id){
    $this->db->select('course.name,allocate.batchId');
    $this->db->from('allocate');
    $this->db->join('course', 'course.id = allocate.courseId');
    $this->db->where('allocate.id',$allocate_id);
    
    $query = $this->db->get();
    $ret = $query->row();
    return $ret->name;
  }

  // public function get_stu_courses($studentId){
  //   $this->db->select('courseId');
  //   $this->db->where('studentId',$studentId);
  //   $query = $this->db->get('course_enroll');
  //   return $query->result_array();
  // }

  // public function select_allocate(){

  //   $date =date('Y-m-d');
  //   $newTime=  date("H:i:s", strtotime("-30 minutes"));
  //   $sql ="select * from allocate where startTime >=? AND date=?";
  //   $query = $this->db->query($sql, array($newTime,$date));
  //   return $query->result_array();
  // }

}
