<?php


Class So_payment_terms extends CI_MOdel {

	public function soByPaymentTerms($pm){
		$data = [];
		$data['pm'] = $pm;
		$data['result'] = [];
		$data['total'] = [];
		$data['overall'] = [];
		$data['overall_total'] = 0;
		$data['total_percentage'] = [];
		
		$sdate = date("Y-m") . "-01";
		$edate = date("Y-m-t");
		$data['sdate'] = date("Y-m") . "-01";
		$data['edate'] = date("Y-m-t");

		$sdate = "";
		$edate = "";
		if(isset($_GET['sdate']) && isset($_GET['edate'])){
			$sdate = $_GET['sdate'];
			$edate = $_GET['edate'];
			$data['sdate'] = $_GET['sdate'];
			$data['edate'] = $_GET['edate'];
		}

		$query = $this->db->get('jump_base_model');
		$data['bm'] = $query->result();

		foreach ($data['pm'] as $key => $value) {
			$bm = [];		
			$data['overall'][$key] = 0;

			foreach ($data['bm'] as $skey => $svalue) {
				$bm[$svalue->name] = $this->paymentByModel($value, $svalue->id, $sdate, $edate);
				if(!isset($data['total'][$svalue->name])){
					$data['total'][$svalue->name] = 0;
				}
				$data['total'][$svalue->name] += $bm[$svalue->name]->count;
				$data['overall'][$key] += $bm[$svalue->name]->count;
			}
			$data['overall_total'] += $data['overall'][$key];
		}

		foreach ($data['pm'] as $key => $value) {
			$bm = [];
			$data['result'][$key] = [];
			$data['result'][$key]['pm'] = $value;
			$data['total_percentage'][$key] = 0;

			if($data['overall'][$key] != 0){
				$data['total_percentage'][$key] = ($data['overall'][$key] /  $data['overall_total']) * 100;
			}
			
			foreach ($data['bm'] as $skey => $svalue) {
				$bm[$svalue->name] = $this->paymentByModel($value, $svalue->id, $sdate, $edate);
				$bm[$svalue->name]->percentage = 0;

				if($bm[$svalue->name]->count != 0){
					$bm[$svalue->name]->percentage = ($bm[$svalue->name]->count / $data['total'][$svalue->name]) * 100;
				}	
			}
			$data['result'][$key]['bm'] = $bm;
		}


		return $data;
	}

	public function paymentByModel($pm, $bm, $sdate = "", $edate = ""){
		$query = $this->db->query("SELECT count(ddms_sales_order.id) as count
				FROM
				ddms_sales_order
				INNER JOIN ddms_sales_order_cstm ON ddms_sales_order.id = ddms_sales_order_cstm.id_c
				INNER JOIN jump_base_model_ddms_sales_order_1_c ON ddms_sales_order_cstm.id_c = jump_base_model_ddms_sales_order_1_c.jump_base_model_ddms_sales_order_1ddms_sales_order_idb
				INNER JOIN jump_base_model ON jump_base_model.id = jump_base_model_ddms_sales_order_1_c.jump_base_model_ddms_sales_order_1jump_base_model_ida
				INNER JOIN jump_base_model_jump_model_description_1_c ON jump_base_model.id = jump_base_model_jump_model_description_1_c.jump_base_model_jump_model_description_1jump_base_model_ida
				INNER JOIN jump_model_description ON jump_model_description.id = jump_base_model_jump_model_description_1_c.jump_base_ae81ription_idb
				WHERE
				jump_base_model.id = '$bm' AND
				ddms_sales_order_cstm.payment_terms_c = '$pm'");


		if(!empty($sdate) && !empty($edate)){
			$query = $this->db->query("SELECT count(ddms_sales_order.id) as count
				FROM
				ddms_sales_order
				INNER JOIN ddms_sales_order_cstm ON ddms_sales_order.id = ddms_sales_order_cstm.id_c
				INNER JOIN jump_base_model_ddms_sales_order_1_c ON ddms_sales_order_cstm.id_c = jump_base_model_ddms_sales_order_1_c.jump_base_model_ddms_sales_order_1ddms_sales_order_idb
				INNER JOIN jump_base_model ON jump_base_model.id = jump_base_model_ddms_sales_order_1_c.jump_base_model_ddms_sales_order_1jump_base_model_ida
				INNER JOIN jump_base_model_jump_model_description_1_c ON jump_base_model.id = jump_base_model_jump_model_description_1_c.jump_base_model_jump_model_description_1jump_base_model_ida
				INNER JOIN jump_model_description ON jump_model_description.id = jump_base_model_jump_model_description_1_c.jump_base_ae81ription_idb
				WHERE
				jump_base_model.id = '$bm' AND
				ddms_sales_order_cstm.payment_terms_c = '$pm' AND 
				ddms_sales_order.date_entered >= '$sdate' AND
				ddms_sales_order.date_entered <= '$edate'");
		}

		// echo "<pre>";
		// print_r($query->result());
		// echo "<pre>";
		// die();
		return $query->result()[0];
	}
}