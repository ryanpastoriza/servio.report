<?php

/**
 * @Author: ET
 * @Date:   2019-02-05 09:24:33
 * @Last Modified by:   ET
 * @Last Modified time: 2019-02-05 10:30:22
 */
//MyReport.view.php
?>
<style>
    table td{
        white-space: nowrap;
    }
</style>
<div class="col-sm-12 table-responsive">
    <?php 
    use \koolreport\widgets\koolphp\Table;
        Table::create(array(
            "dataStore"=>$this->dataStore("users"),
            "cssClass"=>array(
                "table"=>"table table-hover"
            )
        ));
     ?>
</div>
