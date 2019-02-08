<?php

/**
 * @Author: ET
 * @Date:   2019-02-04 15:55:06
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-08 17:02:00
 */
defined('BASEPATH') OR exit('No direct script access allowed');



class Dashboard extends MY_Controller {



	public function index()
	{	

		$this->load->model('pi_prospect_inquiry_cstm');

		set_header_title('Servio-DMS Dashboard');

		$report 			= new PIByPaymentModeChart;
		$PILSReport 		= new PIByLeadSourceLineChart;
		$PIStatusReport 	= new PIStatusPieChart();
		$PerDealer 			= new PerDealerChart;

		$cashTerm  = new Pi_prospect_inquiry_cstm;
		$cashTerm = $cashTerm->by_MOP();

		$dashboard = $this;

		$content = $this->load->view('dashboard/main', ['dashboard' => $dashboard, 'cashTerm' => $cashTerm,'report' => $report, 'PILSReport' => $PILSReport, 'PIStatusReport' => $PIStatusReport, 'PerDealer' => $PerDealer], TRUE);

		$this->put_contents($content,"Dashboard");
			
			
	}
	function select_PIbyMOP_chart($chart, $str = FALSE)
	{
		$this->load->model('pi_prospect_inquiry_cstm');
		$cashTerm  = new Pi_prospect_inquiry_cstm;
		$cashTerm = $cashTerm->by_MOP();

		$data = [
				'dataset' 	=> $cashTerm,
				'chartType' => $chart,
				'chartId' => 'slsOrderByMOP',
				'sumField' => 'total',
				'xAxis' => "month",
				'labelField' => "payment_terms_c"

			];

		return $this->create_chart($data, $str);
	}
	function PI_by_LS($chart, $str = FALSE)
	{
		
		$this->load->model('pi_prospect_inquiry_cstm');
		$res  = new Pi_prospect_inquiry_cstm;
		$res = $res->by_LS();

		$data = [
				'dataset' 	=> $res,
				'chartType' => $chart,
				'chartId' => 'slsOrderByLS',
				'sumField' => 'total',
				'xAxis' => "month",
				'labelField' => "ls_name"

			];

		return $this->create_chart($data, $str);
	}

	public function create_chart($data, $str = FALSE){

		return $this->load->view('chartjs/bar_chart', $data, $str);

	}


}

/* End of file login.php */
/* Location: ./application/controllers/login.php */