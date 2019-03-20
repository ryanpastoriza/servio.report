<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-03-19 16:18:29
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-03-19 16:27:03
 */
?>
<script>


	$(document).on('click',".spg-chart-selector", function(){
		$('#spg-chart').css({opacity:'0.3'});
		$('.spg-chart-selector.bg-gray').removeClass('bg-gray');
		$(this).addClass('bg-gray');
		var chart = $(this).attr('chart');
		var chartName = $(this).attr('chart-name');
		console.log($('#filterCharts').serialize());
		$.post("<?= base_url('index.php/dashboard/SO_PER_GROUP/') ?>"+chart, $('#filterCharts').serialize(),function(r){
			$('#spg-chart').html(r);
			$('#spg-chart').css({opacity:'1'});
		})
		return false;
	})
</script>


<?php


	echo lte_load_view('widget5', ['header' => "",
								'bgColor' => "box-navy",
								'col_grid' => col_grid(12),
								'boxOptions' => [
												'<button type="button" chart="line" class="spg-chart-selector btn btn-box-tool bg-gray" ><i class="fa fa-line-chart"></i></button>',
												'<button type="button" chart="bar" class="spg-chart-selector btn btn-box-tool " ><i class="fa fa-bar-chart"></i></button>',
											],
								'body' =>"<div id='spg-chart' style='min-height:300px'>".$dashboard->SO_PER_GROUP('line', TRUE)."</div>"
							]);

?>
