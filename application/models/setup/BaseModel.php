<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-07 16:23:37
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-22 17:22:18
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseModel extends MY_Model {

	const DB_TABLE 		= 'jump_base_model';
	const DB_TABLE_PK 	= 'id';
	
    function getBaseModel($baseModel = null){
        return  $this->db->query('SELECT * from jump_base_model')->result();

    }
        
  	function model_descriptions($like = ""){
  		$this->toJoin = [
  							['jump_base_model_jump_model_description_1_c', "jump_base_model_jump_model_description_1_c.jump_base_model_jump_model_description_1jump_base_model_ida = jump_base_model.id", "INNER"],
  							['jump_model_description', "jump_base_model_jump_model_description_1_c.jump_base_ae81ription_idb = jump_model_description.id", "INNER"],
  						];
  		return $this->search("jump_model_description.name like '%{$like}%'");
  	}

}