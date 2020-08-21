<?php

class Classroom_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_classes() {
        $this->db->select('classroom.*,branch.name as branch');
        $this->db->from ('classroom');
         $this->db->join('branch', 'classroom.branchId=branch.id', 'inner');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add() {
        $this->load->helper('url');
        $data = array(

            'name'=>$this->input->post('className'),
            'type'=>$this->input->post('classType'),
            'capacity'=>$this->input->post('capacity'),
            'branchId'=>$this->input->post('branchId')
        );
        return $this->db->insert('classroom', $data);
    }

    public function classroom_by_branch($branchId){
        $this->db->select('*');
        $this->db->from ('classroom');
        $this->db->Where('branchId',$branchId);
        $query = $this->db->get();
        return $query->result_array();

    }

    public function availability_allocate($startDate,$startTime,$endTime,$scheduleDay,$heads,$branchId,$selectedclsRId) {

        $this->db->select('course.name as course,batch.name as batch,module.name as module');
        $this->db->from('allocate');
        $this->db->join('batch', 'batch.id=allocate.batchId', 'inner');
        $this->db->join('course', 'course.id=allocate.courseId', 'inner');
        $this->db->join('module', 'module.id=allocate.moduleId', 'inner');
        $this->db->where('branchId',$branchId); 
        $this->db->where('date',$startDate); 
        $where = '((startTime  BETWEEN "'.$startTime.'" AND "'.$endTime.'") OR (endTime BETWEEN"'.$startTime.'" AND "'.$endTime.'"))';
        $this->db->where($where); 
        $this->db->where('classroomId',$selectedclsRId);  

        if($heads) {
        $this->db->where('classroom.capacity >=',$heads); 
        }
        $query = $this->db->get();

        //$this->db->where('classroom.id NOT IN (SELECT classroomId FROM allocate WHERE branchId="'.$branchId.'" AND (date BETWEEN "'.$startDate.'" AND "'.$endDate.'") AND day="'.$scheduleDay.'" AND ((startTime BETWEEN "'.$startTime.'" AND "'.$endTime.'") OR (endTime BETWEEN "'.$startTime.'" AND "'.$endTime.'") OR ("'.$startTime.'" BETWEEN startTime AND endTime) OR ("'.$endTime.'" BETWEEN startTime AND endTime)))');
        //$this->db->where('classroom.id NOT IN (SELECT classroomId FROM event WHERE branchId="'.$branchId.'" AND (date BETWEEN "'.$startDate.'" AND "'.$endDate.'") AND day="'.$scheduleDay.'" AND ((startTime BETWEEN "'.$startTime.'" AND "'.$endTime.'") OR (endTime BETWEEN "'.$startTime.'" AND "'.$endTime.'") OR ("'.$startTime.'" BETWEEN startTime AND endTime) OR ("'.$endTime.'" BETWEEN startTime AND endTime)))');

        // foreach ($query->result() as $data) {
        //     $response[] = $data;
        // }

       return $query->result_array();
    }
   
}
