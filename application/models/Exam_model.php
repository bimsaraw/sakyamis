<?php

class Exam_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_exams() {
        $this->db->select('exam.*,branch.name as branchName,module.name as moduleName');
        $this->db->from('exam');
        $this->db->join('branch','branch.id=exam.branchId');
        $this->db->join('module','module.id=exam.moduleId');
        $this->db->where('status',1);
        $this->db->order_by('date','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_exams_by_branch($branchId) { // use this functions for the Student Examination Enroll Form
      $this->db->select('exam.*,branch.name as branchName,module.name as moduleName');
      $this->db->from('exam');
      $this->db->join('branch','branch.id=exam.branchId');
      $this->db->join('module','module.id=exam.moduleId');
      $this->db->where('status',1);
      $this->db->where('branchId',$branchId);
      $this->db->where('request_form',1);
      $this->db->order_by('date','DESC');
      $query = $this->db->get();
      return $query->result_array();
  }

  public function get_single_exam_row($examId) {
    $this->db->where('exam.id',$examId);
    $query = $this->db->get('exam');
    return $query->row();
  }

    public function get_single_exam($examId) {
      $this->db->select('exam.*,branch.name as branchName,module.name as moduleName,course.name as courseName');
      $this->db->from('exam');
      $this->db->join('branch','branch.id=exam.branchId');
      $this->db->join('module','module.id=exam.moduleId');
      $this->db->join('batch','batch.id=exam.batchId');
      $this->db->join('course','course.id=batch.courseId');
      $this->db->where('exam.id',$examId);
      $query = $this->db->get();
      return $query->result_array();
  }

  public function get_find_exam() {
    $this->db->select('*');
    $this->db->from('exam');
    $this->db->where('branchId',$this->input->post('branchId'));
    $this->db->where('batchId',$this->input->post('batchId'));
    $this->db->where('moduleId',$this->input->post('moduleId'));
    $query = $this->db->get();
    return $query->result_array();
}

    public function get_exams_by_studentId($studentId) {
      $this->db->select('exam.*,branch.name as branchName,module.name as moduleName, student.full_name as studentName,course.name as courseName,exam_marks.mark,marks_gradescal.grade');
      $this->db->from('exam_marks');
      $this->db->join('exam','exam.id=exam_marks.examId');
      $this->db->join('student','student.studentId=exam_marks.studentId');
      $this->db->join('branch','branch.id=exam.branchId');
      $this->db->join('batch','batch.id=exam.batchId');
      $this->db->join('course','course.id=batch.courseId');
      $this->db->join('module','module.id=exam.moduleId');
      $this->db->join('marks_gradescal','(marks_gradescal.id=exam.grade_scal) AND (exam_marks.mark BETWEEN marks_gradescal.value1 AND marks_gradescal.value2)','inner');
      $this->db->where('exam_marks.studentId',$studentId);
      $this->db->where('batch.status',1);
      $this->db->order_by('date','DESC');
      $query = $this->db->get();
      return $query->result_array();
  }

  public function get_examsresult_by_examId($examId) {
    $this->db->select('exam_marks.*,marks_gradescal.grade');
    $this->db->from('exam_marks');
    $this->db->join('exam','exam.id=exam_marks.examId');
    $this->db->join('marks_gradescal','(marks_gradescal.id=exam.grade_scal) AND (exam_marks.mark BETWEEN marks_gradescal.value1 AND marks_gradescal.value2)','inner');
    $this->db->where('examId',$examId);
    $this->db->order_by('studentId','ASC');
    $query = $this->db->get();
    return $query->result_array();
}

  public function get_grade_scal(){
    $this->db->select('id');
    $this->db->group_by('id');
    $query =$this->db->get('marks_gradescal');
    return $query->result_array();
  }

    public function get_modules_byBatch($batchId) {

        $this->db->select('module.name as moduleName,module.id as moduleId');
        $this->db->from('exam');
        $this->db->join('module','module.id=exam.moduleId');
        $this->db->where('exam.batchId',$batchId);
        $this->db->group_by('moduleId');
        $this->db->order_by('moduleId','ASC');
        $query =$this->db->get();
        return $query->result_array(); 
    }

    public function get_singleStudent_exam_result($studentId,$moduleId){ //by studentId and module Id
      $this->db->select('mark,marks_gradescal.grade');
      $this->db->from('exam_marks');
      $this->db->join('exam','exam_marks.examId=exam.id');
      $this->db->join('module','module.id=exam.moduleId');
      $this->db->join('marks_gradescal','(marks_gradescal.id=exam.grade_scal) AND (exam_marks.mark BETWEEN marks_gradescal.value1 AND marks_gradescal.value2)','inner');
      $this->db->where('module.id',$moduleId);
      $this->db->where('exam_marks.studentId',$studentId);
      $this->db->where('mark >','39');
      $this->db->order_by('examId','DESC');
      $this->db->group_by('moduleId');
      $query =$this->db->get();
      return $query->result_array(); 
    }

    public function insert_exam(){
        $this->load->helper('url');
         if ($this->input->post('serf')==true){
          $serf=1;
         } else {
          $serf=0;
         }  
        
        $data = array(
                'branchId'=>$this->input->post('branchId'),
                'batchId'=>$this->input->post('batchId'),
                'moduleId'=>$this->input->post('moduleId'),
                'date'=>$this->input->post('date'),
                'purpose'=>$this->input->post('purpose'),
                'name'=>$this->input->post('name'),
                'start_time'=>$this->input->post('startTime'),
                'end_time'=>$this->input->post('endTime'),
                'status'=> 1,
                'grade_scal'=> $this->input->post('gradeScal'),
                'weight'=> $this->input->post('weight'),
                'request_form'=> $serf
                
            );
            return $this->db->insert('exam', $data);
        }

    public function clone_exam($data){
        $this->load->helper('url');
        return $this->db->insert('exam', $data);
    }

        public function check_conflit(){
            $branchId= $this->input->post('branchId');
            $batchId=$this->input->post('batchId');
            $moduleId=$this->input->post('moduleId');
            $purpose=$this->input->post('purpose');

                $this->db->select('*');
                $this->db->from('exam');
                $this->db->where('branchId',$branchId);
                $this->db->where('batchId',$batchId);
                $this->db->where('moduleId',$moduleId);
                $this->db->where('purpose',$purpose);
                $query = $this->db->get();
                return $query->num_rows();
        }

        public function delete_exam ($examId){
            $this->db->where('id',$examId);
            return $this->db->delete('exam');
        }

        public function set_status($examId,$status)
        {
          $data = array(
            'status' => $status
          );
          $this->db->where('id',$examId);
          $response = $this->db->update('exam',$data);
    
          if($response) {
            $this->db->where('id',$examId);
            return $this->db->get('exam')->row();
          }
    
        }

        public function get_batchEnroll_studentIds($batchId,$examId) {
             $this->db->select('studentId');
             $this->db->from('exam_marks');
             $this->db->where('examId',$examId);
             $query1 = $this->db->get();
             $data = $query1->result_array();

             $studentIds = array('');

             foreach($data as $row){
                array_push($studentIds,$row['studentId']);
              }

            $this->db->select('studentId');
            $this->db->from('course_enroll');
            $this->db->where('batchId',$batchId);
            $this->db->where_not_in('studentId',$studentIds);
            $this->db->order_by('studentId','asc');
            $query = $this->db->get();
            return $query->result_array();
          }
//get exam applied students
          public function get_examApply_studentIds ($examId){
            $this->db->select('studentId');
            $this->db->from('exam_marks');
            $this->db->where('examId',$examId);
            $query1 = $this->db->get();
            $data = $query1->result_array();

            $studentIds = array('');

            foreach($data as $row){
               array_push($studentIds,$row['studentId']);
             }
            

            $this->db->where('examId',$examId);
            $this->db->where_not_in('studentId',$studentIds);
            $this->db->order_by('studentId','asc');
            $query = $this->db->get('exam_student_enroll');
            return $query->result_array();
          }

          public function insert_exam_marks($data){
            $this->load->helper('url');
            return $this->db->insert('exam_marks', $data);
          }

          public function get_EFnon_applied_students($students,$batchId){
            $this->db->select('course_enroll.studentId,student.full_name');
            $this->db->from('course_enroll');
            $this->db->join('student','student.studentId=course_enroll.studentId');
            $this->db->where('course_enroll.batchId',$batchId);
            $this->db->where_not_in('course_enroll.studentId',$students);
            $query = $this->db->get();
            return $query->result_array();
          }
          
          public function get_EFapplied_students($examId){
            $this->db->select('exam_student_enroll.studentId,exam_student_enroll.datetime,student.full_name');
            $this->db->from('exam_student_enroll');
            $this->db->join('student','student.studentId=exam_student_enroll.studentId');
            $this->db->where('examId',$examId);
            $this->db->order_by('exam_student_enroll.datetime','DESC');
            $query = $this->db->get();
            return $query->result_array();
          }

          public function add_EF_student(){
            $this->load->helper('url');
           
            $data = array(
              'examId'=>$this->input->post('examId'),
              'studentId'=>$this->input->post('studentId'),
              'datetime'=>date('Y-m-d h:i:s')
            );
          return $this->db->insert('exam_student_enroll', $data);
          }

          public function delete_EF_student(){
            $this->db->where('examId',$this->input->post('examId'));
            $this->db->where('studentId',$this->input->post('studentId'));
            return $this->db->delete('exam_student_enroll');
          }
        
}