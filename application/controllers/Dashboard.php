<?php

/**
 * @Author: ET
 * @Date:   2019-02-04 15:55:06
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-22 11:43:02
 */
defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard extends MY_Controller {

	function test(){
		$dealer = new Dealer;
		$dealer->load('3f2c1bb1-fc53-7f3e-f6f6-5c3559b9edd0');

		echo "<pre>";
			print_r($dealer);
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
		$this->load->model('BaseModel');
		$this->load->model('modelDescription');
		$this->load->model('Lead_lead_source');

		set_header_title('Servio-DMS Dashboard');

		$PIStatusReport 	= new PIStatusPieChart();
		$PerDealer 			= new PerDealerChart;
		$pI 				= new Pi_prospect_inquiry_cstm;
		$bm 				= new BaseModel;
		$bm->sqlQueries['toGroup'] = 'jump_base_model.name';



		$dealers 	 = $this->allowed_dealers();
		$pis 		 = $pI->payment_terms();
		$bms 		 = $bm->get();
		$mds 	  	 = $this->ModelDescription->get();
		$ls 		 = $this->Lead_lead_source->get();

		$dealersSelect = [];
		$MOP 		   = [];
		$baseModelSelect = [];
		$moDes 			= [];
		$lss 			= [];


		foreach ($ls as $value) {
			$lss[] = (object)['id' => $value->id, 'text' => $value->name];
		}
		foreach ($mds as $value) {
			$moDes[] = (object)['id' => $value->id, 'text' => $value->name];
		}
		foreach ($bms as $value) {
			$baseModelSelect[] = (object)['id' => $value->name, 'text' => $value->name];
		}
		foreach ($pis as $value) {
			$MOP[] = (object)['id' => $value->payment_terms_c, 'text' => ucfirst($value->payment_terms_c)];
		}
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
														'modeOfPayments' => $MOP,
														'baseModels' => $baseModelSelect,
														'modelDescriptions' => $moDes,
														'leadSources' 	=> $lss
													]
													, TRUE);

		$this->put_contents($content,"Dashboard");
			
			
	}
	function select_PIbyMOP_chart($chart, $str = FALSE, $cond = [])
	{
		if (count($_POST) > 0 ) {
			if($_POST['from_date'] == '' || $_POST['to_date'] == ''){
				$_POST['from_date'] = date('Y-m-01');
				$_POST['to_date'] = date('Y-m-t');
			}
			$cond = $this->refine_condition_for_PI($_POST);
		}
		else{
			$thPost = ['from_date' => date('Y-m-01'),
						'to_date' => date('Y-m-t')];
			$cond = $this->refine_condition_for_PI($thPost);
		}

		$this->load->model('pi_prospect_inquiry_cstm');
		$cashTerm  = new Pi_prospect_inquiry_cstm;
		$cashTerm = $cashTerm->by_MOP($cond);

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
	function PI_by_LS($chart, $str = FALSE, $cond = [])
	{

		if (count($_POST) > 0 ) {
			if($_POST['from_date'] == '' || $_POST['to_date'] == ''){
				$_POST['from_date'] = date('Y-m-01');
				$_POST['to_date'] = date('Y-m-t');
			}
			$cond = $this->refine_condition_for_PI($_POST);
		}
		else{
			$thPost = ['from_date' => date('Y-m-01'),
						'to_date' => date('Y-m-t')];
			$cond = $this->refine_condition_for_PI($thPost);
		}

		$this->load->model('pi_prospect_inquiry_cstm');
		$res  = new Pi_prospect_inquiry_cstm;
		$res = $res->by_LS($cond);

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
	function PI_by_status(){

		$this->load->model('pi_prospect_inquiry_cstm');
		$res  = new Pi_prospect_inquiry_cstm;
		$res = $res->by_LS([]);


		$data = [
					'dataset' 	=> $res,
					'chartType' => 'pie',
					'chartId' => 'PiByLeadSource',
					'sumField' => 'total',
					'xAxis' => "month",
					'labelField' => "ls_name"

			];

		return $this->create_chart($data, TRUE);
	}
	function PI_by_model($chart, $str = FALSE, $cond = []){

		if (count($_POST) > 0 ) {
			if($_POST['from_date'] == '' || $_POST['to_date'] == ''){
				$_POST['from_date'] = date('Y-m-01');
				$_POST['to_date'] = date('Y-m-t');
			}
			$cond = $this->refine_condition_for_PI($_POST);
		}
		else{
			$thPost = ['from_date' => date('Y-m-01'),
						'to_date' => date('Y-m-t')];
			$cond = $this->refine_condition_for_PI($thPost);
		}

		$this->load->model('pi_prospect_inquiry_cstm');
		$res  = new Pi_prospect_inquiry_cstm;
		$res = $res->by_Model($cond);

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
	function SObyMOP_chart($chart, $str = FALSE, $cond = []){
		if (count($_POST) > 0 ) {
			if($_POST['from_date'] == '' || $_POST['to_date'] == ''){
				$_POST['from_date'] = date('Y-m-01');
				$_POST['to_date'] = date('Y-m-t');
			}
			$cond = $this->refine_condition_for_SO($_POST);
		}
		else{
			$thPost = ['from_date' => date('Y-m-01'),
						'to_date' => date('Y-m-t')];
			$cond = $this->refine_condition_for_SO($thPost);
		}
		$this->load->model('Ddms_sales_order');
		$res  = new Ddms_sales_order;
		$res = $res->by_MOP($cond);

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
	function SObyLS_chart($chart, $str = FALSE, $cond = []){
		if (count($_POST) > 0 ) {
			if($_POST['from_date'] == '' || $_POST['to_date'] == ''){
				$_POST['from_date'] = date('Y-m-01');
				$_POST['to_date'] = date('Y-m-t');
			}
			$cond = $this->refine_condition_for_SO($_POST);
		}
		else{
			$thPost = ['from_date' => date('Y-m-01'),
						'to_date' => date('Y-m-t')];
			$cond = $this->refine_condition_for_SO($thPost);
		}
		$this->load->model('Ddms_sales_order');
		$res  = new Ddms_sales_order;
		$res = $res->by_LS($cond);

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
	function SObyModel_chart($chart, $str = FALSE, $cond = []){
		if (count($_POST) > 0 ) {
			if($_POST['from_date'] == '' || $_POST['to_date'] == ''){
				$_POST['from_date'] = date('Y-m-01');
				$_POST['to_date'] = date('Y-m-t');
			}
			$cond = $this->refine_condition_for_SO($_POST);
		}
		else{
			$thPost = ['from_date' => date('Y-m-01'),
						'to_date' => date('Y-m-t')];
			$cond = $this->refine_condition_for_SO($thPost);
		}
		$this->load->model('Ddms_sales_order');
		$res  = new Ddms_sales_order;
		$res = $res->by_Model($cond);

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
	function SOInvoiced_chart($chart, $str = false, $cond = []){
		if (count($_POST) > 0 ) {
			if($_POST['from_date'] == '' || $_POST['to_date'] == ''){
				$_POST['from_date'] = date('Y-m-01');
				$_POST['to_date'] = date('Y-m-t');
			}
			$cond = $this->refine_condition_for_SO($_POST);
		}
		else{
			$thPost = ['from_date' => date('Y-m-01'),
						'to_date' => date('Y-m-t')];
			$cond = $this->refine_condition_for_SO($thPost);
		}
		$this->load->model('Ddms_sales_order');
		$res  = new Ddms_sales_order;
		$res = $res->invoiced($cond);

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
	function get_branches(){

		$this->load->model('setup/dealer');
		$selected = $this->input->post('selected');
		$selected = explode(",", $selected);

		$all_branches = [];
		$all_ids = [];

		foreach ($selected as $value) {
			if($value != ""){
			$dealer = new Dealer;
			$dealer->load($value);

			$branches = $dealer->branches();

			foreach ($branches as $value2) {
				if(!in_array($value2->id, $all_ids)){
					$all_branches[] = (object)['id' => $value2->id, 'text' => $value2->name];
					$all_ids[] = $value2->id;
				}
			}
			}

		}


		echo json_encode($all_branches);
	}
	function refine_condition_for_PI($cond){

		$qry = "";


		if($cond['from_date'] && $cond['to_date']){
			$qry .= " pi_prospect_inquiry_cstm.inquiry_date_c BETWEEN '{$cond['from_date']}' AND '{$cond['to_date']}' ";
		}

		if (isset($cond['dealers'])) {
			$qry .= $qry != "" ? "AND" : "";
			$qry .= "(";

			$counter = 0;
			foreach ($cond['dealers'] as $value) {
				$counter++;
				$qry .= " users_cstm.jump_dealer_id_c = '{$value}' ";
				$qry .= $counter < count($cond['dealers']) ? " OR ": "";
			}
			$qry .= ")";
		}
		else{
			if($this->user_type() == 'dealer'){
				$qry .= "AND (users_cstm.jump_dealer_id_c = '{$this->user_info->dealer->dealer_id}' )";
			}
		}
		if(isset($cond['branches'])){
			$qry .= $qry != "" ? "AND" : "";
			$qry .= "(";

			$counter = 0;
			foreach ($cond['branches'] as $value) {
				$counter++;
				$qry .= " users_cstm.jump_branch_id_c = '{$value}' ";
				$qry .= $counter < count($cond['branches']) ? " OR ": "";
			}

			$qry .= ")";
		}
		else{
			if($this->user_type() == 'branch' ){
				$qry .= "AND (users_cstm.jump_branch_id_c = '{$this->user_info->dealer->branch_id}' )";
			}
		}

		if(isset($cond['mode_of_payments'])){
			$qry .= $qry != "" ? "AND" : "";
			$qry .= "(";

			$counter = 0;
			foreach ($cond['mode_of_payments'] as $value) {
				$counter++;
				$qry .= " pi_prospect_inquiry_cstm.payment_terms_c = '{$value}' ";
				$qry .= $counter < count($cond['mode_of_payments']) ? " OR ": "";
			}

			$qry .= ")";
		}
		if(isset($cond['base_models'])){
			$qry .= $qry != "" ? "AND" : "";
			$qry .= "(";

			$counter = 0;
			foreach ($cond['base_models'] as $value) {
				$counter++;
				$qry .= " jump_base_model.name = '{$value}' ";
				$qry .= $counter < count($cond['base_models']) ? " OR ": "";
			}

			$qry .= ")";
		}
		if(isset($cond['vehicle_descriptions'])){
			$qry .= $qry != "" ? "AND" : "";
			$qry .= "(";

			$counter = 0;
			foreach ($cond['vehicle_descriptions'] as $value) {
				$counter++;
				$qry .= " jump_model_description_pi_prospect_inquiry_1_c.jump_modela8cbription_ida = '{$value}' ";
				$qry .= $counter < count($cond['vehicle_descriptions']) ? " OR ": "";
			}

			$qry .= ")";
		}
		if(isset($cond['lead_sources'])){
			$qry .= $qry != "" ? "AND" : "";
			$qry .= "(";

			$counter = 0;
			foreach ($cond['lead_sources'] as $value) {
				$counter++;
				$qry .= " lead_lead_source_pi_prospect_inquiry_1_c.lead_lead_source_pi_prospect_inquiry_1lead_lead_source_ida = '{$value}' ";
				$qry .= $counter < count($cond['lead_sources']) ? " OR ": "";
			}

			$qry .= ")";
		}
		

		return $qry;
	}
	function refine_condition_for_SO($cond){
		$qry = "";


		if($cond['from_date'] && $cond['to_date']){
			$qry .= " Ddms_sales_order.date_entered BETWEEN '{$cond['from_date']}' AND '{$cond['to_date']}' ";
		}
		if (isset($cond['dealers'])) {
			$qry .= $qry != "" ? "AND" : "";
			$qry .= "(";

			$counter = 0;
			foreach ($cond['dealers'] as $value) {
				$counter++;
				$qry .= " users_cstm.jump_dealer_id_c = '{$value}' ";
				$qry .= $counter < count($cond['dealers']) ? " OR ": "";
			}
			$qry .= ")";
		}
		else{
			if($this->user_type() == 'dealer'){
				$qry .= "AND (users_cstm.jump_dealer_id_c = '{$this->user_info->dealer->dealer_id}' )";
			}
		}

		if(isset($cond['branches'])){
			$qry .= $qry != "" ? "AND" : "";
			$qry .= "(";

			$counter = 0;
			foreach ($cond['branches'] as $value) {
				$counter++;
				$qry .= " users_cstm.jump_branch_id_c = '{$value}' ";
				$qry .= $counter < count($cond['branches']) ? " OR ": "";
			}

			$qry .= ")";
		}else{
			if($this->user_type() == 'branch' ){
				$qry .= "AND (users_cstm.jump_branch_id_c = '{$this->user_info->dealer->branch_id}' )";
			}
		}
		if(isset($cond['mode_of_payments'])){
			$qry .= $qry != "" ? "AND" : "";
			$qry .= "(";

			$counter = 0;
			foreach ($cond['mode_of_payments'] as $value) {
				$counter++;
				$qry .= " Ddms_sales_order_cstm.payment_terms_c = '{$value}' ";
				$qry .= $counter < count($cond['mode_of_payments']) ? " OR ": "";
			}

			$qry .= ")";
		}
		if(isset($cond['base_models'])){
			$qry .= $qry != "" ? "AND" : "";
			$qry .= "(";

			$counter = 0;
			foreach ($cond['base_models'] as $value) {
				$counter++;
				$qry .= " jump_base_model.name = '{$value}' ";
				$qry .= $counter < count($cond['base_models']) ? " OR ": "";
			}

			$qry .= ")";
		}
		if(isset($cond['vehicle_descriptions'])){
			$qry .= $qry != "" ? "AND" : "";
			$qry .= "(";

			$counter = 0;
			foreach ($cond['vehicle_descriptions'] as $value) {
				$counter++;
				$qry .= " jump_model_description.id = '{$value}' ";
				$qry .= $counter < count($cond['vehicle_descriptions']) ? " OR ": "";
			}

			$qry .= ")";
		}
		if(isset($cond['lead_sources'])){
			$qry .= $qry != "" ? "AND" : "";
			$qry .= "(";

			$counter = 0;
			foreach ($cond['lead_sources'] as $value) {
				$counter++;
				$qry .= " Lead_lead_source_ddms_sales_order_1_c.lead_lead_source_ddms_sales_order_1lead_lead_source_ida = '{$value}' ";
				$qry .= $counter < count($cond['lead_sources']) ? " OR ": "";
			}

			$qry .= ")";
		}
		

		return $qry;
	}
	function apply_search(){
		$charts = [];
		if ($_POST['from_date'] == '' || $_POST['to_date'] == '') {
			$_POST['from_date'] = date('Y-01-d');
			$_POST['to_date'] = date('Y-t-d');
		}

		$cond = $this->refine_condition_for_PI($_POST);
		$SOcond = $this->refine_condition_for_SO($_POST);

		$charts['pi_by_mop'] 	= $this->select_PIbyMOP_chart('line', TRUE, $cond);
		$charts['pi_by_ls'] 	= $this->PI_by_LS('line', TRUE, $cond);
		$charts['pi_by_model'] 	= $this->PI_by_model('line', TRUE, $cond);
		$charts['so_by_mop'] 	= $this->SObyMOP_chart('line', TRUE, $SOcond);
		$charts['so_by_ls'] 	= $this->SObyLS_chart('line', TRUE, $SOcond);
		$charts['so_by_model'] 	= $this->SObyModel_chart('line', TRUE, $SOcond);
		$charts['so_invoiced'] 	= $this->SOInvoiced_chart('line', TRUE, $SOcond);

		echo json_encode($charts);
	}
	function get_model_descriptions(){
		$this->load->model('setup/BaseModel');
		$selected = $this->input->post('selected');
		$selected = explode(",", $selected);

		$all_model_descriptions = [];
		$all_ids = [];

		foreach ($selected as $value) {
			if($value != ""){
			$bm = new BaseModel;
			$bm->load($value);

			$moDes = $bm->model_descriptions();

			foreach ($moDes as $value2) {
				if(!in_array($value2->id, $all_ids)){
					$all_model_descriptions[] = (object)['id' => $value2->id, 'text' => $value2->name];
					$all_ids[] = $value2->id;
				}
			}
			}

		}

		echo json_encode($all_model_descriptions);
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