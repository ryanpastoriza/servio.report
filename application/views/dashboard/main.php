<?php

/**
 * @Author: ET
 * @Date:   2019-02-05 17:29:08
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-11 17:05:10
 */


$prospectInquiryContent = $this->load->view('charts/PIbyMOP', [], True);
$prospectInquiryContent .=  $this->load->view('charts/PIbyLS', [], True);
$prospectInquiryContent .=  $this->load->view('charts/PIperModel', [], True);


$soContent = $this->load->view('charts/SObyMOP', [], True);
$soContent .= $this->load->view('charts/SObyLS', [], True);
$soContent .= $this->load->view('charts/SObyModel', [], True);

$siContent = $this->load->view('charts/SOInvoiced', [], True);



?>

<div class="row col-sm-9">
<div class="col-sm-5">
        <?php $this->load->view('reports/PIStatusPieChart/widget.php'); ?>    
</div>
<div class="col-sm-7">
	<?php 
		$vars = ['header' => "Dealers",
				'boxOptions' => false,
				'body' =>  $this->load->view('reports/per_dealer/chart', [], True),
				'col_grid' => "row"];

		echo lte_load_view('widget5',$vars);
	 ?>
</div>
<?php


	$accord_vars = ['header' => '',
						'items' => [
										['title' => "Prospect Inquiry",
										'content' => $prospectInquiryContent
										],
										['title' => "Sales Order",
										'content' => $soContent
										],
										['title' => "Sales Invoice",
										'content' => $siContent
										]
									],
					'col_grid' => col_grid(12)
					];

	echo lte_load_view('accordion',$accord_vars);


	// echo lte_load_view('accordion',[]);
// prospect inquiry by payment mode
//  $this->load->view('reports/prospect_inquiry_by_payment_mode/widget', [], False);


 ?>
</div>
<div class="row col-sm-3">
	<?php $this->load->view('reports/filter/filter'); ?>	
</div>
