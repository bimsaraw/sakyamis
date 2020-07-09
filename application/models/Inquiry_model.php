<?php

class Inquiry_model extends CI_Model {

  public function __construct() {
    $this->load->database();
    $this->load->helper('url_helper');
    $this->load->helper('url');
  }

  public function get_intakes() {
    $this->db->order_by('id','DESC');
    $query = $this->db->get('intakes');
    return $query->result_array();
  }

  public function get_single_intake($id) {
    $this->db->where('id',$id);
    $query = $this->db->get('intakes');
    return $query->row();
  }

  public function add_intake() {
    $data = array(
      'name'=>$this->input->post('intakeName'),
      'startDate'=>$this->input->post('startDate'),
      'endDate'=>$this->input->post('endDate'),
    );
    return $this->db->insert('intakes', $data);
  }

  public function get_targets($intakeId) {
    $this->db->select('t.*,course.name AS courseName, users.username');
    $this->db->from('targets t');
    $this->db->join('course','course.id=t.courseId','inner');
    $this->db->join('users','users.username=t.username','inner');
    $this->db->where('intakeId',$intakeId);
    $this->db->order_by('t.username asc');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_targets_by_username_course($username,$courseId,$intakeId) {
    $this->db->select('target');
    $this->db->from('targets');
    $this->db->where('username',$username);
    $this->db->where('intakeId',$intakeId);
    $this->db->where('courseId',$courseId);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_targets_by_intake_course($courseId,$intakeId) {
    $this->db->select('targets.*,users.name as usersname');
    $this->db->from('targets');
    $this->db->join('users','users.username=targets.username');
    $this->db->where('intakeId',$intakeId);
    $this->db->where('courseId',$courseId);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function update_target() {
    $this->load->helper('url');

    $intakeId = $this->input->post('intakeId');
    $courseId = $this->input->post('courseId');
    $username = $this->input->post('username');
    $target = $this->input->post('target');

    $this->db->where('intakeId',$intakeId);
    $this->db->where('courseId',$courseId);
    $this->db->where('username',$username);
    $existing_target = $this->db->get('targets');

    $data = array(
        'intakeId'=>$intakeId,
        'courseId'=>$courseId,
        'username'=>$username,
        'target'=>$target
    );

    if($target!=0) {
      if($existing_target->num_rows()==0) {
        return $this->db->insert('targets', $data);
      } else {
        $this->db->where('intakeId',$intakeId);
        $this->db->where('courseId',$courseId);
        $this->db->where('username',$username);
        return $this->db->update('targets',$data);
      }
    } else {
      $this->db->where('intakeId',$intakeId);
      $this->db->where('courseId',$courseId);
      $this->db->where('username',$username);
      return $this->db->delete('targets');
    }
  }

  public function get_inquiry_medium() {
    $this->db->order_by('medium','asc');
    $query = $this->db->get('inquiry_medium');
    return $query->result_array();
  }

  public function get_inquiry_reference() {
    $this->db->order_by('reference','asc');
    $query = $this->db->get('inquiry_reference');
    return $query->result_array();
  }

  public function get_next_rotation($courseId) {
    $this->db->where('courseId',$courseId);
    $this->db->order_by('id','desc');
    $this->db->limit(1);
    $rotations = $this->db->get('inquiry_rotation');

    if($rotations->num_rows()>0) {
      $persons = $rotations->result_array();
      foreach($persons as $person) {
        $last_rotated = $person['username'];
      }
    } else {
      $last_rotated = '';
    }

    $date = date('Y-m-d');

    $this->db->select('targets.*,intakes.name,intakes.startDate,intakes.endDate');
    $this->db->join('intakes','intakes.id=targets.intakeId');
    $this->db->where('courseId',$courseId);
    $this->db->where('"'.$date.'" BETWEEN intakes.startDate AND intakes.endDate');
    $this->db->where('targets.target > 0');
    $this->db->order_by('username','asc');
    $targets = $this->db->get('targets');

    $staff = array();
    $i = 0;

    if($targets->num_rows()>0) {
      foreach($targets->result_array() as $target) {
        $staff[$i] = $target['username'];
        $i++;
      }

      $a = array_search($last_rotated,$staff);

      if(!array_key_exists($a+1,$staff)) {
        return $staff[0];
      } else {
        return $staff[$a+1];
      }
    } else {
      $this->db->where('courseId',$courseId);
      $this->db->order_by('username','asc');
      $targets = $this->db->get('default_rotation');

      foreach($targets->result_array() as $target) {
        $staff[$i] = $target['username'];
        $i++;
      }

      $a = array_search($last_rotated,$staff);

      if(!array_key_exists($a+1,$staff)) {
        return $staff[0];
      } else {
        return $staff[$a+1];
      }
    }
  }

  public function save_inquiry($username) {
    $this->load->helper('url');
    $data = array(
      'username'=>$username,
      'name'=>$this->input->post('name'),
      'email'=>$this->input->post('email'),
      'mobile'=>$this->input->post('mobile'),
      'home'=>$this->input->post('home'),
      'address'=>$this->input->post('address'),
      'city'=>$this->input->post('city'),
      'medium'=>$this->input->post('medium'),
      'reference'=>$this->input->post('reference'),
      'course'=>$this->input->post('course'),
      'remarks'=>$this->input->post('remarks'),
      'datetime'=>date('Y-m-d h:i:sa'),
      'student_type'=>$this->input->post('student_type'),
      'is_pending'=>1
    );

    try {
      $this->db->insert('inquiry', $data);
      return  $this->db->insert_id();
    } catch(Exeption $e) {
      return $e->getMessage();
    }
  }

  public function update_inquiry() {
    $this->load->helper('url');
    $inquiry_id = $this->input->post('inquiry_id');
    $data = array(
      'id'=>$this->input->post('inquiry_id'),
      'username'=>$this->input->post('username'),
      'name'=>$this->input->post('name'),
      'email'=>$this->input->post('email'),
      'mobile'=>$this->input->post('mobile'),
      'home'=>$this->input->post('home'),
      'address'=>$this->input->post('address'),
      'city'=>$this->input->post('city'),
      'course'=>$this->input->post('course'),
      'student_type'=>$this->input->post('student_type'),
    );

    try {
      $this->db->where('id',$inquiry_id);
      return $this->db->update('inquiry', $data);
    } catch(Exeption $e) {
      return $e->getMessage();
    }
  }

  public function save_rotation($username) {
    $this->load->helper('url');
    $data = array(
      'username'=>$username,
      'courseId'=>$this->input->post('course'),
      'datetime'=>$this->input->post('datetime'),
    );
    return $this->db->insert('inquiry_rotation', $data);
  }

  public function set_status($username,$inquiry_id) {
    $this->load->helper('url');
    $data = array(
      'inquiry_id'=>$inquiry_id,
      'username'=>$username,
      'datetime'=>$this->input->post('datetime'),
      'status'=>1,
      'remarks'=>'Not followed',
    );
    return $this->db->insert('inquiry_status', $data);
  }

  public function get_inquiries_count($username,$status) {
    if($username=="") {
      $this->db->select('course.name AS courseName,COUNT(inquiry.id) AS count');
      $this->db->from('inquiry');
      $this->db->join('course','course.id=inquiry.course','inner');
      $this->db->where($status,'1');
      $this->db->group_by('course');
      $query = $this->db->get();

      return $query->result_array();
    } else {
      $this->db->select('course.name AS courseName,COUNT(inquiry.id) AS count');
      $this->db->from('inquiry');
      $this->db->join('course','course.id=inquiry.course','inner');
      $this->db->where($status,'1');
      $this->db->where('username',$username);
      $this->db->group_by('course');
      $query = $this->db->get();

      return $query->result_array();
    }
  }

  public function view_inquiries($courseId,$username,$type,$followUps,$range,$name) {
    if($username=="") {
      $this->db->select('inquiry.*,count(inquiry_status.remarks) AS remarks_count');
      $this->db->from('inquiry');
      $this->db->join('inquiry_status','inquiry.id=inquiry_status.inquiry_id','left');
      $this->db->where($type,'1');
      $this->db->where('course',$courseId);

      if($name!="") {
        $this->db->like('name',$name);
      }

      $this->db->group_by('inquiry.id');
      $this->db->having('remarks_count>='.$followUps);
      $this->db->order_by('datetime','DESC');

      if($range!="") {
        $this->db->limit($range);
      }

      $query = $this->db->get();

      return $query->result_array();
    } else {
      $this->db->select('inquiry.*,count(inquiry_status.remarks) AS remarks_count');
      $this->db->from('inquiry');
      $this->db->join('inquiry_status','inquiry.id=inquiry_status.inquiry_id','left');
      $this->db->where($type,'1');
      $this->db->where('inquiry.username',$username);
      $this->db->where('course',$courseId);

      if($name!="") {
        $this->db->like('name',$name);
      }

      $this->db->group_by('inquiry.id');
      $this->db->having('remarks_count>='.$followUps);
      $this->db->order_by('datetime','DESC');

      if($range!="") {
        $this->db->limit($range);
      }

      $query = $this->db->get();

      return $query->result_array();
    }
  }

  public function view_all_inquiries($username,$type) {
    if($username=="") {
      $this->db->from('inquiry');
      $this->db->where($type,'1');
      $query = $this->db->get();

      return $query->result_array();
    } else {
      $this->db->from('inquiry');
      $this->db->where($type,'1');
      $this->db->where('username',$username);
      $query = $this->db->get();

      return $query->result_array();
    }
  }

  public function view_all(){
    $this->db->select('inquiry.*,course.name AS courseName');
    $this->db->join('course','course.id=inquiry.course','inner');
    $query = $this->db->get('inquiry');

    return $query->result_array();
  }

  public function get_status_inquiry($id) {
    $this->db->from('inquiry_status');
    $this->db->where('inquiry_id',$id);
    $this->db->order_by('datetime','asc');
    $query = $this->db->get();

    return $query->result_array();
  }

  public function save_status($username) {
    $remarks = $this->input->post('remarks');
    $status = $this->input->post('status');
    $inquiry_id = $this->input->post('id');
    $datetime = date('Y-m-d h:i:sa');

    if($status=='Pending') {
      $inq_tbl = array(
        'is_pending'=>1,
        'is_failed'=>0,
        'is_positive'=>0
      );
    } else if($status=='Positive') {
      $inq_tbl = array(
        'is_pending'=>0,
        'is_failed'=>0,
        'is_positive'=>1
      );
    } else if($status=='Failed') {
      $inq_tbl = array(
        'is_pending'=>0,
        'is_failed'=>1,
        'is_positive'=>0
      );
    }

    $data = array(
      'inquiry_id'=>$inquiry_id,
      'username'=>$username,
      'datetime'=>$datetime,
      'status'=>$status,
      'remarks'=>$remarks,
    );

    $this->db->where('id',$inquiry_id);
    $this->db->update('inquiry',$inq_tbl);

    return $this->db->insert('inquiry_status', $data);
  }

  public function update_registered($inquiryId) {
    $data = array(
      'is_pending'=>0,
      'is_failed'=>0,
      'is_positive'=>0,
      'is_registered'=>1
    );

    $this->db->where('id',$inquiryId);
    return $this->db->update('inquiry',$data);
  }

  public function get_inquiry_by_id($inquiry_id) {
    $this->db->select('inquiry.*, course.name AS courseName');
    $this->db->join('course','course.id=inquiry.course','inner');
    $this->db->where('inquiry.id',$inquiry_id);
    $query = $this->db->get('inquiry');

    return $query->result_array();
  }

  public function search_student() {
    $value = $this->input->get('value');
    $by = $this->input->get('by');

    $this->db->select('inquiry.*,course.name AS courseName');
    $this->db->join('course','course.id=inquiry.course','inner');
    $this->db->or_where('is_positive',1);
    $this->db->or_where('is_pending',1);
    $this->db->like('inquiry.'.$by,$value,'right');
    $query = $this->db->get('inquiry');

    return $query->result_array();

  }

  public function get_intake_dates() {
    $intakeId = $this->input->post('intakeId');

    $this->db->where('id',$intakeId);
    $query = $this->db->get('intakes');
    return $query->result_array();
  }

  public function get_target_by_course() {
    $intakeId = $this->input->get('intakeId');
    $courseId = $this->input->get('courseId');

    $this->db->select('courseId,SUM(target) as target');
    $this->db->where('intakeId',$intakeId);
    $this->db->where('courseId',$courseId);;
    $query = $this->db->get('targets');
    return $query->result_array();
  }

  public function get_target_by_course_username() {
    $intakeId = $this->input->get('intakeId');
    $courseId = $this->input->get('courseId');
    $username = $this->input->get('username');

    $this->db->where('intakeId',$intakeId);
    $this->db->where('courseId',$courseId);
    $this->db->where('username',$username);
    $query = $this->db->get('targets');
    return $query->result_array();
  }

  public function count_inquiries_by_course() {
    $type = $this->input->get('type');
    $courseId = $this->input->get('courseId');
    $startDate = $this->input->get('startDate');
    $endDate = $this->input->get('endDate');

    $this->db->select('course,COUNT(id) AS inquiries');
    $this->db->where('course',$courseId);
    $this->db->where('datetime BETWEEN "'.$startDate.'" AND "'.$endDate.'"');
    $this->db->where($type,1);

    $query = $this->db->get('inquiry');
    return $query->result_array();
  }

  public function count_inquiries_by_course_username() {
    $type = $this->input->get('type');
    $courseId = $this->input->get('courseId');
    $startDate = $this->input->get('startDate');
    $endDate = $this->input->get('endDate');
    $username = $this->input->get('username');

    $this->db->select('course, COUNT(id) AS inquiries');
    $this->db->where('course',$courseId);
    $this->db->where('username',$username);
    $this->db->where('datetime BETWEEN "'.$startDate.'" AND "'.$endDate.'"');
    $this->db->where($type,1);

    $query = $this->db->get('inquiry');
    return $query->result_array();
  }

  public function get_inquiry_sources_by_course($courseId,$startDate,$endDate) {
    $this->db->select('inquiry_reference.reference, COUNT(inquiry.id) AS count');
    $this->db->join('inquiry','inquiry.reference=inquiry_reference.id');

    if($courseId!="") {
      $this->db->where('inquiry.course',$courseId);
    }

    $this->db->where('(inquiry.datetime BETWEEN "'.$startDate.'" AND "'.$endDate.'")');
    $this->db->group_by('inquiry_reference.reference');

    $query = $this->db->get('inquiry_reference');

    return $query->result_array();
  }

  public function search_inquiries($mobile) {
    $this->db->select('inquiry.*,course.name as courseName');
    $this->db->where('mobile',$mobile);
    $this->db->where('is_registered',0);
    $this->db->where('is_failed',0);
    $this->db->join('course','course.id=inquiry.course','inner');
    $query = $this->db->get('inquiry');

    return $query->result_array();
  }

}

 ?>
