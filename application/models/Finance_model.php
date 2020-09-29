<?php

class Finance_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_banks() {
        $query = $this->db->get('banks');
        return $query->result_array();
    }

    public function get_bank_branch($bankCode) {
        $this->db->select('bank_branch.*,bank.name as bankName');
        $this->db->from('bank_branch');
        $this->db->join('banks','banks.bank_code=bank_branch.bank_code');
        $this->db->where('bank_branch.bank_code',$bankCode);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_non_bulk_payments($branchId,$username){
        $sql = "select DISTINCT  studentId,pplanId,installmentId,amount,datetime
        from payments
        where NOT EXISTS
        (select 1 from cash_bulk_details
        where payments.studentId = cash_bulk_details.studentId AND payments.pplanId = cash_bulk_details.pplanId AND payments.installmentId = cash_bulk_details.installmentId) 
        AND branchId='".$branchId."' AND username='".$username."'";
         $query = $this->db->query($sql);
         return $query->result_array();
    }
}
