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
	function get_branch($id)
	{
		$sql = "SELECT jump_branch.`name` as `branch`, jump_dealer.`name` as `dealer` FROM users_cstm LEFT JOIN jump_branch ON users_cstm.jump_branch_id_c = jump_branch.id LEFT JOIN jump_dealer ON users_cstm.jump_dealer_id_c = jump_dealer.id WHERE users_cstm.id_c ='".$id."'";
		return $this->db->query($sql)->row();	

	}
	

}


?>