
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('main_model');
		if ($this->session->userdata('user')){
			redirect('dashboard');
		}
	}

	public function index()
	{
		$data['title'] = 'Login Form';
		$this->load->view('login');
	}
	public function verify()
	{
		
		$this->form_validation->set_rules('username','username','required|trim');
		$this->form_validation->set_rules('password','password','required');
		if($this->form_validation->run())
		{
			$check = $this->main_model->validate();
			if ($check) 
			{
				
				if($check->title == "MMPC" | $check->title == "Dealer Sales Manager" | $check->title == "Branch Sales Manager")
				{
					$check = $this->main_model->validate();
					$dealer =$this->main_model->get_branch($check->id);
					$check->fullname = $check->first_name." ".$check->last_name; 
					unset($check->user_hash);
					$this->session->set_userdata('user', $check);
					// $this->session->set_userdata('id',$check->id);
					// $this->session->set_userdata('username',$check->user_name);
					// $this->session->set_userdata('fullname',$fullname);
					// $this->session->set_userdata('dealer',$dealer->dealer);
					// $this->session->set_userdata('branch',$dealer->branch);
					// $this->session->set_userdata('title',$check->title);
					redirect('dashboard');
				}
				else
				{
					$this->session->set_flashdata('error','Invalid Username and Password');
					$this->index();
				}
			}
			else
			{
				$this->session->set_flashdata('error','Invalid Username and Password');
				$this->index();
			}
		}
		else
		{
			$this->index();
		}
		
	}
	

}
?>