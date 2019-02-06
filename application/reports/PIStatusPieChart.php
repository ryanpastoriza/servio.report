<?php

require APPPATH."/libraries/koolreport/autoload.php";

// use DB;
use \koolreport\processes\Group;
use \koolreport\querybuilder\DB;
use \koolreport\codeigniter\Friendship;

class PIStatusPieChart extends \koolreport\KoolReport {

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

        # setup for prospect inquiry status - piechart
        # you can view the pie chart code in MyDashboard.view.php
        $this->src('automaker')
        ->query(
                DB::table('pi_prospect_inquiry')
                    ->join('pi_prospect_inquiry_cstm', 'pi_prospect_inquiry.id', '=', 'pi_prospect_inquiry_cstm.id_c')
                    ->select('pi_prospect_inquiry_cstm.editable_date_created_c', 'pi_prospect_inquiry_cstm.status_c')
                    ->where('pi_prospect_inquiry.deleted', 0)
                    // ->whereBetween('pi_prospect_inquiry_cstm.editable_date_created_c', [$this->params["start"], $this->params["end"]])
            )
            ->pipe(new Group(array(
                "by" => "status_c",
                'count' => 'editable_date_created_c'
            )))
            # datasource 
            ->pipe($this->dataStore("status_chart"));
    }
}