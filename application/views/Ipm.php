
<div class="col-lg-12">
	<div class="box box-default box-solid">
		<div class="box-header with-border">
	  		<h3 class="box-title"><b>Inquiry per Model</b> <small> Report</small></h3>

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
							    <select name="dealer" id="dealer" name="dealer" class="form-control input-sm">
							    	<option disabled selected>Click to select</option>
							    	<?php foreach($dealers as $value):?>
								    	<option value="<?= $value->id ?>"> <?= $value->name ?> </option>									
							    	<?php endforeach?>
							    </select>
							</div>
						</div>

						<div class="form-group row">
							<label for="branch" class="col-sm-2 col-form-label">Branch: </label>
							<div class="col-sm-10">
							    <select name="branch" id="branch" name="branch" class="form-control input-sm"></select>
							</div>
						</div>

					</div>

					<div class="col-lg-4">
						<div class="form-group row">
							<label for="date_from" class="col-sm-2 col-form-label">From: *</label>
							<div class="col-sm-10">
							    <input date="date_from" type="date" id="date_from" name="date_from" class="form-control input-sm" required="required">
							</div>
						</div>
						<div class="form-group row">
							<label for="date_to" class="col-sm-2 col-form-label">To: *</label>
							<div class="col-sm-10">
							    <input date="date_to" type="date" id="date_to" name="date_to" class="form-control input-sm" required="required">
							</div>
						</div>
						<div class="form-group row">
							<label for="submit" class="col-sm-2 col-form-label"></label>
							<div class="col-sm-10">
								<button class="btn btn-primary btn-sm pull-right form-control" id="submit">Search</button>
							</div>
						</div>
					</div>
					<div class="col-lg-4"></div>		
				</form>		
			</div>

			<table id="ipmtable"  class="table table-striped table-bordered" style="width:100%">
	            <thead>
	               <tr>
					   <td style="width:40%">MODEL DESCRIPTION</td>
					   <td>PROSPECT INQUIRY</td>
					   <td>SALES ORDER</td>
				   </tr>
	            </thead>

	            <tbody id="tbody">
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
		var dealer = $("#dealer").val()
		var branch   = $("#branch").val()
		
		if( date_from && date_to ){
			search(date_from,date_to,dealer,branch)
        	
		
		}
		else{
			alert("Please fill required fields.")
		}
		
	});

	function search(date_from,date_to,dealer,branch){
		
		var tbody = "";
		$.ajax({
			url: "<?php echo base_url('index.php/ipm/getdata') ?>",
			type: 'GET',
			dataType: 'JSON',
			data: {date_from: date_from,date_to: date_to,dealer: dealer,branch: branch},
		})
		.done(function(data) {
			
			if(data){
				$.each(data, function(index, val) {
					console.log(val)
					tbody += "<tr id='trow'><td>"+ val.bm +"</td><td>"+ val.pi +"</td><td>"+ val.o +"</td></tr>";
				});
			}
			$("#tbody").html(tbody)

		})
		.fail(function() {
			console.log("error ");
		})	
	}

	function branch_list(dealer_id){
		var branches = "";

		$.ajax({
			url: "<?php echo base_url('index.php/ipm/branch') ?>",
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
	

   
    

</script>