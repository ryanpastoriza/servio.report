<?php

/**
* 
*/
class Main_model extends CI_Model
{
	
	function validate(){
		$arr['user_name']=$this->input->post('username');
		$user_hash=$this->db->get_where('users',$arr)->row('user_hash');
		$password_md5 = md5($this->input->post('password'));

		$arr1['user_name']=$this->input->post('username');
		$arr1['user_hash']=crypt(strtolower($password_md5), $user_hash);

		return $this->db->get_where('users',$arr1)->row();
	}
	function base_model_records(){
		return  $this->db->query('SELECT * from jump_base_model WHERE deleted = 0')->result();
	}
	function dealers(){
		
		$query = $this->db->query("SELECT * from jump_dealer WHERE deleted = 0")->result();
		return $query;	
	}
	function region(){
		
		$query = $this->db->query("SELECT * from group_dealer_by_region WHERE deleted = 0")->result();
		return $query;	
	}
	function getmmpc(){
		$arr1['name']='MMPC';
		return $this->db->get_where('jump_dealer',$arr1)->row('id');	
	}
	function branch(){

		$dealer_id = $_GET['dealer_id'];

		$query = $this->db->query("	SELECT
										jump_dealer.id,
										jump_dealer.name,
										jump_branch.name as branch_name
									FROM
										jump_dealer
									INNER JOIN jump_branch_cstm
									ON jump_branch_cstm.jump_dealer_id_c = jump_dealer.id  

									INNER JOIN jump_branch
									ON jump_branch_cstm.id_c = jump_branch.id

									where jump_dealer.id = '{$dealer_id}'")->result();
		return json_encode($query);
	}
	function dealer1(){

		$region_id = $_GET['region_id'];
		if ($region_id=="all") {
			$query = $this->db->query("SELECT jump_dealer.id, jump_dealer.`name` AS ` dealer_name` from jump_dealer WHERE deleted = 0")->result();
			return json_encode($query);
		} else {
			$query = $this->db->query("	SELECT
			jump_dealer.id,
			jump_dealer.`name` AS ` dealer_name`
			FROM
			group_dealer_by_region_jump_dealer_1_c
			INNER JOIN jump_dealer ON group_dealer_by_region_jump_dealer_1_c.group_dealer_by_region_jump_dealer_1jump_dealer_idb = jump_dealer.id
			WHERE
			group_dealer_by_region_jump_dealer_1_c.group_dealer_by_region_jump_dealer_1group_dealer_by_region_ida = '{$region_id}' AND
			group_dealer_by_region_jump_dealer_1_c.deleted = '0' AND
			jump_dealer.deleted = '0'")->result();
			return json_encode($query);
		}
		
		
	}
	function allsem($bm){
		
		$query = $this->db->query("SELECT
		Count(users.user_name) as `allse`
		FROM
		users_cstm
		INNER JOIN jump_dealer ON users_cstm.jump_dealer_id_c = jump_dealer.id
		INNER JOIN users ON users_cstm.id_c = users.id
		WHERE
		jump_dealer.`id` = '{$bm}' AND
		users.title = 'Sales Executive'
		")->row('allse');

		return ($query);
	}
	function allavem($date_from,$date_to,$bm){
		
		$query = $this->db->query("SELECT
		Count(ddms_sales_order.id) as `o`
		FROM
				pi_prospect_inquiry
				INNER JOIN jump_model_description_pi_prospect_inquiry_1_c ON pi_prospect_inquiry.id = jump_model_description_pi_prospect_inquiry_1_c.jump_modeldc9einquiry_idb
				INNER JOIN jump_model_description ON jump_model_description_pi_prospect_inquiry_1_c.jump_modela8cbription_ida = jump_model_description.id
				INNER JOIN users ON pi_prospect_inquiry.created_by = users.id
				INNER JOIN users_cstm ON users.id = users_cstm.id_c
				INNER JOIN jump_dealer ON users_cstm.jump_dealer_id_c = jump_dealer.id
				INNER JOIN jump_branch ON users_cstm.jump_branch_id_c = jump_branch.id
				INNER JOIN pi_prospect_inquiry_ddms_sales_order_1_c ON pi_prospect_inquiry.id = pi_prospect_inquiry_ddms_sales_order_1_c.pi_prospect_inquiry_ddms_sales_order_1pi_prospect_inquiry_ida
				INNER JOIN ddms_sales_order ON ddms_sales_order.id = pi_prospect_inquiry_ddms_sales_order_1_c.pi_prospect_inquiry_ddms_sales_order_1ddms_sales_order_idb
		WHERE
		ddms_sales_order.date_entered BETWEEN '{$date_from}' AND '{$date_to}' AND
		jump_dealer.`id` = '{$bm}' AND
		ddms_sales_order.deleted = '0'")->row('o');

		return ($query);
	}

	function getpi($date_from,$date_to,$dealer,$branch,$bm){
		$basemodel = $bm;
		if ($date_from=="all") {
			$query = $this->db->query("	SELECT
			Count(pi_prospect_inquiry.id) as `pi`
			FROM
			pi_prospect_inquiry
			INNER JOIN jump_model_description_pi_prospect_inquiry_1_c ON pi_prospect_inquiry.id = jump_model_description_pi_prospect_inquiry_1_c.jump_modeldc9einquiry_idb
			INNER JOIN jump_model_description ON jump_model_description_pi_prospect_inquiry_1_c.jump_modela8cbription_ida = jump_model_description.id
			INNER JOIN users ON pi_prospect_inquiry.created_by = users.id
			INNER JOIN users_cstm ON users.id = users_cstm.id_c
			INNER JOIN jump_dealer ON users_cstm.jump_dealer_id_c = jump_dealer.id
			INNER JOIN jump_branch ON users_cstm.jump_branch_id_c = jump_branch.id
			WHERE
			jump_dealer.id = '{$dealer}' AND
			jump_branch.`name` = '{$branch}' AND
			pi_prospect_inquiry.deleted = '0' AND
			jump_model_description.`name` LIKE '{$basemodel}%'")->row('pi');
		}else{
			$query = $this->db->query("	SELECT
			Count(pi_prospect_inquiry.id) as `pi`
			FROM
			pi_prospect_inquiry
			INNER JOIN jump_model_description_pi_prospect_inquiry_1_c ON pi_prospect_inquiry.id = jump_model_description_pi_prospect_inquiry_1_c.jump_modeldc9einquiry_idb
			INNER JOIN jump_model_description ON jump_model_description_pi_prospect_inquiry_1_c.jump_modela8cbription_ida = jump_model_description.id
			INNER JOIN users ON pi_prospect_inquiry.created_by = users.id
			INNER JOIN users_cstm ON users.id = users_cstm.id_c
			INNER JOIN jump_dealer ON users_cstm.jump_dealer_id_c = jump_dealer.id
			INNER JOIN jump_branch ON users_cstm.jump_branch_id_c = jump_branch.id
			WHERE
			pi_prospect_inquiry.date_entered BETWEEN '{$date_from}' AND '{$date_to}' AND
			jump_dealer.id = '{$dealer}' AND
			jump_branch.`name` = '{$branch}' AND
			pi_prospect_inquiry.deleted = '0' AND
			jump_model_description.`name` LIKE '{$basemodel}%'")->row('pi');
		}
		

		return ($query);
	}
	function geto($date_from,$date_to,$dealer,$branch,$bm){
		$basemodel = $bm;
		if ($date_from=="all") {
			$query = $this->db->query("	SELECT
			Count(ddms_sales_order.id) as `o`
			FROM
			pi_prospect_inquiry
			INNER JOIN jump_model_description_pi_prospect_inquiry_1_c ON pi_prospect_inquiry.id = jump_model_description_pi_prospect_inquiry_1_c.jump_modeldc9einquiry_idb
			INNER JOIN jump_model_description ON jump_model_description_pi_prospect_inquiry_1_c.jump_modela8cbription_ida = jump_model_description.id
			INNER JOIN users ON pi_prospect_inquiry.created_by = users.id
			INNER JOIN users_cstm ON users.id = users_cstm.id_c
			INNER JOIN jump_dealer ON users_cstm.jump_dealer_id_c = jump_dealer.id
			INNER JOIN jump_branch ON users_cstm.jump_branch_id_c = jump_branch.id
			INNER JOIN pi_prospect_inquiry_ddms_sales_order_1_c ON pi_prospect_inquiry.id = pi_prospect_inquiry_ddms_sales_order_1_c.pi_prospect_inquiry_ddms_sales_order_1pi_prospect_inquiry_ida
			INNER JOIN ddms_sales_order ON ddms_sales_order.id = pi_prospect_inquiry_ddms_sales_order_1_c.pi_prospect_inquiry_ddms_sales_order_1ddms_sales_order_idb
			WHERE		
			jump_dealer.id = '{$dealer}' AND
			jump_branch.`name` = '{$branch}' AND
			ddms_sales_order.deleted = '0' AND
			jump_model_description.`name` LIKE '{$basemodel}%'")->row('o');
		}else{
			$query = $this->db->query("	SELECT
			Count(ddms_sales_order.id) as `o`
			FROM
			pi_prospect_inquiry
			INNER JOIN jump_model_description_pi_prospect_inquiry_1_c ON pi_prospect_inquiry.id = jump_model_description_pi_prospect_inquiry_1_c.jump_modeldc9einquiry_idb
			INNER JOIN jump_model_description ON jump_model_description_pi_prospect_inquiry_1_c.jump_modela8cbription_ida = jump_model_description.id
			INNER JOIN users ON pi_prospect_inquiry.created_by = users.id
			INNER JOIN users_cstm ON users.id = users_cstm.id_c
			INNER JOIN jump_dealer ON users_cstm.jump_dealer_id_c = jump_dealer.id
			INNER JOIN jump_branch ON users_cstm.jump_branch_id_c = jump_branch.id
			INNER JOIN pi_prospect_inquiry_ddms_sales_order_1_c ON pi_prospect_inquiry.id = pi_prospect_inquiry_ddms_sales_order_1_c.pi_prospect_inquiry_ddms_sales_order_1pi_prospect_inquiry_ida
			INNER JOIN ddms_sales_order ON ddms_sales_order.id = pi_prospect_inquiry_ddms_sales_order_1_c.pi_prospect_inquiry_ddms_sales_order_1ddms_sales_order_idb
			WHERE		
			pi_prospect_inquiry.date_entered BETWEEN '{$date_from}' AND '{$date_to}' AND
			jump_dealer.id = '{$dealer}' AND
			jump_branch.`name` = '{$branch}' AND
			ddms_sales_order.deleted = '0' AND
			jump_model_description.`name` LIKE '{$basemodel}%'")->row('o');
		}
		

		return ($query);
	}
	function getpi1($date_from,$date_to,$dealer,$branch,$bm){
		$basemodel = $bm;
		if ($date_from=="all") {
			$query = $this->db->query("SELECT
			Count(pi_prospect_inquiry.id) AS pi
			FROM
			pi_prospect_inquiry
			INNER JOIN jump_model_description_pi_prospect_inquiry_1_c ON pi_prospect_inquiry.id = jump_model_description_pi_prospect_inquiry_1_c.jump_modeldc9einquiry_idb
			INNER JOIN jump_model_description ON jump_model_description_pi_prospect_inquiry_1_c.jump_modela8cbription_ida = jump_model_description.id
			INNER JOIN users ON pi_prospect_inquiry.created_by = users.id
			INNER JOIN users_cstm ON users.id = users_cstm.id_c
			WHERE		
			pi_prospect_inquiry.deleted = '0' AND
			jump_model_description.`name` LIKE '{$basemodel}%'")->row('pi');
		}else{
			$query = $this->db->query("SELECT
			Count(pi_prospect_inquiry.id) AS pi
			FROM
			pi_prospect_inquiry
			INNER JOIN jump_model_description_pi_prospect_inquiry_1_c ON pi_prospect_inquiry.id = jump_model_description_pi_prospect_inquiry_1_c.jump_modeldc9einquiry_idb
			INNER JOIN jump_model_description ON jump_model_description_pi_prospect_inquiry_1_c.jump_modela8cbription_ida = jump_model_description.id
			INNER JOIN users ON pi_prospect_inquiry.created_by = users.id
			INNER JOIN users_cstm ON users.id = users_cstm.id_c
			WHERE		
			pi_prospect_inquiry.date_entered BETWEEN '{$date_from}' AND '{$date_to}' AND
			pi_prospect_inquiry.deleted = '0' AND
			jump_model_description.`name` LIKE '{$basemodel}%'")->row('pi');
		}
		

		return ($query);
	}
	function geto1($date_from,$date_to,$dealer,$branch,$bm){
		$basemodel = $bm;
		if ($date_from=="all") {
			$query = $this->db->query("	SELECT
			Count(ddms_sales_order.id) as `o`
			FROM
			pi_prospect_inquiry
			INNER JOIN jump_model_description_pi_prospect_inquiry_1_c ON pi_prospect_inquiry.id = jump_model_description_pi_prospect_inquiry_1_c.jump_modeldc9einquiry_idb
			INNER JOIN jump_model_description ON jump_model_description_pi_prospect_inquiry_1_c.jump_modela8cbription_ida = jump_model_description.id
			INNER JOIN users ON pi_prospect_inquiry.created_by = users.id
			INNER JOIN users_cstm ON users.id = users_cstm.id_c
			INNER JOIN pi_prospect_inquiry_ddms_sales_order_1_c ON pi_prospect_inquiry.id = pi_prospect_inquiry_ddms_sales_order_1_c.pi_prospect_inquiry_ddms_sales_order_1pi_prospect_inquiry_ida
			INNER JOIN ddms_sales_order ON ddms_sales_order.id = pi_prospect_inquiry_ddms_sales_order_1_c.pi_prospect_inquiry_ddms_sales_order_1ddms_sales_order_idb
			WHERE		
			ddms_sales_order.deleted = '0' AND
			jump_model_description.`name` LIKE '{$basemodel}%'")->row('o');
		}else{
			$query = $this->db->query("	SELECT
			Count(ddms_sales_order.id) as `o`
			FROM
			pi_prospect_inquiry
			INNER JOIN jump_model_description_pi_prospect_inquiry_1_c ON pi_prospect_inquiry.id = jump_model_description_pi_prospect_inquiry_1_c.jump_modeldc9einquiry_idb
			INNER JOIN jump_model_description ON jump_model_description_pi_prospect_inquiry_1_c.jump_modela8cbription_ida = jump_model_description.id
			INNER JOIN users ON pi_prospect_inquiry.created_by = users.id
			INNER JOIN users_cstm ON users.id = users_cstm.id_c
			INNER JOIN pi_prospect_inquiry_ddms_sales_order_1_c ON pi_prospect_inquiry.id = pi_prospect_inquiry_ddms_sales_order_1_c.pi_prospect_inquiry_ddms_sales_order_1pi_prospect_inquiry_ida
			INNER JOIN ddms_sales_order ON ddms_sales_order.id = pi_prospect_inquiry_ddms_sales_order_1_c.pi_prospect_inquiry_ddms_sales_order_1ddms_sales_order_idb
			WHERE		
			pi_prospect_inquiry.date_entered BETWEEN '{$date_from}' AND '{$date_to}' AND
			ddms_sales_order.deleted = '0' AND
			jump_model_description.`name` LIKE '{$basemodel}%'")->row('o');
		}
		

		return ($query);
	}
	function getpi2($date_from,$date_to,$dealer,$branch,$bm){
		$basemodel = $bm;
		if ($date_from=="all") {
			$query = $this->db->query("SELECT
			Count(pi_prospect_inquiry.id) as `pi`
			FROM
			pi_prospect_inquiry
			INNER JOIN jump_model_description_pi_prospect_inquiry_1_c ON pi_prospect_inquiry.id = jump_model_description_pi_prospect_inquiry_1_c.jump_modeldc9einquiry_idb
			INNER JOIN jump_model_description ON jump_model_description_pi_prospect_inquiry_1_c.jump_modela8cbription_ida = jump_model_description.id
			INNER JOIN users ON pi_prospect_inquiry.created_by = users.id
			INNER JOIN users_cstm ON users.id = users_cstm.id_c
			INNER JOIN jump_dealer ON users_cstm.jump_dealer_id_c = jump_dealer.id
			WHERE
			jump_dealer.id = '{$dealer}' AND
			pi_prospect_inquiry.deleted = '0' AND
			jump_model_description.`name` LIKE '{$basemodel}%'")->row('pi');
		}else{
			$query = $this->db->query("SELECT
			Count(pi_prospect_inquiry.id) as `pi`
			FROM
			pi_prospect_inquiry
			INNER JOIN jump_model_description_pi_prospect_inquiry_1_c ON pi_prospect_inquiry.id = jump_model_description_pi_prospect_inquiry_1_c.jump_modeldc9einquiry_idb
			INNER JOIN jump_model_description ON jump_model_description_pi_prospect_inquiry_1_c.jump_modela8cbription_ida = jump_model_description.id
			INNER JOIN users ON pi_prospect_inquiry.created_by = users.id
			INNER JOIN users_cstm ON users.id = users_cstm.id_c
			INNER JOIN jump_dealer ON users_cstm.jump_dealer_id_c = jump_dealer.id
			WHERE
			pi_prospect_inquiry.date_entered BETWEEN '{$date_from}' AND '{$date_to}' AND
			jump_dealer.id = '{$dealer}' AND
			pi_prospect_inquiry.deleted = '0' AND
			jump_model_description.`name` LIKE '{$basemodel}%'")->row('pi');
		}
		

		return ($query);
	}
	function geto2($date_from,$date_to,$dealer,$branch,$bm){
		$basemodel = $bm;
		if ($date_from=="all") {
			$query = $this->db->query("	SELECT
			Count(ddms_sales_order.id) as `o`
			FROM
			pi_prospect_inquiry
			INNER JOIN jump_model_description_pi_prospect_inquiry_1_c ON pi_prospect_inquiry.id = jump_model_description_pi_prospect_inquiry_1_c.jump_modeldc9einquiry_idb
			INNER JOIN jump_model_description ON jump_model_description_pi_prospect_inquiry_1_c.jump_modela8cbription_ida = jump_model_description.id
			INNER JOIN users ON pi_prospect_inquiry.created_by = users.id
			INNER JOIN users_cstm ON users.id = users_cstm.id_c
			INNER JOIN jump_dealer ON users_cstm.jump_dealer_id_c = jump_dealer.id
			INNER JOIN pi_prospect_inquiry_ddms_sales_order_1_c ON pi_prospect_inquiry.id = pi_prospect_inquiry_ddms_sales_order_1_c.pi_prospect_inquiry_ddms_sales_order_1pi_prospect_inquiry_ida
			INNER JOIN ddms_sales_order ON ddms_sales_order.id = pi_prospect_inquiry_ddms_sales_order_1_c.pi_prospect_inquiry_ddms_sales_order_1ddms_sales_order_idb
			WHERE		
			jump_dealer.id = '{$dealer}' AND
			ddms_sales_order.deleted = '0' AND
			jump_model_description.`name` LIKE '{$basemodel}%'")->row('o');
		}else{
			$query = $this->db->query("	SELECT
			Count(ddms_sales_order.id) as `o`
			FROM
			pi_prospect_inquiry
			INNER JOIN jump_model_description_pi_prospect_inquiry_1_c ON pi_prospect_inquiry.id = jump_model_description_pi_prospect_inquiry_1_c.jump_modeldc9einquiry_idb
			INNER JOIN jump_model_description ON jump_model_description_pi_prospect_inquiry_1_c.jump_modela8cbription_ida = jump_model_description.id
			INNER JOIN users ON pi_prospect_inquiry.created_by = users.id
			INNER JOIN users_cstm ON users.id = users_cstm.id_c
			INNER JOIN jump_dealer ON users_cstm.jump_dealer_id_c = jump_dealer.id
			INNER JOIN pi_prospect_inquiry_ddms_sales_order_1_c ON pi_prospect_inquiry.id = pi_prospect_inquiry_ddms_sales_order_1_c.pi_prospect_inquiry_ddms_sales_order_1pi_prospect_inquiry_ida
			INNER JOIN ddms_sales_order ON ddms_sales_order.id = pi_prospect_inquiry_ddms_sales_order_1_c.pi_prospect_inquiry_ddms_sales_order_1ddms_sales_order_idb
			WHERE		
			pi_prospect_inquiry.date_entered BETWEEN '{$date_from}' AND '{$date_to}' AND
			jump_dealer.id = '{$dealer}' AND
			ddms_sales_order.deleted = '0' AND
			jump_model_description.`name` LIKE '{$basemodel}%'")->row('o');
		}
		

		return ($query);
	}

	// function get_branch($id)
	// {
	// 	$sql = "SELECT jump_branch.id as branch_id, jump_branch.name  as `branch`, jump_dealer.id as dealer_id, jump_dealer.`name` as `dealer`  
	// 	FROM users_cstm LEFT JOIN jump_branch ON users_cstm.jump_branch_id_c = jump_branch.id 
	// 	LEFT JOIN jump_dealer ON users_cstm.jump_dealer_id_c = jump_dealer.id 
	// 	WHERE users_cstm.id_c ='".$id."'";
	// 	return $this->db->query($sql)->row();	
	// }

}


?>