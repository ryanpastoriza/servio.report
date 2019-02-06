<?php

/**
 * @Author: ET
 * @Date:   2019-02-05 17:35:38
 * @Last Modified by:   ET
 * @Last Modified time: 2019-02-05 17:59:15
 */
$widgetVars = [
				'header' => 'Prospect Inquiry by Lead Source',
				'body' => $this->load->view('reports/prospect_inquiry_by_payment_mode/chart', ['report' => $PILSReport], TRUE),
				'boxOptions' => [],
			];

echo lte_load_view('widget5',$widgetVars);