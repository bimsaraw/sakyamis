<?php

class Allocation_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function batch_conflict($startDate,$endDate,$startTime,$endTime,$scheduleDay,$batchId,$branchId) {
        $this->db->select('batchId');
        $this->db->from('allocate');
        $this->db->where('batchId = "'.$batchId.'" AND branchId= "'.$branchId.'" AND (date BETWEEN "'.$startDate.'" AND "'.$endDate.'") AND (day="'.$scheduleDay.'") AND ((startTime BETWEEN "'.$startTime.'" AND "'.$endTime.'") OR (endTime BETWEEN "'.$startTime.'" AND "'.$endTime.'") OR ("'.$startTime.'" BETWEEN startTime AND endTime) OR ("'.$endTime.'" BETWEEN startTime AND endTime))');

        $query = $this->db->get();
        foreach ($query->result() as $data) {
            $response = "conflict";
        }

        return $response;
    }

    public function save_allocation() {
        $courseId = $this->input->post('courseId');
        $batchId = $this->input->post('batchId');
        $semesterId = $this->input->post('semesterId');
        $moduleId = $this->input->post('moduleId');

        $startDate = date('Y-m-d',strtotime($this->input->post('startDate')));
        $endDate = date('Y-m-d',strtotime($this->input->post('endDate')));
        $scheduleDay = $this->input->post('scheduleDay');
        $scheduleType = $this->input->post('scheduleType');
        $startTime = $this->input->post('startTime');
        $endTime = $this->input->post('endTime');
        $purpose = $this->input->post('purpose');

        $classroomId = $this->input->post('classroomId');
        $lecturerId= $this->input->post('lecturerId');
        $branchId= $this->input->post('L_allocateBranch');
        $i = 0;

        while($startDate<=$endDate) {
            $day = date('l', strtotime($startDate));

            if($day == $scheduleDay) {
                $data[$i]['courseId'] = $courseId;
                $data[$i]['batchId'] = $batchId;
                $data[$i]['semesterId'] = $semesterId;
                $data[$i]['moduleId'] = $moduleId;
                $data[$i]['date'] = $startDate;
                $data[$i]['day'] = $scheduleDay;
                $data[$i]['startTime'] = $startTime;
                $data[$i]['endTime'] = $endTime;
                $data[$i]['purpose'] = $scheduleType;
                $data[$i]['classroomId'] = $classroomId;
                $data[$i]['lecturerId'] = $lecturerId;
                $data[$i]['branchId'] = $branchId;
            }

            $startDate = date('Y-m-d',strtotime($startDate.'+1 Day'));
            $i++;

        }

        return $this->db->insert_batch('allocate', $data);
    }

    public function save_event() {

        $startDate = date('Y-m-d',strtotime($this->input->post('startDate')));
        $endDate = date('Y-m-d',strtotime($this->input->post('endDate')));
        $scheduleDay = $this->input->post('scheduleDay');
        $startTime = $this->input->post('startTime');
        $endTime = $this->input->post('endTime');
        $name = $this->input->post('name');
        $color = $this->input->post('color');
        $branchId= $this->input->post('EventeBranch');

        $classroomId = $this->input->post('classroomId');

        $i = 0;

        while($startDate<=$endDate) {
            $day = date('l', strtotime($startDate));

            if($day == $scheduleDay) {
                $data[$i]['date'] = $startDate;
                $data[$i]['day'] = $scheduleDay;
                $data[$i]['startTime'] = $startTime;
                $data[$i]['endTime'] = $endTime;
                $data[$i]['name'] = $name;
                $data[$i]['classroomId'] = $classroomId;
                $data[$i]['color'] = $color;
                $data[$i]['branchId'] = $branchId;
            }

            $startDate = date('Y-m-d',strtotime($startDate.'+1 Day'));
            $i++;

        }

        return $this->db->insert_batch('event', $data);
    }

    public function get_dates($branchId) {
        $date = date('Y-m-d');
        $this->db->distinct();
        $this->db->select('date,id');
        $this->db->from('allocate');
        $this->db->order_by('date','asc');
        $this->db->group_by('date','asc');
        $this->db->where('date>="'.$date.'"');
        $this->db->where('branchId',$branchId);

        $query = $this->db->get();
        return $query->result_array();

    }

    //attendance automated
    public function timeNerest_allocate($branch,$date,$beforeTime,$afterTime){
        $this->db->select('allocate.courseId');
        $this->db->from('allocate');
        $this->db->where('date',$date);
        $this->db->where('branchId',$branch);
        $this->db->where('startTime>=',$beforeTime);
        $this->db->where('startTime<=',$afterTime);
        $this->db->order_by('startTime','asc');
        $query = $this->db->get();
        return $query->result_array();
    }
    //attendance automated
    public function get_allocateDetails_bycourseId($branch,$date,$beforeTime,$afterTime,$courseId){
        $this->db->select('allocate.*,course.name as courseName');
        $this->db->from('allocate');
        $this->db->join('course','course.id=allocate.courseId','inner');
        $this->db->where('date',$date);
        $this->db->where('branchId',$branch);
        $this->db->where('startTime>=',$beforeTime);
        $this->db->where('startTime<=',$afterTime);
        $this->db->where('courseId',$courseId);
        $this->db->order_by('startTime','asc');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_allocations_date($date,$branchId) {
        $this->db->select('a.*,batch.name AS batchName, classroom.name AS classroomName, lecturer.name AS lecturerName,module.name AS moduleName,course.name AS courseName');
        $this->db->from('allocate a');
        $this->db->join('batch','batch.id=a.batchId','inner');
        $this->db->join('classroom','classroom.id=a.classroomId','inner');
        $this->db->join('lecturer','lecturer.id=a.lecturerId','inner');
        $this->db->join('module','module.id=a.moduleId','inner');
        $this->db->join('course','course.id=a.courseId','inner');
        $this->db->where('date',$date);
        if($branchId!=""){
        $this->db->where('a.branchId',$branchId);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_allocation_lecture_by_dateBranch($date,$branchId){
        $this->db->select('b.name as lecturerName,a.lecturerId');
        $this->db->from('allocate a');
        $this->db->join('lecturer b','a.batchId=b.id','inner');
        $this->db->where('date',$date);
        if($branchId!=""){
            $this->db->where('branchId',$branchId);
            }
       
        $this->db->group_by('lecturerId');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_events_date($date,$branchId) {
        $this->db->select('a.*,classroom.name AS classroomName');
        $this->db->from('event a');
        $this->db->join('classroom','classroom.id=a.classroomId','inner');
        $this->db->where('date',$date);
        if($branchId!=""){
        $this->db->where('a.branchId',$branchId);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_allocations() {

        $date = date('Y-m-d');
        //$this->db->distict();
        $this->db->select('a.*,batch.name AS batchName, classroom.name AS classroomName, lecturer.name AS lecturerName,module.name AS moduleName,course.name AS courseName');
        $this->db->from('allocate a');
        $this->db->join('batch','batch.id=a.batchId','inner');
        $this->db->join('classroom','classroom.id=a.classroomId','inner');
        $this->db->join('lecturer','lecturer.id=a.lecturerId','inner');
        $this->db->join('module','module.id=a.moduleId','inner');
        $this->db->join('course','course.id=a.courseId','inner');
        $this->db->where('date>="'.$date.'"');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_allocation_by_id($id) {
        $this->db->select('a.*,batch.name AS batchName, classroom.name AS classroomName, lecturer.name AS lecturerName,module.name AS moduleName,course.name AS courseName');
        $this->db->from('allocate a');
        $this->db->join('batch','batch.id=a.batchId','inner');
        $this->db->join('classroom','classroom.id=a.classroomId','inner');
        $this->db->join('lecturer','lecturer.id=a.lecturerId','inner');
        $this->db->join('module','module.id=a.moduleId','inner');
        $this->db->join('course','course.id=a.courseId','inner');
        $this->db->where('a.id',$id);

        $query = $this->db->get();
        foreach ($query->result() as $data) {
            $response[] = $data;
        }

        if(isset($response)) {
            return $response;
        }
    }

    public function get_event_by_id($id) {
        $this->db->select('a.*,classroom.name AS classroomName');
        $this->db->from('event a');
        $this->db->join('classroom','classroom.id=a.classroomId','inner');
        $this->db->where('a.id',$id);

        $query = $this->db->get();
        foreach ($query->result() as $data) {
            $response[] = $data;
        }

        if(isset($response)) {
            return $response;
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        if($this->db->delete('allocate')) {
            return true;
        }
    }

    public function delete_event($id) {
        $this->db->where('id', $id);
        if($this->db->delete('event')) {
            return true;
        }
    }

    public function delete_lectures() {
        $inputs = $this->input->post('delete');

        foreach( $inputs as $input ) {
          $this->db->where('id',$input);
          if($this->db->delete('allocate')) {
            $flag = 1;
          } else {
            $flag = 0;
          }
        }

        if($flag==1) {
          return true;
        }
    }

    public function search_lecture() {
      $courseId = $this->input->post('courseId');
      $batchId = $this->input->post('batchId');
      $semesterId = $this->input->post('semesterId');
      $moduleId = $this->input->post('moduleId');
      $startDate = $this->input->post('startDate');
      $endDate = $this->input->post('endDate');
      $scheduleDay = $this->input->post('scheduleDay');

      $this->db->select('a.*,batch.name AS batchName, classroom.name AS classroomName, lecturer.name AS lecturerName,module.name AS moduleName,course.name AS courseName');
      $this->db->from('allocate a');
      $this->db->join('batch','batch.id=a.batchId','inner');
      $this->db->join('classroom','classroom.id=a.classroomId','inner');
      $this->db->join('lecturer','lecturer.id=a.lecturerId','inner');
      $this->db->join('module','module.id=a.moduleId','inner');
      $this->db->join('course','course.id=a.courseId','inner');

      if($courseId!="") {
        $this->db->where('a.courseId',$courseId);
      }

      if($batchId!="") {
        $this->db->where('a.batchId',$batchId);
      }

      if($semesterId!="") {
        $this->db->where('a.semesterId',$semesterId);
      }

      if($moduleId!="") {
        $this->db->where('a.moduleId',$moduleId);
      }

      if($startDate!="" && $endDate!="") {
        $this->db->where('(date BETWEEN "'.$startDate.'" AND "'.$endDate.'") AND (day="'.$scheduleDay.'")');
      }


      $query = $this->db->get();
      return $query->result_array();
    }


}
