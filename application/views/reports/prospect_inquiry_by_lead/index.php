
<div class="col-lg-12">
	<div class="box box-default box-solid">
		<div class="box-header with-border">
	  		<h3 class="box-title"><b>Lead Source</b> <small> Prospect Inquiry Report</small></h3>

		  	<div class="box-tools pull-right">
	    		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	  		</div>
		</div>
		<div class="box-body">
			
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
	            </tbody>
		    </table>
			

		</div>
	</div>
</div>

<script>
	
	var table;

	$(document).ready(function() {
        lead_datatable("");
    });

    function lead_datatable($data){

    	table = $('#lead_table').DataTable({
	        ajax:{
	        	url:'<?php echo base_url('index.php/reports/lead_data'); ?>',
	            cache:true,
	        },
	        destroy: true,
	        "bPaginate": false,
	        columns:[
				{"data" : "source_of_sale"},
				{"data" : "total_value"},
				{"data" : "total_pct"},
				<?php foreach($base_model as $value): ?>
				{"data" : "v<?=$value->name?>"},
				{"data" : "p<?=$value->name?>"},
				<?php endforeach ?>
			],
			data: []
      	});

    }
    

</script>