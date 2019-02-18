
<div class="col-lg-12">
	<div class="box box-default box-solid">
		<div class="box-header with-border">
	  		<h3 class="box-title"><b>Sales Order by Payment Mode</b></h3>

		  	<div class="box-tools pull-right">
	    		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	  		</div>
		</div>
		<div class="box-body">
			
			<h5 style="font-weight:bold;">Date Range</h5>
			<div style="margin-bottom:15px;display:flex;align-items: center;">				
				<span style="color:#aaa;margin-right:5px;">From:</span> <input class="form-control" type="date" id="startDate" value="<?php echo $data['sdate'] ?>" style="margin-right:15px;width:200px;"></input>
				<span style="color:#aaa;margin-right:5px;">To:</span> <input value="<?php echo $data['sdate'] ?>" class="form-control" type="date" id="endDate" style="margin-right:15px;width:200px;"></input>
				<a href="" class="btn btn-primary btn-sm" id="setBtn">Set</a>
			</div>

			<table id="lead_table" class="table table-striped table-bordered" style="width:100%;font-size:14px;">
	            <thead>
	            	<tr>
	            		<th rowspan="2" ="" ="" ="2">PAYMENT MODE</th>
	            		<th colspan="2" style="text-align:center">TOTAL</th>

	            		<?php foreach ($data['bm'] as $key => $value): ?>
	            			<th colspan="2" style="text-align:center"><?php echo $value->name ?></th>
	            		<?php endforeach ?>
	            		
	            	</tr>
	                <tr>
	                    <th>Value</th>
	                    <th>PCT</th>

	                     <?php foreach ($data['bm'] as $key => $value): ?>
	            			<th>Value</th>
	                    	<th>PCT</th>
	            		<?php endforeach ?>
                   
	                </tr>
	            </thead>
	            <tbody>	  

	            	<?php foreach ($data['result'] as $key => $value): ?>
	            		<tr>
	            			<td><?php echo ucwords($value['pm']) ?></td>
	            			<td><?php echo $data['overall'][$key] ?></td>
	            			<td><?php echo $data['total_percentage'][$key] ?>%</td>

	            			<?php foreach ($value['bm'] as $key => $value): ?>
	            				<td><?php echo $value->count ?></td>
	            				<td><?php echo $value->percentage ?>%</td>
	            			<?php endforeach ?>
	            		</tr>
	            	<?php endforeach ?>    

	            	<tr style="background:#ddd;">
	            		<td>TOTAL</td>
	            		<td><?php echo $data['overall_total'] ?></td>
	            		<td>100%</td>

	            		<?php foreach ($data['total'] as $key => $value): ?>
	            			<td><?php echo $value ?></td>
	            			<td>100%</td>
	            		<?php endforeach ?>
	            	</tr>      	
	            	
	            </tbody>
		    </table>
					   
		</div>		
	</div>
</div>


<script>
	$("#setBtn").click(function(e){
		e.preventDefault();
		let startDate = $("#startDate").val();
		let endDate = $("#endDate").val();

		if(startDate.length > 0 && endDate.length > 0){
			window.location = "so_by_payment?" + 'sdate=' + startDate + "&edate=" + endDate;
		}
		
	});


</script>