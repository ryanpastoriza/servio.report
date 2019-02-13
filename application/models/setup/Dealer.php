<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-07 16:23:37
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-13 14:30:20
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
        $this->load->model('branch');

        $branch = new Branch;

        $branch->selects = ['jump_branch.id', 'jump_branch.`name` AS branch_name'];
        $branch->toJoin = [
                            ['jump_branch_cstm', 'jump_branch.id = jump_branch_cstm.id_c', 'inner'],
                        ];
        $res = $branch->search(["jump_branch_cstm.jump_dealer_id_c" => $this->{$this::DB_TABLE_PK}]);
        return $res;
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