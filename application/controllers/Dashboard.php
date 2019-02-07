<?php

/**
 * @Author: ET
 * @Date:   2019-02-04 15:55:06
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-06 15:57:22
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

		set_header_title('Servio-DMS Dashboard');

		$report 			= new PIByPaymentModeChart;
		$PILSReport 		= new PIByLeadSourceLineChart;
		$PIStatusReport 	= new PIStatusPieChart();
		$PerDealer 			= new PerDealerChart;

		$content = $this->load->view('dashboard/main', ['report' => $report, 'PILSReport' => $PILSReport, 'PIStatusReport' => $PIStatusReport, 'PerDealer' => $PerDealer], TRUE);

		$this->put_contents($content,"Dashboard");
			
			
	}
	function select_chart($chart)
	{
		$report = new $chart;
		$this->load->view('reports/prospect_inquiry_by_payment_mode/chart', ['report' => $report], false);

	}

	function prospect_status_chart(){



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