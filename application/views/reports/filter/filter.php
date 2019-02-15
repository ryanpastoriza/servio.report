<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-06 10:27:19
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-15 17:25:10
 */


?>

<script>
	$(function(){

		$('#filterCharts').ajaxForm({
			beforeSubmit: function(a,b){
				$(b).find('button').attr('disabled','disabled');
				$('#pimp-chart').css({opacity:'0.3'});
				$('#pils-chart').css({opacity:'0.3'});
				$('#pibm-chart').css({opacity:'0.3'});
				$('#somp-chart').css({opacity:'0.3'});
				$('#sols-chart').css({opacity:'0.3'});
				$('#som-chart').css({opacity:'0.3'});
				$('#soInvoiced-chart').css({opacity:'0.3'});
				
			},
			complete:function(r,b,c){
				var resp = r.responseJSON;
				$('#pimp-chart').css({opacity:'1'}).html(resp.pi_by_mop);
				$('#pils-chart').css({opacity:'1'}).html(resp.pi_by_ls);
				$('#pibm-chart').css({opacity:'1'}).html(resp.pi_by_model);
				$('#somp-chart').css({opacity:'1'}).html(resp.so_by_mop);
				$('#sols-chart').css({opacity:'1'}).html(resp.so_by_ls);
				$('#som-chart').css({opacity:'1'}).html(resp.so_by_model);
				$('#soInvoiced-chart').css({opacity:'1'}).html(resp.so_invoiced);
				$(c).find('button').removeAttr('disabled');
			},
			dataType: 'JSON'
		});

		$('#ls-select').select2({data: <?= json_encode($leadSources) ?> });
		$('#dealer-select').select2({data : <?= json_encode($dealers) ?>});
		$('#mop-select').select2({data: <?= json_encode($modeOfPayments) ?> });
		$('#bm-select').select2({data: <?= json_encode($baseModels) ?> });
		$('#branch-select').select2({data:[]});
		$('#modes-select').select2({data: []});


	})
	$(document).on('change','#dealer-select', function(){
		var t = $(this);
		// $('#branch-select').val('null').trigger('change');
		$('#branch-select option').remove();
		$('#branch-select').addClass('disabled').attr('disabled','disabled');

		if(t.val() != ""){
			$.post("<?= base_url('dashboard/get_branches/') ?>","selected="+t.val(), function(r){
				$('#branch-select').select2({data:r});
				if(r.length > 0){
					$('#branch-select').removeClass('disabled').removeAttr('disabled');
				}
			},'JSON')
		}
	})
	$(document).on('change', '#bm-select', function(){
		var t = $(this);

		$('#modes-select option').remove();
		$('#modes-select').addClass('disabled').attr('disabled','disabled');

		if(t.val() != ""){
			$.post("<?= base_url('dashboard/get_model_descriptions/') ?>","selected="+t.val(), function(r){
				$('#modes-select').select2({data:r});
				if(r.length > 0){
					$('#modes-select').removeClass('disabled').removeAttr('disabled');
				}
			},'JSON')
		}


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