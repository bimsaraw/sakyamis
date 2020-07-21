<?php

class Enrollment_model extends CI_Model {

  public function __construct() {
    $this->load->database();
  }

  public function get_students() {
    $query = $this->db->get('student');

    return $query->result_array();
  }

  public function get_student_by_id($studentId) {
    $this->db->where('studentId',$studentId);
    $query = $this->db->get('student');

    return $query->row();
  }

  public function get_students_enrolled($courseId) {
    $this->db->select('course_enroll.*,student.*,course.name AS courseName, payment_plan.name AS pplan_name, intakes.name AS intakeName, batch.name AS batchName, inquiry.username AS counselor');
    $this->db->join('student','student.studentId = course_enroll.studentId','inner');
    $this->db->join('course','course.id=course_enroll.courseId');
    $this->db->join('inquiry','inquiry.id=course_enroll.inquiryId');
    $this->db->join('payment_plan','payment_plan.id=course_enroll.pplanId');
    $this->db->join('batch','batch.id=course_enroll.batchId');
    $this->db->join('intakes','intakes.id=course_enroll.intakeId');
    $this->db->where('course_enroll.courseId',$courseId);
    $this->db->order_by('course_enroll.datetime','DESC');

    $query = $this->db->get('course_enroll');

    return $query->result_array();
  }

  public function get_latest_enrollment($studentId,$courseId) {
    $this->db->select('course_enroll.*,student.*,course.name AS courseName, payment_plan.name AS pplan_name, intakes.name AS intakeName, batch.name AS batchName, inquiry.username AS counselor');
    $this->db->join('student','student.studentId = course_enroll.studentId','inner');
    $this->db->join('course','course.id=course_enroll.courseId');
    $this->db->join('inquiry','inquiry.id=course_enroll.inquiryId');
    $this->db->join('payment_plan','payment_plan.id=course_enroll.pplanId');
    $this->db->join('batch','batch.id=course_enroll.batchId');
    $this->db->join('intakes','intakes.id=course_enroll.intakeId');
    $this->db->where('course_enroll.courseId',$courseId);
    $this->db->where('course_enroll.studentId',$studentId);

    $query = $this->db->get('course_enroll');

    return $query->result_array();
  }

  public function get_latest_enrollment_duplicate($studentId,$courseId) {
    $this->db->select('course_enroll.*,student.*,course.name AS courseName, payment_plan.name AS pplan_name, intakes.name AS intakeName, batch.name AS batchName, inquiry.username AS counselor');
    $this->db->join('student','student.studentId = course_enroll.studentId','inner');
    $this->db->join('course','course.id=course_enroll.courseId');
    $this->db->join('inquiry','inquiry.id=course_enroll.inquiryId');
    $this->db->join('payment_plan','payment_plan.id=course_enroll.pplanId');
    $this->db->join('batch','batch.id=course_enroll.batchId');
    $this->db->join('intakes','intakes.id=course_enroll.intakeId');
    $this->db->where('course_enroll.courseId',$courseId);
    $this->db->where('course_enroll.inquiryId',$studentId);

    $query = $this->db->get('course_enroll');

    return $query->result_array();
  }

  public function check_student_exist($nic) {
    $this->db->where('nic',$nic);
    $student = $this->db->get('student');

    if($student->num_rows()>0) {
      return $student->row()->studentId;
    } else {
      return false;
    }


  }

  public function generate_student_id($courseId,$nic,$intakeId) {
    $this->db->where('nic',$nic);
    $check = $this->db->get('student');

    if($check->num_rows() > 0) {
      $this->db->where('nic',$nic);
      $student = $this->db->get('student')->row();

      return $student->studentId;
    } else {
      $this->db->where('id',$intakeId);
      $intake = $this->db->get('intakes');
      $intakeYear = $intake->row()->endDate;

      $courseId = sprintf("%02d", $courseId);
      $searchId = date('y', strtotime($intakeYear)).'S'.$courseId;

      $this->db->like('studentId',$searchId,'both');
      $this->db->order_by('studentId','DESC');
      $currentId = $this->db->get('student',1);

      if($currentId->num_rows() > 0) {
        $row = $currentId->row();

        $next = sprintf("%03d",substr($row->studentId,-3)+1);
        $nextId = $searchId.$next;

        return $nextId;

      } else {
        $nextId = $searchId.'001';
        return $nextId;
      }
    }
  }

  public function save_student_data($studentId) {
    $inquiryId = $this->input->post('inquiryId');
    $title = $this->input->post('title');
    $full_name = $this->input->post('full_name');
    $initial_name = $this->input->post('initials_name');
    $dob = $this->input->post('dob');
    $gender = $this->input->post('gender');
    $nic = $this->input->post('nic');
    $nationality = $this->input->post('nationality');
    $address = $this->input->post('address');
    $city = $this->input->post('city');
    $country = $this->input->post('country');
    $mobile = $this->input->post('mobile');
    $home = $this->input->post('home');
    $email = $this->input->post('email');
    $schools = $this->input->post('schools');
    $ol = $this->input->post('ol');
    $ol_year = $this->input->post('ol_year');
    $al = $this->input->post('al');
    $stream = $this->input->post('stream');
    $al_year = $this->input->post('al_year');
    $other_edu = $this->input->post('other_edu');
    $guardian_name = $this->input->post('guardian_name');
    $relationship = $this->input->post('relationship');
    $guardian_mobile = $this->input->post('guardian_mobile');
    $guardian_home = $this->input->post('guardian_home');
    $birth_certificate = $this->input->post('birth_certificate');
    $ol_certificate = $this->input->post('ol_certificate');
    $al_certificate = $this->input->post('al_certificate');
    $nic_copy = $this->input->post('nic_copy');
    $other_certificates = $this->input->post('other_certificates');
    $remarks = $this->input->post('remarks');
    $date_time = date('Y-m-d h:i:sa');

    $data = array(
      'inquiryId' => $inquiryId,
      'title' => $title,
      'full_name' => $full_name,
      'initials_name' => $initial_name,
      'dob' => $dob,
      'gender' => $gender,
      'nic' => $nic,
      'nationality' => $nationality,
      'address' => $address,
      'city' => $city,
      'country' => $country,
      'mobile' => $mobile,
      'home' => $home,
      'email' => $email,
      'schools' => $schools,
      'ol' => $ol,
      'ol_year' => $ol_year,
      'al' => $al,
      'stream' => $stream,
      'al_year' => $al_year,
      'other_edu' => $other_edu,
      'guardian_name' => $guardian_name,
      'relationship' => $relationship,
      'guardian_mobile' => $guardian_mobile,
      'guardian_home' => $guardian_home,
      'birth_certificate' => $birth_certificate,
      'ol_certificate' => $ol_certificate,
      'al_certificate' => $al_certificate,
      'nic_copy' => $nic_copy,
      'other_certificates' => $other_certificates,
      'remarks' => $remarks,
      'datetime' => $date_time
    );

    $this->db->where('nic',$nic);
    $check = $this->db->get('student');

    if($check->num_rows() > 0) {
      $this->db->where('nic',$nic);

      if($this->db->update('student',$data)) {
        $this->db->where('nic',$nic);
        $student = $this->db->get('student')->row();

        return $student->studentId;
      }

    } else {
      $data['studentId'] = $studentId;

      return $this->db->insert('student',$data);
    }
  }

  public function course_enroll($studentId,$username) {
    $courseId = $this->input->post('courseId');
    $inquiryId = $this->input->post('inquiryId');
    $pplanId = $this->input->post('pplanId');
    $batchId = $this->input->post('batchId');
    $intakeId = $this->input->post('intakeId');
    $datetime = date('Y-m-d h:i:sa');

    $data = array(
      'studentId' => $studentId,
      'inquiryId' => $inquiryId,
      'courseId' => $courseId,
      'pplanId' => $pplanId,
      'batchId' => $batchId,
      'intakeId' => $intakeId,
      'datetime' => $datetime,
      'username' => $username
    );

    $this->db->where('studentId',$studentId);
    $this->db->where('courseId',$courseId);
    $check = $this->db->get('course_enroll');

    if($check->num_rows() > 0) {
      return false;
    } else {
      return $this->db->insert('course_enroll',$data);
    }
  }

  public function save_student_data_bulk($row) {

    $data = array(
      'studentId' => $row['studentId'],
      'inquiryId' => $row['inquiryId'],
      'title' => $row['title'],
      'full_name' => $row['full_name'],
      'initials_name' => $row['initial_name'],
      'dob' => $row['dob'],
      'gender' => $row['gender'],
      'nic' => $row['nic'],
      'nationality' => $row['nationality'],
      'address' => $row['address'],
      'city' => $row['city'],
      'country' => $row['country'],
      'mobile' => $row['mobile'],
      'home' => $row['home'],
      'email' => $row['email'],
      'schools' => $row['schools'],
      'ol' => $row['ol'],
      'ol_year' => $row['ol_year'],
      'al' => $row['al'],
      'stream' => $row['stream'],
      'al_year' => $row['al_year'],
      'other_edu' => $row['other_edu'],
      'guardian_name' => $row['guardian_name'],
      'relationship' => $row['relationship'],
      'guardian_mobile' => $row['guardian_mobile'],
      'guardian_home' => $row['guardian_home'],
      'birth_certificate' => $row['birth_certificate'],
      'ol_certificate' => $row['ol_certificate'],
      'al_certificate' => $row['al_certificate'],
      'nic_copy' => $row['nic_copy'],
      'other_certificates' => $row['other_certificates'],
      'remarks' => $row['remarks'],
      'datetime' => $row['date_registered']
    );

    $this->db->where('nic',$row['nic']);
    $check = $this->db->get('student');

    if($check->num_rows() > 0) {
      $this->db->where('nic',$row['nic']);

      return $this->db->update('student',$data);

    } else {
      $data['studentId'] = $studentId;

      return $this->db->insert('student',$data);
    }
  }

  public function course_enroll_bulk($row) {
    print_r($row);
    $studentId = $row['studentId'];
    $courseId = $row['courseId'];
    $inquiryId = $row['inquiryId'];
    $pplanId = $row['pplanId'];
    $batchId = $row['batchId'];
    $intakeId = $row['intakeId'];
    $datetime = $row['date_registered'];

    $data = array(
      'studentId' => $studentId,
      'inquiryId' => $inquiryId,
      'courseId' => $courseId,
      'pplanId' => $pplanId,
      'batchId' => $batchId,
      'intakeId' => $intakeId,
      'datetime' => $datetime,
      'username' => $username
    );

    $this->db->where('studentId',$studentId);
    $this->db->where('courseId',$courseId);
    $check = $this->db->get('course_enroll');

    if($check->num_rows() > 0) {
      return false;
    } else {
      return $this->db->insert('course_enroll',$data);
    }
  }

  public function validate_nic() {
    $nic = $this->input->post('nic');
    $this->db->where('nic',$nic);
    $query = $this->db->get('student');

    if($query->num_rows() > 0) {
      return false;
    } else {
      return true;
    }
  }

  public function studentId_by_nic() {
    $nic = $this->input->post('nic');
    $this->db->where('nic',$nic);
    $query = $this->db->get('student');

    if($query->num_rows() > 0) {
      return $query->row();
    } else {
      return false;
    }
  }

  public function search_student_by_id() {
    $studentId = $this->input->get('studentId');

    $this->db->where('studentId',$studentId);

    $query = $this->db->get('student');

    return $query->result_array();
  }

  public function get_enrolled_students_by_course() {
    $courseId = $this->input->get('courseId');
    $intakeId = $this->input->get('intakeId');
    $username = $this->input->get('username');

    $this->db->select('course_enroll.courseId, COUNT(course_enroll.studentId) AS inquiries');
    $this->db->join('inquiry','course_enroll.inquiryId=inquiry.id');
    $this->db->where('course_enroll.intakeId',$intakeId);
    $this->db->where('course_enroll.courseId',$courseId);
    if($username != "") {
      $this->db->where('inquiry.username',$username);
    }

    $query = $this->db->get('course_enroll');
    return $query->result_array();
  }

  public function get_registered_students_by_course() {
    $courseId = $this->input->get('courseId');
    $intakeId = $this->input->get('intakeId');
    $username = $this->input->get('username');

    $this->db->select('course_enroll.courseId, COUNT(course_enroll.studentId) AS inquiries');
    $this->db->join('inquiry','course_enroll.inquiryId=inquiry.id');
    $this->db->where('course_enroll.intakeId',$intakeId);
    $this->db->where('course_enroll.is_enroll_valid','1');
    $this->db->where('course_enroll.courseId',$courseId);
    if($username != "") {
      $this->db->where('inquiry.username',$username);
    }

    $query = $this->db->get('course_enroll');
    return $query->result_array();
  }

  public function get_unconfirmed_by_id($inquiryId) {
    $this->db->select('student.*,student.is_valid AS student_valid,course_enroll.*,course.name AS courseName,batch.name AS batchName,intakes.name AS intakeName,payment_plan.name AS paymentplanName');
    $this->db->join('student','course_enroll.studentId=student.studentId');
    $this->db->join('batch','batch.id=course_enroll.batchId');
    $this->db->join('course','course.id=course_enroll.courseId');
    $this->db->join('intakes','intakes.id=course_enroll.intakeId');
    $this->db->join('payment_plan','payment_plan.id=course_enroll.pplanId');
    $this->db->where('course_enroll.inquiryId',$inquiryId);

    $query = $this->db->get('course_enroll');
    return $query->result_array();
  }

  public function get_course_enrollments_by_id($studentId) {
    $this->db->select('course_enroll.*,course.name AS courseName,batch.name AS batchName,intakes.name AS intakeName,payment_plan.name AS paymentplanName');
    $this->db->join('student','course_enroll.studentId=student.studentId');
    $this->db->join('batch','batch.id=course_enroll.batchId');
    $this->db->join('course','course.id=course_enroll.courseId');
    $this->db->join('intakes','intakes.id=course_enroll.intakeId');
    $this->db->join('payment_plan','payment_plan.id=course_enroll.pplanId');
    $this->db->where('course_enroll.studentId',$studentId);

    $query = $this->db->get('course_enroll');
    return $query->result_array();
  }

  public function edit_course_enrollment($studentId,$courseId) {
    $this->db->select('course_enroll.*,course.name AS courseName,batch.name AS batchName,intakes.name AS intakeName,payment_plan.name AS paymentplanName');
    $this->db->join('student','course_enroll.studentId=student.studentId');
    $this->db->join('batch','batch.id=course_enroll.batchId');
    $this->db->join('course','course.id=course_enroll.courseId');
    $this->db->join('intakes','intakes.id=course_enroll.intakeId');
    $this->db->join('payment_plan','payment_plan.id=course_enroll.pplanId');
    $this->db->where('course_enroll.studentId',$studentId);
    $this->db->where('course_enroll.courseId',$courseId);

    $query = $this->db->get('course_enroll');
    return $query->result_array();
  }

  public function update_personal_details() {
    $studentId = $this->input->post('studentId');
    $title = $this->input->post('title');
    $full_name = $this->input->post('full_name');
    $initial_name = $this->input->post('initials_name');
    $dob = $this->input->post('dob');
    $gender = $this->input->post('gender');
    $nic = $this->input->post('nic');
    $nationality = $this->input->post('nationality');
    $address = $this->input->post('address');
    $city = $this->input->post('city');
    $country = $this->input->post('country');
    $mobile = $this->input->post('mobile');
    $home = $this->input->post('home');
    $email = $this->input->post('email');

    $data = array(
      'studentId' => $studentId,
      'title' => $title,
      'full_name' => $full_name,
      'initials_name' => $initial_name,
      'dob' => $dob,
      'gender' => $gender,
      'nic' => $nic,
      'nationality' => $nationality,
      'address' => $address,
      'city' => $city,
      'country' => $country,
      'mobile' => $mobile,
      'home' => $home,
      'email' => $email
    );
    $this->db->where('studentId',$studentId);
    if($this->db->update('student',$data)) {
      return true;
    }
  }

  public function update_education_details() {
    $studentId = $this->input->post('studentId');
    $schools = $this->input->post('schools');
    $ol = $this->input->post('ol');
    $ol_year = $this->input->post('ol_year');
    $al = $this->input->post('al');
    $stream = $this->input->post('stream');
    $al_year = $this->input->post('al_year');
    $other_edu = $this->input->post('other_edu');

    $data = array(
      'studentId' => $studentId,
      'schools' => $schools,
      'ol' => $ol,
      'ol_year' => $ol_year,
      'al' => $al,
      'stream' => $stream,
      'al_year' => $al_year,
      'other_edu' => $other_edu,
    );
    $this->db->where('studentId',$studentId);
    if($this->db->update('student',$data)) {
      return true;
    }
  }

  public function update_guardian_details() {
    $studentId = $this->input->post('studentId');
    $guardian_name = $this->input->post('guardian_name');
    $relationship = $this->input->post('relationship');
    $guardian_mobile = $this->input->post('guardian_mobile');
    $guardian_home = $this->input->post('guardian_home');

    $data = array(
      'studentId' => $studentId,
      'guardian_name' => $guardian_name,
      'relationship' => $relationship,
      'guardian_mobile' => $guardian_mobile,
      'guardian_home' => $guardian_home,
    );
    $this->db->where('studentId',$studentId);
    if($this->db->update('student',$data)) {
      return true;
    }
  }

  public function update_enrollment_details() {
    $studentId = $this->input->post('studentId');
    $birth_certificate = $this->input->post('birth_certificate');
    $ol_certificate = $this->input->post('ol_certificate');
    $al_certificate = $this->input->post('al_certificate');
    $nic_copy = $this->input->post('nic_copy');
    $other_certificates = $this->input->post('other_certificates');
    $remarks = $this->input->post('remarks');

    $data = array(
      'studentId' => $studentId,
      'birth_certificate' => $birth_certificate,
      'ol_certificate' => $ol_certificate,
      'al_certificate' => $al_certificate,
      'nic_copy' => $nic_copy,
      'other_certificates' => $other_certificates,
      'remarks' => $remarks,
    );
    $this->db->where('studentId',$studentId);
    if($this->db->update('student',$data)) {
      return true;
    }
  }

  public function update_image($image,$studentId) {
    $data = array(
      'studentId' => $studentId,
      'image' => $image
    );

    $this->db->where('studentId',$studentId);

    if($this->db->update('student',$data)) {
        return true;
    } else {
      return false;
    }
  }

  public function confirm_enrollment($studentId,$courseId) {
    $data = array(
      'is_enroll_valid' => 1
    );

    $this->db->where('studentId',$studentId);
    $this->db->where('courseID',$courseId);

    if($this->db->update('course_enroll',$data)) {
        return true;
    } else {
      return false;
    }
  }

  public function confirm_student($studentId) {
    $data = array(
      'is_valid' => 1
    );

    $this->db->where('studentId',$studentId);

    if($this->db->update('student',$data)) {
        return true;
    } else {
      return false;
    }
  }

  public function update_course_enrollment() {
    $studentId = $this->input->post('studentId');
    $courseId = $this->input->post('courseId');
    $batchId = $this->input->post('batchId');

    $data = array(
      'batchId' => $batchId
    );

    if(isset($_POST['pplanId'])) {
      $pplanId = $this->input->post('pplanId');
      $data['pplanId'] = $pplanId;
    } 

    $this->db->where('studentId',$studentId);
    $this->db->where('courseId',$courseId);

    if($this->db->update('course_enroll',$data)) {
        return true;
    } else {
      return false;
    }
  }

  public function filter_students() {
    $full_name = $this->input->post('full_name');
    $courseId = $this->input->post('courseId');
    $intakeId = $this->input->post('intakeId');
    $batchId = $this->input->post('batchId');
    $is_valid = $this->input->post('is_valid');
    $username = $this->input->post('username');

    $this->db->select('course_enroll.*,student.*,course.name AS courseName, payment_plan.name AS pplan_name, intakes.name AS intakeName, batch.name AS batchName, inquiry.username AS counselor');
    $this->db->join('student','student.studentId = course_enroll.studentId','inner');
    $this->db->join('course','course.id=course_enroll.courseId');
    $this->db->join('inquiry','inquiry.id=course_enroll.inquiryId');
    $this->db->join('payment_plan','payment_plan.id=course_enroll.pplanId');
    $this->db->join('batch','batch.id=course_enroll.batchId');
    $this->db->join('intakes','intakes.id=course_enroll.intakeId');

    if($full_name!="") {
      $this->db->like('student.full_name',$full_name);
    }

    if($courseId!="") {
      $this->db->where('course_enroll.courseId',$courseId);
    }

    if($intakeId!="") {
      $this->db->where('course_enroll.intakeId',$intakeId);
    }

    if($batchId!="") {
      $this->db->where('course_enroll.batchId',$batchId);
    }

    if($username!="") {
      $this->db->where('inquiry.username',$username);
    }

    if($is_valid!="") {
      $this->db->where('course_enroll.is_enroll_valid',$is_valid);
    }

    $this->db->order_by('student.studentId','DESC');

    $query = $this->db->get('course_enroll');

    return $query->result_array();
  }

  public function filter_students_by_user($username) {
    $full_name = $this->input->post('full_name');
    $courseId = $this->input->post('courseId');
    $intakeId = $this->input->post('intakeId');
    $batchId = $this->input->post('batchId');
    $is_valid = $this->input->post('is_valid');

    $this->db->select('course_enroll.*,student.*,course.name AS courseName, payment_plan.name AS pplan_name, intakes.name AS intakeName, batch.name AS batchName, inquiry.username AS counselor');
    $this->db->join('student','student.studentId = course_enroll.studentId','inner');
    $this->db->join('course','course.id=course_enroll.courseId');
    $this->db->join('inquiry','inquiry.id=course_enroll.inquiryId');
    $this->db->join('payment_plan','payment_plan.id=course_enroll.pplanId');
    $this->db->join('batch','batch.id=course_enroll.batchId');
    $this->db->join('intakes','intakes.id=course_enroll.intakeId');

    if($full_name!="") {
      $this->db->like('student.full_name',$full_name);
    }

    if($courseId!="") {
      $this->db->where('course_enroll.courseId',$courseId);
    }

    if($intakeId!="") {
      $this->db->where('course_enroll.intakeId',$intakeId);
    }

    if($batchId!="") {
      $this->db->where('course_enroll.batchId',$batchId);
    }

    if($is_valid!="") {
      $this->db->where('course_enroll.is_enroll_valid',$is_valid);
    }

    $this->db->where('inquiry.username',$username);

    $this->db->order_by('student.studentId','DESC');

    $query = $this->db->get('course_enroll');

    return $query->result_array();
  }

  public function save_correction($studentId, $inquiryId, $batchId) {

    $this->db->where('studentId',$studentId);
    $this->db->where('inquiryId',$inquiryId);
    $find = $this->db->get('course_enroll');

    if($find->num_rows() > 0) {
      $data = array(
        'batchId'=> $batchId
      );

      $this->db->where('studentId',$studentId);
      $this->db->where('inquiryId',$inquiryId);

      return $this->db->update('course_enroll', $data);
    }
  }

  public function save_dropouts($studentId, $courseId) {

    $this->db->where('studentId',$studentId);
    $this->db->where('courseId',$courseId);
    $find = $this->db->get('course_enroll');

    if($find->num_rows() > 0) {
      $data = array(
        'is_dropout'=> 1
      );

      $this->db->where('studentId',$studentId);
      $this->db->where('courseId',$courseId);

      return $this->db->update('course_enroll', $data);
    }
  }

}
