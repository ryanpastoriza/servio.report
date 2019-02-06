<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-06 10:27:19
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-06 14:58:59
 */
$widgetVars = ['collapsable' => false,
				'col_grid' => col_grid(12),
				'header' => 'Filter',
				'body' => $this->load->view('reports/filter/form', [], TRUE),
				'boxOptions' => false,
				'bgColor' => 'box-navy'];


echo lte_load_view('widget5',$widgetVars);