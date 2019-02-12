<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-07 16:23:37
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-12 11:44:27
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends MY_Model {

	const DB_TABLE = 'jump_branch';
	const DB_TABLE_PK = 'id';

	
    function getBranch($id){

        $sql = "SELECT jump_branch.id as branch_id, jump_branch.name  as `branch`, jump_dealer.id as dealer_id, jump_dealer.`name` as `dealer`  
		FROM users_cstm LEFT JOIN jump_branch ON users_cstm.jump_branch_id_c = jump_branch.id 
		LEFT JOIN jump_dealer ON users_cstm.jump_dealer_id_c = jump_dealer.id 
		WHERE users_cstm.id_c ='".$id."'";
		return $this->db->query($sql)->row();	

    }
        
}