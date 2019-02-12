<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-06 10:36:41
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-12 10:51:24
 */
?>
<div class="form-group">
  <label>From Date</label>
  <input type="date" class="form-control" placeholder="mm/dd/yyyy">
</div>
<div class="form-group">
  <label>To Date</label>
  <input type="date" class="form-control" placeholder="mm/dd/yyyy">
</div>
<div class="form-group">
  <label>Dealer</label>
  <input type="text" class="form-control" multiple="multiple" name='dealers[]'  id='dealer-select' placeholder="Dealer Name">
</div>
<div class="form-group hidden branch-selector">
  <label>Branch</label>
  <input type="text" class="form-control" id='branch-select' placeholder="Branch Name">
</div>
<div class="form-group">
  <label>Mode of Payment</label>
  <input type="text" class="form-control" placeholder="Enter ...">
</div>
<div class="form-group">
  <label>Base Model</label>
  <input type="text" class="form-control" placeholder="Enter ...">
</div>
<div class="form-group">
  <label>Vehicle Variance</label>
  <input type="text" class="form-control" placeholder="Enter ...">
</div>
<button class="btn btn-default"> Apply Search</button>