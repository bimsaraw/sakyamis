<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url_helper');
		$this->load->model('user_model');
		$this->load->model('inquiry_model');
		$this->load->model('course_model');
	}

	public function index()
	{
		$username = $this->session->userdata('username');

		$data['title'] = "Sibt MIS";

		$data['intakes'] = $this->inquiry_model->get_intakes();
		$data['courses'] = $this->course_model->get_courses();
		$data['username'] = $username;

		if($this->user_model->validate_permission($username,5)) {
			$data['show_inquiries'] = 1;
			$data['all'] = 1;
		}

		if($this->user_model->validate_permission($username,25)) {
			$data['show_inquiries'] = 1;
			$data['all'] = 0;
		}

		$this->load->view('templates/header',$data);
		$this->load->view('templates/sidebar');
		$this->load->view('home',$data);
		$this->load->view('templates/footer');
	}
}
