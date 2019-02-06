<?php

/**
 * @Author: ET
 * @Date:   2019-02-05 12:03:30
 * @Last Modified by:   ET
 * @Last Modified time: 2019-02-05 16:14:29
 */
require APPPATH."/libraries/koolreport/autoload.php";
use \koolreport\querybuilder\DB;
use \koolreport\querybuilder\MySQL;


class PIByPaymentModeBarChart extends \koolreport\KoolReport
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
        ->query("SELECT MONTHNAME(inquiry_date_c) as month, 
        				count(id_c) as total,
        				(SELECT count(id_c) WHERE payment_terms_c = 'cash') as cashterm,
        				(SELECT count(id_c) WHERE payment_terms_c = 'financing') as financingterm
        				FROM pi_prospect_inquiry_cstm 
        				GROUP BY payment_terms_c, MONTHNAME(inquiry_date_c),payment_terms_c ORDER BY inquiry_date_c asc")
        // ->query(MySQL::type(
        // 		DB::table("pi_prospect_inquiry_cstm")
        // 		->count('id_c')->alias('total')
        // 		->addSelect('inquiry_date_c')->alias('month')
        // 		->addSelect('payment_terms_c')
        // 		->groupBy('inquiry_date_c')

        // 	))
        ->pipe($this->dataStore("PiByPaymentMode"));
    }
}