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
		$this->put_contents("content");
	}

}

/* End of file Reports.php */
/* Location: ./application/controllers/Reports.php */