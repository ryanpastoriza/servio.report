<?php


Class So_Leads extends MY_Model {

	public function leads(){
		$query = $this->db->get('lead_lead_source');
		$data['ls'] = $query->result();

		$query = $this->db->get('jump_base_model');
		$data['bm'] = $query->result();
		$data['total_bm'] = (object) Array();
		$data['total_ls'] = 0;

		$sdate = date("Y-m") . "-01";
		$edate = date("Y-m-t");
		$data['sdate'] = date("Y-m") . "-01";
		$data['edate'] = date("Y-m-t");
		$data['so_status_c'] = "Open";
		$data['bbranch'] = "";
		$data['ddealer'] = "";
		$soStatus = "Open";
		$ddata = [];

		$data['so_status'] = $this->fetchSoStatus();

		if(isset($_GET['start_date']) && isset($_GET['end_date'])){
			$sdate = $_GET['start_date'];
			$edate = $_GET['end_date'];
			$data['sdate'] = $_GET['start_date'];
			$data['edate'] = $_GET['end_date'];
			$data['bbranch'] = $_GET['branch'];
			$data['ddealer'] = $_GET['dealer'];
		}

		if(isset($_GET['so_status'])){
			$data['so_status_c'] = $_GET['so_status'];
			$soStatus = $_GET['so_status'];
		}


		// :::::::::::::::::::: CALCULATE TOTAL ::::::::::::::::::::::::::::::::

		foreach ($data['ls'] as $key => $value) {
			$data['ls'][$key]->total = 0;
			foreach ($data['bm'] as $skey => $svalue) {
				$bm = $this->byModel($value->id, $svalue->id, $sdate, $edate, $soStatus, $data['bbranch'], $data['ddealer']);
				$data['ls'][$key]->total += count($bm);
				if(!isset($data['total_bm']->{$svalue->name})){
					$data['total_bm']->{$svalue->name} = 0;
				}
				$data['total_bm']->{$svalue->name} += count($bm);
			}
			$data['total_ls'] += $data['ls'][$key]->total;
		}

		// :::::::::::::::::::: CALCULATE RESULT ::::::::::::::::::::::::::::::::

		foreach ($data['ls'] as $key => $value) {
			if($data['total_ls'] != 0){
				$data['ls'][$key]->pct = round(($data['ls'][$key]->total / $data['total_ls']) * 100, 1);
			}else{
				$data['ls'][$key]->pct = 0;
			}
			
			foreach ($data['bm'] as $skey => $svalue) { 
				$bm = $this->byModel($value->id, $svalue->id, $sdate, $edate, $soStatus, $data['bbranch'], $data['ddealer']);
				$data['ls'][$key]->bm[$svalue->name]['count'] = count($bm);
				if($data['total_bm']->{$svalue->name} != 0){
					$data['ls'][$key]->bm[$svalue->name]['pct'] = round((count($bm) / $data['total_bm']->{$svalue->name}) * 100, 1);
				}else{
					$data['ls'][$key]->bm[$svalue->name]['pct'] = 0;
				}
				
			}
		}

		// $this->pp($data);
		return $data;
	}

	public function byModel($ls, $bm, $sdate, $edate, $so_status, $branch, $dealer){
		$query = "SELECT
				ddms_sales_order_cstm.id_c,
				jump_dealer.`name`,
				jump_branch.`name`
				FROM
				ddms_sales_order_cstm
				INNER JOIN lead_lead_source_ddms_sales_order_1_c ON ddms_sales_order_cstm.id_c = lead_lead_source_ddms_sales_order_1_c.lead_lead_source_ddms_sales_order_1ddms_sales_order_idb
				INNER JOIN jump_model_description_ddms_sales_order_1_c ON ddms_sales_order_cstm.id_c = jump_model_description_ddms_sales_order_1_c.jump_model_description_ddms_sales_order_1ddms_sales_order_idb
				INNER JOIN lead_lead_source ON lead_lead_source.id = lead_lead_source_ddms_sales_order_1_c.lead_lead_source_ddms_sales_order_1lead_lead_source_ida
				INNER JOIN jump_model_description ON jump_model_description.id = jump_model_description_ddms_sales_order_1_c.jump_model7e53ription_ida
				INNER JOIN jump_base_model_jump_model_description_1_c ON jump_model_description.id = jump_base_model_jump_model_description_1_c.jump_base_ae81ription_idb
				INNER JOIN jump_base_model ON jump_base_model.id = jump_base_model_jump_model_description_1_c.jump_base_model_jump_model_description_1jump_base_model_ida
				INNER JOIN ddms_sales_order ON ddms_sales_order_cstm.id_c = ddms_sales_order.id
				INNER JOIN users_cstm ON users_cstm.id_c = ddms_sales_order.assigned_user_id
				INNER JOIN jump_dealer ON jump_dealer.id = users_cstm.jump_dealer_id_c
				INNER JOIN jump_branch ON jump_branch.id = users_cstm.jump_branch_id_c
				WHERE
				lead_lead_source.id = '$ls' AND
				jump_base_model.id = '$bm' AND
				ddms_sales_order_cstm.status_c = '$so_status' AND
				jump_branch.id = '$branch' AND
				jump_dealer.id = '$dealer' AND
				ddms_sales_order.date_entered >= '$sdate' AND
				ddms_sales_order.date_entered <= '$edate'
				GROUP BY ddms_sales_order_cstm.id_c";

		$res = $this->db->query($query);
		// return $query;
		return $res->result();
	}

	public function fetchSoStatus(){
		$status = $this->db->query("SELECT status_c FROM ddms_sales_order_cstm GROUP BY status_c");

		return $status->result();
	}

	public function pp($data){
		echo "<pre>";
		print_r($data);
		echo "<pre>";
		die();
	}
}