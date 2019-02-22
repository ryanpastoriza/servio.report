<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-06 10:46:14
 * @Last Modified by:   IanJayBronola

 * @Last Modified time: 2019-02-20 14:37:35

 */
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."reports\PIByPaymentModeChart.php";
require APPPATH."reports\PIByPaymentModeBarChart.php";
require APPPATH."reports\PIByLeadSourceLineChart.php";
require APPPATH."reports\PIByLeadSourceBarChart.php";

require APPPATH."reports\PIStatusPieChart.php";
require APPPATH."reports\PerDealerChart.php";


class MY_Controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->dealer_user_titles 	= ['dealer_sales_manager'];
		$this->branch_user_tiles 	= ['branch_sales_manager'];
		$this->mmpc_user_titles 	= ['mmpc'];
		if($this->session->get_userdata('user')['user']){
			$this->user_info = $this->session->get_userdata('user')['user'];
		}
		else{
			redirect("login");
		}
	}

	public function index()
	{
		
	}
	function put_contents($content,$contentHeader)
	{

		$vars = [
					'addStyles'  => [ 
										asset_url('plugins/select2/select2.min.css'),
										// asset_url('plugins/datatables/dataTables.bootstrap.css'),
										// asset_url('plugins/datatables/jquery.dataTables.min.css'),
										// asset_url('plugins/dataTables/extensions/buttons/css/buttons.bootstrap.min.css'),
										// asset_url('plugins/dataTables/extensions/buttons/css/buttons.dataTables.min.css'),

										asset_url('datatable_reports/jquery.dataTables.min.css'),
										asset_url('datatable_reports/buttons.dataTables.min.css'),

									],
					'addPlugins' => [ 

										asset_url('datatable_reports/jquery.dataTables.min.js'),
										asset_url('datatable_reports/dataTables.buttons.min.js'),
										asset_url('datatable_reports/buttons.print.min.js'),
										asset_url('datatable_reports/buttons.flash.min.js'),
										asset_url('datatable_reports/buttons.html5.min.js'),
										asset_url('datatable_reports/jszip.min.js'),
										asset_url('datatable_reports/pdfmake.min.js'),
										asset_url('datatable_reports/vfs_fonts.js'),


										// asset_url('plugins/datatables/jquery.dataTables.min.js'),
										// asset_url('plugins/datatables/version1/dataTables.buttons.min.js'),
										// asset_url('plugins/datatables/extensions/buttons/js/buttons.flash.min.js'),
										// asset_url('plugins/datatables/extensions/buttons/js/buttons.html5.min.js'),
										// asset_url('plugins/datatables/extensions/buttons/js/buttons.print.min.js'),
										// asset_url('plugins/datatables/jszip.min.js'),
										// asset_url('plugins/datatables/pdfmake.min.js'),
										// asset_url('plugins/datatables/vfs_fonts.js'),

										asset_url('plugins/chartjs/Chart.js'),
										asset_url('plugins/momentjs/moment.js'),
										asset_url('plugins/select2/select2.full.min.js'),
										asset_url('plugins/jquery.form.min.js'),

										asset_url('plugins/jquery.printThis.js'),
									],
					'rightNav' => ["<a href='#'><span>{$this->user_info->fullname}</span></a>"]
				];



		$content_vars = ['contentHeader' => $contentHeader,
							'content' => $content
						];



		$footer_vars = ['addScripts' => [],
						'right' => "Version 1",
						'left' => "<span class='text-blue'>Engtech Global Solutions Inc.</span> Copyright &copy; 2019"
						];
		$nav_vars 	= ['userPanel' => ['userInfo' => $this->user_info->dealer->branch."<br>".$this->user_info->title,
										'userName' => $this->user_info->fullname,
										'userImage' => asset_url('dist/img/avatar5.png')],
						'searchBar' => false,
						'options' => ['Dashboard' => 
										['icon' => 'fa fa-dashboard', 
										'link' => base_url('dashboard')
											],
										'Reports' => 
										['icon' => 'fa fa-line-chart', 
										'link' => [
													'Prospect Inquiry by Lead Source' => base_url('reports/lead_source'),
													'Prospect Inquiry by Mode of Payment' => '',
													'Inquiry per Dealer' => '',
													'Inquiry per Model' => '',
													'Prospect Inquiry by Mode of Payment' => base_url('reports/payment_mode'),
													'Inquiry per Dealer' => base_url('reports/inquiry_per_dealer'),
													'Inquiry per Model' => base_url('ipm/inquiry_per_model'),
													'Sales Order by Lead Source' => base_url('so_by_leads'),
													'Sales Order by Payment Mode' => base_url('so_by_payment'),

 												  ]

											]
									],
					];



		echo lte_load_view('header',$vars);
		echo lte_load_view('side_nav',$nav_vars);
		echo lte_load_view('content',$content_vars);
		echo lte_load_view('footer',$footer_vars);
	}

	function allowed_dealers(){
		$this->load->model('setup/Dealer');

		$mmpc_user 		= in_array(strtolower($this->user_info->title),$this->mmpc_user_titles);

		$dealer_user 	= in_array($this->user_info->title,$this->dealer_user_titles);
		$dealer = new Dealer;

		if($mmpc_user){
			return $dealer->get();
		}
		else{
			$dealer = $dealer->search(['id' => $this->user_info->dealer->dealer_id]);
			return $dealer;
		}
	}
	function user_type(){
		$mmpc_user 		= in_array(strtolower($this->user_info->title), $this->mmpc_user_titles);
		$dealer_user 	= in_array(strtolower($this->user_info->title), $this->dealer_user_titles);

		if($mmpc_user){
			return "MMPC";
		}
		elseif ($dealer_user) {
			return "dealer";
		}
		else{
			return "branch";
		}

	}
	function allowed_branches(){
		$this->load->model('dealer');
		$this->load->model('branch');


		$mmpc_user 		= in_array(strtolower($this->user_info->title), $this->mmpc_user_titles);
		$dealer_user 	= in_array(strtolower($this->user_info->title), $this->dealer_user_titles);
		$branch_user 	= in_array(	strtolower($this->user_info->title), $this->branch_user_tiles);
		$branch = new Branch;


		$dealer = new Dealer;
		$dealer->load($this->user_info->dealer->dealer_id);

		if($mmpc_user)
		{
			return $branch->get();
		}
		elseif($dealer_user){
			return $dealer->branches();
		}
		else
		{
			$branch = $branch->search(['id' => $this->user_info->dealer->branch_id]);
			return $branch;
		}
	}


}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */