
<div class="col-lg-12">
	<div class="box box-default box-solid">
		<div class="box-header with-border">
	  		<h3 class="box-title"><b>Payment Mode</b> <small> Prospect Inquiry Report</small></h3>

		  	<div class="box-tools pull-right">
	    		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	  		</div>
		</div>
		<div class="box-body">
			<div class="row">
				<form id="lead_form">
					<div class="col-lg-4">
						<div class="form-group row">
							<label for="dealer" class="col-sm-2 col-form-label">Dealer:  </label>
							<div class="col-sm-10">
							    <select name="dealer" id="dealer" class="form-control input-sm">
							    	<option disabled selected>Click to select</option>
							    	<?php foreach( $dealers["dealers"] as $key => $value ): ?>
										<option value="<?= $value ?>"> <?= $key ?> </option>
							    	<?php endforeach?>
							    </select>
							</div>
						</div>

						<div class="form-group row">
							<label for="branch" class="col-sm-2 col-form-label">Branch: </label>
							<div class="col-sm-10">
							    <select name="branch" id="branch" class="form-control input-sm"></select>
							</div>
						</div>

						<div class="form-group row">
							<label for="dealer" class="col-sm-2 col-form-label">Status: </label>
							<div class="col-sm-10">
							    <select name="status" id="status" class="form-control input-sm">
							    	<option value="">All</option>
							    	<option value="open">Open</option>
							    	<option value="qualified">Qualified</option>
							    	<option value="Disqualified">Disqualified</option>
							    </select>
							</div>
						</div>

					</div>

					<div class="col-lg-4">
						<div class="form-group row">
							<label for="branch" class="col-sm-2 col-form-label">From: *</label>
							<div class="col-sm-10">
							    <input date="date_from" type="date" id="date_from" class="form-control input-sm" required="required">
							</div>
						</div>
						<div class="form-group row">
							<label for="branch" class="col-sm-2 col-form-label">To: *</label>
							<div class="col-sm-10">
							    <input date="date_to" type="date" id="date_to" class="form-control input-sm" required="required">
							</div>
						</div>
						<div class="form-group row">
							<label for="branch" class="col-sm-2 col-form-label"></label>
							<div class="col-sm-10">
								<button class="btn btn-primary btn-sm pull-right form-control" id="submit">Submit</button>
							</div>
						</div>
					</div>
					<div class="col-lg-4"></div>		
				</form>		
			</div>

			<table id="lead_table" class="table table-striped table-bordered" style="width:100%">
	            <thead>
	                <tr>
	                    <th rowspan="2">SOURCE OF SALE</th>
						<th colspan="2"> TOTAL </th>
						<?php foreach($base_model as $value): ?>
							<th colspan="2"> <?= $value->name ?> </th>
						<?php endforeach ?>
	                </tr>
	                <tr>
	                	<th> Value </th>
	                	<th> Pct </th>
	                	<?php foreach($base_model as $value): ?>
							<th> Value </th>
							<th> Pct </th>
						<?php endforeach ?>
	                </tr>
	            </thead>
	            <tbody>
	            	<tr>
	            		<td colspan="<?php echo 2 + (count($base_model)+1)*2 ?>"> Please fill up the fields</td>
	            	</tr>
	            </tbody>
		    </table>
			

		</div>
	</div>
</div>

<script>
	
	var table;

	$("#dealer").change(function(event) {
		var id = $(this).val();
		branch_list(id);
	});

	$("#submit").click(function(event) {

		event.preventDefault();
		var date_from = $("#date_from").val()
		var date_to   = $("#date_to").val()
		var status    = $("#status").val()
		var dealer    = $("#dealer").val();
		var branch    = $("#branch").val();

		data =  { 
					date_from : date_from, 
					date_to: date_to,
					status: status,
					branch: branch,
					dealer: dealer
				};

		if( date_from && date_to ){

        	if( branch || dealer ){
        		payment_mode_datatable(data);
        	}
        	else{
        		alert("Branch or Dealer must have a value.")
        	}

		}
		else{
			alert("Please fill required fields.")
		}

	});

	function branch_list(dealer_id){
		var branches = "";

		$.ajax({
			url: "<?php echo base_url('index.php/reports/branch') ?>",
			type: 'GET',
			dataType: 'JSON',
			data: {dealer_id: dealer_id},
		})
		.done(function(data) {

			if(data){
				branches += "<option disabled selected></option>";
				$.each(data, function(index, val) {
					branches += "<option value='"+val.branch_name+"' >"+ val.branch_name +"</option>";
				});
				$("#branch").removeAttr('disabled')
			}
			$("#branch").html(branches)

		})
		.fail(function() {
			console.log("error");
		})	
	}
	

    function payment_mode_datatable(data){

    	var table = $('#lead_table').DataTable({
	        ajax:{
	        	url:'<?php echo base_url('index.php/reports/payment_mode_data'); ?>',
	            cache:true,
				data: {data: data}
	        },
			dom: 'Bfrtip',
	        buttons: [
	            { extend: 'excel', className: 'btn btn-primary fa fa-download', text: ' Excel', exportOptions:
	                 { columns: ':visible' }
	            }
           	],
	        destroy: true,
	        "bPaginate": false,
    		"ordering": false,
			"bInfo": false,
			"bFilter": false,
	        columns:[
				{"data" : "source_of_sale"},
				{"data" : "total_value"},
				{"data" : "total_pct"},
				<?php foreach($base_model as $value): ?>
				{"data" : "v<?=$value->name?>"},
				{"data" : "p<?=$value->name?>"},
				<?php endforeach ?>
			],
      	});

      	$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
		    console.log(message);
		};

    }
    

</script>