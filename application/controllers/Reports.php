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

		$query = $this->db->get('lead_lead_source')->result();

		foreach ($query as $key => $value) {
			$array[] = [
						"source_of_sale" => ucwords($value->name),
						"lname" => ucwords($value->name),
					 ];
		}

		echo json_encode([
			"data" => $array
		]);

	}

	public function test_method(){


	}

}

/* End of file Reports.php */
/* Location: ./application/controllers/Reports.php */