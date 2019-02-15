<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-11 09:24:10
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-15 17:35:01
 */
?>
<script>
	$(document).on('click',".pibm-chart-selector", function(){
		if(!$(this).hasClass('bg-gray')){
			$('#pibm-chart').css({opacity:'0.3'});
			$('.pibm-chart-selector.bg-gray').removeClass('bg-gray');
			$(this).addClass('bg-gray');
			var chart = $(this).attr('chart');
			var chartName = $(this).attr('chart-name');
			$.post("<?= base_url('index.php/dashboard/PI_by_model/') ?>"+chart, $('#filterCharts').serialize(), function(r){
				$('#pibm-chart').html(r);
				$('#pibm-chart').css({opacity:'1'});
			})
		}
		return false;
	})
</script>


<?php


	echo lte_load_view('widget5', ['header' => "Prospect Inquiry by Model",
								'bgColor' => "box-navy",
								'col_grid' => col_grid(12),
								'boxOptions' => [
												'<button type="button" chart="line" chart-name="PI_by_model" class="pibm-chart-selector btn btn-box-tool bg-gray" ><i class="fa fa-line-chart"></i></button>',
												'<button type="button" chart="bar" chart-name="PI_by_model" class="pibm-chart-selector btn btn-box-tool " ><i class="fa fa-bar-chart"></i></button>',
											],
								'body' =>"<div id='pibm-chart'>".$dashboard->PI_by_model('line', TRUE)."</div>"
							]);

?>
