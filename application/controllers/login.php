<?php

/**
 * @Author: ET
 * @Date:   2019-02-04 15:55:06
 * @Last Modified by:   ET
 * @Last Modified time: 2019-02-05 17:59:32
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."reports\PIByPaymentModeChart.php";
require APPPATH."reports\PIByPaymentModeBarChart.php";
require APPPATH."reports\PIByLeadSourceLineChart.php";

class Login extends CI_Controller {

	public function index()
	{	

		set_header_title('Servio-DMS Dashboard');

		$vars = ['addStyles' => [],
				'addPlugins' => []];

		$report = new PIByPaymentModeChart;
		$PILSReport = new PIByLeadSourceLineChart;


		$content_vars = ['contentHeader' => 'Servio-DMS Dashboard',
							'content' => $this->load->view('dashboard/main', ['report' => $report, 'PILSReport' => $PILSReport], TRUE)
						];

		$footer_vars = ['addScripts' => [],
						'right' => "Version 1",
						'left' => "<span class='text-blue'>Engtech Global Solutions Inc.</span> Copyright &copy; 2019"
						];
		$nav_vars 	= ['userPanel' => [],
						'searchBar' => false,
						'options' => ['Dashboard' => 
										['icon' => 'fa fa-dashboard', 
										'link' => ''
											],
										'Reports' => 
										['icon' => 'fa fa-line-chart', 
										'link' => base_url('reports')
											]
									],
					];


			echo lte_load_view('header',$vars);
			echo lte_load_view('side_nav',$nav_vars);
			echo lte_load_view('content',$content_vars);
			echo lte_load_view('footer',$footer_vars);

			
	}
	function select_chart($chart)
	{
		$report = new $chart;
		$this->load->view('reports/prospect_inquiry_by_payment_mode/chart', ['report' => $report], false);

	}


}

/* End of file login.php */
/* Location: ./application/controllers/login.php */