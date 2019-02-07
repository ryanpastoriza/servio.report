<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-07 16:23:37
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-07 16:34:01
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


}

/* End of file Prospect_inquiry_cstm.php */
/* Location: ./application/models/Prospect_inquiry_cstm.php */