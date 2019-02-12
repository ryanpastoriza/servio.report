<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-07 16:23:37
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-07 16:34:01
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class LeadSource extends MY_Model {
	
    function getLeadSource(){
        return $this->db->get('lead_lead_source')->result();
    }
        
}