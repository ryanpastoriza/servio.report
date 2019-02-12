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
		$dealers    = $this->dealers();

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

		$leads 		 = $this->db->get('lead_lead_source')->result();
		$base_models = $this->base_model_records();
		$main_query  = $this->lead_payment_query();

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

	public function lead_payment_query(){

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

									WHERE pi_prospect_inquiry.deleted = 0
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

	public function inquiry_per_dealer(){
		
		$base_model = $this->base_model_records();
		$dealers    = $this->dealers();
		$user = $_SESSION;

		if( strtolower($user['title']) == "mmpc"){	
			$content = $this->load->view("reports/prospect_inquiry_per_dealer/index.php" ,[ "base_model" => $base_model, "dealers" => $dealers], TRUE);
		}
		else{
			$content = $this->load->view("errors/unauthorized.php" ,[ ], TRUE);
		}

		set_header_title("Reports - Inquiry per Dealer");
		$this->put_contents($content, "Inquiry Per Dealer");
	}

	public function per_dealer_json(){



		$array[] = [
			"dealer" => "asdasd",
			// "code" => "asdasd",
			"branch" => "asdasd",
			"prospect_inquiry" => "asdasd",
			"sales_order" => "asdasd",
			"sales_invoice" => "asdasd",
		];

		echo json_encode([
			"data" => $array
		]);

	}

	public function test_method(){
		
		$dealer_branch = $this->db->query("	SELECT
												jump_dealer.id AS dealer_id,
												jump_dealer. NAME AS dealer,
												jump_branch. NAME AS branch
											FROM
												jump_dealer
											LEFT JOIN jump_branch_cstm ON jump_branch_cstm.jump_dealer_id_c = jump_dealer.id
											INNER JOIN jump_branch ON jump_branch.id = jump_branch_cstm.id_c
											WHERE jump_dealer.name != 'mmpc' ")->result();

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

		$prospects = $this->main_query();

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

		echo "<pre>";
		print_r($db_array);

	}

	public function main_query(){
		
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

					where pi_prospect_inquiry.deleted = 0";

		return $this->db->query($query)->result();

	}

}

/* End of file Reports.php */
/* Location: ./application/controllers/Reports.php */