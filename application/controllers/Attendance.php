<?php

class Attendance extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->library('session');
    $this->load->model('payment_model');
    $this->load->model('enrollment_model');
    $this->load->model('batch_model');
    $this->load->model('user_model');
    $this->load->model('inquiry_model');
    $this->load->model('attendance_model');
    $this->load->model('allocation_model');
    $this->load->model('branches_model');
    $this->load->model('course_model');
    $this->load->helper('url_helper');
    $this->load->helper('url');
    $this->load->helper('form');
  }

  public function index() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,24)) {
      $data['title'] = 'Student Attendance - Entrance';

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('attendance/index', $data);
      $this->load->view('templates/footer');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function classroom_attendance() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,24)) {
      $data['title'] = 'Student Attendance - Classroom';

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('attendance/classroom_attendance', $data);
      $this->load->view('templates/footer');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function automated() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,24)) {
      $data['title'] = 'Student-Attendance-Automated';
      $data['branches'] = $this->branches_model->get_branch_byuser($username);
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('attendance/automated', $data);
      $this->load->view('templates/footer');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function full_screen_automated() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,24)) {
      $data['title'] = 'Student Attendance - Entrance';
      $data['branches'] = $this->branches_model->get_branch_byuser($username);
      $this->load->view('attendance/full_screen_automated', $data);
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function full_screen() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,24)) {
      $data['title'] = 'Student Attendance - Entrance';

      $this->load->view('attendance/full_screen', $data);
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function full_screen_class() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,24)) {
      $data['title'] = 'Student Attendance - Classroom';

      $this->load->view('attendance/full_screen_class', $data);
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  
  public function mark_attendance_entrance() {
    $studentId = $this->input->post('studentId');
    $date = date('Y-m-d');
    $time = date('H:i:sa');

    if($response = $this->payment_model->validate_payments($studentId,$date)) {
      if($response == 1) {
        echo 'success';
        $this->attendance_model->save_attendance($studentId,$date,$time,0,'');
      } else {
        header('Content-Type: application/json');
        $this->attendance_model->save_attendance($studentId,$date,$time,1,'Pending Payments');
        echo json_encode( $response );
      }
    }
  }

  //classroom attendance section
  public function mark_attendance_classroom() {
    $date = date('Y-m-d');
    $time = date('H:i:sa');
    $studentId = $this->input->post('studentId');
    $allocate_id =$this->input->post('allocate_id');
    $branch =$this->input->post('branchId');

    $checkatt = $this->attendance_model->check_attendance($studentId,$date,$allocate_id);
    if ($checkatt) {
      echo 'Already Marked..!';
    } else {
        $response_cs = $this->check_clss_attendance($studentId,$allocate_id);
      //  echo Json_encode ($response_cs);
        if($response_cs==1){
          if($response = $this->payment_model->validate_payments($studentId,$date)) {
            if($response == 1) {
              $this->attendance_model->save_attendance_classroom($studentId,$date,$time,$allocate_id);
              echo 'Batch Pass..';
            } else {
              header('Content-Type: application/json');
              $this->attendance_model->save_attendance_classroom($studentId,$date,$time,$allocate_id);
              echo json_encode( $response );
            }
          }
        }else if ($response_cs==0){
          echo 'batch fail..!';
        }else if($response_cs==2){
          echo 'invalide..!';
        }
    }
  }

  //classroom attendance section
  public function mark_attendance_classroom_automated() {
    $date = date('Y-m-d');
    $time = date('H:i:sa');
    $studentId = $this->input->post('studentId');
    //$allocate_id =$this->input->post('allocate_id');
    $branch =$this->input->post('branchId');

    $Nallocates = $this->get_automated_allocatedDetails($studentId,$branch);
    
    if(is_array($Nallocates)) {
      foreach($Nallocates as $Nallocate){
        $allocate_id= $Nallocate['id'];  //set to automated allocate Id
      }
          $checkatt = $this->attendance_model->check_attendance($studentId,$date,$allocate_id);
          if ($checkatt) {
            echo 'AlreadyMarked!';
          } else {
              $response_cs = $this->check_clss_attendance($studentId,$allocate_id);
            //  echo Json_encode ($response_cs);
              if($response_cs==1){
                if($response = $this->payment_model->validate_payments($studentId,$date)) {
                  if($response == 1) {
                    $this->attendance_model->save_attendance_classroom($studentId,$date,$time,$allocate_id);
                    echo 'BatchPass!';
                  } else {
                    header('Content-Type: application/json');
                    $this->attendance_model->save_attendance_classroom($studentId,$date,$time,$allocate_id);
                    $data=array(
                      'payments'=> $response,
                       'allocate' => $Nallocates);
                    echo json_encode($data);
                  }
                }
              }else if ($response_cs==0){
                echo 'batchfail!';
              }else if($response_cs==2){
                echo 'invalid!';
              }
          }
      } else {
        echo $Nallocates;
      }
  }

//classroom attendance section
  public function check_clss_attendance($studentId,$allocate_id) {
    $ac= array(); // allocate schedulu cours ID get to array
    $sec= array();  // Student enroll course ID'S get to array
    //student_allocate()
    $allocate =$this->attendance_model->allocate_course($allocate_id); // schedule course Id
    foreach ($allocate as $allc){
      $acVal = $allc['courseId'];
      array_push($ac, $acVal);
    }
   // student_course
   $course_e = $this->attendance_model->student_course($studentId);
   $courseERows= COUNT($course_e);
      foreach ($course_e as $ce){
        $cecVal= $ce['courseId'];
        array_push($sec,$cecVal);
      }
      if ($courseERows>=1) {
        $result=array_intersect($ac,$sec);
        $ArrayPass = COUNT($result);
             
        if ($ArrayPass==1){
          return 1;
        } else{
          return 0;
        }
      }else {
        return 2;
      }       
  }

  public function get_automated_allocatedDetails($studentId,$branch) {
    
    $sec= array(); // student enroll courses
    $tnac = array();

    $date = date('Y-m-d');
    $beforeTime=  date("H:i:s", strtotime("-29 minutes"));
    $afterTime=  date("H:i:s", strtotime("+29 minutes"));
 
    $course_e = $this->attendance_model->student_course($studentId);
    $courseERows= COUNT($course_e);
       foreach ($course_e as $ce){
         $studentEnroll_CIds= $ce['courseId'];
         array_push($sec,$studentEnroll_CIds);
       }

       $secCount= COUNT($sec);

    if ($secCount>=1) {
    
      $nerest_course = $this->allocation_model->timeNerest_allocate($branch,$date,$beforeTime,$afterTime);   
      
    $ncCount= COUNT($nerest_course);
    if($ncCount>=1) {
          foreach ($nerest_course as $nc){
              $Find_courseId= $nc['courseId'];
              array_push($tnac,$Find_courseId);
            }
          }
        
          $result=array_intersect($sec,$tnac);

          $final_courseId;
          $Rcount= COUNT($result);
          if($Rcount>=1) {
              foreach ($result as $fc){
                  $final_courseId=$fc;
                }
                $FinalAllocateId = $this->allocation_model->get_allocateDetails_bycourseId($branch,$date,$beforeTime,$afterTime,$final_courseId);   
                return $FinalAllocateId;
              }else {
            return 'Error!';
          }
      }else {
        return 'invalid!';
      }
  }


  public function get_schedule_name(){
    $allocate_id =$this->input->post('allocateId');
    $schedule_name = $this->attendance_model->get_schedule_name($allocate_id);
    echo $schedule_name ;
  }

  public function get_attendance_history() {
    $studentId = $this->input->post('studentId');
    $data = $this->attendance_model->get_attendance_history($studentId);
    header('Content-Type: application/json');
    echo json_encode( $data );
  }

  public function get_attendance_detail() {
    $username = $this->session->userdata('username');
      if($this->user_model->validate_permission($username,39)) { 
          $studentID= $this->input->post('studentId');
          $data = $this->attendance_model->get_attendance_detail($studentID);
          $this->user_model->save_user_log($username,'Viewed attendance report.');
          header('Content-Type: application/json');
          echo json_encode($data);
      } else {
        echo "no-perm";
      }
}



public function get_classroom_attendance_detail() {
  $username = $this->session->userdata('username');
    if($this->user_model->validate_permission($username,39)) { 
        $studentID= $this->input->post('studentId');
        $data = $this->attendance_model->get_classroom_attendance_detail($studentID);
        $this->user_model->save_user_log($username,'Viewed attendance report.');
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
      echo "no-perm";
    }
}



public function get_single_detail() {
  $username = $this->session->userdata('username');
  if($this->user_model->validate_permission($username,39)) { 
      $studentID= $this->input->post('studentId');
      $date= $this->input->post('date');
      $time= $this->input->post('time');
      $data = $this->attendance_model->get_single_detail($studentID,$date,$time);
      $this->user_model->save_user_log($username,'Viewed remarks of '.$studentID.' for '.$date);
      header('Content-Type: application/json');
      echo json_encode($data);
  } else {
    echo "no-perm";
  }
}

  public function entrance_report() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,39)) {
      $data['title'] = 'Student Attendance - Report';

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('attendance/entrance_report', $data);
      $this->load->view('templates/footer');

      $this->user_model->save_user_log($username,'Viewed attendance report.');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function classroom_report() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,39)) {
      $data['title'] = 'Student Attendance - Report';

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('attendance/classroom_report', $data);
      $this->load->view('templates/footer');

      $this->user_model->save_user_log($username,'Viewed attendance report.');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function delete_attendance() {
    $username = $this->session->userdata('username');
    if($this->user_model->validate_permission($username,43)) {  
      $response = $this->attendance_model->delete_attendance();

      $id= $this->input->post('studentId');
     
      if($response) {
        $this->session->set_flashdata('info', 'Attendance Delete Successfully..!');

        $this->user_model->save_user_log($username,'Attendance deleted for '.$id);
        echo "success";
       
      } else {
        $this->session->set_flashdata('info', 'Attendance Delete Unsuccessfully..!');
        echo "unsuccess";
      }

    } else {
      echo "no-perm";
    }
  }

  public function delete_clss_attendance() {
    $username = $this->session->userdata('username');
    if($this->user_model->validate_permission($username,43)) {  
      $response = $this->attendance_model->delete_clss_attendance();

      $id= $this->input->post('studentId');
     
      if($response) {
        $this->session->set_flashdata('info', 'Attendance Delete Successfully..!');

        $this->user_model->save_user_log($username,'Attendance deleted for '.$id);
        echo "success";
       
      } else {
        $this->session->set_flashdata('info', 'Attendance Delete Unsuccessfully..!');
        echo "unsuccess";
      }

    } else {
      echo "no-perm";
    }
  }

  public function add_remark() {
    $username = $this->session->userdata('username');
    if($this->user_model->validate_permission($username,43)) {  
      $response = $this->attendance_model->add_remark();

      $id= $this->input->post('studentID');
     
      if($response) {
        $this->session->set_flashdata('info', 'Attendance remark added Successfully..!');
        $this->user_model->save_user_log($username,'Attendance remark added for '.$id);
        echo "success";
      } else {
        $this->session->set_flashdata('error', 'Attendance remark added Unsuccessfully..!');
          echo "unsuccess";
      }

    } else {
      echo "no-perm";
    }
  }

  public function change_status() {
    $username = $this->session->userdata('username');
    if($this->user_model->validate_permission($username,40)) {  
      $response = $this->attendance_model->change_status();

      $id= $this->input->post('studentId');
     
      if($response) {
        $this->session->set_flashdata('success', 'Attendance finance visit update Successfully..!');
        echo "success";
        $this->user_model->save_user_log($username,'Attendance status changed for '.$id);
      } else {
        $this->session->set_flashdata('danger', 'Attendance finance visit update Unsuccessfully..!'); 
        echo "unsuccess";
      }
    } else {
      echo "no-perm";
    }
  }

}
