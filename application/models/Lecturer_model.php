<?php

class Lecturer_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_lecturers() {
        $query = $this->db->get('lecturer');
        return $query->result_array();
    }

    public function add_lecturer() {
        $this->load->helper('url');
        $data = array('name'=>$this->input->post('lecturerName'));
        return $this->db->insert('lecturer', $data);
    }

    public function allocate_lecturer() {
        $module_list = $this->input->post('selectAllocations');
        $lecturerId = $this->input->post('allocateName');

        $data = array();

        foreach($module_list as $key => $value) {
            $data[$key]['lecturerId'] = $lecturerId;
            $data[$key]['moduleId'] = $value;
        }

        return $this->db->insert_batch('lecturer_module', $data);
    }

    public function remove_allocation($lecturerId,$moduleId) {
        return $this->db->delete('lecturer_module', array('lecturerId' => $lecturerId,'moduleId' => $moduleId));
    }

    public function get_allocated_modules($lecturerId) {
        $this->db->select('lecturer_module.*,lecturer.name AS lecturerName,module.name AS moduleName');
        $this->db->from('lecturer_module');
        $this->db->join('lecturer','lecturer_module.lecturerId=lecturer.id','inner');
        $this->db->join('module','lecturer_module.moduleId=module.id','inner');
        $this->db->where('lecturerId',$lecturerId);

        $query = $this->db->get();
        foreach ($query->result() as $data) {
            $response[] = $data;
        }

        if(isset($response)) {
            return $response;
        } else {
            return [];
        }
    }

    public function moduleLecturer($moduleId) {
        $this->db->select('lecturer.*');
        $this->db->from('lecturer');
        $this->db->join('lecturer_module','lecturer.id=lecturer_module.lecturerId','inner');
        $this->db->where('moduleId',$moduleId);
        //$this->db->where('lecturer.id NOT IN (SELECT lecturerId FROM allocate WHERE (date BETWEEN "'.$startDate.'" AND "'.$endDate.'") AND day="'.$scheduleDay.'" AND ((startTime BETWEEN "'.$startTime.'" AND "'.$endTime.'") OR (endTime BETWEEN "'.$startTime.'" AND "'.$endTime.'") OR ("'.$startTime.'" BETWEEN startTime AND endTime) OR ("'.$endTime.'" BETWEEN startTime AND endTime)))');

        $query = $this->db->get();
        return $query->result_array();
        // foreach ($query->result() as $data) {
        //     $response[] = $data;
        // }

        // return $response;
    }

    public function availability($startDate,$endDate,$startTime,$endTime,$scheduleDay,$lecturerId,$branchId) {
        $this->db->select('course.name as course,batch.name as batch,module.name as module');
        $this->db->from('allocate');
        $this->db->join('batch', 'batch.id=allocate.batchId', 'inner');
        $this->db->join('course', 'course.id=allocate.courseId', 'inner');
        $this->db->join('module', 'module.id=allocate.moduleId', 'inner');
        $this->db->where('branchId',$branchId); 
        $this->db->where('date',$startDate); 
        $where = '((startTime  BETWEEN "'.$startTime.'" AND "'.$endTime.'") OR (endTime BETWEEN"'.$startTime.'" AND "'.$endTime.'"))';
        $this->db->where($where); 
        $this->db->where('lecturerId',$lecturerId);  

        $query = $this->db->get();
        return $query->result_array();
    }
    public function delete_lecturer() {
        $lecturer_id = $this->input->post('lecturer_id');   
        $this->db->where('id',$lecturer_id);
        return $this->db->delete('lecturer');
      }

}
