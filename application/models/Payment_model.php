<?php

class Payment_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_payment_plans() {
      $this->db->select('intakes.name AS intakeName, course.name AS courseName, payment_plan.*,');
      $this->db->join('intakes', 'intakes.id = payment_plan.intakeId', 'inner');
      $this->db->join('course', 'course.id = payment_plan.courseId', 'inner');
      $this->db->order_by('datetime','DESC');

      $query = $this->db->get('payment_plan');
      return $query->result_array();
    }

    public function get_single_pplan($id) {
      $this->db->where('id',$id);
      $query = $this->db->get('payment_plan');
      return $query->row();
    }

    public function get_payment_plans_by_approval() {
      $this->db->select('payment_plan.*,course_enroll.studentId');
      $this->db->join('course_enroll', 'course_enroll.pplanId = payment_plan.id', 'inner');
      $this->db->Where('payment_plan.pp_type',1);
      $this->db->Where('payment_plan.Approved',0);
      $query = $this->db->get('payment_plan');
      return $query->result_array();
    }

    public function filter_payment_plans() {
      $this->db->select('intakes.name AS intakeName, course.name AS courseName, payment_plan.*,');
      $this->db->join('intakes', 'intakes.id = payment_plan.intakeId', 'inner');
      $this->db->join('course', 'course.id = payment_plan.courseId', 'inner');

      if($this->input->post('intakeId')!="") {
        $this->db->where('payment_plan.intakeId',$this->input->post('intakeId'));
      }

      if($this->input->post('courseId')!="") {
        $this->db->where('payment_plan.courseId',$this->input->post('courseId'));
      }

      $this->db->order_by('datetime','DESC');
      $query = $this->db->get('payment_plan');
      return $query->result_array();
    }

    public function get_payment_plans_by_intake_course($intakeId,$courseId) {
      $this->db->select('intakes.name AS intakeName, course.name AS courseName, payment_plan.*');
      $this->db->join('intakes', 'intakes.id = payment_plan.intakeId', 'inner');
      $this->db->join('course', 'course.id = payment_plan.courseId', 'inner');
      $this->db->where('intakeId',$intakeId);
      $this->db->where('courseId',$courseId);
      $this->db->order_by('datetime','DESC');
      $query = $this->db->get('payment_plan');

      return $query->result_array();
    }

    public function view_pplan() {
      $this->db->where('pplanId',$this->input->post('pplanId'));
      $query = $this->db->get('pp_installment');

      return $query->result_array();
    }

    public function copy_pplan($oldppid,$type) {

      $this->db->where('id',$oldppid);
      $query = $this->db->get('payment_plan');
      $data= $query->result_array();
      $name='';
      $courseid='';
      $intakeId='';

      foreach($data as $data){
        $name=$data['name'];
        $courseid=$data['courseId'];
        $intakeId=$data['intakeId'];
      }

      $data = array(
        'name'=> $name,
        'courseId'=> $courseid,
        'intakeId'=> $intakeId,
        'datetime'=>date('Y-m-d h:i:sa'),
        'pp_type'=> $type,
        'original_id'=>$oldppid
      );

      $this->db->insert('payment_plan', $data);
      return array(
        'id'=> $this->db->insert_id(),
        'courseid'=>$courseid
      );
      
     
    }

    public function add_payment_plan() {
      $data = array(
        'name'=> $this->input->post('name'),
        'courseId'=> $this->input->post('courseId'),
        'intakeId'=> $this->input->post('intakeId'),
        'datetime'=>date('Y-m-d h:i:sa')
      );

      $this->db->insert('payment_plan', $data);

      return $this->db->insert_id();
    }

    public function update_payment_plan() {
      $data = array(
        'name'=> $this->input->post('name'),
        'courseId'=> $this->input->post('courseId'),
        'intakeId'=> $this->input->post('intakeId'),
        'datetime'=>date('Y-m-d h:i:sa')
      );

      $id = $this->input->post('pplanId');
      $this->db->where('id',$id);

      return $this->db->update('payment_plan', $id);
    }

    public function pp_approval($pplanId) {
      $data = array(
        'Approved'=> 1,
      );
      $this->db->where('id',$pplanId);
      return $this->db->update('payment_plan', $data);
    }

    public function Payment_transfer($pplanId,$StudentId) {
      //get old payment_Planid
      $this->db->where('id',$pplanId);
      $query = $this->db->get('payment_plan');
      $data= $query->result_array();
      $oldid;
      foreach($data as $data){
        $oldid=$data['original_id'];
      }
      //replace old Id to new Id
      $this->db->where('pplanId',$oldid);
      $this->db->where('studentId',$StudentId);
        $updates_data = array(
          'pplanId'=> $pplanId,
        );
      $updated_response= $this->db->update('payments', $updates_data);
      return $updated_response;
    }

    public function pp_approval_status($pplanId) {
      $this->db->where('id',$pplanId);
      $this->db->from('payment_plan');
      $query = $this->db->get();
      return $query->result_array();
    }

    public function delete_payment_plan() {
      $this->db->where('id', $this->input->get('id'));

     if($this->db->delete('payment_plan')) {
       return true;
     } else {
       return $this->db->error;
     }
    }

    public function update_installment($id,$name,$amount,$currency,$date,$pplanId) {
      $this->db->where('id', $id);
      $this->db->where('pplanId', $pplanId);

      $find = $this->db->get('pp_installment');

      if($find->num_rows() > 0) {
        $data = array(
          'id'=>$id,
          'name'=>$name,
          'amount'=>$amount,
          'currency'=>$currency,
          'date'=>$date,
          'pplanId'=>$pplanId,
        );

        $this->db->where('id', $id);
        $this->db->where('pplanId', $pplanId);

        return $this->db->update('pp_installment',$data);
      } else {
        $data = array(
          'id'=>$id,
          'name'=>$name,
          'amount'=>$amount,
          'currency'=>$currency,
          'date'=>$date,
          'pplanId'=>$pplanId,
        );

        return $this->db->insert('pp_installment',$data);
      }
    }

    public function update_course_enroll($studentId,$pplanId,$courseId) {
        $this->db->where('studentId',$studentId);
        $this->db->where('courseId',$courseId);
        $data = array(
          'pplanId'=>$pplanId,
        );
        return $this->db->update('course_enroll',$data);
      
    }

    public function delete_installment($id,$pplanId) {
      $this->db->where('id', $id);
      $this->db->where('pplanId', $pplanId);

      $this->db->delete('pp_installment');
    }

    public function view_installments_by_pplan($pplanId) {
      $this->db->where('pplanId',$pplanId);
      $query = $this->db->get('pp_installment');
      return $query->result_array();
    }

    public function view_installments_by_paid($pplanId,$studentId,$installmentId) {
      $this->db->select('student.studentId');
      $this->db->from('pp_installment');
      $this->db->join('payment_plan','payment_plan.id=pp_installment.pplanId');
      $this->db->join('course_enroll','course_enroll.pplanId=payment_plan.id');
      $this->db->join('student','course_enroll.studentId=student.studentId');
      $this->db->where("(pp_installment.id, pp_installment.pplanId) IN (SELECT payments.installmentId, payments.pplanId FROM payments WHERE payments.studentId=student.studentId) AND course_enroll.studentId = student.studentId");
      $this->db->where('course_enroll.studentId',$studentId);
      $this->db->where('course_enroll.pplanId',$pplanId);
      $this->db->where('pp_installment.id',$installmentId);
      $query = $this->db->get();
      
      if($query->num_rows()>0) {
        return true;
      }else {
        return false;
      }
    
    }

    public function get_pp_type_approved($pplanId) {
      $this->db->where('id',$pplanId);
      $query = $this->db->get('payment_plan');
      return $query->result_array();
    }

    public function get_sumof_pplan($pplanId) {
      $this->db->select_sum('amount');
      $this->db->select('currency');
      $this->db->where('pplanId',$pplanId);
      $this->db->from('pp_installment');
      $this->db->group_by('currency');
      $query = $this->db->get();

      return $query->result_array();
    }

    public function get_payment_status($studentId,$pplanId,$installmentId) {
      $this->db->where('studentId',$studentId);
      $this->db->where('pplanId',$pplanId);
      $this->db->where('installmentId',$installmentId);

      $query = $this->db->get('payments');

      return $query->num_rows();
    }

    public function save_payment($username) {
      $studentId = $this->input->post('studentId');
      $pplanId = $this->input->post('pplanId');
      $installmentId = $this->input->post('installmentId');
      $amount = $this->input->post('amount');
      $currency = $this->input->post('currency');
      $currency_amount = $this->input->post('currency_amount');
      $type = $this->input->post('type');
      $remarks = $this->input->post('remarks');
      $date = date('Y-m-d h:i:sa');
      $rate = $this->input->post('rate');
      $fee_type = $this->input->post('fee_type');

      $data = array(
        'studentId'=>$studentId,
        'pplanId'=>$pplanId,
        'installmentId'=>$installmentId,
        'amount'=>$amount,
        'currency'=>$currency,
        'currency_amount'=>$currency_amount,
        'remarks'=>$remarks,
        'type' => $type,
        'datetime'=>$date,
        'rate' => $rate,
        'username'=>$username,
        'fee_type'=>$fee_type
      );

      return $this->db->insert('payments',$data);
    }

    public function print_receipt($studentId,$pplanId,$installmentId) {
      $this->db->select('student.initials_name AS studentName,course.name AS courseName,course_enroll.*,payments.*,pp_installment.name AS installmentName');
      $this->db->join('student','student.studentId=payments.studentId','inner');
      $this->db->join('course_enroll','payments.studentId=course_enroll.studentId AND payments.pplanId=course_enroll.pplanId','inner');
      $this->db->join('course','course.id=course_enroll.courseId','inner');
      $this->db->join('pp_installment','pp_installment.id=payments.installmentId AND pp_installment.pplanId=payments.pplanId','inner');
      $this->db->where('payments.studentId',$studentId);
      $this->db->where('payments.pplanId',$pplanId);
      $this->db->where('payments.installmentId',$installmentId);

      $query = $this->db->get('payments');

      return $query->row();
    }

    public function filter_payments($username) {

      $startDate = $this->input->get('startDate');
      $endDate = $this->input->get('endDate');
      $studentId = $this->input->get('studentId');
      $courseId = $this->input->get('courseId');
      $batchId = $this->input->get('batchId');
      $fee_type = $this->input->get('fee_type');

      $this->db->select('payments.studentId, payments.pplanId, payments.installmentId, course.name AS courseName, payments.amount, payments.fee_type AS fee_type, payments.type');
      $this->db->join('student','student.studentId=payments.studentId','inner');
      $this->db->join('course_enroll','payments.studentId=course_enroll.studentId AND payments.pplanId=course_enroll.pplanId','inner');
      $this->db->join('course','course.id=course_enroll.courseId','inner');
      $this->db->join('pp_installment','pp_installment.id=payments.installmentId AND pp_installment.pplanId=payments.pplanId','inner');
      $this->db->where('DATE(payments.datetime) BETWEEN "'.$startDate.'" AND "'.$endDate.'"');
      $this->db->order_by('payments.fee_type','ASC');

      if($username!="") {
        $this->db->where('payments.username',$username);
      }

      if($studentId!="") {
        $this->db->where('payments.studentId',$studentId);
      }

      if($courseId!="") {
        $this->db->where('course_enroll.courseId',$courseId);
      }

      if($batchId!="") {
        $this->db->where('course_enroll.batchId',$batchId);
      }

      if($fee_type!="") {
        $this->db->where('payments.fee_type',$fee_type);
      }

      //$this->db->group_by('payments.fee_type');

      $query = $this->db->get('payments');

      return $query->result_array();
    }

    public function validate_payments($studentId,$date) {
      $this->db->select('student.studentId,student.initials_name,pp_installment.name,pp_installment.amount,pp_installment.currency,pp_installment.date');
      $this->db->join('payment_plan','payment_plan.id=pp_installment.pplanId','inner');
      $this->db->join('course_enroll','course_enroll.pplanId = payment_plan.id','inner');
      $this->db->join('student','course_enroll.studentId = student.studentId');
      $this->db->where("(pp_installment.id, pp_installment.pplanId) NOT IN (SELECT payments.installmentId, payments.pplanId FROM payments WHERE payments.studentId='$studentId')");
      $this->db->where('course_enroll.studentId',$studentId);
      $this->db->where("pp_installment.date<='$date'");

      $query = $this->db->get('pp_installment');

      if($query->num_rows()>0) {
        return $query->result_array();
      } else {
        return true;
      }
    }

    public function delete_payment() {
      $studentId = $this->input->post('studentId');
      $pplanId = $this->input->post('pplanId');
      $installmentId = $this->input->post('installmentId');

      $this->db->where('studentId',$studentId);
      $this->db->where('pplanId',$pplanId);
      $this->db->where('installmentId',$installmentId);

      $query = $this->db->delete('payments');

      if($query) {
        return true;
      } else {
        return false;
      }
    }

    public function save_correction($studentId, $batchId, $courseId, $pplanId) {

      $this->db->where('studentId',$studentId);
      $this->db->where('courseId',$courseId);
      $find = $this->db->get('course_enroll');

      if($find->num_rows() > 0) {
        $data = array(
          'pplanId'=> $pplanId
        );

        $this->db->where('studentId',$studentId);
        $this->db->where('courseId',$courseId);

        return $this->db->update('course_enroll', $data);
      }
    }

  }
