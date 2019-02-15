<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-07 16:23:37
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-13 16:15:52
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Dealer extends MY_Model {

    const DB_TABLE = 'jump_dealer';
    const DB_TABLE_PK = 'id';

	
    function getDealer($dealer_id = null){
        return
        $this->db->select('jump_dealer.`name` AS dealer, jump_dealer.id')
                 ->group_by('jump_dealer.id')
                 ->get('jump_dealer')->result();
    }

    function branches(){
        $CI =& get_instance();
        $CI->load->model('branch');

        $branch = new Branch;

        if($this->id == '3f2c1bb1-fc53-7f3e-f6f6-5c3559b9edd0')
        {
            return $branch->get();
        }
        else{
            $branch->toJoin = [
                                ['jump_branch_cstm', "jump_branch_cstm.id_c = jump_branch.id", "LEFT"]
                                ];
            return $branch->search(['jump_branch_cstm.jump_dealer_id_c' => $this->id]);
        }
    }

    function getDealerBranch($dealer = null, $branch = null) {

        $this->db->select(['jump_branch.id AS branch_id', 'jump_branch.`name` AS branch_name', 'jump_dealer.id as dealer_id', 'jump_dealer.`name` as dealer_name'])
        ->from('jump_branch_cstm')
        ->join('jump_branch', 'jump_branch.id = jump_branch_cstm.id_c', 'inner');
        $this->db->join('jump_dealer', 'jump_dealer.id = jump_branch_cstm.jump_dealer_id_c', 'right');
        if($dealer != null) {
            $this->db->where('jump_dealer.name', $dealer); 
        }
        if($branch != null && $dealer != null) {
            $this->db->where('jump_branch.name', $branch); 
        }
        $this->db ->order_by('jump_dealer.id', 'ASC');
        $result = $this->db->get()->result();
        
        
        $dealerArray = array();
        # cluster branch by dealer
        foreach ($result as $row) {

            if( !isset($dealerArray[$row->dealer_name])  ){
                $dealerArray[$row->dealer_name] = array();
            }

            if( $row->branch_name != null or $row->branch_name != '' ){
                $dealerArray[$row->dealer_name][] = $row->branch_name;
            }
        }
        
        return $dealerArray;
    }
        
}