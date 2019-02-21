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
     	$this->load->model('so_leads');
     	$this->load->model('Pi_prospect_inquiry_cstm');
	}

	public function index()
	{	
		$data = [];
		$data['dealers'] = $this->allowed_dealers();
		$data['branches'] = [];

		if(!isset($_GET['start_date']) && !isset($_GET['end_date'])){
			$_GET['start_date'] = date("Y-m") . "-01";
			$_GET['end_date'] = date("Y-m-t");
		}

		if(isset($_GET['dealer'])){
			$d = new Dealer;

		    $d->load($_GET['dealer']);
		    $data['branches'] = $d->branches();
		}	

		$user = strtolower($this->user_type());

		if($user == 'dealer' && !isset($_GET['dealer'])){
			$_GET['dealer'] = $this->arrayFirst($data['dealers']); 
		}

		if($user == 'branch' && !isset($_GET['branch'])){
			$_GET['dealer'] = $this->arrayFirst($data['dealers']); 
			$d = new Dealer;

		    $d->load($_GET['dealer']);
		    $data['branches'] = $d->branches();
		    $_GET['branch'] = $this->arrayFirst($data['branches']); 
		}

		// $this->dd($_GET['branch']);
		$data = array_merge($data, $this->so_leads->leads());
		$content = $this->load->view('reports/SO_by_lead/index.php', ['data'=>$data], TRUE);
		set_header_title("Reports - Sales Order by Lead Source");
		$this->put_contents($content, 'Sales Order Reports');
		
		// $pi = new Pi_prospect_inquiry_cstm;
			
	}

	public function dd($data){
		echo "<pre>";
		print_r($data);
		echo "<pre>";
		die();
	}

	private function arrayFirst($arr){
		foreach ($arr as $key => $value) {
			return $value->id;
		}
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */