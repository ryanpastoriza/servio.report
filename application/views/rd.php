
<div class="col-lg-12">
	<div class="box box-default box-solid">
		<div class="box-header with-border">
	  		<h3 class="box-title"><b>Dealer</b> <small> Report</small></h3>

		  	<div class="box-tools pull-right">
	    		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	  		</div>
		</div>
		<div class="box-body">
			<div class="row">
				<form id="lead_form">
					<div class="col-lg-4">
						<div class="form-group row">
							<label for="region" class="col-sm-2 col-form-label">Region:  </label>
							<div class="col-sm-10">
							    <select name="region" id="region" name="region" class="form-control">
                                    <option value="all"> ALL </option>
							    	<?php foreach($region as $value):?>
								    	<option value="<?= $value->id ?>"> <?= $value->name ?> </option>									
							    	<?php endforeach?>
							    </select>
							</div>
						</div>
						<div class="form-group row">
							<label for="dealer" class="col-sm-2 col-form-label">Dealer: </label>
							<div class="col-sm-10">
							    <select name="dealer" id="dealer" name="dealer" class="form-control">
								</select>
							</div>
						</div>

					</div>

					<div class="col-lg-4">
						<div class="form-group row">
							<label for="date_from" class="col-sm-2 col-form-label">From:</label>
							<div class="col-sm-10">
							    <input date="date_from" type="date" id="date_from" name="date_from" class="form-control" required="required">
							</div>
						</div>
						<div class="form-group row">
							<label for="date_to" class="col-sm-2 col-form-label">To:</label>
							<div class="col-sm-10">
							    <input date="date_to" type="date" id="date_to" name="date_to" class="form-control" required="required">
							</div>
						</div>
						<div class="form-group row">
							<label for="submit" class="col-sm-2 col-form-label"></label>
							<div class="col-sm-10">
								<button class="btn btn-primary btn-sm pull-right form-control" id="submit">Search</button>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						
					</div>
					<div class="col-lg-4"></div>		
				</form>		
			</div>

			<table id="rdtable"  class="table table-striped table-bordered" style="width:100%">
	            <thead>
	               <tr>
					   <th style="width:40%">DEALER</th>
					   <th>No. of SE</th>
					   <th>Average Sales of SE</th>
				   </tr>
	            </thead>

	            <tbody id="tbody">
	            </tbody>
		    </table>
			

		</div>
	</div>
</div>

<script>
    var dealerid ="<?php echo $_SESSION['user']->dealer->dealer_id; ?>";
    var dealer1 ="<?php echo $_SESSION['user']->dealer->dealer; ?>";
    jQuery(window).on("load", function(){

    var date    = new Date();
    var year    = date.getFullYear();
    var month   = date.getMonth();
    var lastDay = new Date(year, month + 1, 0).getDate();

    $("#date_from").val(year + "-" + ("0" + (month +1) ).slice(-2) + "-01")
    $("#date_to").val(year + "-" + ("0" + (month +1) ).slice(-2) + "-" + ("0" + lastDay ).slice(-2))
    $("#date_to").attr("min",$("#date_from").val());
	var dealers = "";
	var region_id="all";
    $.ajax({
			url: "<?php echo base_url('index.php/rd/dealer') ?>",
			type: 'GET',
			dataType: 'JSON',
			data: {region_id: region_id},
		})
		.done(function(data) {

			if(data){
				
				$.each(data, function(index, val) {
					dealers += "<option value='"+val.id+"' >"+ val.dealer_name +"</option>";
					
				});
				$("#dealer").removeAttr('disabled')
				
			}
			$("#dealer").html(dealers)
			$("select option").filter(function() {
			return $(this).text() == dealer1; 
		}).prop('selected', true);
		})
		.fail(function() {
			console.log("error")
		})	
		


             var date_from = $("#date_from").val()
             var date_to   = $("#date_to").val()

             var dealer = $("#dealer").val()
            
             search(date_from,date_to,dealerid);

    });
  
    
	$("#region").change(function(event) {
		var id = $(this).val();
			dealer(id);
           
	});
    function dealer(region_id){
		var dealers = "";

		$.ajax({
			url: "<?php echo base_url('index.php/rd/dealer') ?>",
			type: 'GET',
			dataType: 'JSON',
			data: {region_id: region_id},
		})
		.done(function(data) {

			if(data){
				
				$.each(data, function(index, val) {
					dealers += "<option value='"+val.id+"' >"+ val.dealer_name +"</option>";
				});
				$("#dealer").removeAttr('disabled')
			}
			$("#dealer").html(dealers)
			$("select option").filter(function() {
				return $(this).text() == dealer1; 
			}).prop('selected', true);
		})
		.fail(function() {
			console.log("error")
		})	
		
		 
	}
    $("#submit").click(function(event) {

        event.preventDefault();
        var date_from = $("#date_from").val()
        var date_to   = $("#date_to").val()
        var dealer = $("#dealer").val()

        if( date_from && date_to ){
            search(date_from,date_to,dealer)
            

        }
        else{
            alert("Please fill required fields.")
        }

    });
    function search(date_from,date_to,dealer){

		
		$("#rdtable").DataTable().destroy();
		var tbody = "";
		$.ajax({
			url: "<?php echo base_url('index.php/rd/getdata') ?>",
			type: 'GET',
			dataType: 'JSON',
			data: {date_from: date_from,date_to: date_to,dealer: dealer},
		})
		.done(function(data) {
			
			if(data){
				$.each(data, function(index, val) {
					tbody += "<tr id='trow'><td>"+ val.bm +"</td><td>"+ val.pi +"</td><td>"+ val.o +"</td></tr>";

				});
			}
			$("#tbody").html(tbody)
			$("#rdtable").DataTable({
				dom: 'Bfrtip',
	       		buttons: [
	            { extend: 'excel', exportOptions:
	                 { columns: ':visible' }
	            }
           	],
	        destroy: true,
	        "bPaginate": false,
    		"ordering": false,
			"bInfo": false,
			"bFilter": false,
			})
			
		})
		.fail(function() {
			console.log("error ");
		})	
	}
    
</script>