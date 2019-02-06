<?php

/**
 * @Author: ET
 * @Date:   2019-02-04 15:55:06
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-06 10:49:22
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."reports\PIByPaymentModeChart.php";
require APPPATH."reports\PIByPaymentModeBarChart.php";
require APPPATH."reports\PIByLeadSourceLineChart.php";

class Dashboard extends MY_Controller {

	public function index()
	{	

		set_header_title('Servio-DMS Dashboard');

		$report = new PIByPaymentModeChart;
		$PILSReport = new PIByLeadSourceLineChart;

		$content = $this->load->view('dashboard/main', ['report' => $report, 'PILSReport' => $PILSReport], TRUE);

		$this->put_contents($content);
			
			
	}
	function select_chart($chart)
	{
		$report = new $chart;
		$this->load->view('reports/prospect_inquiry_by_payment_mode/chart', ['report' => $report], false);

	}


}

/* End of file login.php */
/* Location: ./application/controllers/login.php */