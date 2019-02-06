<?php

/**
 * @Author: ET
 * @Date:   2019-02-05 17:29:08
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-06 11:38:36
 */

?>
<div class="row col-sm-9">
<?php
	echo lte_load_view('accordion',[]);

// prospect inquiry by payment mode
 $this->load->view('reports/prospect_inquiry_by_payment_mode/widget', [], False);

 // prospect inquiry by lead source
 $this->load->view('reports/PI_by_lead_source/widget', [], False);
 ?>
</div>
<div class="row col-sm-3">
	<?php $this->load->view('reports/filter/filter'); ?>	
</div>