<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-11 17:03:07
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-11 17:23:48
 */
?>

<script>
	$(document).on('click',".soInvoiced-chart-selector", function(){
		if(!$(this).hasClass('bg-gray')){
			$('#soInvoiced-chart').css({opacity:'0.3'});
			$('.soInvoiced-chart-selector.bg-gray').removeClass('bg-gray');
			$(this).addClass('bg-gray');
			var chart = $(this).attr('chart');
			var chartName = $(this).attr('chart-name');
			$.post("<?= base_url('index.php/dashboard/SOInvoiced_chart/') ?>"+chart, function(r){
				$('#soInvoiced-chart').html(r);
				$('#soInvoiced-chart').css({opacity:'1'});
			})
		}
		return false;
	})
</script>


<?php


	echo lte_load_view('widget5', ['header' => "Invoiced by Model",
								'bgColor' => "box-navy",
								'col_grid' => col_grid(12),
								'boxOptions' => [
												'<button type="button" chart="line" chart-name="SOInvoiced" class="soInvoiced-chart-selector btn btn-box-tool bg-gray" ><i class="fa fa-line-chart"></i></button>',
												'<button type="button" chart="bar" chart-name="SOInvoiced" class="soInvoiced-chart-selector btn btn-box-tool " ><i class="fa fa-bar-chart"></i></button>',
											],
								'body' =>"<div id='soInvoiced-chart'>".$dashboard->SOInvoiced_chart('line', TRUE)."</div>"
							]);

?>
