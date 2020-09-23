<?php

class Exam extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('exam_model');
        $this->load->model('branches_model');
        $this->load->model('allocation_model');
        $this->load->model('batch_model');
        $this->load->model('module_model');
        $this->load->model('user_model');
        $this->load->helper('url_helper');
        $this->load->helper('form');
    }

    public function index() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,44)) {
        $data['title'] = 'Exams';

        $data['exams'] = $this->exam_model->get_exams();

        $this->user_model->save_user_log($username,'Viewed lecturers.');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('exam/index', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function results_summary(){
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,44)) {
        $data['title'] = 'Exams Result Summary';
        $examId=  $this->input->get('examId'); 
        $data['results'] = $this->exam_model->get_examsresult_by_examId($examId);
        $data['exam'] = $this->exam_model->get_single_exam($examId);

        $this->user_model->save_user_log($username,'Viewed exam result summary.');

        $this->load->view('templates/report_header', $data);
        $this->load->view('exam/report_exam_summ', $data);
        $this->load->view('templates/report_footer');

      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function marks() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,44)) {
        $data['title'] = 'Exam Marks';

        $data['exams'] = $this->exam_model->get_exams();

        $this->user_model->save_user_log($username,'Viewed lecturers.');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('exam/marks', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function batch_result_summ() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,44)) {
        $data['title'] = 'Batch Graded Summary';

        $batchId = $this->input->GET('batchId');
        $topArray=array();
        $rowArray= array();
        $modules= $this->exam_model->get_modules_byBatch($batchId);
        $data['branches'] = $this->branches_model->get_branch_byuser($username);

        $students = $this->batch_model->get_batch_students($batchId);
        
        foreach($students as $student){
          $studentId = $student['studentId'];
          $total =0;
          $moduleCount = 0;
          array_push($rowArray,$studentId);
          foreach($modules as $module){
              $moduleId = $module['moduleId'];
              $grade="";
              $results = $this->exam_model->get_singleStudent_exam_result($studentId,$moduleId);
                foreach ($results as $result){
                  $grade=$result['grade'];
                  $total=$total+ $result['mark'];
                }
                $moduleCount++;
            if ($grade) {
              array_push($rowArray,$grade);
             
            }else {
              array_push($rowArray,"NA");
            } 
            }
            if($moduleCount>=1){
              $Avg = $total/$moduleCount;
            }else{
              $Avg =0;
            }
         
           array_push($rowArray,$total);
           array_push($rowArray,number_format($Avg,2)."%");
           array_push($topArray,$rowArray); 
           $rowArray= array();
        }

        $data['modules'] = $modules;
        $data['results'] = $topArray;
        $this->user_model->save_user_log($username,'Viewed lecturers.');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('exam/report_batch_summ', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function result_parameter() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,44)) {
        $data['title'] = 'Exam Result sheet parameter';

        $data['branches'] = $this->branches_model->get_branch();

        $this->user_model->save_user_log($username,'Viewed Exam Result sheet.');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('exam/resultSheet_parameter', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }
    public function samplereport(){
      $username = $this->session->userdata('username');
      $data['title'] = 'Exam Result sheet parameter';

      $data['branches'] = $this->branches_model->get_branch();

      $this->user_model->save_user_log($username,'Viewed Exam Result sheet.');

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('exam/samplereport', $data);
      $this->load->view('templates/footer');
    }

    public function student_marks() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,47)) {
        $data['title'] = 'Student Marks';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('exam/student_marks', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function student_enroll() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,48)) {
        $data['title'] = 'Student Examination Enroll Form';

        $data['exams'] = $this->exam_model->get_exams();
        $data['branches'] = $this->branches_model->get_branch_byuser($username);
        
        $this->user_model->save_user_log($username,'Viewed lecturers.');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('exam/student_enroll', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function get_student_attend_Exams(){
      $username = $this->session->userdata('username');

      if ($this->user_model->validate_permission($username, 31)) {

        $studentId = $this->input->post('studentId');

        $data= $this->exam_model->get_exams_by_studentId($studentId);
        
        header('Content-Type: application/json');
        echo json_encode($data);
      }
    }

    public function get_batch_student(){
      $batchId = $this->input->post('batchId');
      $examId =  $this->input->post('examId');
      $exam = $this->exam_model->get_single_exam_row($examId);
      if ($exam->request_form==1){
        $data = $this->exam_model-> get_examApply_studentIds($examId);
      }else {
        $data = $this->exam_model-> get_batchEnroll_studentIds($batchId,$examId);
      }
      
      header('Content-Type: application/json');
      echo json_encode($data);
    }

    public function find_exams(){
      $data = $this->exam_model->get_find_exam();
      header('Content-Type: application/json');
      echo json_encode($data);
    }
    
    public function get_exams_by_branch(){
      $branchId = $this->input->get('branchId');
      $data = $this->exam_model->get_exams_by_branch($branchId);
      header('Content-Type: application/json');
      echo json_encode($data);
    }


   

    public function add() {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,36)) {
      
        $batchId = $this->input->get('batchId');
        $data['title'] = 'Add New Exam /Assignment /Presentation';

        $data['branches'] = $this->branches_model->get_branch();
        $data['allocates'] =$this->allocation_model->get_exam_schedules('');
        $data['gradeScals'] = $this->exam_model->get_grade_scal();
        $this->user_model->save_user_log($username,'Marks added');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('exam/add', $data);
        $this->load->view('templates/footer');
      } else {
        redirect('/?msg=noperm', 'refresh');
      }
    }

    public function addExam()
    {
      $username = $this->session->userdata('username');

      if($this->user_model->validate_permission($username,45)) {
        
                $conflit = $this->exam_model->check_conflit();
              if (!$conflit>=1) {
                $response = $this->exam_model->insert_exam();
            
                    if($response) {
                      $this->session->set_flashdata('success', 'Exam Insert Successfully..!');
                    } else {
                      $this->session->set_flashdata('danger', 'Exam Insert Unsuccessfully..!');
                    }
                $this->user_model->save_user_log($username,'Exam added.');
                redirect(base_url() . 'index.php/exam/add');
              }else {
                $this->session->set_flashdata('warning', 'Exam already Inserted..!');
                redirect(base_url() . 'index.php/exam/add');
              }
        } else {
          redirect('/?msg=noperm', 'refresh');
        }
    }

    public function get_batchs_by_branch(){
      $username = $this->session->userdata('username');

      if ($this->user_model->validate_permission($username, 31)) {

      $branchId = $this->input->get('branchId');

      $data= $this->batch_model->batches_by_branch($branchId);
      
      header('Content-Type: application/json');
      echo json_encode($data);
      }
  }
  public function get_courseModules_by_batch(){
    $username = $this->session->userdata('username');

    if ($this->user_model->validate_permission($username, 31)) {

      $batchId = $this->input->get('batchId');
      $courseId= $this->batch_model->get_batch_course($batchId);
      $data['modules']= $this->module_model->get_module_by_courseId($courseId);
      $data['courseId'] =  $courseId;
    header('Content-Type: application/json');
    echo json_encode($data);
    }
  }

  public function delete_exam(){
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,46)) {
      $examId = $this->input->post('examId');
      $response = $this->exam_model->delete_exam($examId);

      $this->user_model->save_user_log($username,'Exam deleted'.$examId);
     
      if($response) {
        $this->session->set_flashdata('success', 'Exam Delete Successfully..!');
        redirect(base_url() . 'index.php/exam');
       
      } else {
        $this->session->set_flashdata('warning', 'Exam Delete Unsuccessfully..!');
          redirect(base_url() . 'index.php/exam');
      }

    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function set_status(){
    $username = $this->session->userdata('username');
    if($this->user_model->validate_permission($username,45)) {
      $status = $this->input->post('status');
      $examId = $this->input->post('examId');

      $response = $this->exam_model->set_status($examId,$status);

      $this->user_model->save_user_log($username,'Set exam Status of examId. '.$examId.' to '.$status);

      if($response) {
        $this->session->set_flashdata('success', 'Exam Status Change Successfully..!');
        echo $response->status;
      }
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function get_allocate_exam_details(){
   
    $data=$this->allocation_model->get_exam_schedules();
    header('Content-Type: application/json');
    echo json_encode($data);
  }

  public function cloneExam(){
    $username = $this->session->userdata('username');
    if($this->user_model->validate_permission($username,45)) {
      $allocateId = $this->input->post('allocateId');
      $allocateData =$this->allocation_model->get_exam_schedules($allocateId);
      
      foreach($allocateData as $allocate) {
        $branchId= $allocate['branchId'];
        $batchId= $allocate['batchId'];
        $moduleId= $allocate['moduleId'];
        $startTime= $allocate['startTime'];
        $endTime= $allocate['endTime'];
        $date= $allocate['date'];
      }


      if ($this->input->post('serf')==true){
        $serf=1;
       } else {
        $serf=0;
       }  
      $data = array(
        'branchId'=>$branchId,
        'batchId'=>$batchId,
        'moduleId'=>$moduleId,
        'date'=>$date,
        'purpose'=>$this->input->post('purpose'),
        'name'=>$this->input->post('name'),
        'start_time'=> $startTime,
        'end_time'=>$endTime,
        'status'=> 1,
        'grade_scal'=> $this->input->post('gradeScal'),
        'weight'=> $this->input->post('weight'),
        'request_form'=> $serf
    );
      
      $response = $this->exam_model->clone_exam($data);
      
      $this->user_model->save_user_log($username,'Set exam Status of examId. '.$examId.' to '.$status);

      if($response) {
        $this->session->set_flashdata('success', 'New exam Clone Successfully..!');
        redirect(base_url() . 'index.php/exam/add');
      }else{
        $this->session->set_flashdata('warning', 'Exam Clone Unsuccessfully..!');
        redirect(base_url() . 'index.php/exam/add');
      }
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function insert_marks(){
    $username = $this->session->userdata('username');
    if($this->user_model->validate_permission($username,44)) {

          $studentIds = $this->input->post('studentId');
          $marks = $this->input->post('marks');
          $examId = $this->input->post('examId');
          
          for ($i = 0; $i < count($studentIds); $i++) {
            $studentId = $studentIds[$i];
            $mark = $marks[$i];
            if ($mark!=0) {
              $data = array(
                'examId'=>  $examId,
                'studentId'=>  $studentId,
                'mark'=>$mark
              );
              $this->exam_model->insert_exam_marks($data);
            }
            $this->user_model->save_user_log($username,'Insert Exam Marks');
          }
          $this->session->set_flashdata('success', 'Exam Marks insert Successfully..! ExaminationId - ' .$examId);
          redirect(base_url() . 'index.php/exam/marks');
    }else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function get_students_by_batch(){
    $examId = $this->input->get('examId');
    $applied_studentIds = array('');

    $exam_details =$this->exam_model->get_single_exam($examId);
    foreach($exam_details as $exam_detail) {
      $batchId=$exam_detail['batchId'];
    }
    $applied_students = $this->exam_model->get_EFapplied_students($examId);
    foreach($applied_students as $student) {
      array_push($applied_studentIds,$student['studentId']);
    }

    $nas =$this->exam_model->get_EFnon_applied_students($applied_studentIds,$batchId); // Batch non applied students
    
    $data=array(
      'non_applied'=> $nas,// non applied students
       'applied' => $applied_students //applied students
    );

    header('Content-Type: application/json');
    echo json_encode($data);

  }

  public function add_EF_student(){
    $username = $this->session->userdata('username');
    if($this->user_model->validate_permission($username,48)) {

   $response=  $this->exam_model->add_EF_student();
    if ($response){
      echo 1;
    }else {
      echo 0;
    }
  }else {
    redirect('/?msg=noperm', 'refresh');
  }
  }
  public function delete_EF_student(){
    $username = $this->session->userdata('username');
    if($this->user_model->validate_permission($username,48)) {

    $response=  $this->exam_model->delete_EF_student();
     if ($response){
       echo 1;
     }else {
       echo 0;
     }
    }else {
      redirect('/?msg=noperm', 'refresh');
    }
   }


}
