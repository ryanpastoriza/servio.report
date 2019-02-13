<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-06 10:27:19
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-12 13:55:08
 */


?>

<script>
	$(function(){
		$('#dealer-select').select2({data : <?= json_encode($dealers) ?>});
	})
	$(document).on('change','#dealer-select', function(){
		var t = $(this);

		$.post("<?= base_url('dashboard/get_branches/') ?>","selected="+t.val(), function(r){
			$('.branch-selector').select2({data:[]});
			$('.branch-selector').removeClass('hidden').select2({data:r});
		},'JSON')

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