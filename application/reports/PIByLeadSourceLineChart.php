<?php

/**
 * @Author: ET
 * @Date:   2019-02-05 12:03:30
 * @Last Modified by:   ET
 * @Last Modified time: 2019-02-05 20:07:34
 */
require APPPATH."/libraries/koolreport/autoload.php";
use \koolreport\querybuilder\DB;
use \koolreport\querybuilder\MySQL;


class PIByLeadSourceLineChart extends \koolreport\KoolReport
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
                  (SELECT count(id) from lead_lead_source_pi_prospect_inquiry_1_c a LEFT JOIN pi_prospect_inquiry_cstm b ON b.id_c = a.lead_lead_source_pi_prospect_inquiry_1pi_prospect_inquiry_idb 
                  WHERE b.inquiry_date_c = pi.inquiry_date_c AND a.lead_lead_source_pi_prospect_inquiry_1lead_lead_source_ida = 'ebcd0903-b85e-7fa8-558c-5c343aad7cf5' AND a.deleted = '0') as walkIns,
                    (SELECT count(id) from lead_lead_source_pi_prospect_inquiry_1_c a LEFT JOIN pi_prospect_inquiry_cstm b ON b.id_c = a.lead_lead_source_pi_prospect_inquiry_1pi_prospect_inquiry_idb 
                  WHERE b.inquiry_date_c = pi.inquiry_date_c AND a.lead_lead_source_pi_prospect_inquiry_1lead_lead_source_ida = 'e3b828cb-8742-d089-4e58-5c343aa8b57c' AND a.deleted = '0') as phoneInquiry, 
                    (SELECT count(id) from lead_lead_source_pi_prospect_inquiry_1_c a LEFT JOIN pi_prospect_inquiry_cstm b ON b.id_c = a.lead_lead_source_pi_prospect_inquiry_1pi_prospect_inquiry_idb 
                  WHERE b.inquiry_date_c = pi.inquiry_date_c AND a.lead_lead_source_pi_prospect_inquiry_1lead_lead_source_ida = '9436aff3-aa30-3f1d-efe9-5c4929b56542' AND a.deleted = '0') as brochure
                    FROM pi_prospect_inquiry_cstm pi 
                        LEFT JOIN lead_lead_source_pi_prospect_inquiry_1_c pils 
                            ON pi.id_c = pils.lead_lead_source_pi_prospect_inquiry_1pi_prospect_inquiry_idb
                        LEFT JOIN lead_lead_source lls 
                            ON lls.id = pils.lead_lead_source_pi_prospect_inquiry_1lead_lead_source_ida
                    WHERE pils.deleted = '0'
                    GROUP BY MONTHNAME(inquiry_date_c), lls.name ORDER BY inquiry_date_c asc
                ")
        ->pipe($this->dataStore("PIByLeadSource"));
    }
}