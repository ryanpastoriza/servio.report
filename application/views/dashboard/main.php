<?php

/**
 * @Author: ET
 * @Date:   2019-02-05 17:29:08
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-06 14:37:07
 */


$prospectInquiryContent = $this->load->view('reports/prospect_inquiry_by_payment_mode/widget', [], True);

$prospectInquiryContent .=  $this->load->view('reports/PI_by_lead_source/widget', [], True);


?>
<div class="row col-sm-9">
<?php

	$accord_vars = ['header' => '',
						'items' => [
										['title' => "Prospect Inquiry",
										'content' => $prospectInquiryContent
										],
										['title' => "Sales Order",
										'content' => "content 2"
										],
										['title' => "Sales Invoice",
										'content' => "content 3"
										]
									],
					'col_grid' => col_grid(12)
					];

	echo lte_load_view('accordion',$accord_vars);


 ?>
</div>
<div class="row col-sm-3">
	<?php $this->load->view('reports/filter/filter'); ?>	
</div>