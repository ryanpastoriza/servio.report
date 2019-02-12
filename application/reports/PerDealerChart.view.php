<?php

/**
 * @Author: ET
 * @Date:   2019-02-05 12:03:49
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-06 16:53:02
 */
use \koolreport\widgets\google\BarChart;
     
// \koolreport\chartjs\LineChart::create(array(
//     "title"=>"Prospect Inquiry by Mode of Payment",
//     "dataSource"=>$this->dataStore('month_sales'),
//     "columns"=>array(
//         "month",
//         "sale"=>array("label"=>"Sale","type"=>"number","prefix"=>"$"),
//         "cost"=>array("label"=>"Cost","type"=>"number","prefix"=>"$"),
//     )
// ));

BarChart::create(array(
    "title"=>"",
    "dataSource"=>$this->dataStore('PIByLeadSource'),
    "columns"=>array(
    	'dealer_name',
        "total_pi"=>array("label"=>"Prospect Inquiry","type"=>"number"),
        "sales_order" => array("label"=>"Sales Order","type"=>"number"),
    ),
    "options"=>array(
        "curveType"=>"function",
        'isStacked' => true
    )
));