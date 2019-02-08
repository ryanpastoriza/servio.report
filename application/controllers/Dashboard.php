<?php

/**
 * @Author: ET
 * @Date:   2019-02-04 15:55:06
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-07 16:52:38
 */
defined('BASEPATH') OR exit('No direct script access allowed');



class Dashboard extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('id')){
			redirect('login');
		}
	}

	public function index()
	{	

		$this->load->model('pi_prospect_inquiry_cstm');

		set_header_title('Servio-DMS Dashboard');

		$report 			= new PIByPaymentModeChart;
		$PILSReport 		= new PIByLeadSourceLineChart;
		$PIStatusReport 	= new PIStatusPieChart();
		$PerDealer 			= new PerDealerChart;

		$cashTerm  = new Pi_prospect_inquiry_cstm;

			$cashTerm = $cashTerm->search(['payment_terms_c' => 'cash']);

		$dashboard = $this;

		$content = $this->load->view('dashboard/main', ['dashboard' => $dashboard, 'cashTerm' => $cashTerm,'report' => $report, 'PILSReport' => $PILSReport, 'PIStatusReport' => $PIStatusReport, 'PerDealer' => $PerDealer], TRUE);

		$this->put_contents($content,"Dashboard");
			
			
	}
	function select_chart($chart)
	{
		$report = new $chart;
		$this->load->view('reports/prospect_inquiry_by_payment_mode/chart', ['report' => $report], false);

	}

	public function create_chart($data){

		$this->load->view('chartjs/bar_chart', $data, FALSE);

	}
	public function logout(){
		unset(
        	$_SESSION['username'],
			$_SESSION['id'],
			$_SESSION['title']
        );
        redirect('login');
	}


}

/* End of file login.php */
/* Location: ./application/controllers/login.php */