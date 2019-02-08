<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-07 16:23:37
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-08 16:59:16
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Pi_prospect_inquiry_cstm extends MY_Model {

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


	function by_MOP()
	{
		$this->selects = [ $this::DB_TABLE_PK, 'count('.$this::DB_TABLE_PK.') as total', 'payment_terms_c', "CONCAT('WEEK ',  WEEK(inquiry_date_c, 3) -
                      							WEEK(inquiry_date_c - INTERVAL DAY(inquiry_date_c)-1 DAY, 3) + 1 , ' ' , DATE_FORMAT(inquiry_date_c, '%b %Y')) as month"];

		$this->sqlQueries['toGroup'] = "payment_terms_c,  month";
		$this->sqlQueries['order_type'] = "asc";
		$this->sqlQueries['order_field'] = "inquiry_date_c";
		$res = $this->search();

		return $res;
	}
	function by_LS(){
		$this->selects = [$this::DB_TABLE_PK, "CONCAT('WEEK ', WEEK(inquiry_date_c, 3) -
                      	WEEK(inquiry_date_c - INTERVAL DAY(inquiry_date_c)-1 DAY, 3) + 1 , ' ' , DATE_FORMAT(inquiry_date_c, '%b')) as month",
                      	'count('.$this::DB_TABLE_PK.') as total', "lead_lead_source.name as ls_name"
                  		];

        $this->sqlQueries['order_type'] = "asc";
		$this->sqlQueries['order_field'] = "inquiry_date_c";
		$this->sqlQueries['toGroup'] = "month, ls_name";
		$this->toJoin = [['Lead_lead_source_pi_prospect_inquiry_1_c', $this::DB_TABLE.".id_c = lead_lead_source_pi_prospect_inquiry_1_c.lead_lead_source_pi_prospect_inquiry_1pi_prospect_inquiry_idb", "INNER" ],
					['lead_lead_source', "lead_lead_source.id = lead_lead_source_pi_prospect_inquiry_1_c.lead_lead_source_pi_prospect_inquiry_1lead_lead_source_ida", "INNER"]];


		$res = $this->search();

		return $res;


	}

}

/* End of file Prospect_inquiry_cstm.php */
/* Location: ./application/models/Prospect_inquiry_cstm.php */