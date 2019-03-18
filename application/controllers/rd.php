<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class rd extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('main_model');
		set_header_title("Reports - Dealers");
	}
	

    public function index()
	{
		$this->put_contents("content", "");
	}

	public function dealers(){
		$region    = $this->main_model->region();

		$content = $this->load->view("rd" ,["region" => $region], TRUE);
		$this->put_contents($content,"Dealer");
	}
	public function dealer(){
		echo $this->main_model->dealer1();
	}
	public function getdata(){
        
        $dealers= $this->main_model->dealers();
		$date_from = $_GET['date_from'];
		$date_to = $_GET['date_to'];
        $dealer = $_GET['dealer'];
        $getmmpc= $this->main_model->getmmpc();
        if ($dealer==$getmmpc) {
            foreach($dealers as $key => $value) {
                $bm=$value->id;
                $bm1=$value->name;
                if ($bm==$getmmpc) {
                } else {
                    $nse=$this->main_model->allsem($bm);
                    $seave=$this->main_model->allavem($date_from,$date_to,$bm);
                    if ($seave>0) {
                       $total = $seave/$nse;
                       echo $bm;
                       echo $seave;
                       echo $bm1;
                    }else{
                        $total = "0";
                    }
                    $data[]=['bm'=>$bm1,'pi'=>$nse,'o'=>$total];
                }
                
               
                
                
            }
        }else{
            foreach($dealers as $key => $value) {
                $bm=$value->id;
                if($bm==$dealer) {
                    $dname=$value->name; 
                }
            }   
            $nse=$this->main_model->allsem($dealer);
            $seave=$this->main_model->allavem($date_from,$date_to,$dealer);
            if($seave>0) {
                $total = $seave/$nse;
             }else{
                $total = "0";
             }
            $data[]=['bm'=>$dname,'pi'=>$nse,'o'=>$total];
        }
		
       
		echo json_encode($data);
	}
	
    
}

/* End of file Ipm.php */

?>