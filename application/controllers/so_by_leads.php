<?php

/**
 * @Author: ET
 * @Date:   2019-02-04 15:55:06
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-06 11:10:52
 */
defined('BASEPATH') OR exit('No direct script access allowed');


class So_by_leads extends MY_Controller {

	public function __construct() {
		
		parent::__construct();

     	// Load model
     	$this->load->model('so_lead');
     	$this->load->model('Pi_prospect_inquiry_cstm');
	}

	public function index()
	{	
		$data = $this->so_lead->leads();	

		$content = $this->load->view('reports/SO_by_lead/index.php', ['data'=>$data], TRUE);
		$this->put_contents($content, 'Sales Order Reports');
		
		// $pi = new Pi_prospect_inquiry_cstm;
			
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */