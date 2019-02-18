<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-11 10:58:40
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-15 19:25:56
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Ddms_sales_order extends MY_Model {

	const DB_TABLE = 'ddms_sales_order';
	const DB_TABLE_PK = 'id';


	function by_MOP($conditions = false)
	{
		$this->selects = [$this::DB_TABLE.".".$this::DB_TABLE_PK, "CONCAT('WK ', WEEK(ddms_sales_order.date_entered, 3) -
                  	WEEK(ddms_sales_order.date_entered - INTERVAL DAY(ddms_sales_order.date_entered)-1 DAY, 3) + 1 , ' ' , DATE_FORMAT(ddms_sales_order.date_entered, '%b %Y')) as month",
                  	'count('.$this::DB_TABLE.".".$this::DB_TABLE_PK.') as total', "Ddms_sales_order_cstm.payment_terms_c as model_name"
              		];

        $this->sqlQueries['order_type'] = "asc";
		$this->sqlQueries['order_field'] = "ddms_sales_order.date_entered";
		$this->sqlQueries['toGroup'] = "month, model_name";
		$this->toJoin = [
							['Ddms_sales_order_cstm', $this::DB_TABLE.".id = Ddms_sales_order_cstm.id_c", "INNER" ],
        					['users', "users.id = ddms_sales_order.assigned_user_id", "INNER"],
        					['users_cstm', "users_cstm.id_c = users.id", "INNER"],
        					['lead_lead_source_ddms_sales_order_1_c', "lead_lead_source_ddms_sales_order_1_c.Lead_lead_source_ddms_sales_order_1ddms_sales_order_idb = ddms_sales_order.id", "INNER"],
		        			['jump_model_description_ddms_sales_order_1_c', "jump_model_description_ddms_sales_order_1_c.jump_model_description_ddms_sales_order_1ddms_sales_order_idb = Ddms_sales_order_cstm.id_c", "INNER"],
		        			['jump_model_description', "jump_model_description.id = jump_model_description_ddms_sales_order_1_c.jump_model7e53ription_ida", "INNER"],
		        			['jump_base_model_jump_model_description_1_c', "jump_base_model_jump_model_description_1_c.jump_base_ae81ription_idb = jump_model_description.id", "INNER"],
		        			['jump_base_model', "jump_base_model_jump_model_description_1_c.jump_base_model_jump_model_description_1jump_base_model_ida = jump_base_model.id", "INNER"]
						];


		$conditions = $conditions ?  $conditions." AND (ddms_sales_order.deleted = 0 AND jump_model_description_ddms_sales_order_1_c.deleted = 0)" : "ddms_sales_order.deleted = 0 AND jump_model_description_ddms_sales_order_1_c.deleted = 0";


		$res = $this->search($conditions);

		return $res;
	}
	function by_LS($conditions = false){
		$this->selects = [$this::DB_TABLE.".".$this::DB_TABLE_PK, "CONCAT('WK ', WEEK(".$this::DB_TABLE.".date_entered, 3) -
                  	WEEK(".$this::DB_TABLE.".date_entered - INTERVAL DAY(".$this::DB_TABLE.".date_entered)-1 DAY, 3) + 1 , ' ' , DATE_FORMAT(".$this::DB_TABLE.".date_entered, '%b %Y')) as month",
                  	'count('.$this::DB_TABLE.".".$this::DB_TABLE_PK.') as total', "lead_lead_source.name as lead_source"
              		];

        $this->sqlQueries['order_type'] = "asc";
		$this->sqlQueries['order_field'] = $this::DB_TABLE.".date_entered";
		$this->sqlQueries['toGroup'] = "month, lead_source";
		$this->toJoin = [
							['Lead_lead_source_ddms_sales_order_1_c', $this::DB_TABLE.".id = Lead_lead_source_ddms_sales_order_1_c.Lead_lead_source_ddms_sales_order_1ddms_sales_order_idb", "INNER" ],
							['lead_lead_source', "lead_lead_source.id = Lead_lead_source_ddms_sales_order_1_c.Lead_lead_source_ddms_sales_order_1lead_lead_source_ida", "INNER" ],
							['Ddms_sales_order_cstm', $this::DB_TABLE.".id = Ddms_sales_order_cstm.id_c", "INNER" ],
							['users', "users.id = ddms_sales_order.assigned_user_id", "INNER"],
        					['users_cstm', "users_cstm.id_c = users.id", "INNER"],
		        			['jump_model_description_ddms_sales_order_1_c', "jump_model_description_ddms_sales_order_1_c.jump_model_description_ddms_sales_order_1ddms_sales_order_idb = Ddms_sales_order_cstm.id_c", "INNER"],
		        			['jump_model_description', "jump_model_description.id = jump_model_description_ddms_sales_order_1_c.jump_model7e53ription_ida", "INNER"],
		        			['jump_base_model_jump_model_description_1_c', "jump_base_model_jump_model_description_1_c.jump_base_ae81ription_idb = jump_model_description.id", "INNER"],
		        			['jump_base_model', "jump_base_model_jump_model_description_1_c.jump_base_model_jump_model_description_1jump_base_model_ida = jump_base_model.id", "INNER"]
						];


		$conditions = $conditions ?  $conditions." AND (ddms_sales_order.deleted = 0 AND jump_model_description_ddms_sales_order_1_c.deleted = 0)" : "ddms_sales_order.deleted = 0 AND jump_model_description_ddms_sales_order_1_c.deleted = 0";


		$res = $this->search($conditions);

		return $res;
	}
	function by_Model($conditions = false){
		$this->selects = [$this::DB_TABLE.".".$this::DB_TABLE_PK, "CONCAT('WK ', WEEK(".$this::DB_TABLE.".date_entered, 3) -
                  	WEEK(".$this::DB_TABLE.".date_entered - INTERVAL DAY(".$this::DB_TABLE.".date_entered)-1 DAY, 3) + 1 , ' ' , DATE_FORMAT(".$this::DB_TABLE.".date_entered, '%b %Y')) as month",
                  	'count('.$this::DB_TABLE.".".$this::DB_TABLE_PK.') as total', "jump_base_model.name as model_name"
              		];

        $this->sqlQueries['order_type'] = "asc";
		$this->sqlQueries['order_field'] = $this::DB_TABLE.".date_entered";
		$this->sqlQueries['toGroup'] = "month, model_name";
		$this->toJoin = [
							['Ddms_sales_order_cstm', $this::DB_TABLE.".id = Ddms_sales_order_cstm.id_c", "INNER" ],
							['users', "users.id = ddms_sales_order.assigned_user_id", "INNER"],
        					['users_cstm', "users_cstm.id_c = users.id", "INNER"],
        					['lead_lead_source_ddms_sales_order_1_c', "lead_lead_source_ddms_sales_order_1_c.Lead_lead_source_ddms_sales_order_1ddms_sales_order_idb = ddms_sales_order.id", "INNER"],
		        			['jump_model_description_ddms_sales_order_1_c', "jump_model_description_ddms_sales_order_1_c.jump_model_description_ddms_sales_order_1ddms_sales_order_idb = Ddms_sales_order_cstm.id_c", "INNER"],
		        			['jump_model_description', "jump_model_description.id = jump_model_description_ddms_sales_order_1_c.jump_model7e53ription_ida", "INNER"],
		        			['jump_base_model_jump_model_description_1_c', "jump_base_model_jump_model_description_1_c.jump_base_ae81ription_idb = jump_model_description.id", "INNER"],
		        			['jump_base_model', "jump_base_model_jump_model_description_1_c.jump_base_model_jump_model_description_1jump_base_model_ida = jump_base_model.id", "INNER"]
						];


		$conditions = $conditions ?  $conditions." AND (ddms_sales_order.deleted = 0 AND jump_model_description_ddms_sales_order_1_c.deleted = 0 AND jump_base_model_jump_model_description_1_c.deleted = 0)" : "ddms_sales_order.deleted = 0 AND jump_model_description_ddms_sales_order_1_c.deleted = 0 AND jump_base_model_jump_model_description_1_c.deleted = 0";


		$res = $this->search($conditions);

		return $res;
	}
	function invoiced($conditions = false){
		$this->selects = [$this::DB_TABLE.".".$this::DB_TABLE_PK, "CONCAT('WK ', WEEK(".$this::DB_TABLE.".date_entered, 3) -
                  	WEEK(".$this::DB_TABLE.".date_entered - INTERVAL DAY(".$this::DB_TABLE.".date_entered)-1 DAY, 3) + 1 , ' ' , DATE_FORMAT(".$this::DB_TABLE.".date_entered, '%b %Y')) as month",
                  	'count('.$this::DB_TABLE.".".$this::DB_TABLE_PK.') as total', "jump_base_model.name as model_name",
              		];

        $this->sqlQueries['order_type'] = "asc";
		$this->sqlQueries['order_field'] = "".$this::DB_TABLE.".date_entered";
		$this->sqlQueries['toGroup'] = "month, model_name";
		$this->toJoin = [
							['Ddms_sales_order_cstm', $this::DB_TABLE.".id = Ddms_sales_order_cstm.id_c", "INNER" ],
							['users', "users.id = ddms_sales_order.assigned_user_id", "INNER"],
        					['users_cstm', "users_cstm.id_c = users.id", "INNER"],
        					['lead_lead_source_ddms_sales_order_1_c', "lead_lead_source_ddms_sales_order_1_c.Lead_lead_source_ddms_sales_order_1ddms_sales_order_idb = ddms_sales_order.id", "INNER"],
		        			['jump_model_description_ddms_sales_order_1_c', "jump_model_description_ddms_sales_order_1_c.jump_model_description_ddms_sales_order_1ddms_sales_order_idb = Ddms_sales_order_cstm.id_c", "INNER"],
		        			['jump_model_description', "jump_model_description.id = jump_model_description_ddms_sales_order_1_c.jump_model7e53ription_ida", "INNER"],
		        			['jump_base_model_jump_model_description_1_c', "jump_base_model_jump_model_description_1_c.jump_base_ae81ription_idb = jump_model_description.id", "INNER"],
		        			['jump_base_model', "jump_base_model_jump_model_description_1_c.jump_base_model_jump_model_description_1jump_base_model_ida = jump_base_model.id", "INNER"]
						];


		$conditions = $conditions ?  $conditions." AND (ddms_sales_order.deleted = 0 AND jump_model_description_ddms_sales_order_1_c.deleted = 0 AND Ddms_sales_order_cstm.invoiced_c !=  '')" : "ddms_sales_order.deleted = 0 AND jump_model_description_ddms_sales_order_1_c.deleted = 0 AND Ddms_sales_order_cstm.invoiced_c !=  ''";


		$res = $this->search($conditions);

		return $res;

	}
}

/* End of file ddms_sales_order.php */
/* Location: ./application/models/ddms_sales_order.php */