<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-06 10:36:41
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-14 16:16:40
 */
?>
<?= form_open(base_url('dashboard/apply_search'), 'id="filterCharts"'); ?>
<div class="form-group">
  <label>From Date</label>
  <input type="date" class="form-control" name="from_date" placeholder="mm/dd/yyyy">
</div>
<div class="form-group">
  <label>To Date</label>
  <input type="date" class="form-control" name="to_date" placeholder="mm/dd/yyyy">
</div>
<div class="form-group">
  <label>Dealer</label>
  <select class="form-control" multiple="multiple" name='dealers[]'  id='dealer-select' placeholder="Dealer Name"></select>
</div>
<div class="form-group branch-selector">
  <label>Branch</label>
  <select class="form-control disabled" id='branch-select' name='branches[]' disabled="disabled" multiple="multiple" placeholder="Branch Name"></select>
</div>
<div class="form-group">
  <label>Mode of Payment</label>
  <select class="form-control" id='mop-select' multiple="multiple" name='mode_of_payments[]' placeholder="Enter ..."></select>
</div>
<div class="form-group">
  <label>Base Model</label>
  <select class="form-control" id='bm-select' multiple="multiple" name='base_models[]' placeholder="Enter ..."></select>
</div>
<div class="form-group">
  <label>Vehicle Variance</label>
  <select class="form-control" id='modes-select' multiple="multiple" name='vehicle_descriptions[]' disabled="disabled" placeholder="Enter ..."></select>
</div>
<button class="btn btn-default"> Apply Search</button>
<?= form_close(); ?>