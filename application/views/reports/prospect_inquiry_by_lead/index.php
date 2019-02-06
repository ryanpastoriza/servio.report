
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
	                    <th>First Name</th>
	                    <th>Last Name</th>
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
	        // stateSave:true,
	        columns:[
	        			{'data':'fname'},
	                    {'data':'lname'},
			]
      	});

    }
    

</script>