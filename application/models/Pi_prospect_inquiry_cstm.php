<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-07 16:23:37
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-15 14:35:36
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Pi_prospect_inquiry_cstm extends My_Model {
	// My_Model
	const DB_TABLE = "Pi_prospect_inquiry_cstm";
	const DB_TABLE_PK = "id_c";

	public $fname_c;
	public $lname_c;
	public $mname_c;
	public $mobile_no_c;
	public $alternate_contact_no_c;
	public $email_c;
	public $company_name_c;
	public $business_no_c;
	public $basic_address_c;
	public $prospect_type_c;
	public $payment_terms_c;
	public $inquiry_date_c;
	public $editable_date_created_c;
	public $inquiry_no_c;
	public $status_c;
	public $disq_reason_c;
	public $jump_customers_id_c;


	function by_MOP($conditions = false)
	{
		$this->selects = [ $this::DB_TABLE.".".$this::DB_TABLE_PK, 'Jump_base_model_pi_prospect_inquiry_1_c.Jump_base_model_pi_prospect_inquiry_1jump_base_model_ida', 'count('.$this::DB_TABLE.".".$this::DB_TABLE_PK.') as total', 'payment_terms_c', "CONCAT('WK ',  WEEK(inquiry_date_c, 3) -
                      							WEEK(inquiry_date_c - INTERVAL DAY(inquiry_date_c)-1 DAY, 3) + 1 , ' ' , DATE_FORMAT(inquiry_date_c, '%b %Y')) as month"];

        $this->toJoin = [
        					['pi_prospect_inquiry', "pi_prospect_inquiry.id = pi_prospect_inquiry_cstm.id_c", "INNER"],
        					['users', "users.id = pi_prospect_inquiry.assigned_user_id", "INNER"],
        					['users_cstm', "users_cstm.id_c = users.id", "INNER"],
        					['Jump_base_model_pi_prospect_inquiry_1_c', "Jump_base_model_pi_prospect_inquiry_1_c.Jump_base_model_pi_prospect_inquiry_1pi_prospect_inquiry_idb = pi_prospect_inquiry.id", "INNER"],
        					['jump_model_description_pi_prospect_inquiry_1_c', "jump_model_description_pi_prospect_inquiry_1_c.jump_modeldc9einquiry_idb = pi_prospect_inquiry.id", "INNER"],
        					['lead_lead_source_pi_prospect_inquiry_1_c', "lead_lead_source_pi_prospect_inquiry_1_c.lead_lead_source_pi_prospect_inquiry_1pi_prospect_inquiry_idb = pi_prospect_inquiry.id", "INNER"]
        				];


		$this->sqlQueries['toGroup'] = "payment_terms_c,  month";
		$this->sqlQueries['order_type'] = "asc";
		$this->sqlQueries['order_field'] = "inquiry_date_c";

			$conditions = $conditions ?  $conditions." AND (pi_prospect_inquiry.deleted = 0 AND Jump_base_model_pi_prospect_inquiry_1_c.deleted = 0  AND jump_model_description_pi_prospect_inquiry_1_c.deleted = 0 AND lead_lead_source_pi_prospect_inquiry_1_c.deleted = 0)" : "pi_prospect_inquiry.deleted = 0 AND Jump_base_model_pi_prospect_inquiry_1_c.deleted = 0 AND jump_model_description_pi_prospect_inquiry_1_c.deleted = 0 AND lead_lead_source_pi_prospect_inquiry_1_c.deleted = 0";


			$res = $this->search($conditions);

		return $res;
	}
	function by_LS($conditions = false){
		$this->selects = [ $this::DB_TABLE.".".$this::DB_TABLE_PK, "CONCAT('WK ', WEEK(inquiry_date_c, 3) -
                      	WEEK(inquiry_date_c - INTERVAL DAY(inquiry_date_c)-1 DAY, 3) + 1 , ' ' , DATE_FORMAT(inquiry_date_c, '%b %Y')) as month",
                      	'count('.$this::DB_TABLE.".".$this::DB_TABLE_PK.') as total', "lead_lead_source.name as ls_name"
                  		];

        $this->sqlQueries['order_type'] = "asc";
		$this->sqlQueries['order_field'] = "inquiry_date_c";
		$this->sqlQueries['toGroup'] = "month, ls_name";

		$this->toJoin = [
        			['pi_prospect_inquiry', "pi_prospect_inquiry.id = pi_prospect_inquiry_cstm.id_c", "INNER"],
        			['Jump_base_model_pi_prospect_inquiry_1_c', "Jump_base_model_pi_prospect_inquiry_1_c.Jump_base_model_pi_prospect_inquiry_1pi_prospect_inquiry_idb = pi_prospect_inquiry.id", "INNER"],
        			['users', "users.id = pi_prospect_inquiry.assigned_user_id", "INNER"],
					['users_cstm', "users_cstm.id_c = users.id", "INNER"],
					['Lead_lead_source_pi_prospect_inquiry_1_c', $this::DB_TABLE.".id_c = lead_lead_source_pi_prospect_inquiry_1_c.lead_lead_source_pi_prospect_inquiry_1pi_prospect_inquiry_idb", "INNER" ],
        			['jump_model_description_pi_prospect_inquiry_1_c', "jump_model_description_pi_prospect_inquiry_1_c.jump_modeldc9einquiry_idb = pi_prospect_inquiry.id", "INNER"],
					['lead_lead_source', "lead_lead_source.id = lead_lead_source_pi_prospect_inquiry_1_c.lead_lead_source_pi_prospect_inquiry_1lead_lead_source_ida", "INNER"]];

		$conditions = $conditions ?  $conditions." AND (pi_prospect_inquiry.deleted = 0 AND Jump_base_model_pi_prospect_inquiry_1_c.deleted = 0  AND jump_model_description_pi_prospect_inquiry_1_c.deleted = 0 AND lead_lead_source_pi_prospect_inquiry_1_c.deleted = 0)" : "pi_prospect_inquiry.deleted = 0 AND Jump_base_model_pi_prospect_inquiry_1_c.deleted = 0 AND jump_model_description_pi_prospect_inquiry_1_c.deleted = 0 AND lead_lead_source_pi_prospect_inquiry_1_c.deleted = 0";


		$res = $this->search($conditions);

		return $res;
	}
	function by_Model($conditions = false){
		$this->selects = [$this::DB_TABLE.".".$this::DB_TABLE_PK, "CONCAT('WK ', WEEK(inquiry_date_c, 3) -
                      	WEEK(inquiry_date_c - INTERVAL DAY(inquiry_date_c)-1 DAY, 3) + 1 , ' ' , DATE_FORMAT(inquiry_date_c, '%b %Y')) as month",
                      	'count('.$this::DB_TABLE.".".$this::DB_TABLE_PK.') as total', "jump_base_model.name as model_name"
                  		];

        $this->sqlQueries['order_type'] = "asc";
		$this->sqlQueries['order_field'] = "inquiry_date_c";
		$this->sqlQueries['toGroup'] = "month, model_name";
		$this->toJoin = [
        			['pi_prospect_inquiry', "pi_prospect_inquiry.id = pi_prospect_inquiry_cstm.id_c", "INNER"],
        			['users', "users.id = pi_prospect_inquiry.assigned_user_id", "INNER"],
					['users_cstm', "users_cstm.id_c = users.id", "INNER"],
					['Jump_base_model_pi_prospect_inquiry_1_c', $this::DB_TABLE.".id_c = Jump_base_model_pi_prospect_inquiry_1_c.Jump_base_model_pi_prospect_inquiry_1pi_prospect_inquiry_idb", "INNER" ],
					['Jump_base_model', "Jump_base_model.id = Jump_base_model_pi_prospect_inquiry_1_c.Jump_base_model_pi_prospect_inquiry_1jump_base_model_ida", "INNER"],
					['Lead_lead_source_pi_prospect_inquiry_1_c', $this::DB_TABLE.".id_c = lead_lead_source_pi_prospect_inquiry_1_c.lead_lead_source_pi_prospect_inquiry_1pi_prospect_inquiry_idb", "INNER" ],
        			['jump_model_description_pi_prospect_inquiry_1_c', "jump_model_description_pi_prospect_inquiry_1_c.jump_modeldc9einquiry_idb = pi_prospect_inquiry.id", "INNER"],
					];


		$conditions = $conditions ?  $conditions." AND (pi_prospect_inquiry.deleted = 0 AND Jump_base_model_pi_prospect_inquiry_1_c.deleted = 0  AND jump_model_description_pi_prospect_inquiry_1_c.deleted = 0 AND lead_lead_source_pi_prospect_inquiry_1_c.deleted = 0)" : "pi_prospect_inquiry.deleted = 0 AND Jump_base_model_pi_prospect_inquiry_1_c.deleted = 0 AND jump_model_description_pi_prospect_inquiry_1_c.deleted = 0 AND lead_lead_source_pi_prospect_inquiry_1_c.deleted = 0";


		$res = $this->search($conditions);

		return $res;
	}
	function by_Variance(){
		$this->selects = [$this::DB_TABLE_PK, "CONCAT('WK ', WEEK(inquiry_date_c, 3) -
                      	WEEK(inquiry_date_c - INTERVAL DAY(inquiry_date_c)-1 DAY, 3) + 1 , ' ' , DATE_FORMAT(inquiry_date_c, '%b %Y')) as month",
                      	'count('.$this::DB_TABLE_PK.') as total', "jump_base_model.name as model_name"
                  		];

        $this->sqlQueries['order_type'] = "asc";
		$this->sqlQueries['order_field'] = "inquiry_date_c";
		$this->sqlQueries['toGroup'] = "month, model_name";
		$this->toJoin = [['Jump_base_model_pi_prospect_inquiry_1_c', $this::DB_TABLE.".id_c = Jump_base_model_pi_prospect_inquiry_1_c.Jump_base_model_pi_prospect_inquiry_1pi_prospect_inquiry_idb", "INNER" ],
					['Jump_base_model', "Jump_base_model.id = Jump_base_model_pi_prospect_inquiry_1_c.Jump_base_model_pi_prospect_inquiry_1jump_base_model_ida", "INNER"]];


		$res = $this->search();

		return $res;
	}

	function populateProspect($cond = array()){

		
		$this->db->select(['pi_prospect_inquiry.id',
		'pi_prospect_inquiry.name',
		'pi_prospect_inquiry_cstm.fname_c',
		'pi_prospect_inquiry_cstm.mname_c',
		'pi_prospect_inquiry_cstm.lname_c',
		'pi_prospect_inquiry_cstm.mobile_no_c',
		'pi_prospect_inquiry_cstm.email_c',
		'pi_prospect_inquiry_cstm.prospect_type_c',
		'pi_prospect_inquiry_cstm.payment_terms_c',
		'pi_prospect_inquiry_cstm.basic_address_c',
		'fnct_financing_terms.name as financing_term',
		'pi_prospect_inquiry_cstm.inquiry_date_c',
		'pi_prospect_inquiry_cstm.editable_date_created_c',
		'pi_prospect_inquiry_cstm.status_c',
		'pi_prospect_inquiry_cstm.disq_reason_c',
		'city_city.name as city',
		'prvn_province.name as province',
		'rgin_region.name as region',
		'ctry_country.name as country',
		'jump_model_description.name as model_description',
		'jump_base_model.name as base_model',
		'jump_body_type.name as body_type',
		'jump_color.name as color',
		'jump_vehicle_type.name as vehicle_type',
		'lead_lead_source.name as lead_source',
		'users.first_name',
		'users.last_name',
		'jump_dealer.name as dealer',
		'jump_branch.name as branch'])
	
		->from('pi_prospect_inquiry')
		->join('pi_prospect_inquiry_cstm', 'pi_prospect_inquiry.id = pi_prospect_inquiry_cstm.id_c', 'inner')
        ->join('city_city_pi_prospect_inquiry_1_c', 'pi_prospect_inquiry.id = city_city_pi_prospect_inquiry_1_c.city_city_pi_prospect_inquiry_1pi_prospect_inquiry_idb', 'inner')
        ->join('city_city', 'city_city.id = city_city_pi_prospect_inquiry_1_c.city_city_pi_prospect_inquiry_1city_city_ida', 'inner')
        ->join('city_city_cstm', 'city_city.id = city_city_cstm.id_c', 'inner')
        ->join('prvn_province', 'prvn_province.id = city_city_cstm.prvn_province_id_c', 'inner')
        ->join('prvn_province_cstm', 'prvn_province.id = prvn_province_cstm.id_c', 'inner')
        ->join('rgin_region', 'rgin_region.id = prvn_province_cstm.rgin_region_id_c', 'inner')
        ->join('ctry_country', 'ctry_country.id = prvn_province_cstm.ctry_country_id_c', 'inner')
        ->join('jump_model_description_pi_prospect_inquiry_1_c', 'jump_model_description_pi_prospect_inquiry_1_c.jump_modeldc9einquiry_idb = pi_prospect_inquiry.id', 'inner')
        ->join('jump_model_description', 'jump_model_description.id = jump_model_description_pi_prospect_inquiry_1_c.jump_modela8cbription_ida', 'inner')
        ->join('jump_base_model_jump_model_description_1_c', 'jump_base_model_jump_model_description_1_c.jump_base_ae81ription_idb = jump_model_description.id', 'inner')
        ->join('jump_base_model', 'jump_base_model.id = jump_base_model_jump_model_description_1_c.jump_base_model_jump_model_description_1jump_base_model_ida', 'inner')
        ->join('jump_body_type_jump_base_model_1_c', 'jump_body_type_jump_base_model_1_c.jump_body_type_jump_base_model_1jump_base_model_idb = jump_base_model.id', 'inner')
        ->join('jump_body_type', 'jump_body_type.id = jump_body_type_jump_base_model_1_c.jump_body_type_jump_base_model_1jump_body_type_ida', 'inner')
        ->join('jump_color_jump_model_description_1_c', 'jump_color_jump_model_description_1_c.jump_color_jump_model_description_1jump_model_description_idb = jump_model_description.id', 'inner')
        ->join('jump_color', 'jump_color.id = jump_color_jump_model_description_1_c.jump_color_jump_model_description_1jump_color_ida', 'inner')
        ->join('jump_vehicle_type_jump_base_model_1_c', 'jump_vehicle_type_jump_base_model_1_c.jump_vehicle_type_jump_base_model_1jump_base_model_idb = jump_base_model.id', 'inner')
        ->join('jump_vehicle_type', 'jump_vehicle_type.id = jump_vehicle_type_jump_base_model_1jump_vehicle_type_ida', 'inner')
        ->join('lead_lead_source_pi_prospect_inquiry_1_c', 'lead_lead_source_pi_prospect_inquiry_1_c.lead_lead_source_pi_prospect_inquiry_1pi_prospect_inquiry_idb = pi_prospect_inquiry.id', 'inner')
        ->join('lead_lead_source', 'lead_lead_source.id = lead_lead_source_pi_prospect_inquiry_1_c.lead_lead_source_pi_prospect_inquiry_1lead_lead_source_ida', 'inner')
		->join('fnct_financing_terms_pi_prospect_inquiry_1_c', 'fnct_financing_terms_pi_prospect_inquiry_1_c.fnct_finanda90inquiry_idb = pi_prospect_inquiry.id', 'left')
        ->join('fnct_financing_terms', 'fnct_financing_terms.id = fnct_financing_terms_pi_prospect_inquiry_1_c.fnct_finand6a4g_terms_ida', 'left')
        ->join('users', 'pi_prospect_inquiry.assigned_user_id = users.id', 'inner')
        ->join('users_cstm', 'users_cstm.id_c = users.id', 'inner')
        // ->join('users', 'pi_prospect_inquiry.created_by', '=', 'users.id')
        // ->join('users_cstm', 'users_cstm.id_c', '=', 'users.id')
        ->join('jump_dealer', 'users_cstm.jump_dealer_id_c = jump_dealer.id', 'left')
		->join('jump_branch', 'jump_branch.id = users_cstm.jump_branch_id_c', 'inner')

		->where('pi_prospect_inquiry.deleted', 0);
		// additional where clause for dealer, branch etc.. . 

		
		$result = $this->db->get()->result();
		return $result;
		



		// return $this->db->get_compiled_select();

	}
	function payment_terms(){
		$this->selects = ['id_c','payment_terms_c'];
		$this->sqlQueries['toGroup'] = 'payment_terms_c';
		return $this->get();
	}




}

/* End of file Prospect_inquiry_cstm.php */
/* Location: ./application/models/Prospect_inquiry_cstm.php */