<?php

class Messages extends CI_Controller {

  public function __construct() {
      parent::__construct();
      $this->load->library('session');
      $this->load->model('message_model');
      $this->load->model('user_model');
      $this->load->model('course_model');
      $this->load->helper('url_helper');
      $this->load->helper('url');
      $this->load->helper('form');
  }

  public function index() {
    $username = $this->session->userdata('username');

    $data['title'] = "Message Templates";

    if($this->user_model->validate_permission($username,19)) {

      $data['messages'] = $this->message_model->get_messages();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('messages/index', $data);
      $this->load->view('templates/footer');

      $this->user_model->save_user_log($username,'View message templates');

    } else {
      redirect('/?msg=noperm', 'refresh');
    }

  }

  public function add() {
    $username = $this->session->userdata('username');

    $data['title'] = "Add Message Template";

    if($this->user_model->validate_permission($username,20)) {

      $data['courses'] = $this->course_model->get_courses();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('messages/add', $data);
      $this->load->view('templates/footer');

      $this->user_model->save_user_log($username,'Open add message templates form');

    } else {
      redirect('/?msg=noperm', 'refresh');
    }

  }

  public function edit() {
    $username = $this->session->userdata('username');

    $data['title'] = "Edit Message Template";

    if($this->user_model->validate_permission($username,21)) {

      $id = $this->input->get('id');

      $data['courses'] = $this->course_model->get_courses();
      $data['edit'] = $this->message_model->get_messages_by_id($id);

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('messages/edit', $data);
      $this->load->view('templates/footer');

      $this->user_model->save_user_log($username,'Open edit message template for: '.$id);

    } else {
      redirect('/?msg=noperm', 'refresh');
    }

  }

  public function save_template() {

    $config['upload_path']          = './uploads';
    $config['allowed_types']        = 'pdf';
    $config['max_size']             = 1024;

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('attachment')) {
      if($this->message_model->save_template('')) {

        $data['title'] = "Message Templates";

        $data['msg'] = "Message template saved!";
        $data['messages'] = $this->message_model->get_messages();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('messages/index', $data);
        $this->load->view('templates/footer');
      }
    } else {
      $file = $this->upload->data();

      if($this->message_model->save_template($file['file_name'])) {

        $data['title'] = "Message Templates";

        $data['msg'] = "Message template saved!";
        $data['messages'] = $this->message_model->get_messages();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('messages/index', $data);
        $this->load->view('templates/footer');
      }
      //print_r($data['filename']);
    }

  }

  public function update_template() {

    $config['upload_path']          = './uploads';
    $config['allowed_types']        = 'pdf';
    $config['max_size']             = 1024;

    $this->load->library('upload', $config);

    if(!$this->input->post('filename')) {

      if (!$this->upload->do_upload('attachment')) {

        if($this->message_model->update_template('')) {

          $data['title'] = "Message Templates";

          $data['msg'] = "Message template updated!";
          $data['messages'] = $this->message_model->get_messages();

          $this->load->view('templates/header', $data);
          $this->load->view('templates/sidebar', $data);
          $this->load->view('messages/index', $data);
          $this->load->view('templates/footer');
        }

      } else {
        $file = $this->upload->data();

        if($this->message_model->update_template($file['file_name'])) {

          $data['title'] = "Message Templates";

          $data['msg'] = "Message template updated!";
          $data['messages'] = $this->message_model->get_messages();

          $this->load->view('templates/header', $data);
          $this->load->view('templates/sidebar', $data);
          $this->load->view('messages/index', $data);
          $this->load->view('templates/footer');
        }
        //print_r($data['filename']);
      }
    } else {

      if($this->message_model->update_template($this->input->post('filename'))) {

        $data['title'] = "Message Templates";

        $data['msg'] = "Message template updated!";
        $data['messages'] = $this->message_model->get_messages();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('messages/index', $data);
        $this->load->view('templates/footer');
      }
    }

  }

  public function delete() {
    $username = $this->session->userdata('username');

    $data['title'] = "Add Message Template";

    if($this->user_model->validate_permission($username,22)) {

      $id = $this->input->get('id');

      if($this->message_model->delete_template($id)) {
        $data['title'] = "Message Templates";

        $data['msg'] = "Message template deleted!";
        $data['messages'] = $this->message_model->get_messages();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('messages/index', $data);
        $this->load->view('templates/footer');

        $this->user_model->save_user_log($username,'Deleted message template'.$id);
      } else {
        $data['title'] = "Message Templates";

        $data['error'] = "Failed to delete the template!";
        $data['messages'] = $this->message_model->get_messages();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('messages/index', $data);
        $this->load->view('templates/footer');
      }
    } else {
      redirect('/?msg=noperm', 'refresh');
    }

  }

  public function send_message() {

    $this->load->library('email');

    $config['protocol'] = 'sendmail';
    $config['mailpath'] = '/usr/sbin/sendmail';
    $config['charset'] = 'iso-8859-1';
    $config['wordwrap'] = TRUE;

    $this->email->initialize($config);

    $courseId = $this->input->post('courseId');
    $instance = $this->input->post('instance');
    $email = $this->input->post('email');
    $mobile = $this->input->post('mobile');
    $username = $this->input->post('username');
    $studentname = $this->input->post('name');

    $users = $this->user_model->get_user_by($username);

    if($messages = $this->message_model->get_message_by_course_instance($courseId,$instance)) {

      foreach($messages as $message) {
        $subject = $message['subject'];
        $body = $message['body'];
        $sms = $message['sms'];
        $attachment = $message['attachment'];
        $atch = base_url().'uploads/'.$message['attachment'];

        foreach($users as $user) {
          $counselor = $user['name'];
          $cemail = $user['email'];
          $ctelephone = $user['telephone'];
        }

        $replacearray = array(
          '[COURSE_NAME]' => $message['courseName'],
          '[STUDENT_NAME]' => $studentname,
          '[COUNSELOR_NAME]' => $counselor,
          '[COUNSELOR_MOBILE]' => '0'.$ctelephone,
        );

        $body = str_replace(array_keys($replacearray),array_values($replacearray),$body);
        $sms = str_replace(array_keys($replacearray),array_values($replacearray),$sms);
        $subject = str_replace(array_keys($replacearray),array_values($replacearray),$subject);

        $this->email->from('no-reply@saegis.edu.lk', 'Saegis Campus Enrollments');
        $this->email->reply_to($cemail, $counselor);
        $this->email->to($email);

        $this->email->subject($subject);
        $this->email->message($body);
        $this->email->set_mailtype("html");
        $this->email->attach($atch);

        $ch = curl_init();

        $url = "http://119.235.1.63:4050/Sms.svc/SendSms?phoneNumber=".$mobile."&smsMessage=".urlencode($sms)."&companyId=SAEGIS&pword=SAEGIS";

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    //  curl_setopt($ch,CURLOPT_HEADER, false);

        if($this->email->send() && $output = curl_exec($ch)) {
          curl_close($ch);
          echo 1;
        } else {
            show_error($this->email->print_debugger());
          echo 0;
        }
      }
    }
  }

}

?>
