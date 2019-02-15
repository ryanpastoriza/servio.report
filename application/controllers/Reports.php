<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-06 10:50:14
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-06 10:50:44
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {

	public function index()
	{
		$this->put_contents("content", "");
	}

	public function lead_source(){
		
		$base_model = $this->base_model_records();
		$dealers    = $this->dealer_with_branches();

		$content = $this->load->view("reports/prospect_inquiry_by_lead/index.php" ,[ "base_model" => $base_model, "dealers" => $dealers], TRUE);
		set_header_title("Reports - Lead Source");
		$this->put_contents($content,"Lead Source");
	}

	public function payment_mode(){
		
		$base_model = $this->base_model_records();
		$dealers    = $this->dealers();

		$content = $this->load->view("reports/prospect_inquiry_by_payment_mode_table/index.php" ,[ "base_model" => $base_model, "dealers" => $dealers], TRUE);
		set_header_title("Reports - Payment Mode");
		$this->put_contents($content,"Payment Mode");
	}

	public function lead_data(){

		$array = [];
		$grand_total = 0;

		$conditions  = '';

		$dealer    = trim($_REQUEST['data']['dealer']);
		$branch    = $_REQUEST['data']['branch'];
		$status    = $_REQUEST['data']['status'];
		$date_from = $_REQUEST['data']['date_from'];
		$date_to   = $_REQUEST['data']['date_to'];
		
		if( $dealer ){
			$conditions .= ' AND jump_dealer.id = ' . '"' . $dealer . '"';
		}
		if( $branch ){
			$conditions .= ' AND jump_branch.id =' . '"' . $branch . '"';
		}
		$conditions .= ' AND pi_prospect_inquiry_cstm.status_c =' . '"' . $status . '"';
		$conditions .= ' AND (pi_prospect_inquiry_cstm.inquiry_date_c BETWEEN DATE("'.$date_from.'") AND DATE("'.$date_to.'") )';


		$leads 		 = $this->db->get('lead_lead_source')->result();
		$base_models = $this->base_model_records();
		$main_query  = $this->lead_payment_query($conditions);

		$base_models_grand_values = [];

		foreach ($leads as $lead_key => $lead) {

			$lead_total_value = 0;
			$lead_total_pct   = 0;

			$array[$lead_key] = [
				"source_of_sale" => ucwords($lead->name),
			];

			foreach ($base_models as $bm_key => $model) {

				$total_value = "";

				foreach ($main_query as $query_key => $query_value) {
					
					if($lead->name == $query_value->lead_source &&  $model->name == $query_value->base_model){
						$total_value = $query_value->total_value;
					} 

				}

				if(array_key_exists("v".$model->name, $base_models_grand_values)){
					$base_models_grand_values["v".$model->name]["value"] = $base_models_grand_values["v".$model->name]["value"] + (int) $total_value;
				}
				else{
					$base_models_grand_values["v".$model->name] = ["value" => (int) $total_value];
				}

				$total_value = (int) $total_value;

				$lead_total_value = (int) $lead_total_value + (int) $total_value;

				$array[$lead_key] += ["v".$model->name => $total_value];
				$array[$lead_key] += ["p".$model->name => 0];

			}

			$array[$lead_key] += ["total_value" => $lead_total_value];
			$array[$lead_key] += ["total_pct" => $lead_total_pct];

			$grand_total = (int) $grand_total + (int) $lead_total_value;
		}
			
		foreach ($array as $key => $value) {

			// calculate lead subtotal percentage 
			$array[$key]["total_pct"] = round(($array[$key]["total_value"] / $grand_total) * 100, 1) . "%";

			foreach ($base_models as $bm_key => $model) {
				if((int) $base_models_grand_values["v".$model->name]["value"] > 0){
					$array[$key]["p".$model->name] = round(( (int) $value["v".$model->name] / (int) $base_models_grand_values["v".$model->name]["value"] ) * 100, 1) . "%";
				}
				else{
					$array[$key]["p".$model->name] = "0%";
				}
			}
		}

		$array[count($leads)] = [
			"source_of_sale" => "<b>Total</b>",
			"total_value" => "<b>".$grand_total."</b>",
			"total_pct" => "<b>100</b>%"
		];

		foreach ($base_models as $key => $value) {
			$array[count($leads)] += ["v".$value->name => "<b>".$base_models_grand_values["v".$value->name]["value"]."</b>"];
			$array[count($leads)] += ["p".$value->name => "<b>" . round(($base_models_grand_values["v".$value->name]["value"] / $grand_total) * 100, 2) . "%</b>" ];
		}

		echo json_encode([
			"data" => $array
		]);
	}

	public function payment_mode_data(){
		
		$array = [];
		$grand_total = 0;

		// $leads 		 = $this->db->get('lead_lead_source')->result();
		$leads 		 = [["name" => "Bank PO"], ["name" => "cash"], ["name" => "financing"], ["name" => "company po"]];
		$base_models = $this->base_model_records();
		$main_query  = $this->lead_payment_query();

		$base_models_grand_values = [];

		foreach ($leads as $lead_key => $lead) {
			$lead = (object) $lead;
			$lead_total_value = 0;
			$lead_total_pct   = 0;

			$array[$lead_key] = [
				"source_of_sale" => ucwords($lead->name),
			];

			foreach ($base_models as $bm_key => $model) {

				$total_value = "";

				foreach ($main_query as $query_key => $query_value) {

					if($lead->name == $query_value->payment_terms_c &&  $model->name == $query_value->base_model){
						$total_value = $query_value->total_value;
					} 

				}

				if(array_key_exists("v".$model->name, $base_models_grand_values)){
					$base_models_grand_values["v".$model->name]["value"] = $base_models_grand_values["v".$model->name]["value"] + (int) $total_value;
				}
				else{
					$base_models_grand_values["v".$model->name] = ["value" => (int) $total_value];
				}

				$total_value = (int) $total_value;

				$lead_total_value = (int) $lead_total_value + (int) $total_value;

				$array[$lead_key] += ["v".$model->name => $total_value];
				$array[$lead_key] += ["p".$model->name => 0];

			}

			$array[$lead_key] += ["total_value" => $lead_total_value];
			$array[$lead_key] += ["total_pct" => $lead_total_pct];

			$grand_total = (int) $grand_total + (int) $lead_total_value;
		}
			
		foreach ($array as $key => $value) {

			// calculate lead subtotal percentage
			$array[$key]["total_pct"] = round(($array[$key]["total_value"] / $grand_total) * 100, 1) . "%";

			foreach ($base_models as $bm_key => $model) {
				if((int) $base_models_grand_values["v".$model->name]["value"] > 0){
					$array[$key]["p".$model->name] = round(( (int) $value["v".$model->name] / (int) $base_models_grand_values["v".$model->name]["value"] ) * 100, 1) . "%";
				}
				else{
					$array[$key]["p".$model->name] = "0%";
				}
			}
		}

		$array[count($leads)] = [
			"source_of_sale" => "<b>Total</b>",
			"total_value" => "<b>".$grand_total."</b>",
			"total_pct" => "<b>100</b>%"
		];

		foreach ($base_models as $key => $value) {
			$array[count($leads)] += ["v".$value->name => "<b>".$base_models_grand_values["v".$value->name]["value"]."</b>"];
			$array[count($leads)] += ["p".$value->name => "<b>" . round(($base_models_grand_values["v".$value->name]["value"] / $grand_total) * 100, 2) . "%</b>" ];
		}	
		echo json_encode([
			"data" => $array
		]);
	}

	public function base_model_records(){
		return  $this->db->query('SELECT * from jump_base_model')->result();
	}

	public function lead_payment_query($conditions = ""){

		$query = $this->db->query("	SELECT
										pi_prospect_inquiry.id,
										pi_prospect_inquiry.name,
										pi_prospect_inquiry_cstm.payment_terms_c,
										jump_model_description.`name` AS model_description,
										jump_base_model.`name` AS base_model,
										lead_lead_source.`name` AS lead_source,
										count(jump_base_model.`name`) as total_value
									FROM
										pi_prospect_inquiry
									INNER JOIN pi_prospect_inquiry_cstm ON pi_prospect_inquiry.id = pi_prospect_inquiry_cstm.id_c
									INNER JOIN city_city_pi_prospect_inquiry_1_c ON pi_prospect_inquiry.id = city_city_pi_prospect_inquiry_1_c.city_city_pi_prospect_inquiry_1pi_prospect_inquiry_idb
									INNER JOIN city_city ON city_city.id = city_city_pi_prospect_inquiry_1_c.city_city_pi_prospect_inquiry_1city_city_ida
									INNER JOIN city_city_cstm ON city_city.id = city_city_cstm.id_c
									INNER JOIN prvn_province ON prvn_province.id = city_city_cstm.prvn_province_id_c
									INNER JOIN prvn_province_cstm ON prvn_province.id = prvn_province_cstm.id_c
									INNER JOIN rgin_region ON rgin_region.id = prvn_province_cstm.rgin_region_id_c
									INNER JOIN ctry_country ON ctry_country.id = prvn_province_cstm.ctry_country_id_c
									INNER JOIN jump_model_description_pi_prospect_inquiry_1_c ON jump_model_description_pi_prospect_inquiry_1_c.jump_modeldc9einquiry_idb = pi_prospect_inquiry.id
									INNER JOIN jump_model_description ON jump_model_description.id = jump_model_description_pi_prospect_inquiry_1_c.jump_modela8cbription_ida
									INNER JOIN jump_base_model_jump_model_description_1_c ON jump_base_model_jump_model_description_1_c.jump_base_ae81ription_idb = jump_model_description.id
									INNER JOIN jump_base_model ON jump_base_model.id = jump_base_model_jump_model_description_1_c.jump_base_model_jump_model_description_1jump_base_model_ida
									INNER JOIN jump_body_type_jump_base_model_1_c ON jump_body_type_jump_base_model_1_c.jump_body_type_jump_base_model_1jump_base_model_idb = jump_base_model.id
									INNER JOIN jump_body_type ON jump_body_type.id = jump_body_type_jump_base_model_1_c.jump_body_type_jump_base_model_1jump_body_type_ida
									INNER JOIN jump_color_jump_model_description_1_c ON jump_color_jump_model_description_1_c.jump_color_jump_model_description_1jump_model_description_idb = jump_model_description.id
									INNER JOIN jump_color ON jump_color.id = jump_color_jump_model_description_1_c.jump_color_jump_model_description_1jump_color_ida
									INNER JOIN lead_lead_source_pi_prospect_inquiry_1_c ON lead_lead_source_pi_prospect_inquiry_1_c.lead_lead_source_pi_prospect_inquiry_1pi_prospect_inquiry_idb = pi_prospect_inquiry.id
									INNER JOIN lead_lead_source ON lead_lead_source.id = lead_lead_source_pi_prospect_inquiry_1_c.lead_lead_source_pi_prospect_inquiry_1lead_lead_source_ida
									LEFT JOIN fnct_financing_terms_pi_prospect_inquiry_1_c ON fnct_financing_terms_pi_prospect_inquiry_1_c.fnct_finanda90inquiry_idb = pi_prospect_inquiry.id
									LEFT JOIN fnct_financing_terms ON fnct_financing_terms.id = fnct_financing_terms_pi_prospect_inquiry_1_c.fnct_finand6a4g_terms_ida
									INNER JOIN users ON pi_prospect_inquiry.assigned_user_id = users.id
									INNER JOIN users_cstm ON users_cstm.id_c = users.id
									LEFT JOIN jump_dealer ON users_cstm.jump_dealer_id_c = jump_dealer.id
									INNER JOIN jump_branch ON jump_branch.id = users_cstm.jump_branch_id_c

									WHERE pi_prospect_inquiry.deleted = 0 {$conditions}
									GROUP by lead_lead_source.id, jump_base_model.id

									ORDER by model_description")->result();
		
		return $query;
	}

	public function dealers(){
		
		$query = $this->db->query("SELECT * from jump_dealer")->result();
		return $query;	
	}

	public function branch(){

		$dealer_id = $_GET['dealer_id'];

		$query = $this->db->query("	SELECT
										jump_dealer.id,
										jump_dealer.name,
										jump_branch.id as branch_id,
										jump_branch.name as branch_name
									FROM
										jump_dealer

									INNER JOIN jump_branch_cstm
									ON jump_branch_cstm.jump_dealer_id_c = jump_dealer.id  

									INNER JOIN jump_branch
									ON jump_branch_cstm.id_c = jump_branch.id

									where jump_dealer.id = '{$dealer_id}'")->result();
		echo json_encode($query);
	}

	public function prospect_inquiry_details(){


		$this->load->model('Pi_prospect_inquiry_cstm');
		// $filters['dealer'] = $this->Dealer->getDealer();
		$filters['dealer_branch'] = $this->Dealer->getDealerBranch();
		// var_dump($filters['dealer_branch']);
		$pi_records = $this->Pi_prospect_inquiry_cstm->populateProspect();

		$content = $this->load->view("reports/prospect_inquiry_details/filter.php" ,[ "filters" => $filters ],TRUE);
		$content .= $this->load->view("reports/prospect_inquiry_details/prospect_inquiry_details.php" ,[ "pi_records" => $pi_records ],TRUE);

		set_header_title("Reports - Prospect Inquiry Details");
		$this->put_contents($content,"Prospect Inquiry Details");
	}

	public function dealer_with_branches(){
		
		$user_type = $this->user_type();
		$array = [];

		if( $user_type == "mmpc" ){

			$all_dealers = $this->dealers();
			foreach ($all_dealers as $dealer_key => $dealer_value) {
				
				$dealer = $dealer_value->name;

				$array["dealers"][$dealer] = $dealer_value->id;
			}

		}

		if( $user_type == "dealer"){

			$dealer_id 	 = $_SESSION['user']->dealer->dealer_id;
			$dealer_name = $_SESSION['user']->dealer->dealer;
			$array["dealers"][$dealer] = $dealer_id;
		}

		if( $user_type == "branch" ){

			$array["branches"][$_SESSION['user']->dealer->branch] = $_SESSION['user']->dealer->branch_id;

		}

		return $array;
	}

	public function inquiry_per_dealer(){
		
		$base_model = $this->base_model_records();
		$dealers    = $this->dealers();
		$user = $_SESSION['user'];

		if( strtolower($user->title) == "mmpc"){	
			$content = $this->load->view("reports/prospect_inquiry_per_dealer/index.php" ,[ "base_model" => $base_model, "dealers" => $dealers], TRUE);
		}
		else{
			$content = $this->load->view("errors/unauthorized.php" ,[ ], TRUE);
		}

		set_header_title("Reports - Inquiry per Dealer");
		$this->put_contents($content, "Inquiry Per Dealer");
	}

	public function per_dealer_json(){

		$date_from = $_REQUEST['date_from'];
		$date_to   = $_REQUEST['date_to'];

		$where_prospect 	= ' AND (pi_prospect_inquiry_cstm.inquiry_date_c BETWEEN DATE("'.$date_from.'") AND DATE("'.$date_to.'") )';
		$where_sales_order  = ' AND (ddms_sales_order.date_entered BETWEEN DATE("'.$date_from.'") AND DATE("'.$date_to.'") )';
		$where_sales_invoice  = ' AND (ddms_sales_order_cstm.invoiced_date_c BETWEEN DATE("'.$date_from.'") AND DATE("'.$date_to.'") )';

		$array = [];
		$dealer_branch = $this->db->query("	SELECT
												jump_dealer.id AS dealer_id,
												jump_dealer. NAME AS dealer,
												jump_branch. NAME AS branch
											FROM
												jump_dealer
											LEFT JOIN jump_branch_cstm ON jump_branch_cstm.jump_dealer_id_c = jump_dealer.id
											INNER JOIN jump_branch ON jump_branch.id = jump_branch_cstm.id_c
											WHERE jump_dealer.name != 'mmpc' ")->result();

		$sales_order = $this->sales_order($where_sales_order);
		$sales_sales_invoice = $this->sales_invoice($where_sales_invoice);

		$db_array = [];
		foreach ($dealer_branch as $key => $value) {
			if( array_key_exists($value->dealer, $db_array) ){

				if($value->branch){
					$db_array[$value->dealer]["branches"][$value->branch]["prospects"] = 0;
					$db_array[$value->dealer]["branches"][$value->branch]["sales_order"] = 0;
					$db_array[$value->dealer]["branches"][$value->branch]["sales_invoice"] = 0;
				}

			}
			else{
				$db_array[$value->dealer]["directs"]["prospects"] = 0;
				$db_array[$value->dealer]["directs"]["sales_order"] = 0;
				$db_array[$value->dealer]["directs"]["sales_invoice"] = 0;
				$db_array[$value->dealer]["branches"] = [];
				if( $value->branch ){
					$db_array[$value->dealer]["branches"][$value->branch]["prospects"] = 0;
					$db_array[$value->dealer]["branches"][$value->branch]["sales_order"] = 0;
					$db_array[$value->dealer]["branches"][$value->branch]["sales_invoice"] = 0;
				}

			}
		}

		$prospects = $this->main_query($where_prospect);
		foreach ($prospects as $p_key => $prospect) {

			// REMOVE THIS CONDITION WHEN DATA IN TABLE IS FIXED
			if( $prospect->employee_username == "admin" ){
				continue;
			}
			// -------------- until here ------------------

			if( $prospect->branch ){

				$db_array[$prospect->dealer]["branches"][$prospect->branch]["prospects"] = $db_array[$prospect->dealer]["branches"][$prospect->branch]["prospects"] + 1;

			}
			else{
				
			}
		}

		foreach ($sales_order as $s_key => $so_value) {
			
			// REMOVE THIS CONDITION WHEN DATA IN TABLE IS FIXED
			if( $so_value->employee_username == "admin" ){
				continue;
			}
			// -------------- until here ------------------

			if( $so_value->branch ){
				$db_array[$so_value->dealer]["branches"][$so_value->branch]["sales_order"] = $db_array[$so_value->dealer]["branches"][$so_value->branch]["sales_order"] + 1;
			}
			else{
				
			}
		}

		foreach ($sales_sales_invoice as $si_key => $si_value) {
			// REMOVE THIS CONDITION WHEN DATA IN TABLE IS FIXED
			if( $si_value->employee_username == "admin" ){
				continue;
			}
			// -------------- until here ------------------

			if( $si_value->branch ){

				if( $si_value->invoiced_c ){
					$db_array[$si_value->dealer]["branches"][$si_value->branch]["sales_invoice"] = $db_array[$si_value->dealer]["branches"][$si_value->branch]["sales_invoice"] + 1;
				}
				else{
					continue;
				}

			}
			else{
				
			}
		}

		foreach ($db_array as $dealer => $d_value) {

			$branches_tr  = "";
			$prospects_tr = "";
			$sales_order_tr    = "";
			$sales_invoice_tr  = "";
			$dealer_total_pros = 0;
			$dealer_total_so   = 0;
			$dealer_total_si   = 0;

			foreach ($d_value['branches'] as $branch => $b_value) {
				
				$branches_tr  .= "<tr><td>{$branch}</td></tr>";
				$prospects_tr .= "<tr><td>{$b_value['prospects']}</td></tr>";
				$sales_order_tr   .= "<tr><td>{$b_value['sales_order']}</td></tr>";
				$sales_invoice_tr .= "<tr><td>{$b_value['sales_invoice']}</td></tr>";

				$dealer_total_pros += $b_value['prospects'];
				$dealer_total_so   += $b_value['sales_order'];
				$dealer_total_si   += $b_value['sales_invoice'];

			}

			$branch = $this->table($branches_tr);
			$prospect = $this->table($prospects_tr);
			$sales_order = $this->table($sales_order_tr);
			$sales_invoice = $this->table($sales_invoice_tr);

			$array[] =  [
				"dealer" => "<h5><b>{$dealer}</b></h5>",
				"branch" => $branch,
				"prospect_inquiry" => $prospect,
				"sales_order" => $sales_order,
				"sales_invoice" => $sales_invoice
			];

			$total_prospect_tr 		= "<tr> <td><b>" . $dealer_total_pros . "</b> </td> </tr>";
			$total_sales_order_tr 	= "<tr> <td><b>" . $dealer_total_so . "</b> </td> </tr>";
			$total_sales_invoice_tr = "<tr> <td><b>" . $dealer_total_si . "</b> </td> </tr>";

			$array[] = [
				"dealer" => "",
				"branch" => "<i class='pull-right'>Total {$dealer}</i>",
				"prospect_inquiry" => $this->table($total_prospect_tr),
				"sales_order" => $this->table($total_sales_order_tr),
				"sales_invoice" => $this->table($total_sales_invoice_tr)
			];
		}

		echo json_encode([
			"data" => $array
		]);
	}

	public function test_method(){


	}

	public function table($tbody){
		
		$table = '<table class="">'.$tbody.'</table>';
		return $table;
	}

	public function sales_order($conditions = ""){

		$res = $this->db->query("	SELECT
										ddms_sales_order.assigned_user_id,
										ddms_sales_order_cstm.invoiced_c,
										jump_dealer.name AS dealer,
										jump_branch.name AS branch,
										users.user_name AS employee_username
									FROM
										ddms_sales_order
									INNER JOIN ddms_sales_order_cstm ON ddms_sales_order.id = ddms_sales_order_cstm.id_c
									INNER JOIN users_cstm ON users_cstm.id_c = ddms_sales_order.assigned_user_id
									INNER JOIN users on users_cstm.id_c = users.id
									INNER JOIN jump_dealer ON jump_dealer.id = users_cstm.jump_dealer_id_c
									LEFT JOIN jump_branch ON jump_branch.id = users_cstm.jump_branch_id_c
									WHERE
										ddms_sales_order.deleted = 0" . $conditions)->result();

		return $res;
	}

	public function sales_invoice($conditions = ""){

		$res = $this->db->query("	SELECT
										ddms_sales_order.assigned_user_id,
										ddms_sales_order_cstm.invoiced_c,
										jump_dealer.name AS dealer,
										jump_branch.name AS branch,
										users.user_name AS employee_username
									FROM
										ddms_sales_order
									INNER JOIN ddms_sales_order_cstm ON ddms_sales_order.id = ddms_sales_order_cstm.id_c
									INNER JOIN users_cstm ON users_cstm.id_c = ddms_sales_order.assigned_user_id
									INNER JOIN users on users_cstm.id_c = users.id
									INNER JOIN jump_dealer ON jump_dealer.id = users_cstm.jump_dealer_id_c
									LEFT JOIN jump_branch ON jump_branch.id = users_cstm.jump_branch_id_c
									WHERE
										ddms_sales_order.deleted = 0" . $conditions)->result();

		return $res;
	}

	public function main_query($conditions = ""){
		
		$query = "	SELECT
						pi_prospect_inquiry.id,
						pi_prospect_inquiry.`name`,
						pi_prospect_inquiry_cstm.fname_c,
						pi_prospect_inquiry_cstm.mname_c,
						pi_prospect_inquiry_cstm.lname_c,
						pi_prospect_inquiry_cstm.prospect_type_c,
						pi_prospect_inquiry_cstm.payment_terms_c,
						fnct_financing_terms.`name` AS financing_term,
						pi_prospect_inquiry_cstm.inquiry_date_c,
						pi_prospect_inquiry_cstm.editable_date_created_c,
						pi_prospect_inquiry_cstm.status_c,
						pi_prospect_inquiry_cstm.disq_reason_c,
						city_city.`name` AS city,
						prvn_province.`name` AS province,
						rgin_region.`name` AS region,
						ctry_country.`name` AS country,
						jump_model_description.`name` AS model_description,
						jump_base_model.`name` AS base_model,
						jump_body_type.`name` AS body_type,
						jump_color.`name` AS color,
						lead_lead_source.`name` AS lead_source,
						users.user_name AS employee_username,
						jump_dealer.`name` AS dealer,
						jump_branch.`name` AS branch
					FROM
						pi_prospect_inquiry
					INNER JOIN pi_prospect_inquiry_cstm ON pi_prospect_inquiry.id = pi_prospect_inquiry_cstm.id_c
					INNER JOIN city_city_pi_prospect_inquiry_1_c ON pi_prospect_inquiry.id = city_city_pi_prospect_inquiry_1_c.city_city_pi_prospect_inquiry_1pi_prospect_inquiry_idb
					INNER JOIN city_city ON city_city.id = city_city_pi_prospect_inquiry_1_c.city_city_pi_prospect_inquiry_1city_city_ida
					INNER JOIN city_city_cstm ON city_city.id = city_city_cstm.id_c
					INNER JOIN prvn_province ON prvn_province.id = city_city_cstm.prvn_province_id_c
					INNER JOIN prvn_province_cstm ON prvn_province.id = prvn_province_cstm.id_c
					INNER JOIN rgin_region ON rgin_region.id = prvn_province_cstm.rgin_region_id_c
					INNER JOIN ctry_country ON ctry_country.id = prvn_province_cstm.ctry_country_id_c
					INNER JOIN jump_model_description_pi_prospect_inquiry_1_c ON jump_model_description_pi_prospect_inquiry_1_c.jump_modeldc9einquiry_idb = pi_prospect_inquiry.id
					INNER JOIN jump_model_description ON jump_model_description.id = jump_model_description_pi_prospect_inquiry_1_c.jump_modela8cbription_ida
					INNER JOIN jump_base_model_jump_model_description_1_c ON jump_base_model_jump_model_description_1_c.jump_base_ae81ription_idb = jump_model_description.id
					INNER JOIN jump_base_model ON jump_base_model.id = jump_base_model_jump_model_description_1_c.jump_base_model_jump_model_description_1jump_base_model_ida
					INNER JOIN jump_body_type_jump_base_model_1_c ON jump_body_type_jump_base_model_1_c.jump_body_type_jump_base_model_1jump_base_model_idb = jump_base_model.id
					INNER JOIN jump_body_type ON jump_body_type.id = jump_body_type_jump_base_model_1_c.jump_body_type_jump_base_model_1jump_body_type_ida
					INNER JOIN jump_color_jump_model_description_1_c ON jump_color_jump_model_description_1_c.jump_color_jump_model_description_1jump_model_description_idb = jump_model_description.id
					INNER JOIN jump_color ON jump_color.id = jump_color_jump_model_description_1_c.jump_color_jump_model_description_1jump_color_ida
					INNER JOIN lead_lead_source_pi_prospect_inquiry_1_c ON lead_lead_source_pi_prospect_inquiry_1_c.lead_lead_source_pi_prospect_inquiry_1pi_prospect_inquiry_idb = pi_prospect_inquiry.id
					INNER JOIN lead_lead_source ON lead_lead_source.id = lead_lead_source_pi_prospect_inquiry_1_c.lead_lead_source_pi_prospect_inquiry_1lead_lead_source_ida
					LEFT JOIN fnct_financing_terms_pi_prospect_inquiry_1_c ON fnct_financing_terms_pi_prospect_inquiry_1_c.fnct_finanda90inquiry_idb = pi_prospect_inquiry.id
					LEFT JOIN fnct_financing_terms ON fnct_financing_terms.id = fnct_financing_terms_pi_prospect_inquiry_1_c.fnct_finand6a4g_terms_ida
					INNER JOIN users ON pi_prospect_inquiry.assigned_user_id = users.id
					INNER JOIN users_cstm ON users_cstm.id_c = users.id
					LEFT JOIN jump_dealer ON users_cstm.jump_dealer_id_c = jump_dealer.id
					INNER JOIN jump_branch ON jump_branch.id = users_cstm.jump_branch_id_c

					where pi_prospect_inquiry.deleted = 0" . $conditions ;
		return $this->db->query($query)->result();
	}

	public function user_type(){
		
		$title = trim(strtolower($_SESSION['user']->title));
		$title = str_replace(" ", "_", $title);
		$user_type = "";

		if( in_array($title, $this->dealer_user_titles) ){
			$user_type = "dealer";
		}
		if( in_array($title, $this->branch_user_tiles) ){
			$user_type = "branch";
		}
		if( in_array($title, $this->mmpc_user_titles) ){
			$user_type = "mmpc";
		}
		return $user_type;
	}	

}

/* End of file Reports.php */
/* Location: ./application/controllers/Reports.php */

