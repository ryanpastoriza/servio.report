<?php

/**
* 
*/
class Main_model extends CI_Model
{
	
	function validate()
	{
		$arr['user_name']=$this->input->post('username');
		$user_hash=$this->db->get_where('users',$arr)->row('user_hash');
		$password_md5 = md5($this->input->post('password'));
		$arr1['user_name']=$this->input->post('username');
		$arr1['user_hash']=crypt(strtolower($password_md5), $user_hash);

		return $this->db->get_where('users',$arr1)->row();
	}

}


?>