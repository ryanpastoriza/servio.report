<?php

/**
 * @Author: ET
 * @Date:   2019-02-05 09:24:21
 * @Last Modified by:   ET
 * @Last Modified time: 2019-02-05 14:13:43
 */
require APPPATH."/libraries/koolreport/autoload.php";
class MyReport extends \koolreport\KoolReport
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
        ->query("Select *, COUNT(id_c) as TOTAL, MONTH(inquiry_date_c) as month from users GROUP BY payment_terms_c")
        ->pipe($this->dataStore("users"));
    }
}