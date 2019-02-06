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

		$query = $this->db->get('lead_lead_source')->result();

		foreach ($query as $key => $value) {
			$array[] = [
						"source_of_sale" => ucwords($value->name),
						"value1" => "value1",
					];
		}

		echo json_encode([
			"data" => $array
		]);
	}

	public function base_model_records(){
		return  $this->db->query('SELECT name from jump_base_model')->result();
	}

	public function test_method(){

		$query = $this->db->query('SELECT
										pi_prospect_inquiry.id,
										pi_prospect_inquiry.name,
										pi_prospect_inquiry_cstm.fname_c,
										pi_prospect_inquiry_cstm.mname_c,
										pi_prospect_inquiry_cstm.lname_c,
										pi_prospect_inquiry_cstm.prospect_type_c,
										pi_prospect_inquiry_cstm.payment_terms_c,
										fnct_financing_terms.name AS financing_term,
										pi_prospect_inquiry_cstm.inquiry_date_c,
										pi_prospect_inquiry_cstm.editable_date_created_c,
										pi_prospect_inquiry_cstm.status_c,
										pi_prospect_inquiry_cstm.disq_reason_c,
										city_city.name AS city,
										prvn_province.name AS province,
										rgin_region.name AS region,
										ctry_country.name AS country,
										jump_model_description.name AS model_description,
										jump_base_model.name AS base_model,
										jump_body_type.name AS body_type,
										jump_color.name AS color,
										lead_lead_source.name AS lead_source,
										users.user_name AS employee_username,
										jump_dealer.name AS dealer,
										jump_branch.name AS branch
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
									INNER JOIN jump_branch ON jump_branch.id = users_cstm.jump_branch_id_c')->result();

		echo "<pre>";
		print_r($query);
	}

}

/* End of file Reports.php */
/* Location: ./application/controllers/Reports.php */