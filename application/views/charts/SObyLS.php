<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-11 16:11:01
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-15 17:35:15
 */
?>

<script>
	$(document).on('click',".sols-chart-selector", function(){
		if(!$(this).hasClass('bg-gray')){
			$('#sols-chart').css({opacity:'0.3'});
			$('.sols-chart-selector.bg-gray').removeClass('bg-gray');
			$(this).addClass('bg-gray');
			var chart = $(this).attr('chart');
			var chartName = $(this).attr('chart-name');
			$.post("<?= base_url('index.php/dashboard/SObyLS_chart/') ?>"+chart, $('#filterCharts').serialize(), function(r){
				$('#sols-chart').html(r);
				$('#sols-chart').css({opacity:'1'});
			})
		}
		return false;
	})
</script>


<?php


	echo lte_load_view('widget5', ['header' => "Sales Order by Lead Source",
								'bgColor' => "box-navy",
								'col_grid' => col_grid(12,6),
								'boxOptions' => [
												'<button type="button" chart="line" chart-name="SObyMOP" class="sols-chart-selector btn btn-box-tool bg-gray" ><i class="fa fa-line-chart"></i></button>',
												'<button type="button" chart="bar" chart-name="SObyMOP" class="sols-chart-selector btn btn-box-tool " ><i class="fa fa-bar-chart"></i></button>',
											],
								'body' =>"<div id='sols-chart'>".$dashboard->SObyLS_chart('line', TRUE)."</div>"
							]);

?>
