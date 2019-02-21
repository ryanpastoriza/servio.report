<?php

/**
 * @Author: ET
 * @Date:   2019-02-04 15:55:06
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-06 11:10:52
 */
defined('BASEPATH') OR exit('No direct script access allowed');


class So_by_payment extends MY_Controller {

	public function __construct() {
		
		parent::__construct();

     	// Load model
     	$this->load->model('so_payment_term');
     	$this->load->model('Pi_prospect_inquiry_cstm');
	}

	public function index()
	{	
		$pm = [];

		$payment_terms = $this->Pi_prospect_inquiry_cstm->payment_terms();
		foreach ($payment_terms as $key => $value) {
			$pm[] = $value->payment_terms_c;
		}
		$pt = [];
		if(!isset($_GET['start_date']) && !isset($_GET['end_date'])){
			$_GET['start_date'] = date("Y-m") . "-01";
			$_GET['end_date'] = date("Y-m-t");
		}

		$pt['dealers'] = $this->allowed_dealers();
		$pt['branches'] = [];

		if(isset($_GET['dealer'])){
			$d = new Dealer;

		    $d->load($_GET['dealer']);
		    $pt['branches'] = $d->branches();
		}
    		
		$user = strtolower($this->user_type());

		if($user == 'dealer' && !isset($_GET['dealer'])){
			$_GET['dealer'] = $this->arrayFirst($pt['dealers']); 
		}
		if($user == 'branch' && !isset($_GET['branch'])){
			$_GET['dealer'] = $this->arrayFirst($pt['dealers']); 
			$d = new Dealer;

		    $d->load($_GET['dealer']);
		    $pt['branches'] = $d->branches();
		    $_GET['branch'] = $this->arrayFirst($pt['branches']); 
		}
		// $this->dd($_GET['branch']);
		$pt = array_merge($pt, $this->so_payment_term->soByPaymentTerms($pm));
		// $pt = $this->so_payment_term->soByPaymentTerms($pm);

		$content = $this->load->view('reports/so_by_payment/index.php', ['data'=>$pt], TRUE);
		set_header_title("Reports - Sales Order by Mode of Payment");
		$this->put_contents($content, 'Sales Order Reports');
		
		// $pi = new Pi_prospect_inquiry_cstm;
			
	}


	private function arrayFirst($arr){
		foreach ($arr as $key => $value) {
			return $value->id;
		}
	}

	private function dd($arr){
		echo "<pre>";
		print_r($arr);
		echo "<pre>";
		die();
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */