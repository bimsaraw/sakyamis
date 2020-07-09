<?php

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_users() {
        $query = $this->db->get('users');
        return $query->result_array();
    }

    public function get_users_marketing() {
        $this->db->where('department',2);
        $query = $this->db->get('users');
        return $query->result_array();
    }

    public function get_permissions() {
        $query = $this->db->get('permission');
        return $query->result_array();
    }

    public function get_permissions_not_in($username) {
      $this->db->select('permission.*');
      $this->db->from('permission');
      $this->db->where('permission.id NOT IN (SELECT permission_id FROM user_permissions WHERE username="'.$username.'")');

      $query = $this->db->get();
      foreach ($query->result() as $data) {
          $response[] = $data;
      }

      return $response;
    }

    public function get_permissions_in($username) {
      $this->db->select('permission.*');
      $this->db->from('permission');
      $this->db->join('user_permissions','permission.id=user_permissions.permission_id');
      $this->db->where('user_permissions.username',$username);

      $query = $this->db->get();
      foreach ($query->result() as $data) {
          $response[] = $data;
      }

      return $response;
    }

    public function get_departments() {
        $query = $this->db->get('departments');
        return $query->result_array();
    }

    public function add() {
        $this->load->helper('url');
        $data = array(
            'username'=>$this->input->post('username'),
            'password'=>password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'name'=>$this->input->post('name'),
            'email'=>$this->input->post('email'),
            'telephone'=>$this->input->post('telephone'),
            'department'=>$this->input->post('department')
        );

        $this->db->where('username', $this->input->post('username'));
        $users = $this->db->get('users');

        if($users->num_rows()==0) {
          $this->db->insert('users', $data);
        } else {
          return false;
        }

        $permissions = $this->input->post('perm_id');
        $perm_stat = $this->input->post('perm_stat');

        foreach($permissions as $key => $value) {
          if($perm_stat[$key]==1) {

            $this->db->where('username', $this->input->post('username'));
            $this->db->where('permission_id', $value);
            $query = $this->db->get('user_permissions');

            if($query->num_rows()==0) {
              $perm_data['username'] = $this->input->post('username');
              $perm_data['permission_id'] = $value;
              $perm_data['date'] = date('Y-m-d h:i:sa');

              $this->db->insert('user_permissions', $perm_data);
            }

          } else {
            $this->db->where('username', $this->input->post('username'));
            $this->db->where('permission_id', $value);
            $this->db->delete('user_permissions');
          }
        }

        return true;
    }

    public function change_pwd($username,$password) {
      $hashed_pwd = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

      $data = array(
        'password'=>$hashed_pwd,
      );

      $this->db->where('username',$username);
      return $this->db->update('users',$data);
    }

    public function modify_permissions() {
        $this->load->helper('url');

        $permissions = $this->input->post('perm_id');
        $perm_stat = $this->input->post('perm_stat');

        foreach($permissions as $key => $value) {
          if($perm_stat[$key]==1) {

            $this->db->where('username', $this->input->post('username'));
            $this->db->where('permission_id', $value);
            $query = $this->db->get('user_permissions');

            if($query->num_rows()==0) {
              $perm_data['username'] = $this->input->post('username');
              $perm_data['permission_id'] = $value;
              $perm_data['date'] = date('Y-m-d h:i:sa');

              $this->db->insert('user_permissions', $perm_data);
            }

          } else {
            $this->db->where('username', $this->input->post('username'));
            $this->db->where('permission_id', $value);
            $this->db->delete('user_permissions');
          }
        }

        return true;
    }

    public function remove_user($username) {
      $this->db->where('username', $username);
      $query = $this->db->delete('users');

      if($query) {
        return true;
      } else {
        return false;
      }
    }

    public function validate(){
        // grab user input
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));

        // Prep the query
        $this->db->select('users.*');
        $this->db->from('users');
        $this->db->where('username', $username);

        // Run the query
        $query = $this->db->get();
        // Let's check if there are any results
        if($query->result())
        {
            // If there is a user, then create session data
            $row = $query->row();

            if(password_verify($password,$row->password)) {
                $data['username'] = $row->username;

                $this->session->set_userdata($data);
                return true;
            }
        }
        // If the previous process did not validate
        // then return false.
        return false;
    }

    public function validate_pwd($username,$password){

        // Prep the query
        $this->db->select('users.*');
        $this->db->from('users');
        $this->db->where('username', $username);

        // Run the query
        $query = $this->db->get();
        // Let's check if there are any results
        if($query->result())
        {
            // If there is a user, then create session data
            $row = $query->row();

            if(password_verify($password,$row->password)) {
                $data['username'] = $row->username;

                return true;
            }
        }
        // If the previous process did not validate
        // then return false.
        return false;
    }

    public function validate_permission($username,$permission) {
      $this->db->where('username',$username);
      $this->db->where('permission_id',$permission);
      $result = $this->db->get('user_permissions');

      if($result->num_rows()>0) {
        return true;
      } else {
        return false;
      }
    }

    public function get_user_by($username) {
      $this->db->where('username',$username);
      $query = $this->db->get('users');

      return $query->result_array();
    }

    public function save_user_log($username, $log) {
      $datetime = date('Y-m-d h:i:sa');
      $data = array(
        'username' => $username,
        'log' => $log,
        'datetime' => $datetime
      );

      return $this->db->insert('user_logs', $data);
    }
}
