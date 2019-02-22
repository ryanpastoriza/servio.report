<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ipm extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('main_model');
		set_header_title("Reports - Base Model");
	}
	

    public function index()
	{
		$this->put_contents("content", "");
	}

	public function inquiry_per_model(){
		$dealers    = $this->main_model->dealers();

		$content = $this->load->view("ipm" ,["dealers" => $dealers], TRUE);
		$this->put_contents($content,"Base Model");
	}
	public function branch(){
		echo $this->main_model->branch();
	}
	public function getdata(){
		$base_model = $this->main_model->base_model_records('name');
		$date_from = $_GET['date_from'];
		$date_to = $_GET['date_to'];
		$dealer = $_GET['dealer'];
		$branch = $_GET['branch'];
		$getmmpc= $this->main_model->getmmpc('name');
		foreach ($base_model as $key => $value) {
			$bm=$value->name;
			if ($dealer==$getmmpc) {
				$pi=$this->main_model->getpi1($date_from,$date_to,$dealer,$branch,$bm);
				$o=$this->main_model->geto1($date_from,$date_to,$dealer,$branch,$bm);
			}else if($dealer!=$getmmpc && !$branch){
				$pi=$this->main_model->getpi2($date_from,$date_to,$dealer,$branch,$bm);
				$o=$this->main_model->geto2($date_from,$date_to,$dealer,$branch,$bm);
			}else{
				$pi=$this->main_model->getpi($date_from,$date_to,$dealer,$branch,$bm);
				$o=$this->main_model->geto($date_from,$date_to,$dealer,$branch,$bm);
			}

			


			$data[]=['bm'=>$value->name,'pi'=>$pi,'o'=>$o];
		}
		echo json_encode($data);
	}
	
    
}

/* End of file Ipm.php */

?>