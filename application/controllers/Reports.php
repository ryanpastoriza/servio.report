<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-06 10:50:14
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-06 10:50:44
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {

	public function index()
	{
		$this->put_contents("content", "");
	}

	public function lead_source(){
		
		$content = $this->load->view("reports/prospect_inquiry_by_lead/index.php" ,[],TRUE);
		set_header_title("Reports - Lead Source");
		$this->put_contents($content,"Lead Source");
	}

	public function lead_data(){
		
		$array = [];

		for ( $i = 0; $i < 5 ; $i++) { 
			$array[] = [
						"fname" => "fname".$i,
						"lname" => "lname".$i,
					 ];
		}

		echo json_encode([
			"data" => $array
		]);

	}

}

/* End of file Reports.php */
/* Location: ./application/controllers/Reports.php */