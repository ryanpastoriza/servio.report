<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-11 16:43:21
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-22 16:57:15
 */
?>

<script>
	$(document).on('click',".som-chart-selector", function(){
		if(!$(this).hasClass('bg-gray')){
			$('#som-chart').css({opacity:'0.3'});
			$('.som-chart-selector.bg-gray').removeClass('bg-gray');
			$(this).addClass('bg-gray');
			var chart = $(this).attr('chart');
			var chartName = $(this).attr('chart-name');
			$.post("<?= base_url('index.php/dashboard/SObyModel_chart/') ?>"+chart, $('#filterCharts').serialize(), function(r){
				$('#som-chart').html(r);
				$('#som-chart').css({opacity:'1'});
			})
		}
		return false;
	})
</script>


<?php


	echo lte_load_view('widget5', ['header' => "Sales Order by Model",
								'bgColor' => "box-navy",
								'col_grid' => col_grid(12),
								'boxOptions' => [
												'<button type="button" chart="line" chart-name="SObyMOP" class="som-chart-selector btn btn-box-tool bg-gray" ><i class="fa fa-line-chart"></i></button>',
												'<button type="button" chart="bar" chart-name="SObyMOP" class="som-chart-selector btn btn-box-tool " ><i class="fa fa-bar-chart"></i></button>',
											],
								'body' =>"<div id='som-chart' style='min-height:300px'>".$dashboard->SObyModel_chart('line', TRUE)."</div>"
							]);

?>
