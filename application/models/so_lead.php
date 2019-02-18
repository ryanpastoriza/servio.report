<?php


Class So_Lead extends CI_Model {

	public function hello(){
		return "Hello";
	}

	public function leads(){
		$query = $this->db->get('lead_lead_source');
		$data['ls'] = $query->result();

		$sdate = date("Y-m") . "-01";
		$edate = date("Y-m-t");
		$data['sdate'] = date("Y-m") . "-01";
		$data['edate'] = date("Y-m-t");
		$data['so_status_c'] = "Open";
		$soStatus = "Open";

		$data['so_status'] = $this->fetchSoStatus();

		if(isset($_GET['start_date']) && isset($_GET['end_date'])){
			$sdate = $_GET['start_date'];
			$edate = $_GET['end_date'];
			$data['sdate'] = $_GET['start_date'];
			$data['edate'] = $_GET['end_date'];
		}

		if(isset($_GET['so_status'])){
			$data['so_status_c'] = $_GET['so_status'];
			$soStatus = $_GET['so_status'];
		}
		

		$query = $this->db->get('jump_base_model');
		$data['bm'] = $query->result();
		$data['total'] = [];
		$data['overall'] = 0;
		foreach ($data['bm'] as $skey => $svalue) {
			$data['total'][$svalue->name] = 0;
		}


		foreach ($data['ls'] as $key => $value) {
			$data['ls'][$key]->value = $this->valueByLeads($value->id, $sdate, $edate);
			// $this->pp($data);
			if($data['overall'] != 0){
				$data['overall'] += $data['ls'][$key]->value->count;
			}			
			$bm = [];
			foreach ($data['bm'] as $skey => $svalue) {				
				$bm[$skey]['value'] = $this->getValue($value->id, $svalue->id, $sdate, $edate, $soStatus);
				// $this->pp($bm);
				$data['total'][$svalue->name] += $bm[$skey]['value']->count;
			}
		}
		// $data['overall'] = 0;
		foreach ($data['ls'] as $key => $value) {
			// $data['ls'][$key]->value = $this->valueByLeads($value->id, $sdate, $edate);
			$data['ls'][$key]->value = 0;
			$data['ls'][$key]->pct = 0;
					
			$bm = [];
			foreach ($data['bm'] as $skey => $svalue) {
				$bm[$skey]['name'] = $svalue->name;
				$bm[$skey]['id'] = $svalue->id;
				$bm[$skey]['value'] = $this->getValue($value->id, $svalue->id, $sdate, $edate, $soStatus);
				// $this->pp($bm[$skey]['value']->count);
				$data['ls'][$key]->value += $bm[$skey]['value']->count;

				$bm[$skey]['pct'] = 0;
				if($data['total'][$svalue->name] != 0){
					$bm[$skey]['pct'] = round(($bm[$skey]['value']->count / $data['total'][$svalue->name]) * 100, 1);
				}
				// echo $bm[$skey]['value']->count;
				// $data['total'][$svalue->name] += $bm[$skey]['value']->count;
			}

			$data['overall'] += $data['ls'][$key]->value;
			if($data['ls'][$key]->value > 0){
				$data['ls'][$key]->pct = round(($data['ls'][$key]->value / $data['overall']) * 100, 1);
			}	
			$data['ls'][$key]->bm = $bm;
		}
		return $data;
		echo "<pre>";
		print_r($data);
		echo "<pre>";
		die();
		
	}

	private function total($ls){

	}

	private function getValue($lead, $base_model, $sdate="", $edate="", $soStatus=""){
		// $query = $this->db->query("SELECT
		// count('id') as count
		// FROM
		// ddms_sales_order_cstm
		// INNER JOIN lead_lead_source_ddms_sales_order_1_c ON ddms_sales_order_cstm.id_c = lead_lead_source_ddms_sales_order_1_c.lead_lead_source_ddms_sales_order_1ddms_sales_order_idb
		// INNER JOIN jump_model_description_ddms_sales_order_1_c ON ddms_sales_order_cstm.id_c = jump_model_description_ddms_sales_order_1_c.jump_model_description_ddms_sales_order_1ddms_sales_order_idb
		// INNER JOIN lead_lead_source ON lead_lead_source.id = lead_lead_source_ddms_sales_order_1_c.lead_lead_source_ddms_sales_order_1lead_lead_source_ida
		// INNER JOIN jump_model_description ON jump_model_description.id = jump_model_description_ddms_sales_order_1_c.jump_model7e53ription_ida
		// INNER JOIN jump_base_model_jump_model_description_1_c ON jump_model_description.id = jump_base_model_jump_model_description_1_c.jump_base_ae81ription_idb
		// INNER JOIN jump_base_model ON jump_base_model.id = jump_base_model_jump_model_description_1_c.jump_base_model_jump_model_description_1jump_base_model_ida
		// INNER JOIN ddms_sales_order ON ddms_sales_order_cstm.id_c = ddms_sales_order.id		
		// WHERE lead_lead_source.id = '$lead' AND jump_base_model.id = '$base_model'");

		// if(!empty($sdate) && !empty($edate)){
		// 	$query = $this->db->query("SELECT
		// 	count('id') as count
		// 	FROM
		// 	ddms_sales_order_cstm
		// 	INNER JOIN lead_lead_source_ddms_sales_order_1_c ON ddms_sales_order_cstm.id_c = lead_lead_source_ddms_sales_order_1_c.lead_lead_source_ddms_sales_order_1ddms_sales_order_idb
		// 	INNER JOIN jump_model_description_ddms_sales_order_1_c ON ddms_sales_order_cstm.id_c = jump_model_description_ddms_sales_order_1_c.jump_model_description_ddms_sales_order_1ddms_sales_order_idb
		// 	INNER JOIN lead_lead_source ON lead_lead_source.id = lead_lead_source_ddms_sales_order_1_c.lead_lead_source_ddms_sales_order_1lead_lead_source_ida
		// 	INNER JOIN jump_model_description ON jump_model_description.id = jump_model_description_ddms_sales_order_1_c.jump_model7e53ription_ida
		// 	INNER JOIN jump_base_model_jump_model_description_1_c ON jump_model_description.id = jump_base_model_jump_model_description_1_c.jump_base_ae81ription_idb
		// 	INNER JOIN jump_base_model ON jump_base_model.id = jump_base_model_jump_model_description_1_c.jump_base_model_jump_model_description_1jump_base_model_ida
		// 	INNER JOIN ddms_sales_order ON ddms_sales_order_cstm.id_c = ddms_sales_order.id
		// 	WHERE lead_lead_source.id = '$lead' AND
		// 	jump_base_model.id = '$base_model' AND
		// 	ddms_sales_order.date_entered >= '$sdate' AND
		// 	ddms_sales_order.date_entered <= '$edate' 
		// 	AND ddms_sales_order_cstm.status_c = '$soStatus'
		// 	GROUP BY ddms_sales_order.id");			
		// }

		$query = $this->db->query("SELECT
			count('id') as count
			FROM
			ddms_sales_order_cstm
			INNER JOIN lead_lead_source_ddms_sales_order_1_c ON ddms_sales_order_cstm.id_c = lead_lead_source_ddms_sales_order_1_c.lead_lead_source_ddms_sales_order_1ddms_sales_order_idb
			INNER JOIN jump_model_description_ddms_sales_order_1_c ON ddms_sales_order_cstm.id_c = jump_model_description_ddms_sales_order_1_c.jump_model_description_ddms_sales_order_1ddms_sales_order_idb
			INNER JOIN lead_lead_source ON lead_lead_source.id = lead_lead_source_ddms_sales_order_1_c.lead_lead_source_ddms_sales_order_1lead_lead_source_ida
			INNER JOIN jump_model_description ON jump_model_description.id = jump_model_description_ddms_sales_order_1_c.jump_model7e53ription_ida
			INNER JOIN jump_base_model_jump_model_description_1_c ON jump_model_description.id = jump_base_model_jump_model_description_1_c.jump_base_ae81ription_idb
			INNER JOIN jump_base_model ON jump_base_model.id = jump_base_model_jump_model_description_1_c.jump_base_model_jump_model_description_1jump_base_model_ida
			INNER JOIN ddms_sales_order ON ddms_sales_order_cstm.id_c = ddms_sales_order.id
			WHERE lead_lead_source.id = '$lead' AND
			jump_base_model.id = '$base_model' AND
			ddms_sales_order.date_entered >= '$sdate' AND
			ddms_sales_order.date_entered <= '$edate' 
			AND ddms_sales_order_cstm.status_c = '$soStatus'
			AND ddms_sales_order.deleted = 0
			GROUP BY ddms_sales_order.id");

		// $qquery = "SELECT
		// 	count('id') as count
		// 	FROM
		// 	ddms_sales_order_cstm
		// 	INNER JOIN lead_lead_source_ddms_sales_order_1_c ON ddms_sales_order_cstm.id_c = lead_lead_source_ddms_sales_order_1_c.lead_lead_source_ddms_sales_order_1ddms_sales_order_idb
		// 	INNER JOIN jump_model_description_ddms_sales_order_1_c ON ddms_sales_order_cstm.id_c = jump_model_description_ddms_sales_order_1_c.jump_model_description_ddms_sales_order_1ddms_sales_order_idb
		// 	INNER JOIN lead_lead_source ON lead_lead_source.id = lead_lead_source_ddms_sales_order_1_c.lead_lead_source_ddms_sales_order_1lead_lead_source_ida
		// 	INNER JOIN jump_model_description ON jump_model_description.id = jump_model_description_ddms_sales_order_1_c.jump_model7e53ription_ida
		// 	INNER JOIN jump_base_model_jump_model_description_1_c ON jump_model_description.id = jump_base_model_jump_model_description_1_c.jump_base_ae81ription_idb
		// 	INNER JOIN jump_base_model ON jump_base_model.id = jump_base_model_jump_model_description_1_c.jump_base_model_jump_model_description_1jump_base_model_ida
		// 	INNER JOIN ddms_sales_order ON ddms_sales_order_cstm.id_c = ddms_sales_order.id
		// 	WHERE lead_lead_source.id = '$lead' AND
		// 	jump_base_model.id = '$base_model' AND
		// 	ddms_sales_order.date_entered >= '$sdate' AND
		// 	ddms_sales_order.date_entered <= '$edate' 
		// 	AND ddms_sales_order_cstm.status_c = '$soStatus' 
		// 	AND ddms_sales_order.deleted = 0
		// 	GROUP BY ddms_sales_order.id";

			// $this->pp($qquery);

		if(count($query->result()) > 0){
			return $query->result()[0];
		}
		$res = (object) Array();
		$res->count = 0;
		return $res;
	}

	private function valueByLeads($lead,  $sdate="", $edate="", $soStatus=""){
		// $query = $this->db->query("SELECT
		// count('id') as count
		// FROM
		// ddms_sales_order_cstm
		// INNER JOIN lead_lead_source_ddms_sales_order_1_c ON ddms_sales_order_cstm.id_c = lead_lead_source_ddms_sales_order_1_c.lead_lead_source_ddms_sales_order_1ddms_sales_order_idb
		// INNER JOIN jump_model_description_ddms_sales_order_1_c ON ddms_sales_order_cstm.id_c = jump_model_description_ddms_sales_order_1_c.jump_model_description_ddms_sales_order_1ddms_sales_order_idb
		// INNER JOIN lead_lead_source ON lead_lead_source.id = lead_lead_source_ddms_sales_order_1_c.lead_lead_source_ddms_sales_order_1lead_lead_source_ida
		// INNER JOIN jump_model_description ON jump_model_description.id = jump_model_description_ddms_sales_order_1_c.jump_model7e53ription_ida
		// INNER JOIN jump_base_model_jump_model_description_1_c ON jump_model_description.id = jump_base_model_jump_model_description_1_c.jump_base_ae81ription_idb
		// INNER JOIN jump_base_model ON jump_base_model.id = jump_base_model_jump_model_description_1_c.jump_base_model_jump_model_description_1jump_base_model_ida
		// WHERE lead_lead_source.id = '$lead'");

		$query = $this->db->query("SELECT
			count('id') as count
			FROM
			ddms_sales_order_cstm
			INNER JOIN lead_lead_source_ddms_sales_order_1_c ON ddms_sales_order_cstm.id_c = lead_lead_source_ddms_sales_order_1_c.lead_lead_source_ddms_sales_order_1ddms_sales_order_idb
			INNER JOIN jump_model_description_ddms_sales_order_1_c ON ddms_sales_order_cstm.id_c = jump_model_description_ddms_sales_order_1_c.jump_model_description_ddms_sales_order_1ddms_sales_order_idb
			INNER JOIN lead_lead_source ON lead_lead_source.id = lead_lead_source_ddms_sales_order_1_c.lead_lead_source_ddms_sales_order_1lead_lead_source_ida
			INNER JOIN jump_model_description ON jump_model_description.id = jump_model_description_ddms_sales_order_1_c.jump_model7e53ription_ida
			INNER JOIN jump_base_model_jump_model_description_1_c ON jump_model_description.id = jump_base_model_jump_model_description_1_c.jump_base_ae81ription_idb
			INNER JOIN jump_base_model ON jump_base_model.id = jump_base_model_jump_model_description_1_c.jump_base_model_jump_model_description_1jump_base_model_ida
			INNER JOIN ddms_sales_order ON ddms_sales_order_cstm.id_c = ddms_sales_order.id
			WHERE lead_lead_source.id = '$lead' AND
			ddms_sales_order.date_entered >= '$sdate' AND
			ddms_sales_order.date_entered <= '$edate'
			AND ddms_sales_order_cstm.status_c = '$soStatus'
			GROUP BY ddms_sales_order.id");

		// if(!empty($sdate) && !empty($edate)){
		// 	$query = $this->db->query("SELECT
		// 	count('id') as count
		// 	FROM
		// 	ddms_sales_order_cstm
		// 	INNER JOIN lead_lead_source_ddms_sales_order_1_c ON ddms_sales_order_cstm.id_c = lead_lead_source_ddms_sales_order_1_c.lead_lead_source_ddms_sales_order_1ddms_sales_order_idb
		// 	INNER JOIN jump_model_description_ddms_sales_order_1_c ON ddms_sales_order_cstm.id_c = jump_model_description_ddms_sales_order_1_c.jump_model_description_ddms_sales_order_1ddms_sales_order_idb
		// 	INNER JOIN lead_lead_source ON lead_lead_source.id = lead_lead_source_ddms_sales_order_1_c.lead_lead_source_ddms_sales_order_1lead_lead_source_ida
		// 	INNER JOIN jump_model_description ON jump_model_description.id = jump_model_description_ddms_sales_order_1_c.jump_model7e53ription_ida
		// 	INNER JOIN jump_base_model_jump_model_description_1_c ON jump_model_description.id = jump_base_model_jump_model_description_1_c.jump_base_ae81ription_idb
		// 	INNER JOIN jump_base_model ON jump_base_model.id = jump_base_model_jump_model_description_1_c.jump_base_model_jump_model_description_1jump_base_model_ida
		// 	INNER JOIN ddms_sales_order ON ddms_sales_order_cstm.id_c = ddms_sales_order.id
		// 	WHERE lead_lead_source.id = '$lead' AND
		// 	ddms_sales_order.date_entered >= '$sdate' AND
		// 	ddms_sales_order.date_entered <= '$edate'");

			
		// }
		// $this->pp($query->result());

		if(count($query->result()) > 0){

			return $query->result()[0];
		}
		$res = (object) Array();
		$res->count = 0;
		// $this->pp($res->count);
		return $res;
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