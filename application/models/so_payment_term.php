<?php


Class So_payment_term extends CI_MOdel {

	public function soByPaymentTerms($pm){
			
		$data['pm'] = $this->setPm($pm);

		$query = $this->db->query("SELECT * FROM jump_base_model WHERE deleted = 0");
		$data['bm'] = $query->result();
		$data['total_bm'] = (object) Array();
		$data['total_bm_pct'] = (object) Array();
		$data['total_pm'] = 0;

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

		// $this->pp($data['pm']);

		// :::::::::::::::::::: CALCULATE TOTAL ::::::::::::::::::::::::::::::::

		foreach ($data['pm'] as $key => $value) {
			$data['pm'][$key]->total = 0;
			// $this->pp($data['pm'][$key]->total);
			foreach ($data['bm'] as $skey => $svalue) {
				$bm = $this->paymentMode($value->name, $svalue->id, $sdate, $edate, $soStatus, $data['bbranch'], $data['ddealer']);
				$data['pm'][$key]->total += count($bm);
				if(!isset($data['total_bm']->{$svalue->name})){
					$data['total_bm']->{$svalue->name} = 0;
				}
				$data['total_bm']->{$svalue->name} += count($bm);
			}
			$data['total_pm'] += $data['pm'][$key]->total;
		}

		// :::::::::::::::::::: CALCULATE RESULT ::::::::::::::::::::::::::::::::

		foreach ($data['pm'] as $key => $value) {
			if($data['total_pm'] != 0){
				$data['pm'][$key]->pct = round(($data['pm'][$key]->total / $data['total_pm']) * 100, 1);
			}else{
				$data['pm'][$key]->pct = 0;
			}
			
			foreach ($data['bm'] as $skey => $svalue) { 
				$bm = $this->paymentMode($value->name, $svalue->id, $sdate, $edate, $soStatus, $data['bbranch'], $data['ddealer']);
				$data['pm'][$key]->bm[$svalue->name]['count'] = count($bm);

				if($data['pm'][$key]->total != 0){
					$data['pm'][$key]->bm[$svalue->name]['pct'] = round((count($bm) / $data['pm'][$key]->total) * 100, 1);
				}else{
					$data['pm'][$key]->bm[$svalue->name]['pct'] = 0;
				}

				if(!isset($data['total_bm_pct']->{$svalue->name})){
					$data['total_bm_pct']->{$svalue->name} = 0;
				}
				if($data['total_pm'] != 0){
					$data['total_bm_pct']->{$svalue->name} = round(($data['total_bm']->{$svalue->name} / $data['total_pm']) * 100, 1);
				}
				// $data['total_bm_pct']->{$svalue->name} += $data['pm'][$key]->bm[$svalue->name]['pct'];
				
			}
		}

		// $this->pp($data);

		return $data;
	}


	private function setPm($pm){
		$ppm = [];
		foreach ($pm as $key => $value) {
			$res = (object) Array();
			$res->name = $pm[$key];
			$ppm[$key] = $res;			
		}
		return $ppm;
	}


	public function paymentMode($pm, $bm, $sdate, $edate, $so_status, $branch, $dealer){
		$query = "SELECT
				ddms_sales_order_cstm.id_c,
				jump_dealer.`name`,
				jump_branch.`name`,
				ddms_sales_order.date_entered,
				jump_branch.id AS branch,
				jump_dealer.id AS dealer,
				ddms_sales_order_cstm.payment_terms_c
				FROM
				ddms_sales_order_cstm
				INNER JOIN jump_model_description_ddms_sales_order_1_c ON ddms_sales_order_cstm.id_c = jump_model_description_ddms_sales_order_1_c.jump_model_description_ddms_sales_order_1ddms_sales_order_idb
				INNER JOIN jump_model_description ON jump_model_description.id = jump_model_description_ddms_sales_order_1_c.jump_model7e53ription_ida
				INNER JOIN jump_base_model_jump_model_description_1_c ON jump_model_description.id = jump_base_model_jump_model_description_1_c.jump_base_ae81ription_idb
				INNER JOIN jump_base_model ON jump_base_model.id = jump_base_model_jump_model_description_1_c.jump_base_model_jump_model_description_1jump_base_model_ida
				INNER JOIN ddms_sales_order ON ddms_sales_order_cstm.id_c = ddms_sales_order.id
				INNER JOIN users_cstm ON users_cstm.id_c = ddms_sales_order.assigned_user_id
				INNER JOIN jump_dealer ON jump_dealer.id = users_cstm.jump_dealer_id_c
				INNER JOIN jump_branch ON jump_branch.id = users_cstm.jump_branch_id_c
				WHERE
				jump_base_model.id = '$bm' AND
				ddms_sales_order_cstm.status_c = '$so_status' AND
				jump_branch.id = '$branch' AND
				jump_dealer.id = '$dealer' AND
				ddms_sales_order.date_entered >= '$sdate' AND
				ddms_sales_order.date_entered <= '$edate' AND
				ddms_sales_order_cstm.payment_terms_c = '$pm'
				GROUP BY ddms_sales_order_cstm.id_c";

		$res = $this->db->query($query);
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