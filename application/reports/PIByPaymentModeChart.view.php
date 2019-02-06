<?php

/**
 * @Author: ET
 * @Date:   2019-02-05 12:03:49
 * @Last Modified by:   ET
 * @Last Modified time: 2019-02-05 15:30:19
 */
use \koolreport\widgets\google\LineChart;
     
// \koolreport\chartjs\LineChart::create(array(
//     "title"=>"Prospect Inquiry by Mode of Payment",
//     "dataSource"=>$this->dataStore('month_sales'),
//     "columns"=>array(
//         "month",
//         "sale"=>array("label"=>"Sale","type"=>"number","prefix"=>"$"),
//         "cost"=>array("label"=>"Cost","type"=>"number","prefix"=>"$"),
//     )
// ));

LineChart::create(array(
    "title"=>"",
    "dataSource"=>$this->dataStore('PiByPaymentMode'),
    "columns"=>array(
    	'month',
        "cashterm"=>array("label"=>"Cash","type"=>"number"),
        "financingterm"=>array("label"=>"Financing","type"=>"number"),
        // "inquiry_date_c"=>array("label"=>"Cost","type"=>"number","prefix"=>"$"),
    ),
    "options"=>array(
        "curveType"=>"function"
    )
));