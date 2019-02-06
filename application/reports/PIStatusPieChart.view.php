<?php

use \koolreport\widgets\google\PieChart;

PieChart::create(array(
    // "title" => "Prospect Inquiry Status",
    "dataSource" => $this->dataStore('status_chart'),
    "columns" => array(
        "status_c",
        "editable_date_created_c" => array(
            "type" => "number",
            "prefix" => "Total ",
        )
    )
));