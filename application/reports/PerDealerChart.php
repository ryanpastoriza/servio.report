<?php

/**
 * @Author: ET
 * @Date:   2019-02-05 12:03:30
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-06 17:07:22
 */
require APPPATH."/libraries/koolreport/autoload.php";
use \koolreport\querybuilder\DB;
use \koolreport\querybuilder\MySQL;


class PerDealerChart extends \koolreport\KoolReport
{

    use \koolreport\clients\Bootstrap;
    function settings()
    {
        return array(
            "assets"=>array(
                "path"=>"../../assets",
                "url"=>"assets",
            ),
            "dataSources"=>array(
                "automaker"=>array(
                    "connectionString"=>"mysql:host=".RYAN_IP.";dbname=".RYAN_DB,
                    "username"=>RYAN_USER,
                    "password"=>RYAN_PASSWORD,
                    "charset"=>"utf8"
                )
            )
        );
    }
    function setup()
    {
        $this->src('automaker')
        ->query("
                    SELECT 
                        COUNT(assigned.id) as total_pi,
                        COUNT(SO.id) as sales_order,
                        dealer.name as dealer_name 
                            FROM pi_prospect_inquiry_cstm pi 
                                INNER JOIN pi_prospect_inquiry assigned 
                                    ON assigned.id = pi.id_c 
                                INNER JOIN users 
                                    ON assigned.assigned_user_id = users.id 
                                INNER JOIN users_cstm 
                                    ON users.id = users_cstm.id_c 
                                INNER JOIN jump_dealer dealer 
                                    ON dealer.id = users_cstm.jump_dealer_id_c 
                                LEFT JOIN pi_prospect_inquiry_ddms_sales_order_1_c SO
                                    ON SO.pi_prospect_inquiry_ddms_sales_order_1pi_prospect_inquiry_ida = assigned.id
                                GROUP BY dealer_name
                ")
        ->pipe($this->dataStore("PIByLeadSource"));
    }
}