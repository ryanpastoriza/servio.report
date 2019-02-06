<?php

/**
 * @Author: ET
 * @Date:   2019-02-05 12:03:49
 * @Last Modified by:   ET
 * @Last Modified time: 2019-02-05 18:11:14
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
    "dataSource"=>$this->dataStore('PIByLeadSource'),
    "columns"=>array(
    	'month',
        "walkIns"=>array("label"=>"Walk-in","type"=>"number"),
        "phoneInquiry"=>array("label"=>"Phone-inquiry","type"=>"number"),
        "brochure"=>array("label"=>"Brochure","type"=>"number"),
    ),
    "options"=>array(
        "curveType"=>"function"
    )
));