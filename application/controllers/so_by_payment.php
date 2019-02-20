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

		$pt = $this->so_payment_term->soByPaymentTerms($pm);

		$pt['dealers'] = $this->allowed_dealers();
		$pt['branches'] = [];

		if(isset($_GET['dealer'])){
			$d = new Dealer;

		    $d->load($_GET['dealer']);
		    $pt['branches'] = $d->branches();
		}		
    		

		// echo "<pre>";
		// print_r($);
		// echo "<pre>";
		// die();

		$content = $this->load->view('reports/so_by_payment/index.php', ['data'=>$pt], TRUE);
		set_header_title("Reports - Sales Order by Mode of Payment");
		$this->put_contents($content, 'Sales Order Reports');
		
		// $pi = new Pi_prospect_inquiry_cstm;
			
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */