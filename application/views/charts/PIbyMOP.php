<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-07 11:25:42
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-22 16:57:04
 */


?>

<script>
	$(document).on('click',".pibmp-chart-selector", function(){
		if(!$(this).hasClass('bg-gray')){
			$('#pimp-chart').css({opacity:'0.3'});
			$('.pibmp-chart-selector.bg-gray').removeClass('bg-gray');
			$(this).addClass('bg-gray');
			var chart = $(this).attr('chart');
			var chartName = $(this).attr('chart-name');
			$.post("<?= base_url('index.php/dashboard/select_PIbyMOP_chart/') ?>"+chart, $('#filterCharts').serialize(), function(r){
				$('#pimp-chart').html(r);
				$('#pimp-chart').css({opacity:'1'});
			})
		}
		return false;
	})
</script>


<?php


	echo lte_load_view('widget5', ['header' => "Prospect Inquiry by Mode of Payment",
								'bgColor' => "box-navy",
								'col_grid' => col_grid(12,6),
								'boxOptions' => [
												'<button type="button" chart="line" chart-name="PIbyMOP" class="pibmp-chart-selector btn btn-box-tool bg-gray" ><i class="fa fa-line-chart"></i></button>',
												'<button type="button" chart="bar" chart-name="PIbyMOP" class="pibmp-chart-selector btn btn-box-tool " ><i class="fa fa-bar-chart"></i></button>',
											],
								'body' =>"<div id='pimp-chart' style='min-height:300px'>".$dashboard->select_PIbyMOP_chart('line', TRUE)."</div>"
							]);

?>
