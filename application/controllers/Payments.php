<?php

class Payments extends CI_Controller {

  public function __construct() {
      parent::__construct();
      $this->load->library('session');
      $this->load->model('payment_model');
      $this->load->model('user_model');
      $this->load->model('batch_model');
      $this->load->model('inquiry_model');
      $this->load->model('course_model');
      $this->load->helper('url_helper');
      $this->load->helper('url');
      $this->load->helper('form');
  }

  public function index() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,17)) {
      $data['title'] = 'Student Payments';

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('payments/index', $data);
      $this->load->view('templates/footer');

      $this->user_model->save_user_log($username,'Opened Student Payments');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function payment_plans() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,11)) {
      $data['title'] = 'All Payment Plans';

      $data['pplans'] = $this->payment_model->get_payment_plans();
      $data['courses'] = $this->course_model->get_courses();
      $data['intakes'] = $this->inquiry_model->get_intakes();

      if(isset($_POST)) {
        $data['pplans'] = $this->payment_model->filter_payment_plans();
      }

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('payments/payment_plans', $data);
      $this->load->view('templates/footer');

      $this->user_model->save_user_log($username,'Opened Student Payment Plans');
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function add_payment_plan() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,10)) {

      $config['upload_path']          = './uploads/';
      $config['allowed_types']        = 'csv';
      $config['max_size']             = 100;
      $config['max_width']            = 1024;
      $config['max_height']           = 768;

      $this->load->library('upload', $config);

      if ( ! $this->upload->do_upload('csv_installment')) {
        $error = array('error' => $this->upload->display_errors());
        print_r($error);
      } else {
        $this->load->library('CSVReader');

        $file = $this->upload->data();
        $csvData = $this->csvreader->parse_csv($file['full_path']);

        if(!empty($csvData)){
          $pplanId = $this->payment_model->add_payment_plan();

          foreach($csvData as $row) {
            $id = $row['id'];
            $name = $row['name'];
            $amount = $row['amount'];
            $currency = $row['currency'];
            $ori_date = str_replace('/', '-',$row['date']);
            $date = date("Y-m-d",strtotime($ori_date));

            $this->payment_model->update_installment($id,$name,$amount,$currency,$date,$pplanId);
          }

          $data['title'] = 'All Payment Plans';

          $data['pplans'] = $this->payment_model->get_payment_plans();
          $data['courses'] = $this->course_model->get_courses();
          $data['intakes'] = $this->inquiry_model->get_intakes();

          $data['msg'] = "Payment plan updated successfully";

          $this->load->view('templates/header', $data);
          $this->load->view('templates/sidebar', $data);
          $this->load->view('payments/payment_plans', $data);
          $this->load->view('templates/footer');

          $this->user_model->save_user_log($username,'Updated payment plan id:'.$pplanId);

        } else {
          $data['title'] = 'All Payment Plans';

          $data['pplans'] = $this->payment_model->get_payment_plans();
          $data['courses'] = $this->course_model->get_courses();
          $data['intakes'] = $this->inquiry_model->get_intakes();

          $data['err'] = "Payment plan couldn't be updated";

          $this->load->view('templates/header', $data);
          $this->load->view('templates/sidebar', $data);
          $this->load->view('payments/payment_plans', $data);
          $this->load->view('templates/footer');
        }

      }
    } else {
      $data['title'] = 'All Payment Plans';

      $data['pplans'] = $this->payment_model->get_payment_plans();
      $data['courses'] = $this->course_model->get_courses();
      $data['intakes'] = $this->inquiry_model->get_intakes();

      $data['err'] = "You don't have necessary permissions to perform this task";

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('payments/payment_plans', $data);
      $this->load->view('templates/footer');
    }
  }

  public function clone_payment_plan() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,10)) {

      $pplanId = $this->payment_model->add_payment_plan();

      $pplan_ids = $this->input->post('installmentId');
      $cname = $this->input->post('installmentName');
      $camount = $this->input->post('amount');
      $ccurrency = $this->input->post('currency');
      $cdate = $this->input->post('date');

      for ($i = 0; $i < count($pplan_ids); $i++) {
        $id = $pplan_ids[$i];
        $name = $cname[$i];
        $amount = $camount[$i];
        $currency = $ccurrency[$i];
        $date = $cdate[$i];

        $this->payment_model->update_installment($id,$name,$amount,$currency,$date,$pplanId);
      }

      $data['title'] = 'All Payment Plans';

      $data['pplans'] = $this->payment_model->get_payment_plans();
      $data['courses'] = $this->course_model->get_courses();
      $data['intakes'] = $this->inquiry_model->get_intakes();

      $data['msg'] = "Payment plan updated successfully";

      $this->user_model->save_user_log($username,'Updated payment plan id:'.$pplanId);

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('payments/payment_plans', $data);
      $this->load->view('templates/footer');
    } else {
      $data['title'] = 'All Payment Plans';

      $data['pplans'] = $this->payment_model->get_payment_plans();
      $data['courses'] = $this->course_model->get_courses();
      $data['intakes'] = $this->inquiry_model->get_intakes();

      $data['err'] = "You don't have necessary permissions to perform this task";

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('payments/payment_plans', $data);
      $this->load->view('templates/footer');
    }
  }

  public function view_pplan() {
    $data = $this->payment_model->view_pplan();

    header('Content-Type: application/json');
    echo json_encode( $data );
  }

  public function get_payment_plans_by_intake_course() {
    $courseId = $this->input->post('courseId');
    $intakeId = $this->input->post('intakeId');

    if($data = $this->payment_model->get_payment_plans_by_intake_course($intakeId,$courseId)) {
      header('Content-Type: application/json');
      echo json_encode( $data );
    }
  }

  public function delete_payment_plan() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,12)) {

      if($response = $this->payment_model->delete_payment_plan()) {
        $data['title'] = 'All Payment Plans';

        $data['pplans'] = $this->payment_model->get_payment_plans();
        $data['courses'] = $this->course_model->get_courses();
        $data['intakes'] = $this->inquiry_model->get_intakes();

        $data['msg'] = "Payment plan deleted! This cannot be undone.";


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('payments/payment_plans', $data);
        $this->load->view('templates/footer');

        $pplanId = $this->input->post('pplanId');
        $this->user_model->save_user_log($username,'Deleted payment plan id:'.$pplanId);
      } else {
        $data['title'] = 'All Payment Plans';

        $data['pplans'] = $this->payment_model->get_payment_plans();
        $data['courses'] = $this->course_model->get_courses();
        $data['intakes'] = $this->inquiry_model->get_intakes();

        $data['err'] = $response;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('payments/payment_plans', $data);
        $this->load->view('templates/footer');
      }
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function view_installments_by_pplan() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,11)) {
      $studentId = $this->input->get('studentId');
      $pplanId = $this->input->get('pplanId');

      $data['installments'] = $this->payment_model->view_installments_by_pplan($pplanId);

      $data['studentId'] = $studentId;
      $data['pplanId'] = $pplanId;

      $data['title'] = 'Collect Payments - '.$studentId;

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('payments/collect_payments', $data);
      $this->load->view('templates/footer');

      $this->user_model->save_user_log($username,'Opened payment installments for student id'.$studentId);
    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function save_payment() {
    $username = $this->session->userdata('username');

    $response = $this->payment_model->save_payment($username);

    if($response) {
      echo "success";
    } else {
      echo "error";
    }
  }

  public function print_receipt() {
    $studentId = $this->input->get('studentId');
    $pplanId = $this->input->get('pplanId');
    $installmentId = $this->input->get('installmentId');

    $data['print'] = $this->payment_model->print_receipt($studentId,$pplanId,$installmentId);

    $this->load->view('payments/print_receipt',$data);
  }

  public function cashier_reports() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,17)) {
      $data['title'] = 'Cashier Reports';

      $data['courses'] = $this->course_model->get_courses();
      $data['batches'] = $this->batch_model->get_batches();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('payments/cashier_reports', $data);
      $this->load->view('templates/footer');

      $this->user_model->save_user_log($username,'Opened cashier reports');

    } else {
      redirect('/?msg=noperm', 'refresh');
    }
  }

  public function filter_payments() {
    $username = $this->session->userdata('username');

    if(!$this->user_model->validate_permission($username,18)) {
      $this->user_model->save_user_log($username,'Filtered cashier reports');
      if($data = $this->payment_model->filter_payments($username)) {
        header('Content-Type: application/json');
        echo json_encode( $data );
      }
    } else {
      $this->user_model->save_user_log($username,'Filtered cashier reports');
      if($data = $this->payment_model->filter_payments("")) {
        header('Content-Type: application/json');
        echo json_encode( $data );
      }
    }
  }

  public function print_cashier_reports() {
    $this->load->library('pdfgenerator');

    $html = $this->load->view('payments/print_cashier_reports', $data, true);
    $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
  }

  public function delete_payment() {
    $username = $this->session->userdata('username');

    if($this->user_model->validate_permission($username,26)) {
      if($this->payment_model->delete_payment()) {
        echo "success";
      } else {
        echo "error";
      }
    } else {
      echo "no-permission";
    }
  }

  public function correction() {
    $data['title'] = 'Modify Student Payments';

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('payments/correction', $data);
    $this->load->view('templates/footer');
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
          $courseId = $row['courseId'];
          $batchId = $row['batchId'];
          $pplanId = $row['pplanId'];

          $this->payment_model->save_correction($studentId, $batchId, $courseId, $pplanId);
        }

        $data['title'] = 'Modify Student Details';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('payments/correction', $data);
        $this->load->view('templates/footer');
      }

    }
  }
}
