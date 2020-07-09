<?php

class Enrollments extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->library('session');
    $this->load->model('payment_model');
    $this->load->model('enrollment_model');
    $this->load->model('batch_model');
    $this->load->model('user_model');
    $this->load->model('inquiry_model');
    $this->load->model('course_model');
    $this->load->helper('url_helper');
    $this->load->helper('url');
    $this->load->helper('form');
  }

  public function index() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,15)) {
      $data['title'] = 'Student Enrollments';

      $data['courses'] = $this->course_model->get_courses();
      $data['intakes'] = $this->inquiry_model->get_intakes();
      $data['batches'] = $this->batch_model->get_batches();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('enrollments/index', $data);
      $this->load->view('templates/footer');

      $this->user_model->save_user_log($username,'View student enrollments');

    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function enroll(){
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,13)) {
      $data['title'] = 'Enroll Student';

      $inquiryId = $this->input->get('inquiryId');

      $inquiries = $this->inquiry_model->get_inquiry_by_id($inquiryId);

      foreach($inquiries as $inquiry) {
        $data['inquiry_details'] = $inquiry;
      }

      $data['courses'] = $this->course_model->get_courses();
      $data['intakes'] = $this->inquiry_model->get_intakes();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('enrollments/enroll', $data);
      $this->load->view('templates/footer');

      $this->user_model->save_user_log($username,'Open enrollment form for inquiry id:'.$inquiryId);
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function course_enroll(){
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,13)) {
      $data['title'] = 'Enroll Student';

      $inquiryId = $this->input->get('inquiryId');
      $studentId = $this->input->get('studentId');

      $inquiries = $this->inquiry_model->get_inquiry_by_id($inquiryId);

      $data['student'] = $this->enrollment_model->get_student_by_id($studentId);

      foreach($inquiries as $inquiry) {
        $data['inquiry_details'] = $inquiry;
      }

      $data['courses'] = $this->course_model->get_courses();
      $data['intakes'] = $this->inquiry_model->get_intakes();
      $data['studentId'] = $studentId;

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('enrollments/course_enroll', $data);
      $this->load->view('templates/footer');

      $this->user_model->save_user_log($username,'Open enrollment form for inquiry id:'.$inquiryId);
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function modify_enroll() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,14)) {
      $data['title'] = 'Modify Student Details';

      $studentId = $this->input->get('studentId');

      $students = $this->enrollment_model->get_unconfirmed_by_id($studentId);

      $this->user_model->save_user_log($username,'Enrollment modification screen opened:'.$studentId);

      foreach($students as $student) {
        $data['student_details'] = $student;
      }

      $data['courses'] = $this->course_model->get_courses();
      $data['intakes'] = $this->inquiry_model->get_intakes();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('enrollments/edit', $data);
      $this->load->view('templates/footer');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function confirm_enroll() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,16)) {
      $data['title'] = 'Modify Student Details';

      $studentId = $this->input->get('studentId');

      $students = $this->enrollment_model->get_unconfirmed_by_id($studentId);

      foreach($students as $student) {
        $data['student_details'] = $student;
      }

      $data['courses'] = $this->course_model->get_courses();
      $data['intakes'] = $this->inquiry_model->get_intakes();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('enrollments/confirm_student', $data);
      $this->load->view('templates/footer');

      $this->user_model->save_user_log($username,'Confirmed student enrollment:'.$studentId);
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function check_student_exist() {
    $nic = $this->input->get('nic');
    $studentId = $this->enrollment_model->check_student_exist($nic);

    if($studentId=="") {
      $studentId = "Not Exists";
    }

    echo $studentId;
  }

  public function enroll_student() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,13)) {
      $courseId = $this->input->post('courseId');
      $intakeId = $this->input->post('intakeId');
      $nic = $this->input->post('nic');

      if($this->input->post('studentId')!="") {
        $studentId = $this->enrollment_model->check_student_exist($nic);

        if($studentId=="") {
          $studentId = $this->input->post('studentId');
        }

      } else {
        $studentId = $this->enrollment_model->generate_student_id($courseId,$nic,$intakeId);
      }

      if($this->enrollment_model->save_student_data($studentId)) {

        if($this->enrollment_model->course_enroll($studentId,$username)) {
          $this->inquiry_model->update_registered($this->input->post('inquiryId'));

          $data['title'] = 'Enrollment Status';

          $data['inquiryId'] = $this->input->post('inquiryId');
          $data['studentId'] = $studentId;
          $data['courseId'] = $courseId;
          $data['status'] = "success";

          $this->load->view('templates/header', $data);
          $this->load->view('templates/sidebar', $data);
          $this->load->view('enrollments/status', $data);
          $this->load->view('templates/footer');

          $this->user_model->save_user_log($username,'Student Enrolled:'.$studentId);

        } else {
          $data['title'] = 'Enrollment Status';

          $data['inquiryId'] = $this->input->post('inquiryId');
          $data['studentId'] = $studentId;
          $data['courseId'] = $courseId;
          $data['status'] = "error";

          $this->load->view('templates/header', $data);
          $this->load->view('templates/sidebar', $data);
          $this->load->view('enrollments/status', $data);
          $this->load->view('templates/footer');
        }
      } else {
        echo 'user_registration_error';
      }
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function print() {
    $this->load->library('pdfgenerator');

    $studentId = $this->input->get('studentId');
    $courseId = $this->input->get('courseId');

    $data['student'] = $this->enrollment_model->get_latest_enrollment($studentId,$courseId);
    $data['studentId'] = $studentId;

    $html = $this->load->view('enrollments/print', $data, true);
    $filename = 'report_'.time();
    //$this->load->view('enrollments/print', $data, true);
    $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
  }

  public function print_duplicate() {
    $this->load->library('pdfgenerator');

    $studentId = $this->input->get('inquiryId');
    $courseId = $this->input->get('courseId');

    $data['student'] = $this->enrollment_model->get_latest_enrollment_duplicate($studentId,$courseId);
    $data['studentId'] = $studentId;

    $html = $this->load->view('enrollments/print', $data, true);
    $filename = 'report_'.time();
    $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
  }

  public function validate_nic() {
    if($this->enrollment_model->validate_nic()) {
      echo 'success';
    } else {
      echo 'error';
    }
  }

  public function studentId_by_nic() {
    $response = $this->enrollment_model->studentId_by_nic();
    if(!$response) {
      echo 'no-student';
    } else {
      echo $response->studentId;
    }
  }

  public function get_enrolled_students_by_course() {
    if($data = $this->enrollment_model->get_enrolled_students_by_course()) {
      header('Content-Type: application/json');
      echo json_encode( $data );
    }
  }

  public function get_registered_students_by_course() {
    if($data = $this->enrollment_model->get_registered_students_by_course()) {
      header('Content-Type: application/json');
      echo json_encode( $data );
    }
  }

  public function update_personal_details() {
    if($this->enrollment_model->update_personal_details()) {
      echo 'success';
    } else {
      echo 'error';
    }
  }

  public function update_education_details() {
    if($this->enrollment_model->update_education_details()) {
      echo 'success';
    } else {
      echo 'error';
    }
  }

  public function update_guardian_details() {
    if($this->enrollment_model->update_guardian_details()) {
      echo 'success';
    } else {
      echo 'error';
    }
  }

  public function update_enrollment_details() {
    if($this->enrollment_model->update_enrollment_details()) {
      echo 'success';
    } else {
      echo 'error';
    }
  }

  public function get_students_enrolled() {
    $courseId = $this->input->get('courseId');
    if($data = $this->enrollment_model->get_students_enrolled($courseId)) {
      header('Content-Type: application/json');
      echo json_encode( $data );
    }
  }

  public function get_course_enrollments_by_id() {
    $studentId = $this->input->get('studentId');
    if($data = $this->enrollment_model->get_course_enrollments_by_id($studentId)) {
      header('Content-Type: application/json');
      echo json_encode( $data );
    }
  }

  public function update_image() {
    $config['upload_path']          = './uploads';
    $config['allowed_types']        = 'gif|jpg|png|jpeg';
    $config['max_size']             = 1024;

    $this->load->library('upload', $config);

    $inquiryId = $this->input->post('inquiryId');
    $studentId = $this->input->post('studentId');

    if ($this->upload->do_upload('image')) {
      $file = $this->upload->data();

      if($this->enrollment_model->update_image($file['file_name'],$studentId)) {

        $data['title'] = 'Modify Student Details';

        $students = $this->enrollment_model->get_unconfirmed_by_id($inquiryId);

        foreach($students as $student) {
          $data['student_details'] = $student;
        }

        $data['courses'] = $this->course_model->get_courses();
        $data['intakes'] = $this->inquiry_model->get_intakes();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('enrollments/edit', $data);
        $this->load->view('templates/footer');
      }
    }
  }

  public function print_studentId() {
    $this->load->library('pdfgenerator');
    $this->load->library('barcode');

    $studentId = $this->input->get('studentId');

    $data['student'] = $this->enrollment_model->get_student_by_id($studentId);
    $data['studentId'] = $studentId;

    //$this->load->view('enrollments/print_studentId', $data);

    $html = $this->load->view('enrollments/print_studentId', $data, true);
    $html = preg_replace('/>\s+</', "><", $html);
    $filename = 'report_'.time();
    $customPaper = array(0,0,243,153);
    $this->pdfgenerator->generate($html, $filename, true, $customPaper, 'portrait');
  }

  public function print_studentId_manual() {
    $config['upload_path']          = './uploads';
    $config['allowed_types']        = 'gif|jpg|png|jpeg';
    $config['max_size']             = 1024;

    $this->load->library('upload', $config);

    $data['studentId'] = $this->input->post('studentId');
    $data['initials_name'] = $this->input->post('initials_name');
    $data['nic'] = $this->input->post('nic');
    $data['title'] = $this->input->post('title');

    if ($this->upload->do_upload('image')) {
      $file = $this->upload->data();

      $this->load->library('pdfgenerator');
      $this->load->library('barcode');

      $data['image'] = $file['file_name'];

      //$this->load->view('enrollments/print_studentId', $data);

      $html = $this->load->view('enrollments/print_studentId_manual', $data, true);
      $html = preg_replace('/>\s+</', "><", $html);
      $filename = 'report_'.time();
      $customPaper = array(0,0,243,153);
      $this->pdfgenerator->generate($html, $filename, true, $customPaper, 'portrait');
    }
  }

  public function student_id() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,23)) {
      $data['title'] = 'Print Student ID';

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('enrollments/student_id', $data);
      $this->load->view('templates/footer');

    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function edit_course_enrollment() {
    $studentId = $this->input->get('studentId');
    $courseId = $this->input->get('courseId');
    $intakeId = $this->input->get('intakeId');

    $data['studentId'] = $studentId;
    $data['courseId'] = $courseId;

    $data['course_enroll'] = $this->enrollment_model->edit_course_enrollment($studentId,$courseId);

    $data['batches'] = $this->batch_model->get_batches_by_course_2($courseId);
    $data['payment_plans'] = $this->payment_model->get_payment_plans_by_intake_course($intakeId,$courseId);

    $data['title'] = 'Edit Course Enrollment';

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('enrollments/edit_course_enrollments', $data);
    $this->load->view('templates/footer');
  }

  public function update_course_enrollment() {
    if($this->enrollment_model->update_course_enrollment()) {
      echo 'success';
    } else {
      echo 'error';
    }
  }

  public function confirm_enrollment() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,27)) {
      $inquiryId = $this->input->get('inquiryId');
      $courseId = $this->input->get('courseId');
      $studentId = $this->input->get('studentId');

      if($this->enrollment_model->confirm_enrollment($studentId,$courseId)) {

        $data['title'] = 'Modify Student Details';

        $students = $this->enrollment_model->get_unconfirmed_by_id($inquiryId);

        foreach($students as $student) {
          $data['student_details'] = $student;
        }

        $data['courses'] = $this->course_model->get_courses();
        $data['intakes'] = $this->inquiry_model->get_intakes();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('enrollments/confirm_student', $data);
        $this->load->view('templates/footer');

        $this->user_model->save_user_log($username,'Student Enrollment Confirmed:'.$studentId);
      }
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function confirm_student() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,27)) {

      $inquiryId = $this->input->get('inquiryId');
      $studentId = $this->input->get('studentId');

      if($this->enrollment_model->confirm_student($studentId)) {

        $data['title'] = 'Modify Student Details';

        $students = $this->enrollment_model->get_unconfirmed_by_id($inquiryId);

        foreach($students as $student) {
          $data['student_details'] = $student;
        }

        $data['courses'] = $this->course_model->get_courses();
        $data['intakes'] = $this->inquiry_model->get_intakes();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('enrollments/confirm_student', $data);
        $this->load->view('templates/footer');

        $this->user_model->save_user_log($username,'Student Details Confirmed:'.$studentId);
      }
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function filter_students() {
    if($data = $this->enrollment_model->filter_students()) {
      header('Content-Type: application/json');
      echo json_encode( $data );
    }
  }

  public function search_student_by_id() {
    if($data = $this->enrollment_model->search_student_by_id()) {
      header('Content-Type: application/json');
      echo json_encode( $data );
    }
  }

  public function correction() {
    $data['title'] = 'Modify Student Details';

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('enrollments/correction', $data);
    $this->load->view('templates/footer');
  }

  public function mark_dropout() {
    $data['title'] = 'Mark Dropouts';

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('enrollments/mark_dropout', $data);
    $this->load->view('templates/footer');
  }

  public function save_dropouts() {
    $config['upload_path']          = './uploads/';
    $config['allowed_types']        = 'csv';
    $config['max_size']             = 100;
    $config['max_width']            = 1024;
    $config['max_height']           = 768;

    $this->load->library('upload', $config);

    if ( ! $this->upload->do_upload('dropout_file')) {
      $error = array('error' => $this->upload->display_errors());
      print_r($error);
    } else {
      $this->load->library('CSVReader');

      $file = $this->upload->data();
      $csvData = $this->csvreader->parse_csv($file['full_path']);

      if(!empty($csvData)){

        foreach($csvData as $row) {
          $studentId = $row['studentId'];
          $courseId = $row['courseId'];

          $this->enrollment_model->save_dropouts($studentId,$courseId);
        }

        $data['title'] = 'Mark Dropouts';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('enrollments/mark_dropout', $data);
        $this->load->view('templates/footer');
      }

    }
  }

  public function bulk_upload() {
    $data['title'] = 'Bulk Student Upload';

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('enrollments/bulk_upload', $data);
    $this->load->view('templates/footer');
  }

  public function bulk_uploadsave() {
    $config['upload_path']          = './uploads/';
    $config['allowed_types']        = 'csv';

    $this->load->library('upload', $config);

    if ( ! $this->upload->do_upload('bulk_file')) {
      $error = array('error' => $this->upload->display_errors());
      print_r($error);
    } else {
      $this->load->library('CSVReader');

      $file = $this->upload->data();
      $csvData = $this->csvreader->parse_csv($file['full_path']);

      print_r($csvData);

      if(!empty($csvData)){
        foreach($csvData as $row) {
          //$this->enrollment_model->save_student_data_bulk($row);
          //$this->enrollment_model->course_enroll_bulk($row);
        }

        $data['title'] = 'Bulk Student Upload';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('enrollments/bulk_upload', $data);
        $this->load->view('templates/footer');
      }

    }
  }

  public function save_correction() {
    $config['upload_path']          = './uploads/';
    $config['allowed_types']        = 'csv';
    $config['max_size']             = 100;
    $config['max_width']            = 1024;
    $config['max_height']           = 768;

    $this->load->library('upload', $config);

    if ( ! $this->upload->do_upload('correction_file')) {
      $error = array('error' => $this->upload->display_errors());
      print_r($error);
    } else {
      $this->load->library('CSVReader');

      $file = $this->upload->data();
      $csvData = $this->csvreader->parse_csv($file['full_path']);

      if(!empty($csvData)){

        foreach($csvData as $row) {
          $studentId = $row['studentId'];
          $inquiryId = $row['inquiryId'];
          $batchId = $row['batchId'];

          $this->enrollment_model->save_correction($studentId,$inquiryId,$batchId);
        }

        $data['title'] = 'Modify Student Details';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('enrollments/correction', $data);
        $this->load->view('templates/footer');
      }

    }
  }

}

?>
