<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-07 16:23:37
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-07 16:34:01
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseModel extends MY_Model {
	
    function getBaseModel($baseModel = null){

        return  $this->db->query('SELECT * from jump_base_model')->result();

    }
        
}