<?php

/**
 * @Author: ET
 * @Date:   2019-02-05 15:11:28
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-06 15:00:44
 */

?>

<script>
	$(document).on('click',".pibmp-chart-selector", function(){
		$('#pimp-chart').css({opacity:'0.3'});
		$('.pibmp-chart-selector.bg-gray').removeClass('bg-gray');
		$(this).addClass('bg-gray');
		var chart = $(this).attr('chart');
		$.post("<?= base_url('index.php/dashboard/select_chart/') ?>"+chart, function(r){
			$('#pimp-chart').html(r);
			$('#pimp-chart').css({opacity:'1'});
		})
		return false;
	})
</script>
<?php
echo lte_load_view('widget5', ['header' => "Prospect Inquiry by Mode of Payment",
								'bgColor' => "box-navy",
								'col_grid' => col_grid(6),
								'boxOptions' => [
												'<button type="button" chart="PIByPaymentModeChart" class="pibmp-chart-selector btn btn-box-tool bg-gray" ><i class="fa fa-line-chart"></i></button>',
												'<button type="button" chart="PIByPaymentModeBarChart" class="pibmp-chart-selector btn btn-box-tool " ><i class="fa fa-bar-chart"></i></button>',
											],
								'body' => "<div id='pimp-chart'>".$this->load->view('reports/prospect_inquiry_by_payment_mode/chart', [], TRUE)])."</div>";