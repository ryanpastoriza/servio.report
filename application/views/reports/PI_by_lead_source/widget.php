<?php

/**
 * @Author: ET
 * @Date:   2019-02-05 17:35:38
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-06 14:49:37
 */



?>
<script>
	$(document).on('click',".pils-chart-selector", function(){
		$('#pils-chart').css({opacity:'0.3'});
		$('.pils-chart-selector.bg-gray').removeClass('bg-gray');
		$(this).addClass('bg-gray');
		var chart = $(this).attr('chart');
		$.post("<?= base_url('dashboard/select_chart/') ?>"+chart, function(r){
			$('#pils-chart').html(r);
			$('#pils-chart').css({opacity:'1'});
		})
		return false;
	})
</script>


<?php 
$widgetVars = [
				'header' => 'Prospect Inquiry by Lead Source',
				'body' => "<div id='pils-chart'>".$this->load->view('reports/prospect_inquiry_by_payment_mode/chart', ['report' => $PILSReport], TRUE)."</div>",
				'boxOptions' => [
									'<button type="button" chart="PIByLeadSourceLineChart" class="pils-chart-selector btn btn-box-tool bg-gray" ><i class="fa fa-line-chart"></i></button>',
									'<button type="button" chart="PIByLeadSourceBarChart" class="pils-chart-selector btn btn-box-tool " ><i class="fa fa-bar-chart"></i></button>',
								],
			];

echo lte_load_view('widget5',$widgetVars);