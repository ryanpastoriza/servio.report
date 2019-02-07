<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('id')){
			redirect('dashboard');
		}
	}

	public function index()
	{
		$data['title'] = 'Login Form';
		$this->load->view('login', $data);
	}
	public function verify()
	{
		
		$this->load->model('main_model');
		$check = $this->main_model->validate();
		if ($check) 
		{
		    $this->session->set_userdata('id',$check->id);
			$this->session->set_userdata('username',$check->user_name);
			$this->session->set_userdata('title',$check->title);
		    redirect('dashboard');
		}
		else
		{
			redirect('login');
		}
	}
	

}
?>