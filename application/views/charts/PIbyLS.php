<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-08 15:40:46
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-08 15:41:54
 */
?>

<script>
	$(document).on('click',".pils-chart-selector", function(){
		$('#pils-chart').css({opacity:'0.3'});
		$('.pils-chart-selector.bg-gray').removeClass('bg-gray');
		$(this).addClass('bg-gray');
		var chart = $(this).attr('chart');
		var chartName = $(this).attr('chart-name');
		$.post("<?= base_url('index.php/dashboard/PI_by_LS/') ?>"+chart, function(r){
			$('#pils-chart').html(r);
			$('#pils-chart').css({opacity:'1'});
		})
		return false;
	})
</script>


<?php


	echo lte_load_view('widget5', ['header' => "Prospect Inquiry by Mode of Payment",
								'bgColor' => "box-navy",
								'col_grid' => col_grid(12,6),
								'boxOptions' => [
												'<button type="button" chart="line" class="pils-chart-selector btn btn-box-tool bg-gray" ><i class="fa fa-line-chart"></i></button>',
												'<button type="button" chart="bar" class="pils-chart-selector btn btn-box-tool " ><i class="fa fa-bar-chart"></i></button>',
											],
								'body' =>"<div id='pils-chart'>".$dashboard->PI_by_LS('line', TRUE)."</div>"
							]);

?>
