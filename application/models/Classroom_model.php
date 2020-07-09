<?php

class Classroom_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_classes() {
        $query = $this->db->get('classroom');
        return $query->result_array();
    }

    public function add() {
        $this->load->helper('url');
        $data = array(
            'name'=>$this->input->post('className'),
            'type'=>$this->input->post('classType'),
            'capacity'=>$this->input->post('capacity')
        );
        return $this->db->insert('classroom', $data);
    }

    public function availability($startDate,$endDate,$startTime,$endTime,$scheduleDay,$heads) {
        $this->db->select('classroom.*');
        $this->db->from('classroom');
        $this->db->where('classroom.capacity >=',$heads);
        $this->db->where('classroom.id NOT IN (SELECT classroomId FROM allocate WHERE (date BETWEEN "'.$startDate.'" AND "'.$endDate.'") AND day="'.$scheduleDay.'" AND ((startTime BETWEEN "'.$startTime.'" AND "'.$endTime.'") OR (endTime BETWEEN "'.$startTime.'" AND "'.$endTime.'") OR ("'.$startTime.'" BETWEEN startTime AND endTime) OR ("'.$endTime.'" BETWEEN startTime AND endTime)))');
        $this->db->where('classroom.id NOT IN (SELECT classroomId FROM event WHERE (date BETWEEN "'.$startDate.'" AND "'.$endDate.'") AND day="'.$scheduleDay.'" AND ((startTime BETWEEN "'.$startTime.'" AND "'.$endTime.'") OR (endTime BETWEEN "'.$startTime.'" AND "'.$endTime.'") OR ("'.$startTime.'" BETWEEN startTime AND endTime) OR ("'.$endTime.'" BETWEEN startTime AND endTime)))');

        $query = $this->db->get();
        foreach ($query->result() as $data) {
            $response[] = $data;
        }

        return $response;
    }
}
