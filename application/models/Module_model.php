<?php 

class Module_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_modules($courseId) {
        $this->db->select('course.name As courseName, semester.name AS semesterName, module.*');
        $this->db->from('module');
        $this->db->join('course','module.course=course.id','inner');
        $this->db->join('semester','module.semester=semester.id','inner');
        $this->db->where('course',$courseId);

        $query = $this->db->get();
        foreach ($query->result() as $data) {
            $response[] = $data;
        }

        return $response;
    }

    public function get_all_modules() {
        $this->db->select('course.name As courseName, semester.name AS semesterName, module.*');
        $this->db->from('module');
        $this->db->join('course','module.course=course.id','inner');
        $this->db->join('semester','module.semester=semester.id','inner');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function search($string) {
        $this->db->select('course.name As courseName, semester.name AS semesterName, module.*');
        $this->db->from('module');
        $this->db->join('course','module.course=course.id','inner');
        $this->db->join('semester','module.semester=semester.id','inner');
        $this->db->like('module.name',$string);

        $query = $this->db->get();
        foreach ($query->result() as $data) {
            $response[] = $data;
        }

        if(isset($response)) {
            return $response;
        } else {
            return $this->get_all_modules();
        }
    }

    public function get_modules_by_course_semester($courseId,$semesterId) {
        $this->db->select('course.name As courseName, semester.name AS semesterName, module.*');
        $this->db->from('module');
        $this->db->join('course','module.course=course.id','inner');
        $this->db->join('semester','module.semester=semester.id','inner');
        $this->db->where('module.course',$courseId);
        $this->db->where('module.semester',$semesterId);

        $query = $this->db->get();
        foreach ($query->result() as $data) {
            $response[] = $data;
        }

        return $response;
    }

    public function add_module() {
        $this->load->helper('url');
        $data = array(
            'course'=>$this->input->post('moduleCourse'),
            'name'=>$this->input->post('moduleName'),
            'semester'=>$this->input->post('moduleSemester')
        );
        return $this->db->insert('module', $data);
    }
    public function delete_module() {
        $this->load->helper('url');
        $course_id=$this->input->post('moduledeleteCourse');
        $module_id = $this->input->post('moduleid');
     
        $this->db->where('id', $module_id);
        $this->db->where('course', $course_id);

        $query = $this->db->delete('module');
        if($query) {
            return true;
          } else {
            return false;
          }
    }
//attendance summary
    public function schedule_date_course($courseId,$branch,$startdate,$enddate){
        $sql = "SELECT b.name,a.moduleId,a.date,a.batchId,a.id,a.branchId,a.courseId from allocate as a inner join module as b on a.moduleId=b.id where a.courseId=? AND a.branchId=? AND a.date BETWEEN ? AND ?";
        $query = $this->db->query($sql,array($courseId,$branch,$startdate,$enddate));
        return $query->result_array();
      }

}