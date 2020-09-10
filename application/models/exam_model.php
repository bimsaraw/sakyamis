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

        $this->db->select('module.*');
        $this->db->from('module');
        $this->db->join('batch','batch.courseId=module.courseId');
        $this->db->where('module.*');
        $this->load->helper('url');
        $data = array('name'=>$this->input->post('student_marks'));
        return $this->db->insert('student_marks', $data);
    }

    public function insert_exam(){
        $this->load->helper('url');
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
                'weight'=> $this->input->post('weight')
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

          public function insert_exam_marks($data){
            $this->load->helper('url');
            return $this->db->insert('exam_marks', $data);
          }
        
}