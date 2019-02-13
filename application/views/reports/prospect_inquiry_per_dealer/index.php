
<div class="col-lg-12">
	<div class="box box-default box-solid">
		<div class="box-header with-border">
	  		<h3 class="box-title"><b>Inquiry Per Dealer</b> <small> Prospect Inquiry Report</small></h3>

		  	<div class="box-tools pull-right">
	    		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	  		</div>
		</div>
		<div class="box-body">
			<div class="row">
				<form>	
					<div class="col-lg-4">
						<div class="form-group row">
							<label for="branch" class="col-sm-2 col-form-label">From: *</label>
							<div class="col-sm-10">
							    <input date="date_from" type="date" id="date_from" class="form-control input-sm" required="required">
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group row">
							<label for="branch" class="col-sm-2 col-form-label">To: *</label>
							<div class="col-sm-10">
							    <input date="date_to" type="date" id="date_to" class="form-control input-sm" required="required">
							</div>
						</div>	
					</div>
					<div class="col-lg-4"></div>
				</form>		
			</div>

			<div class="row">
				<div class="col-lg-12">
					<table id="dealer_tbl" class="table table-striped table-bordered" style="width:100%">
						<thead>
							
							<tr>
								<th>Dealer Name</th>
								<!-- <th>Code</th> -->
								<th>Outlet</th>
								<th>Prospect Inquiry</th>
								<th>Sales Order</th>
								<th>Sales Invoice</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><b>CITIMOTORS</b></td>
								<td>
									<table class="table table-responsive">
										<tr>
											<td>Makati</td>
										</tr>
										<tr>
											<td>Las Piñas</td>
										</tr>
										<tr>
											<td>Alabang</td>
										</tr>
									</table>
								</td>
								<td>
									<table class="table table-responsive">
										<tr>
											<td>13</td>
										</tr>
										<tr>
											<td>24</td>
										</tr>
										<tr>
											<td>12</td>
										</tr>
									</table>
								</td>
								<td>
									<table class="table table-responsive">
										<tr>
											<td>4</td>
										</tr>
										<tr>
											<td>6</td>
										</tr>
										<tr>
											<td>23</td>
										</tr>
									</table>
								</td>
								<td>
									<table class="table table-responsive">
										<tr>
											<td>61</td>
										</tr>
										<tr>
											<td>12</td>
										</tr>
										<tr>
											<td>39</td>
										</tr>
									</table>
								</td>
							</tr>
							<!-- <tr>
								<td colspan="5"><h4><i><b>Please select dates.</b></i></h4></td>
							</tr> -->
						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>
</div>

<script>
	
	$(function(){

		$("#date_to").attr("disabled", "disabled")

	});

	$("#date_from").change(function(event) {

		$("#date_to").attr("min", $(this).val())

		$("#date_to").removeAttr('disabled');
	});


	$("#date_to").change(function(event) {

		var date_from = $("#date_from").val();
		var date_to   = $("#date_to").val();

		// ajax(date_from, date_to);

	});

	
	function ajax(date_from, date_to){
		
		var table = $('#dealer_tbl').DataTable({
	        ajax:{
	        	url:'<?php echo base_url('index.php/reports/per_dealer_json'); ?>',
	            cache:true,
	        },
			dom: 'Bfrtip',
			buttons: [
				'copy',
			],
	        destroy: true,
	        "bPaginate": false,
    		"ordering": false,
			"bInfo": false,
			"bFilter": false,
	        columns:[
	        	{"data": "dealer"},
	        	// {"data": "code"},
	        	{"data": "branch"},
	        	{"data": "prospect_inquiry"},
	        	{"data": "sales_order"},
	        	{"data": "sales_invoice"},
			],
			data: { "date_from" : date_from, "date_to" : date_to }
      	});

	}
	

</script>