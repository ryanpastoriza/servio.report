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

		$content = $this->load->view("reports/prospect_inquiry_by_lead/index.php" ,[ "base_model" => $base_model],TRUE);
		set_header_title("Reports - Lead Source");
		$this->put_contents($content,"Lead Source");
	}

	public function lead_data(){
		
		$array = [];

		$leads 		 = $this->db->get('lead_lead_source')->result();
		$base_models = $this->base_model_records();
		$main_query  = $this->main_query();

		foreach ($leads as $lead_key => $lead) {

			$lead_total_value = 0;
			$lead_total_pct   = 0;

			$array[$lead_key] = [
				"source_of_sale" => ucwords($lead->name)
			];

			foreach ($base_models as $bm_key => $model) {

				$total_value = "";

				foreach ($main_query as $query_key => $query_value) {
					
					if($lead->name == $query_value->lead_source &&  $model->name == $query_value->base_model){
						$total_value = $query_value->total_value;
					} 

				}
				$total_value = (int) $total_value;

				$lead_total_value = (int) $lead_total_value + (int) $total_value;

				$array[$lead_key] += ["v".$model->name => $total_value];
				$array[$lead_key] += ["p".$model->name => "va1"];

			}

			$array[$lead_key] += ["total_value" => $lead_total_value];
			$array[$lead_key] += ["total_pct" => $lead_total_pct];

		}


		
		// $grand_total_array = [
		// 	"source_of_sale" => "grand total"
		// ];
		// array_push($array, (object)$grand_total_array);

		echo json_encode([
			"data" => $array
		]);
	}

	public function base_model_records(){
		return  $this->db->query('SELECT * from jump_base_model')->result();
	}

	public function main_query(){

		$query = $this->db->query("	SELECT
										pi_prospect_inquiry.id,
										pi_prospect_inquiry.name,
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


									GROUP by lead_lead_source.id, jump_base_model.id

									ORDER by model_description")->result();
		
		return $query;
	}

	public function test_method(){
		$array = [];

		$leads 		 = $this->db->get('lead_lead_source')->result();
		$base_models = $this->base_model_records();
		$main_query  = $this->main_query();

		$grand_total = 0;

		$base_model_columns = [];

		foreach ($leads as $lead_key => $lead) {

			$lead_total_value = 0;
			$lead_total_pct   = 0;

			$array[$lead_key] = [
				"source_of_sale" => ucwords($lead->name)
			];

			foreach ($base_models as $bm_key => $model) {

				$base_model_columns[$model->name] = 0;

				$total_value = "";

				foreach ($main_query as $query_key => $query_value) {
					
					if($lead->name == $query_value->lead_source &&  $model->name == $query_value->base_model){
						$total_value = $query_value->total_value;
					} 

				}

				$total_value = (int) $total_value;
				$lead_total_value = (int) $lead_total_value + (int) $total_value;
				$array[$lead_key] += ["v".$model->name => $total_value];
				$array[$lead_key] += ["p".$model->name => "va1"];

				echo $lead->name . " => " . $model->name . ": " . $total_value . "<br>";
			
				$base_model_columns[$model->name] = (int)$total_value + (int)$base_model_columns[$model->name] ;
			}

			$array[$lead_key] += ["total_value" => $lead_total_value];
			$array[$lead_key] += ["total_pct" => $lead_total_pct];

			$grand_total = (int) $grand_total + (int) $lead_total_value;
			echo "<br>";
		}


		$grand_total_array = [
			"source_of_sale" => "grand total",
			"total_value" => $grand_total,
			"total_pct" => ""
		];

		echo "<pre>";
		print_r($base_model_columns);

		// $grand_total_array += $base_model_columns;
		// array_push($array, (object)$grand_total_array);

		// echo "<pre>";
		// print_r($array);

		// echo "<pre>";
		// print_r($base_model_columns);

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

}

/* End of file Reports.php */
/* Location: ./application/controllers/Reports.php */