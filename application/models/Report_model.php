<?php

class Report_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function table_structure($table_name) {
      return $this->db->list_fields($table_name);
    }

    public function get_tables() {
      return $this->db->list_tables();
    }

    public function create_report($reportName,$query,$reportType,$fromTable,$groupTable,$groupColumn,$orderTable,$orderColumn,$orderType) {
      $datetime = date('Y-m-d h:i:sa');

      $data = array(
        'reportName' => $reportName,
        'query' => $query,
        'reportType' => $reportType,
        'datetime' => $datetime,
        'report_from' => $fromTable,
        'report_order' => $orderTable.".".$orderColumn,
        'order_type' => $orderType,
        'report_group' => $groupTable.".".$groupColumn
      );

      $this->db->insert('reports',$data);

      return $this->db->insert_id();
    }

    public function create_report_columns($reportId) {
      $table = $this->input->post('table');
      $column = $this->input->post('column');
      $type = $this->input->post('type');

      foreach($table as $key=>$value) {
        $data[] = array(
          'reportId' => $reportId,
          'variable_table' => $table[$key],
          'column' => $column[$key],
          'type' => $type[$key]
        );
      }

      $this->db->insert_batch('report_columns',$data);
    }

    public function create_report_selects($reportId) {
      $table = $this->input->post('selectTable');
      $column = $this->input->post('selectColumn');
      $columnAs = $this->input->post('columnAs');

      foreach($table as $key=>$value) {
        $data[] = array(
          'reportId' => $reportId,
          'select_column' => $table[$key].".".$column[$key],
          'columnAs' => $columnAs[$key]
        );
      }

      $this->db->insert_batch('report_select',$data);
    }

    public function create_report_joins($reportId) {
      $table = $this->input->post('joinTable');
      $column = $this->input->post('joinColumn');
      $joinTable = $this->input->post('joinRootTable');
      $joinColumn = $this->input->post('joinRootColumn');
      $joinType = $this->input->post('joinType');

      foreach($table as $key=>$value) {
        $data[] = array(
          'reportId' => $reportId,
          'table_join' => $table[$key],
          'column1' => $table[$key].".".$column[$key],
          'column2' => $joinTable[$key].".".$joinColumn[$key],
          'joinType' => $joinType[$key]
        );
      }

      $this->db->insert_batch('report_join',$data);
    }

    public function get_variable_fields($id) {
      $this->db->where('reportId',$id);
      return $this->db->get('report_columns')->result_array();
    }

    public function get_report($id) {
      $this->db->where('id',$id);
      $report = $this->db->get('reports')->row();

      $this->db->where('reportId',$id);
      $select_columns = $this->db->get('report_select')->result_array();

      $this->db->where('reportId',$id);
      $join_columns = $this->db->get('report_join')->result_array();

      $this->db->where('reportId',$id);
      $vari_columns = $this->db->get('report_columns')->result_array();

      foreach($select_columns as $select) {
        $this->db->select($select['select_column']." AS ".$select['columnAs']);
      }

      $this->db->from($report->report_from);

      foreach($join_columns as $join) {
        $this->db->join($join['table_join'],$join['column1']."=".$join['column2'],$join['joinType']);
      }

      if($_POST) {
        foreach($vari_columns as $vari) {
          $this->db->where($vari['variable_table'].$vari['column'],$this->input->post($vari['column']));
        }
      }

      $this->db->order_by($report->report_order,$report->order_type);

      return $this->db->get()->result_array();
    }

    public function payment_plan_wise_students($data) {
      $this->db->select('course_enroll.*,student.*,course.name AS courseName, payment_plan.name AS pplan_name, intakes.name AS intakeName, batch.name AS batchName, inquiry.username AS counselor');
      $this->db->join('student','student.studentId = course_enroll.studentId','inner');
      $this->db->join('course','course.id=course_enroll.courseId');
      $this->db->join('inquiry','inquiry.id=course_enroll.inquiryId');
      $this->db->join('payment_plan','payment_plan.id=course_enroll.pplanId');
      $this->db->join('batch','batch.id=course_enroll.batchId');
      $this->db->join('intakes','intakes.id=course_enroll.intakeId');

      $this->db->where('course_enroll.intakeId',$data['intakeId']);
      $this->db->where('course_enroll.courseId',$data['courseId']);
      $this->db->where('course_enroll.pplanId',$data['pplanId']);

      $this->db->order_by('student.studentId','DESC');

      $query = $this->db->get('course_enroll');

      return $query->result_array();
    }

    public function outstanding_report($data) {
      $this->db->select('student.studentId,student.initials_name,student.mobile,student.email,course.name AS courseName,batch.name as batchName,COUNT(pp_installment.id) AS installments, SUM(pp_installment.amount) AS amount, pp_installment.currency');
      $this->db->join('payment_plan','payment_plan.id=pp_installment.pplanId');
      $this->db->join('course_enroll','course_enroll.pplanId=payment_plan.id');
      $this->db->join('course','course_enroll.courseId=course.id');
      $this->db->join('batch','course_enroll.batchId=batch.id');
      $this->db->join('student','course_enroll.studentId=student.studentId');
      $this->db->where("(pp_installment.id, pp_installment.pplanId) NOT IN (SELECT payments.installmentId, payments.pplanId FROM payments WHERE payments.studentId=student.studentId) AND course_enroll.studentId = student.studentId AND pp_installment.date <='".$data['date']."'");

      if($data['courseId']!="") {
        $this->db->where('course_enroll.courseId',$data['courseId']);
      }

      if($data['intakeId']!="") {
        $this->db->where('course_enroll.intakeId',$data['intakeId']);
      }

      if($data['batchId']!="") {
        $this->db->where('course_enroll.batchId',$data['batchId']);
      }

      $this->db->where('course_enroll.is_dropout',0);

      $this->db->group_by('student.studentId, pp_installment.currency');

      $query = $this->db->get('pp_installment');

      return $query->result_array();
    }

    public function final_report($data) {
      $this->db->select('student.studentId,student.initials_name,student.mobile,student.email,course.name AS courseName,batch.name as batchName,COUNT(pp_installment.id) AS installments, SUM(pp_installment.amount) AS amount, pp_installment.currency');
      $this->db->join('payment_plan','payment_plan.id=pp_installment.pplanId');
      $this->db->join('course_enroll','course_enroll.pplanId=payment_plan.id');
      $this->db->join('course','course_enroll.courseId=course.id');
      $this->db->join('batch','course_enroll.batchId=batch.id');
      $this->db->join('student','course_enroll.studentId=student.studentId');
      $this->db->where("(pp_installment.id, pp_installment.pplanId) NOT IN (SELECT payments.installmentId, payments.pplanId FROM payments WHERE payments.studentId=student.studentId) AND course_enroll.studentId = student.studentId AND pp_installment.date <='".$data['date']."'");

      if($data['courseId']!="") {
        $this->db->where('course_enroll.courseId',$data['courseId']);
      }

      if($data['intakeId']!="") {
        $this->db->where('course_enroll.intakeId',$data['intakeId']);
      }

      if($data['batchId']!="") {
        $this->db->where('course_enroll.batchId',$data['batchId']);
      }

      $this->db->where('course_enroll.is_dropout',0);

      $this->db->group_by('student.studentId, pp_installment.currency');

      $query = $this->db->get('pp_installment');

      return $query->result_array();
    }

    public function payment_report($data) {
      $this->db->select('student.studentId,student.initials_name,student.mobile,student.email,course.name AS courseName,batch.name as batchName,COUNT(pp_installment.id) AS installments, SUM(pp_installment.amount) AS amount, pp_installment.currency');
      $this->db->join('payment_plan','payment_plan.id=pp_installment.pplanId');
      $this->db->join('course_enroll','course_enroll.pplanId=payment_plan.id');
      $this->db->join('course','course_enroll.courseId=course.id');
      $this->db->join('batch','course_enroll.batchId=batch.id');
      $this->db->join('student','course_enroll.studentId=student.studentId');
      $this->db->where("(pp_installment.id, pp_installment.pplanId) IN (SELECT payments.installmentId, payments.pplanId FROM payments WHERE payments.studentId=student.studentId) AND course_enroll.studentId = student.studentId AND pp_installment.date <='".$data['date']."'");


      if($data['courseId']!="") {
        $this->db->where('course_enroll.courseId',$data['courseId']);
      }

      if($data['intakeId']!="") {
        $this->db->where('course_enroll.intakeId',$data['intakeId']);
      }

      if($data['batchId']!="") {
        $this->db->where('course_enroll.batchId',$data['batchId']);
      }

      $this->db->group_by('student.studentId,pp_installment.currency');

      $query = $this->db->get('pp_installment');

      return $query->result_array();
    }

    public function attendance_report($data) {
      $this->db->select('student.studentId,student.initials_name,attendance.date,attendance.time,attendance.is_pending_payment,attendance.visited_finance,attendance.remarks');
      $this->db->join('student','attendance.studentId=student.studentId');
      $this->db->where("date BETWEEN '".$data['startDate']."' AND '".$data['endDate']."'");

      if($data['courseId']!="") {
        $this->db->where('course_enroll.courseId',$data['courseId']);
      }

      if($data['batchId']!="") {
        $this->db->where('course_enroll.batchId',$data['batchId']);
      }

      if($data['is_pending_payment']!="") {
        $this->db->where('attendance.is_pending_payment',$data['is_pending_payment']);
      }

      $query = $this->db->get('attendance');

      return $query->result_array();
    }

    //class attendance summary
  public function clsatt_summary() {
    
    $branch =$this->input->post('branchId');
    $startDate=$this->input->post('startDate');
    $endDate=$this->input->post('endDate');
    $courseId=$this->input->post('courseId');
    $module=$this->input->post('moduleId');
    $batch=$this->input->post('batch');
    
    $this->db->select('a.studentId,full_name,a.date,a.time,a.allocateId,d.id as batch ,e.moduleId,f.name as module,e.branchId');
    $this->db->from('classroom_attendance as a','inner');
    $this->db->join('student as b', 'a.studentId=b.studentId','inner');
    $this->db->join('allocate as e', 'e.id= a.allocateId','inner');
    $this->db->join('course_enroll as c', 'c.studentId=a.studentId','inner');
    $this->db->join('batch as d', 'd.id=c.batchId','inner');
    $this->db->join('module as f', 'f.id=e.moduleId','inner');
  
    if($branch!="") {
      $this->db->where('e.branchId',$branch);
    }
    
    if ($startDate!=""){
      $this->db->where("a.date >=", $startDate);
      $this->db->where("a.date <=", $endDate);
    }
    
    if($courseId!="") {
      $this->db->where('e.courseId',$courseId);
    }

    if($module!="") {
       $this->db->where('e.moduleId',$module);
    }
    if($batch!="") {
        $this->db->where('e.batchId',$batch);
    }

    $this->db->order_by('a.date desc,a.time desc');
    
    $query = $this->db->get();
    return $query->result_array();
  }
}
