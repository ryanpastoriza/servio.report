<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-06 10:27:19
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-12 09:19:38
 */


?>

<script>
	$(function(){
		$('#dealer-select').select2({data : <?= json_encode($dealers) ?>});
		$('#branch-select').select2({data : <?= json_encode($branches) ?>});

	})
</script>


<?php
$widgetVars = ['collapsable' => false,
				'col_grid' => col_grid(12),
				'header' => 'Filter',
				'body' => $this->load->view('reports/filter/form', [], TRUE),
				'boxOptions' => false,
				'bgColor' => 'box-navy'];


echo lte_load_view('widget5',$widgetVars);