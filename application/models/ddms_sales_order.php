<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-11 10:58:40
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-13 11:36:03
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Ddms_sales_order extends MY_Model {

	const DB_TABLE = 'ddms_sales_order';
	const DB_TABLE_PK = 'id';


	function by_MOP()
	{
		$this->selects = [$this::DB_TABLE_PK, "CONCAT('WK ', WEEK(date_entered, 3) -
                  	WEEK(date_entered - INTERVAL DAY(date_entered)-1 DAY, 3) + 1 , ' ' , DATE_FORMAT(date_entered, '%b %Y')) as month",
                  	'count('.$this::DB_TABLE_PK.') as total', "Ddms_sales_order_cstm.payment_terms_c as model_name"
              		];

        $this->sqlQueries['order_type'] = "asc";
		$this->sqlQueries['order_field'] = "date_entered";
		$this->sqlQueries['toGroup'] = "month, model_name";
		$this->toJoin = [['Ddms_sales_order_cstm', $this::DB_TABLE.".id = Ddms_sales_order_cstm.id_c", "INNER" ]];


		$res = $this->search();

		return $res;
	}
	function by_LS(){
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
						];


		$res = $this->search();

		return $res;
	}
	function by_Model(){
		$this->selects = [$this::DB_TABLE_PK, "CONCAT('WK ', WEEK(date_entered, 3) -
                  	WEEK(date_entered - INTERVAL DAY(date_entered)-1 DAY, 3) + 1 , ' ' , DATE_FORMAT(date_entered, '%b %Y')) as month",
                  	'count('.$this::DB_TABLE_PK.') as total', "Ddms_sales_order_cstm.base_model_c as model_name"
              		];

        $this->sqlQueries['order_type'] = "asc";
		$this->sqlQueries['order_field'] = "date_entered";
		$this->sqlQueries['toGroup'] = "month, model_name";
		$this->toJoin = [['Ddms_sales_order_cstm', $this::DB_TABLE.".id = Ddms_sales_order_cstm.id_c", "INNER" ]];


		$res = $this->search();

		return $res;
	}
	function invoiced(){
		$this->selects = [$this::DB_TABLE_PK, "CONCAT('WK ', WEEK(date_entered, 3) -
                  	WEEK(date_entered - INTERVAL DAY(date_entered)-1 DAY, 3) + 1 , ' ' , DATE_FORMAT(date_entered, '%b %Y')) as month",
                  	'count('.$this::DB_TABLE_PK.') as total', "Ddms_sales_order_cstm.base_model_c as model_name"
              		];

        $this->sqlQueries['order_type'] = "asc";
		$this->sqlQueries['order_field'] = "date_entered";
		$this->sqlQueries['toGroup'] = "month, model_name";
		$this->toJoin = [['Ddms_sales_order_cstm', $this::DB_TABLE.".id = Ddms_sales_order_cstm.id_c", "INNER" ]];


		$res = $this->search("Ddms_sales_order_cstm.invoiced_c !=  ''");

		return $res;
	}
}

/* End of file ddms_sales_order.php */
/* Location: ./application/models/ddms_sales_order.php */