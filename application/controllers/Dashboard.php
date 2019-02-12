<?php

/**
 * @Author: ET
 * @Date:   2019-02-04 15:55:06
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-12 09:19:00
 */
defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard extends MY_Controller {

	function test(){

		$this->load->model('jump_dealer');

		$dso = new jump_dealer;
		$dso = $dso->get();

		echo "<pre>";
		print_r ($dso);
		echo "</pre>";

	}
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('user')){
			redirect('login');
		}
	}

	public function index()
	{	

		$this->load->model('pi_prospect_inquiry_cstm');
		$this->load->model('jump_dealer');
		$this->load->model('jump_branch');

		set_header_title('Servio-DMS Dashboard');

		$PIStatusReport 	= new PIStatusPieChart();
		$PerDealer 			= new PerDealerChart;
		$jd 				= new Jump_dealer;
		$branch 			= new Jump_branch;

		$branch->selects = ['name','id'];
		$branches = $branch->get();

		$branchesSelect = [];

		foreach ($branches as $value) {
			$branchesSelect[] = (object)['id' => $value->id, 'text' => $value->name];
		}


		$jd->selects = ['name as text', 'id'];
		$dealers = $jd->get();

		$dealersSelect = [];

		foreach ($dealers as $value) {
			$dealersSelect[] = (object)['id' => $value->id, 'text' => $value->name];
		}



		$cashTerm  = new Pi_prospect_inquiry_cstm;
		$cashTerm = $cashTerm->by_MOP();

		$dashboard = $this;

		$content = $this->load->view('dashboard/main', ['dealers' => $dealersSelect, 
														'dashboard' => $dashboard, 
														'cashTerm' => $cashTerm, 
														'PIStatusReport' => $PIStatusReport,
														'PerDealer' => $PerDealer,
														'branches' => $branchesSelect
													]
													, TRUE);

		$this->put_contents($content,"Dashboard");
			
			
	}
	function find_branch(){
		
	}
	function select_PIbyMOP_chart($chart, $str = FALSE)
	{
		$this->load->model('pi_prospect_inquiry_cstm');
		$cashTerm  = new Pi_prospect_inquiry_cstm;
		$cashTerm = $cashTerm->by_MOP();

		$data = [
				'dataset' 	=> $cashTerm,
				'chartType' => $chart,
				'chartId' => 'PiByMOP',
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
				'chartId' => 'PiByLeadSource',
				'sumField' => 'total',
				'xAxis' => "month",
				'labelField' => "ls_name"

			];

		return $this->create_chart($data, $str);
	}
	function PI_by_model($chart, $str = FALSE){
		$this->load->model('pi_prospect_inquiry_cstm');
		$res  = new Pi_prospect_inquiry_cstm;
		$res = $res->by_Model();

		$data = [
				'dataset' 	=> $res,
				'chartType' => $chart,
				'chartId' => 'PiByModel',
				'sumField' => 'total',
				'xAxis' => "month",
				'labelField' => "model_name"
			];

		return $this->create_chart($data, $str);
	}
	function SObyMOP_chart($chart, $str = FALSE){
		$this->load->model('Ddms_sales_order');
		$res  = new Ddms_sales_order;
		$res = $res->by_MOP();

		$data = [
				'dataset' 	=> $res,
				'chartType' => $chart,
				'chartId' => 'SOByMOP',
				'sumField' => 'total',
				'xAxis' => "month",
				'labelField' => "model_name"
			];

		return $this->create_chart($data, $str);
	}
	function SObyLS_chart($chart, $str = FALSE){
		$this->load->model('Ddms_sales_order');
		$res  = new Ddms_sales_order;
		$res = $res->by_LS();

		$data = [
				'dataset' 	=> $res,
				'chartType' => $chart,
				'chartId' => 'SOByLeadSource',
				'sumField' => 'total',
				'xAxis' => "month",
				'labelField' => "lead_source"
			];

		return $this->create_chart($data, $str);
	}
	function SObyModel_chart($chart, $str = FALSE){
		$this->load->model('Ddms_sales_order');
		$res  = new Ddms_sales_order;
		$res = $res->by_Model();

		$data = [
				'dataset' 	=> $res,
				'chartType' => $chart,
				'chartId' => 'SOByModel',
				'sumField' => 'total',
				'xAxis' => "month",
				'labelField' => "model_name"
			];

		return $this->create_chart($data, $str);
	}
	function SOInvoiced_chart($chart, $str = false){
		$this->load->model('Ddms_sales_order');
		$res  = new Ddms_sales_order;
		$res = $res->invoiced();

		$data = [
				'dataset' 	=> $res,
				'chartType' => $chart,
				'chartId' => 'soInvoiced',
				'sumField' => 'total',
				'xAxis' => "month",
				'labelField' => "model_name"
			];

		return $this->create_chart($data, $str);
	}
	public function create_chart($data, $str = FALSE){

		return $this->load->view('chartjs/bar_chart', $data, $str);

	}
	public function logout(){
		$this->session->unset_userdata('user');
        redirect('login');
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */