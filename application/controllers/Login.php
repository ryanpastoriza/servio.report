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
			unset($check->user_hash);
		    $this->session->set_userdata('id',$check);
		    redirect('dashboard');
		}
		else
		{
			redirect('login');
		}
	}
	

}
?>